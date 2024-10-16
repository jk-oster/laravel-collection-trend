<?php

namespace JkOster\CollectionTrend;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Carbon\CarbonPeriod;
use Closure;
use Error;
use Illuminate\Support\Collection;
use JkOster\CollectionTrend\CollectionTrendValue as TrendValue;

class CollectionTrend implements ITrend
{
    public string $interval;

    public CarbonInterface $start;

    public CarbonInterface $end;

    public string|Closure $dateColumn = 'created_at';

    public string|Closure|null $valueColumn;

    public function __construct(public Collection|array $collection)
    {
        if (is_array($collection)) {
            $this->collection = collect($collection);
        }
    }

    public static function make(Collection|array $collection): self
    {
        return new static($collection);
    }

    public function between($start, $end): self
    {
        $this->start = $start;
        $this->end = $end;

        return $this;
    }

    public function interval(string $interval): self
    {
        $this->interval = $interval;

        return $this;
    }

    public function per(string $interval): self
    {
        return $this->interval($interval);
    }

    public function perMinute(): self
    {
        return $this->interval('minute');
    }

    public function perHour(): self
    {
        return $this->interval('hour');
    }

    public function perDay(): self
    {
        return $this->interval('day');
    }

    public function perWeek(): self
    {
        return $this->interval('week');
    }

    public function perMonth(): self
    {
        return $this->interval('month');
    }

    public function perYear(): self
    {
        return $this->interval('year');
    }

    /**
     * Set date column as a column name or how the date value should be retrieved from the collection item.
     *
     * @param  string|Closure  $column  Column name or closure returning date column value
     */
    public function dateColumn(string|Closure $column): self
    {
        $this->dateColumn = $column;

        return $this;
    }

    protected function getItemDateAsCarbon($item): CarbonInterface
    {
        $itemDate = null;

        if ($this->dateColumn instanceof Closure) {
            $closure = $this->dateColumn;
            $itemDate = $closure($item);
        } elseif (is_string($this->dateColumn)) {
            $itemDate = is_array($item) ? $item[$this->dateColumn] : $item->{$this->dateColumn};
        }

        if (! $itemDate) {
            throw new Error('Invalid date column: "'.$this->dateColumn.'". Defined date column did not match any column in the collection item or returned null.');
        }

        if (! $itemDate instanceof CarbonInterface) {
            $itemDate = Carbon::parse($itemDate);
        }

        if (! $itemDate instanceof CarbonInterface) {
            throw new Error('Invalid date format.');
        }

        return $itemDate;
    }

    protected function getItemValue($item): int|float|null|bool
    {
        if ($this->valueColumn instanceof Closure) {
            $valueClosure = $this->valueColumn;

            return $valueClosure($item);
        } elseif (is_string($this->valueColumn)) {
            return is_array($item) ? $item[$this->valueColumn] : $item->{$this->valueColumn};
        }

        return null;
    }

    public function mapValuesToDates(Collection $values, int $filler = 0): Collection
    {
        $values = $values->map(fn (mixed $aggregate, string $date) => new TrendValue(
            date: $date,
            aggregate: $aggregate,
        ));

        $placeholders = $this->getDatePeriod()->map(
            fn (CarbonInterface $date) => new TrendValue(
                date: $date->isoFormat($this->getCarbonDateIsoFormat()),
                aggregate: $filler,
            )
        );

        return $values
            ->merge($placeholders)
            ->unique('date')
            ->sort()
            ->flatten();
    }

    public function getDatePeriod(): Collection
    {
        return collect(
            CarbonPeriod::between(
                $this->start,
                $this->end,
            )->interval("1 {$this->interval}")
        );
    }

    protected function getCarbonDateIsoFormat(): string
    {
        return match ($this->interval) {
            'minute' => 'YYYY-MM-DD HH:mm:00',
            'hour' => 'YYYY-MM-DD HH:00',
            'day' => 'YYYY-MM-DD',
            'week' => 'GGGG-[W]WW',
            'month' => 'YYYY-MM',
            'year' => 'YYYY',
            default => throw new Error('Invalid interval: '.$this->interval.'. Available intervals: "minute", "hour", "day", "week", "month", "year".')
        };
    }

    /**
     * Aggregates collection values within date range grouped by date interval.
     *
     * @param  string|Closure  $valueColumn  column name or closure returning the value to be aggregated from a collection item.
     * @param  string|Closure  $aggregate  aggregation function name or closure returning an aggregated value from value collection.
     */
    public function aggregate(string|Closure|null $valueColumn, string|Closure $aggregate, int $filler = 0): Collection
    {
        $this->valueColumn = $valueColumn;

        $groupedValuesWithinDateRange = $this->collection
            // Filter items within date range
            ->filter(function ($item) {
                $itemDate = $this->getItemDateAsCarbon($item);

                return $itemDate->isBetween($this->start, $this->end);
            })
            // Group items by date interval
            ->groupBy(function ($item) {
                $itemDate = $this->getItemDateAsCarbon($item);

                return $itemDate->isoFormat($this->getCarbonDateIsoFormat());
            })
            // Map items to values
            ->map(function ($items) {
                return $items->map(function ($item) {
                    return $this->getItemValue($item);
                });
            });

        // Apply aggregation function
        $aggregated = $groupedValuesWithinDateRange->map(function ($group) use ($aggregate) {
            if (! $group instanceof Collection) {
                $group = collect($group);
            }

            if ($aggregate instanceof Closure) {
                $aggregatedValue = $aggregate($group);

                return $aggregatedValue;
            }

            /** @var string $aggregate */
            /** @var Collection $items */

            return match ($aggregate) {
                'sum' => $group->sum(),
                'count' => $group->count(),
                'median' => $group->median(),
                'avg' => $group->avg(),
                'min' => $group->min(),
                'max' => $group->max(),
                default => throw new \InvalidArgumentException("Unsupported aggregate function: {$aggregate}"),
            };
        });

        return $this->mapValuesToDates($aggregated, $filler);
    }

    public function sum(string|Closure $column, int $filler = 0): Collection
    {
        return $this->aggregate($column, 'sum', $filler);
    }

    public function count(string|Closure $column = '*', int $filler = 0): Collection
    {
        if ($column == '*') {
            return $this->aggregate(null, 'count', 0);
        }

        return $this->aggregate($column, 'count');
    }

    public function median(string|Closure $column, int $filler = 0): Collection
    {
        return $this->aggregate($column, 'median', $filler);
    }

    public function avg(string|Closure $column, int $filler = 0): Collection
    {
        return $this->aggregate($column, 'avg', $filler);
    }

    public function min(string|Closure $column, int $filler = 0): Collection
    {
        return $this->aggregate($column, 'min', $filler);
    }

    public function max(string|Closure $column, int $filler = 0): Collection
    {
        return $this->aggregate($column, 'max', $filler);
    }
}
