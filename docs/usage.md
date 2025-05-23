---
title: "Usage"
description: "Generate report and trends from collections."
editLink: true
prev:
  text: Installtion & Setup
  link: /#installation-setup
next:
  text: Usage Examples
  link: /example.html
---

## General

To generate a trend for your collection of items, import the ``JkOster\CollectionTrend\CollectionTrend`` class and pass along a collectable.

Example:

```php
// Maximum weight over the last 30 days and results are grouped per day
$trend = CollectionTrend::make($collectable)
    ->between(
        start: now()->subDays(30),
        end: now(),
    )
    ->perDay()
    ->max('weight');
```

## Filtering a trend

You can filter a trend by using common filtering methods of [Laravel Collections](https://laravel.com/docs/collections#available-methods).

```php
// Average user weight where name equals "Jakob", over a span of 11 years and results are grouped per year
$filteredCollection = collect($collectable)->where('name', '=', 'Jakob');
$trend = CollectionTrend::make($filteredCollection)
    ->between(
        start: now()->startOfYear()->subYears(10),
        end: now()->endOfYear(),
    )
    ->perYear()
    ->average('weight');
```

## Starting a trend

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

## Interval

You can use the following aggregates intervals:

```php
perMinute()
perHour()
perDay()
perWeek()
perMonth()
perYear()
```

> TIPP: Make sure that the time you defined in the ``between()`` is the same or a bigger time span than the interval.

## Aggregates

You can use the following aggregates:

```php
sum('column')
average('column')
median('column')
max('column')
min('column')
count('*')
```

## Date Column

By default, laravel-collection-trend assumes that the item on which the operation is being performed has a ``created_at`` date column or property. If your item uses a different column / property name for the date or you want to use a different one, you should specify it using the ``dateColumn(string|Closure $column)`` method.

Example:

```php
CollectionTrend::make($collectable)
    ->dateColumn('custom_date_column')
    ->between(...)
    ->perDay()
    ->count();

// Or using a closure

CollectionTrend::collect($collectable)
    ->dateColumn(fn ($item) => $item['custom_date_column'])
    ->between(...)
    ->perDay()
    ->count();
```

This allows you to work with models that have custom date column names or when you want to analyze data based on a different date column.

## Value Column

By default in laravel-collection-trend you have to pass the column / property name as ``string`` that contains the values you want to aggregate to the aggregate methods. However, like the date column you can also specify a ``Closure`` returning a value, which you pass in the aggregate methods.

Example:

```php
CollectionTrend::make($collectable)
    ->between(...)
    ->perDay()
    ->sum('value_column');

// Or using a closure

CollectionTrend::collect($collectable)
    ->between(...)
    ->perDay()
    ->sum(fn ($item) => $item['value_column']);
```

> TIPP: Using a closure allows you  e.g. to map non numeric values of your items to numeric values for analysis purposes and implement other more advanced operations.

## Empty Data Fillers / Placeholder Values

By default laravel-collection-trend fills up missing data points with the placeholder value ``0``. You can change this behavior by passing any ``int`` as second argument to the aggregate methods. However, this is not recommended or required in most cases.

Example:

```php
// Fills up missing data with the value -1
CollectionTrend::make($collectable)
    ->between(...)
    ->perDay()
    ->sum('value_column', -1);
```
