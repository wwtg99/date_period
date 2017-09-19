Date Period
===========

Generate a series of date period, usually for statistics.
基于日、周、月、年等的时间段切分。

# Installation

```
composer require wwtg99/date_period
```
or add 
```
"wwtg99/date_period": "*"
```
to composer.json

# Test
Unit test file in tests. Tested in PHP 7.1.

# Usage

## Generate day array between start day(included) and end day(excluded)
```php
$start = '2017-09-01';
$end = '2017-09-10';
$arr = DatePeriod::getPeriodArray(DatePeriod::TYPE_PERIOD_DAY, $start, $end);

foreach ($arr as $item) {
    echo "Title: ", $item->getTitle(), " From: ", $item->getStartString(), " To: ", $item->getEndString(), "\n";
}
```

Output:
```
Title: 2017-09-01 From: 2017-09-01 To: 2017-09-02
Title: 2017-09-02 From: 2017-09-02 To: 2017-09-03
Title: 2017-09-03 From: 2017-09-03 To: 2017-09-04
Title: 2017-09-04 From: 2017-09-04 To: 2017-09-05
Title: 2017-09-05 From: 2017-09-05 To: 2017-09-06
Title: 2017-09-06 From: 2017-09-06 To: 2017-09-07
Title: 2017-09-07 From: 2017-09-07 To: 2017-09-08
Title: 2017-09-08 From: 2017-09-08 To: 2017-09-09
Title: 2017-09-09 From: 2017-09-09 To: 2017-09-10
Title: 2017-09-10 From: 2017-09-10 To: 2017-09-11
```

## Generate month array between start day(included) and end day(excluded)
```php
$start = '2017-05-11';
$end = '2017-09-10';
$arr = DatePeriod::getPeriodArray(DatePeriod::TYPE_PERIOD_MONTH, $start, $end);

foreach ($arr as $item) {
    echo "Title: ", $item->getTitle(), " From: ", $item->getStartString(), " To: ", $item->getEndString(), "\n";
}
```

Output:
```
Title: 2017-05 From: 2017-05-01 To: 2017-06-01
Title: 2017-06 From: 2017-06-01 To: 2017-07-01
Title: 2017-07 From: 2017-07-01 To: 2017-08-01
Title: 2017-08 From: 2017-08-01 To: 2017-09-01
Title: 2017-09 From: 2017-09-01 To: 2017-10-01
```

## Use generator instead of array (usually for very long period)
Generator support PHP 7.0+.
```php
$start = '2017-07-11';
$end = '2017-09-10';
foreach (DatePeriod::getPeriodArray(DatePeriod::TYPE_PERIOD_WEEK, $start, $end) as $item) {
    echo "Title: ", $item->getTitle(), " From: ", $item->getStartString(), " To: ", $item->getEndString(), "\n";
}
```

Output:
```
Title: 2017-07 W2 From: 2017-07-10 To: 2017-07-17
Title: 2017-07 W3 From: 2017-07-17 To: 2017-07-24
Title: 2017-07 W4 From: 2017-07-24 To: 2017-07-31
Title: 2017-07 W5 From: 2017-07-31 To: 2017-08-07
Title: 2017-08 W1 From: 2017-08-07 To: 2017-08-14
Title: 2017-08 W2 From: 2017-08-14 To: 2017-08-21
Title: 2017-08 W3 From: 2017-08-21 To: 2017-08-28
Title: 2017-08 W4 From: 2017-08-28 To: 2017-09-04
Title: 2017-09 W1 From: 2017-09-04 To: 2017-09-11
```

## Supported period
- Day: every day from start to end
- Week: every week from start to end
- Month: every month from start to end
- Year: every year from start to end
- None: same as DateInterval
