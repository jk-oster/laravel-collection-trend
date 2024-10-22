
# Collection Trend for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jk-oster/laravel-collection-trend.svg?style=flat-square)](https://packagist.org/packages/jk-oster/laravel-collection-trend)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/jk-oster/laravel-collection-trend/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/jk-oster/laravel-collection-trend/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/jk-oster/laravel-collection-trend/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/jk-oster/laravel-collection-trend/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/jk-oster/laravel-collection-trend.svg?style=flat-square)](https://packagist.org/packages/jk-oster/laravel-collection-trend)


Generate trends from collections. Easily create charts or reports.

For detailed examples checkout the [docs page](https://jk-oster.github.io/laravel-collection-trend/).

## Why?

Most applications require charts or reports to be generated. Doing this over again, and again can be a painful process. That's why I've created a fluent Laravel package to solve this problem (inspired by [laravel-trend](https://github.com/Flowframe/laravel-trend)).

## Installation & Setup

You can install this package with composer using the following command:

```bash
composer require jk-oster/laravel-collection-trend
```

## Usage

To generate a trend for your model, import the ``JkOster\CollectionTrend\CollectionTrend`` class and pass along a collectable.

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
median('column')
max('column')
min('column')
count('*')
```

### Date Column

By default, laravel-collection-trend assumes that the model on which the operation is being performed has a ``created_at`` date column. If your model uses a different column name for the date or you want to use a different one, you should specify it using the ``dateColumn(string|Closure $column)`` method.

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

### Value Column

By default laravel-collection-trend you have to specify the column that contains the values you want to aggregate in the aggregate method. Like the date column you can specify it using a ``string|Closure`` which you pass in the aggregate method.

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

### Empty Data Fillers

By default laravel-collection-trend fills up missing data with the value ``0``. You can change this behavior by passing a ``int`` as second argument to the aggregate method.

Example:

```php
CollectionTrend::make($collectable)
    ->between(...)
    ->perDay()
    ->sum('value_column', -1);
```

## Compatibility with Flowframe/Laravel-Trend

The interface of the package to the biggest part compatible with the [Laravel-Trend](https://github.com/Flowframe/Laravel-Trend) package. You only need to exchange the ```Trend::model($model)``` calls with ```CollectionTrend::make($collectable)```.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Credits

Thanks to the creators of [flowframe/laravel-trend](https://github.com/Flowframe/laravel-trend) for inspiration.

- [Jakob Osterberger](https://github.com/jk-oster)
- [All Contributors](../../contributors)
