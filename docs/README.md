---
title: "Docs"
description: "Generate trends from collections. Easily create charts or reports."
home: true
---

## Overview

Generate trends from collections. Easily create charts or reports.

## Why?

Most applications require charts or reports to be generated. Doing this over again, and again can be a painful process. That's why I've created a fluent Laravel package to solve this problem. This package is heavily inspired by [laravel-trend](https://github.com/Flowframe/laravel-trend) and uses for the biggest part exactly the same interface for creating trends.

## Requirements

**PHP 8.1+** and **Composer 2.0+** installed.

## Installation & Setup

You can install this package with composer using the following command:

```bash
composer require jk-oster/laravel-collection-trend
```

## Usage

To generate a trend for your model, import the ``JkOster\CollectionTrend\CollectionTrend`` class and pass along a model or query.

Example:

```php
// Totals per month
$trend = CollectionTrend::make($collectable)
    ->between(
        start: now()->startOfYear(),
        end: now()->endOfYear(),
    )
    ->perMonth()
    ->count();

// Average user weight where name starts with a over a span of 11 years, results are grouped per year
$trend = CollectionTrend::make($collectable)
    ->between(
        start: now()->startOfYear()->subYears(10),
        end: now()->endOfYear(),
    )
    ->perYear()
    ->average('weight');
```

### Starting a trend

You can either start a trend using ``::make()`` or ``::collect()``.

```php
CollectionTrend::make($collectable)
    ->between(...)
    ->perDay()
    ->count();

CollectionTrend::collect($collectable)
    ->between(...)
    ->perDay()
    ->count();
```

### Interval

You can use the following aggregates intervals:

```php
perMinute()
perHour()
perDay()
perMonth()
perYear()
```

### Aggregates

You can use the following aggregates:

```php
sum('column')
average('column')
max('column')
min('column')
count('*')
```

### Date Column

By default, laravel-trend assumes that the model on which the operation is being performed has a ``created_at`` date column. If your model uses a different column name for the date or you want to use a different one, you should specify it using the ``dateColumn(string $column)`` method.

Example:

```php
CollectionTrend::make($collectable)
    ->dateColumn('custom_date_column')
    ->between(...)
    ->perDay()
    ->count();
```

This allows you to work with models that have custom date column names or when you want to analyze data based on a different date column.
