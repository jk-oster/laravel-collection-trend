---
title: "Docs"
description: "Generate trends from laravel collections. Easily create charts or reports."
home: false
sidebar: "heading"
footer: "Made with ❤️ by <a href='https://jakobosterberger.com'>Jakob Osterberger</a> (c) 2024"
footerHtml: true
actions:
  - text: Get Started
    link: "/#installation-setup"
    type: primary
  - text: Usage Guide
    link: "/usage.html"
    type: secondary
features:
  - title: Simplicity
    details: Easy to use fluent API for creating trends and reports with sensible defaults.
  - title: Flexibility
    details: Can be used from simple trends up to complex reporting analysis through using Closures.
  - title: Compatible
    details: Package is to the biggest part compatible with the Laravel-Trend package.
next:
  text: Usage Guide
  link: /usage.html
---

## Why?

Most applications require charts or reports to be generated. Doing this over again, and again can be a painful process. For this reason I've created a fluent Laravel package to solve this problem.

This package is heavily inspired by [laravel-trend](https://github.com/Flowframe/laravel-trend) and exhibits for the biggest part exactly the same API for creating trends, however it operates on collections instead of models.

## Requirements

**PHP 8.0+** and **Composer 2.0+** installed.

## Installation & Setup

You can install this package with composer using the following command:

```bash
composer require jk-oster/laravel-collection-trend
```

## Usage

To generate a trend for your collection of items, import the ``JkOster\CollectionTrend\CollectionTrend`` class and pass along a collectable.

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
```

- [Detailed Usage Guide](./usage.md)
- [Code Examples](./example.md)

## Compatibility with Flowframe/Laravel-Trend API

The interface of the package is to the biggest part compatible with the [Laravel-Trend](https://github.com/Flowframe/Laravel-Trend) package. You only need to exchange the ``Trend::model($model)`` calls with ``CollectionTrend::make($collectable)``.

## License

The MIT License (MIT). Please see [License File](../LICENSE.md) for more information.

## Credits

Thanks to the creators of [flowframe/laravel-trend](https://github.com/Flowframe/laravel-trend) for inspiration.

- [Jakob Osterberger](https://github.com/jk-oster)
- [All Contributors](https://github.com/jk-oster/laravel-collection-trend/contributors)
