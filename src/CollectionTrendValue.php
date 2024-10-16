<?php

namespace JkOster\CollectionTrend;

class CollectionTrendValue
{
    public function __construct(
        public string $date,
        public mixed $aggregate,
    ) {}
}
