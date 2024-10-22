<?php

namespace JkOster\CollectionTrend\Tests;

use Illuminate\Support\Carbon;
use JkOster\CollectionTrend\CollectionTrend;
use JkOster\CollectionTrend\CollectionTrendValue;
use PHPUnit\Framework\TestCase;

class CollectionTrendTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_that_true_is_true(): void
    {
        $this->assertTrue(true);
    }

    public static array $collection = [
        ['created_at' => '2022-01-01', 'value' => 1],
        ['created_at' => '2022-01-01', 'value' => 2],
        ['created_at' => '2022-01-01', 'value' => 3],

        ['created_at' => '2022-01-02', 'value' => 4],
        ['created_at' => '2022-01-02', 'value' => 5],
        ['created_at' => '2022-01-02', 'value' => 6],

        ['created_at' => '2022-01-03', 'value' => 7],
        ['created_at' => '2022-01-03', 'value' => 8],
        ['created_at' => '2022-01-03', 'value' => 9],

        // ['created_at' => '2022-01-04', 'value' => 10],
        // ['created_at' => '2022-01-04', 'value' => 11],
        // ['created_at' => '2022-01-04', 'value' => 12],

        ['created_at' => '2022-01-05', 'value' => 13],
        ['created_at' => '2022-01-05', 'value' => 14],
        ['created_at' => '2022-01-05', 'value' => 15],

        ['created_at' => '2022-01-06', 'value' => 16],
        ['created_at' => '2022-01-06', 'value' => 17],
        ['created_at' => '2022-01-06', 'value' => 18],
    ];

    public function test_collection_trend_sum(): void
    {
        $trend = CollectionTrend::make(self::$collection)
            ->between(
                start: Carbon::parse('2022-01-02'),
                end: Carbon::parse('2022-01-05'),
            )
            ->perDay()
            ->sum('value')
            ->toArray();

        $this->assertEquals([
            new CollectionTrendValue(
                date: '2022-01-02',
                aggregate: 15,
            ),
            new CollectionTrendValue(
                date: '2022-01-03',
                aggregate: 24,
            ),
            new CollectionTrendValue(
                date: '2022-01-04',
                aggregate: 0,
            ),
            new CollectionTrendValue(
                date: '2022-01-05',
                aggregate: 42,
            ),
        ], $trend);
    }

    public function test_collection_trend_count(): void
    {
        $trend = CollectionTrend::make(self::$collection)
            ->between(
                start: Carbon::parse('2022-01-02'),
                end: Carbon::parse('2022-01-05'),
            )
            ->perDay()
            ->count()
            ->toArray();

        $this->assertEquals([
            new CollectionTrendValue(
                date: '2022-01-02',
                aggregate: 3,
            ),
            new CollectionTrendValue(
                date: '2022-01-03',
                aggregate: 3,
            ),
            new CollectionTrendValue(
                date: '2022-01-04',
                aggregate: 0,
            ),
            new CollectionTrendValue(
                date: '2022-01-05',
                aggregate: 3,
            ),
        ], $trend);
    }

    public function test_collection_trend_median(): void
    {
        $trend = CollectionTrend::make(self::$collection)
            ->between(
                start: Carbon::parse('2022-01-02'),
                end: Carbon::parse('2022-01-05'),
            )
            ->perDay()
            ->median('value')
            ->toArray();

        $this->assertEquals([
            new CollectionTrendValue(
                date: '2022-01-02',
                aggregate: 5,
            ),
            new CollectionTrendValue(
                date: '2022-01-03',
                aggregate: 8,
            ),
            new CollectionTrendValue(
                date: '2022-01-04',
                aggregate: 0,
            ),
            new CollectionTrendValue(
                date: '2022-01-05',
                aggregate: 14,
            ),
        ], $trend);
    }

    public function test_collection_trend_max(): void
    {
        $trend = CollectionTrend::make(self::$collection)
            ->between(
                start: Carbon::parse('2022-01-02'),
                end: Carbon::parse('2022-01-05'),
            )
            ->perDay()
            ->max('value')
            ->toArray();

        $this->assertEquals([
            new CollectionTrendValue(
                date: '2022-01-02',
                aggregate: 6,
            ),
            new CollectionTrendValue(
                date: '2022-01-03',
                aggregate: 9,
            ),
            new CollectionTrendValue(
                date: '2022-01-04',
                aggregate: 0,
            ),
            new CollectionTrendValue(
                date: '2022-01-05',
                aggregate: 15,
            ),
        ], $trend);
    }

    public function test_collection_trend_min(): void
    {
        $trend = CollectionTrend::make(self::$collection)
            ->between(
                start: Carbon::parse('2022-01-02'),
                end: Carbon::parse('2022-01-05'),
            )
            ->perDay()
            ->min('value')
            ->toArray();

        $this->assertEquals([
            new CollectionTrendValue(
                date: '2022-01-02',
                aggregate: 4,
            ),
            new CollectionTrendValue(
                date: '2022-01-03',
                aggregate: 7,
            ),
            new CollectionTrendValue(
                date: '2022-01-04',
                aggregate: 0,
            ),
            new CollectionTrendValue(
                date: '2022-01-05',
                aggregate: 13,
            ),
        ], $trend);
    }

    public function test_collection_trend_avg(): void
    {
        $trend = CollectionTrend::make(self::$collection)
            ->between(
                start: Carbon::parse('2022-01-02'),
                end: Carbon::parse('2022-01-05'),
            )
            ->perDay()
            ->avg('value')
            ->toArray();

        $this->assertEquals([
            new CollectionTrendValue(
                date: '2022-01-02',
                aggregate: 5,
            ),
            new CollectionTrendValue(
                date: '2022-01-03',
                aggregate: 8,
            ),
            new CollectionTrendValue(
                date: '2022-01-04',
                aggregate: 0,
            ),
            new CollectionTrendValue(
                date: '2022-01-05',
                aggregate: 14,
            ),
        ], $trend);
    }

    public function test_collection_trend_per_week(): void
    {
        $trend = CollectionTrend::make(self::$collection)
            ->between(
                start: Carbon::parse('2022-01-02'),
                end: Carbon::parse('2022-01-05'),
            )
            ->perWeek()
            ->count()
            ->toArray();

        $this->assertEquals([
            new CollectionTrendValue(
                date: '2021-W52',
                aggregate: 3,
            ),
            new CollectionTrendValue(
                date: '2022-W01',
                aggregate: 6,
            ),
        ], $trend);
    }

    public function test_collection_trend_per_hour(): void
    {
        $collection = collect([
            ['created_at' => '2022-01-02 00:00:00', 'value' => 1],

            ['created_at' => '2022-01-02 00:10:00', 'value' => 1],
            ['created_at' => '2022-01-02 00:20:00', 'value' => 1],
            ['created_at' => '2022-01-02 00:30:00', 'value' => 1],
            ['created_at' => '2022-01-02 00:40:00', 'value' => 1],

            ['created_at' => '2022-01-02 00:50:00', 'value' => 1],
        ]);
        $trend = CollectionTrend::make($collection)
            ->between(
                start: Carbon::parse('2022-01-02 00:10:00'),
                end: Carbon::parse('2022-01-02 00:40:00'),
            )
            ->perHour()
            ->count()
            ->toArray();

        $this->assertEquals([
            new CollectionTrendValue(
                date: '2022-01-02 00:00',
                aggregate: 4,
            ),
        ], $trend);
    }

    public function test_collection_trend_per_month(): void
    {
        $trend = CollectionTrend::make(self::$collection)
            ->between(
                start: Carbon::parse('2022-01-02'),
                end: Carbon::parse('2022-01-05'),
            )
            ->perMonth()
            ->count()
            ->toArray();

        $this->assertEquals([
            new CollectionTrendValue(
                date: '2022-01',
                aggregate: 9,
            ),
        ], $trend);
    }

    public function test_collection_trend_per_year(): void
    {
        $trend = CollectionTrend::make(self::$collection)
            ->between(
                start: Carbon::parse('2022-01-02'),
                end: Carbon::parse('2022-01-05'),
            )
            ->perYear()
            ->count('value')
            ->toArray();

        $this->assertEquals([
            new CollectionTrendValue(
                date: '2022',
                aggregate: 9,
            ),
        ], $trend);
    }

    public function test_collection_trend_placeholders(): void
    {
        $trend = CollectionTrend::make([])
            ->between(
                start: Carbon::parse('2022-01-02'),
                end: Carbon::parse('2022-01-05'),
            )
            ->perDay()
            ->count()
            ->toArray();

        $this->assertEquals([
            new CollectionTrendValue(
                date: '2022-01-02',
                aggregate: 0,
            ),
            new CollectionTrendValue(
                date: '2022-01-03',
                aggregate: 0,
            ),
            new CollectionTrendValue(
                date: '2022-01-04',
                aggregate: 0,
            ),
            new CollectionTrendValue(
                date: '2022-01-05',
                aggregate: 0,
            ),
        ], $trend);
    }

    public function test_collection_trend_exception(): void {}

    public function test_collection_trend_date_column_closure(): void
    {
        $trend = CollectionTrend::make(self::$collection)
            ->between(
                start: Carbon::parse('2022-01-02'),
                end: Carbon::parse('2022-01-05'),
            )
            ->dateColumn(fn ($item) => $item['created_at'])
            ->perDay()
            ->count()
            ->toArray();

        $this->assertEquals([
            new CollectionTrendValue(
                date: '2022-01-02',
                aggregate: 3,
            ),
            new CollectionTrendValue(
                date: '2022-01-03',
                aggregate: 3,
            ),
            new CollectionTrendValue(
                date: '2022-01-04',
                aggregate: 0,
            ),
            new CollectionTrendValue(
                date: '2022-01-05',
                aggregate: 3,
            ),
        ], $trend);
    }

    public function test_collection_trend_value_column_closure(): void
    {
        $trend = CollectionTrend::make(self::$collection)
            ->between(
                start: Carbon::parse('2022-01-02'),
                end: Carbon::parse('2022-01-05'),
            )
            ->perDay()
            ->count(fn ($item) => $item['value'])
            ->toArray();

        $this->assertEquals([
            new CollectionTrendValue(
                date: '2022-01-02',
                aggregate: 3,
            ),
            new CollectionTrendValue(
                date: '2022-01-03',
                aggregate: 3,
            ),
            new CollectionTrendValue(
                date: '2022-01-04',
                aggregate: 0,
            ),
            new CollectionTrendValue(
                date: '2022-01-05',
                aggregate: 3,
            ),
        ], $trend);
    }
}
