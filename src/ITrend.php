<?php

namespace JkOster\CollectionTrend;

use Illuminate\Support\Collection;

interface ITrend
{
    public function between($start, $end): self;

    public function interval(string $interval): self;

    public function perMinute(): self;

    public function perHour(): self;

    public function perDay(): self;

    public function perWeek(): self;

    public function perMonth(): self;

    public function perYear(): self;

    public function dateColumn(string $column): self;

    public function mapValuesToDates(Collection $values): Collection;

    public function aggregate(string $valueColumn, string $aggregate): Collection;

    public function sum(string $column): Collection;

    public function count(string $column = '*'): Collection;

    public function median(string $column): Collection;

    public function avg(string $column): Collection;

    public function min(string $column): Collection;

    public function max(string $column): Collection;
}
