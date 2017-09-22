<?php
/**
 * Created by PhpStorm.
 * User: wuwentao
 * Date: 2017/9/18
 * Time: 10:21
 */

namespace Tests;


use Carbon\Carbon;
use Faker\Factory;
use Wwtg99\DatePeriod\DatePeriod;

class DataPeriodTest extends \PHPUnit_Framework_TestCase
{

    public function testDatePeriodArray()
    {
        //date type
        $faker = Factory::create();
        $start = $faker->dateTime()->format('Y-m-d H:i:s');
        $startDay = new Carbon($start);
        //none period date format
        $endDay = $this->generateRandomDateAfter($start);
        $end = $endDay->toDateTimeString();
        $arr = DatePeriod::getPeriodArray(DatePeriod::TYPE_PERIOD_NONE, $start, $end);
        self::assertEquals(1, count($arr));
        self::assertEquals($startDay->toDateString(), $arr[0]->getStartString());
        self::assertEquals($endDay->toDateString(), $arr[0]->getEndString());
        //none period datetime format
        $arr = DatePeriod::getPeriodArray(DatePeriod::TYPE_PERIOD_NONE, $start, $end, DatePeriod::TYPE_DATETIME);
        self::assertEquals(1, count($arr));
        self::assertEquals($startDay->toDateTimeString(), $arr[0]->getStartString());
        self::assertEquals($endDay->toDateTimeString(), $arr[0]->getEndString());
        //second
        $endDay = $this->generateRandomDateAfter($start, false, false, false, false, false, true);
        $end = $endDay->toDateTimeString();
        $arr = DatePeriod::getPeriodArray(DatePeriod::TYPE_PERIOD_SECOND, $start, $end);
        self::assertEquals($endDay->copy()->diffInSeconds($startDay) + 1, count($arr));
        $st = $startDay->copy();
        foreach ($arr as $item) {
            self::assertEquals($st->toDateTimeString(), $item->getTitle());
            $st->addSecond(1);
        }
        //minute
        $endDay = $this->generateRandomDateAfter($start, false, false, false, false, true, false);
        $end = $endDay->toDateTimeString();
        $arr = DatePeriod::getPeriodArray(DatePeriod::TYPE_PERIOD_MINUTE, $start, $end);
        self::assertEquals($endDay->copy()->diffInMinutes($startDay) + 1, count($arr));
        $st = $startDay->copy();
        foreach ($arr as $item) {
            self::assertEquals($st->toDateTimeString(), $item->getTitle());
            $st->addMinute(1);
        }
        //hour
        $endDay = $this->generateRandomDateAfter($start, false, false, false, true, false, false);
        $end = $endDay->toDateTimeString();
        $arr = DatePeriod::getPeriodArray(DatePeriod::TYPE_PERIOD_HOUR, $start, $end);
        self::assertEquals($endDay->copy()->diffInHours($startDay) + 1, count($arr));
        $st = $startDay->copy();
        foreach ($arr as $item) {
            self::assertEquals($st->toDateTimeString(), $item->getTitle());
            $st->addHour(1);
        }
        //day date format
        $endDay = $this->generateRandomDateAfter($start, false, false, true);
        $end = $endDay->toDateTimeString();
        $arr = DatePeriod::getPeriodArray(DatePeriod::TYPE_PERIOD_DAY, $start, $end);
        self::assertEquals($endDay->copy()->startOfDay()->diffInDays($startDay->copy()->startOfDay()) + 1, count($arr));
        $st = $startDay->copy()->startOfDay();
        foreach ($arr as $item) {
            self::assertEquals($st->toDateString(), $item->getTitle());
            $st->addDay(1);
        }
        //day datetime format
        $arr = DatePeriod::getPeriodArray(DatePeriod::TYPE_PERIOD_DAY, $start, $end, DatePeriod::TYPE_DATETIME);
        self::assertEquals($endDay->copy()->startOfDay()->diffInDays($startDay->copy()->startOfDay()) + 1, count($arr));
        $st = $startDay->copy()->startOfDay();
        foreach ($arr as $item) {
            self::assertEquals($st->toDateTimeString(), $item->getStartString());
            $st->addDay(1);
        }
        //week
        $endDay = $this->generateRandomDateAfter($start, false, false, true);
        $end = $endDay->toDateString();
        $arr = DatePeriod::getPeriodArray(DatePeriod::TYPE_PERIOD_WEEK, $start, $end);
        self::assertEquals($endDay->diffInWeeks($startDay->copy()->startOfWeek()) + 1, count($arr));
        $st = $startDay->copy()->startOfWeek();
        foreach ($arr as $item) {
            self::assertEquals($st->format('Y-m') . ' W' . $st->weekOfMonth, $item->getTitle());
            $st->addWeek(1);
        }
        //month
        $endDay = $this->generateRandomDateAfter($start, false, true);
        $end = $endDay->toDateString();
        $arr = DatePeriod::getPeriodArray(DatePeriod::TYPE_PERIOD_MONTH, $start, $end);
        self::assertEquals($endDay->diffInMonths($startDay->copy()->startOfMonth()) + 1, count($arr));
        $st = $startDay->copy()->startOfMonth();
        foreach ($arr as $item) {
            self::assertEquals($st->format('Y-m'), $item->getTitle());
            $st->addMonth(1);
        }
        //season
        $endDay = $this->generateRandomDateAfter($start, false, true);
        $end = $endDay->toDateString();
        $arr = DatePeriod::getPeriodArray(DatePeriod::TYPE_PERIOD_SEASON, $start, $end);
        self::assertEquals(floor($endDay->startOfQuarter()->diffInMonths($startDay->copy()->startOfQuarter()) / 3) + 1, count($arr));
        $st = $startDay->copy()->startOfMonth();
        foreach ($arr as $item) {
            self::assertEquals($st->format('Y-' . ceil($st->month / 3)), $item->getTitle());
            $st->addQuarter(1);
        }
        //year
        $endDay = $this->generateRandomDateAfter($start, true);
        $end = $endDay->toDateString();
        $arr = DatePeriod::getPeriodArray(DatePeriod::TYPE_PERIOD_YEAR, $start, $end);
        self::assertEquals($endDay->diffInYears($startDay->copy()->startOfYear()) + 1, count($arr));
        $st = $startDay->copy()->startOfYear();
        foreach ($arr as $item) {
            self::assertEquals($st->format('Y'), $item->getTitle());
            $st->addYear(1);
        }
    }

    public function testDatePeriodGenerator()
    {
        //date type
        $faker = Factory::create();
        $start = $faker->dateTime()->format('Y-m-d H:i:s');
        $startDay = new Carbon($start);
        //none period date format
        $endDay = $this->generateRandomDateAfter($start);
        $end = $endDay->toDateTimeString();
        foreach (DatePeriod::getPeriodGenerator(DatePeriod::TYPE_PERIOD_NONE, $start, $end) as $item) {
            self::assertEquals($startDay->toDateString(), $item->getStartString());
            self::assertEquals($endDay->toDateString(), $item->getEndString());
        }
        //none period datetime format
        foreach (DatePeriod::getPeriodGenerator(DatePeriod::TYPE_PERIOD_NONE, $start, $end, DatePeriod::TYPE_DATETIME) as $item) {
            self::assertEquals($startDay->toDateTimeString(), $item->getStartString());
            self::assertEquals($endDay->toDateTimeString(), $item->getEndString());
        }
        //second
        $endDay = $this->generateRandomDateAfter($start, false, false, false, false, false, true);
        $end = $endDay->toDateTimeString();
        $st = $startDay->copy();
        $n = 0;
        foreach (DatePeriod::getPeriodGenerator(DatePeriod::TYPE_PERIOD_SECOND, $start, $end) as $item) {
            self::assertEquals($st->toDateTimeString(), $item->getTitle());
            $st->addSecond(1);
            $n++;
        }
        self::assertEquals($endDay->diffInSeconds($startDay) + 1, $n);
        //minute
        $endDay = $this->generateRandomDateAfter($start, false, false, false, false, true, false);
        $end = $endDay->toDateTimeString();
        $st = $startDay->copy();
        $n = 0;
        foreach (DatePeriod::getPeriodGenerator(DatePeriod::TYPE_PERIOD_MINUTE, $start, $end) as $item) {
            self::assertEquals($st->toDateTimeString(), $item->getTitle());
            $st->addMinute(1);
            $n++;
        }
        self::assertEquals($endDay->diffInMinutes($startDay) + 1, $n);
        //hour
        $endDay = $this->generateRandomDateAfter($start, false, false, false, true, false, false);
        $end = $endDay->toDateTimeString();
        $st = $startDay->copy();
        $n = 0;
        foreach (DatePeriod::getPeriodGenerator(DatePeriod::TYPE_PERIOD_HOUR, $start, $end) as $item) {
            self::assertEquals($st->toDateTimeString(), $item->getTitle());
            $st->addHour(1);
            $n++;
        }
        self::assertEquals($endDay->diffInHours($startDay) + 1, $n);
        //day date format
        $endDay = $this->generateRandomDateAfter($start, false, false, true);
        $end = $endDay->toDateString();
        $st = $startDay->copy()->startOfDay();
        $n = 0;
        foreach (DatePeriod::getPeriodGenerator(DatePeriod::TYPE_PERIOD_DAY, $start, $end) as $item) {
            self::assertEquals($st->toDateString(), $item->getTitle());
            $st->addDay(1);
            $n++;
        }
        self::assertEquals($endDay->copy()->startOfDay()->diffInDays($startDay->copy()->startOfDay()) + 1, $n);
        //day datetime format
        $st = $startDay->copy()->startOfDay();
        $n = 0;
        foreach (DatePeriod::getPeriodGenerator(DatePeriod::TYPE_PERIOD_DAY, $start, $end, DatePeriod::TYPE_DATETIME) as $item) {
            self::assertEquals($st->toDateTimeString(), $item->getStartString());
            $st->addDay(1);
            $n++;
        }
        self::assertEquals($endDay->copy()->startOfDay()->diffInDays($startDay->copy()->startOfDay()) + 1, $n);
        //week
        $endDay = $this->generateRandomDateAfter($start, false, false, true);
        $end = $endDay->toDateString();
        $st = $startDay->copy()->startOfWeek();
        $n = 0;
        foreach (DatePeriod::getPeriodGenerator(DatePeriod::TYPE_PERIOD_WEEK, $start, $end) as $item) {
            self::assertEquals($st->format('Y-m') . ' W' . $st->weekOfMonth, $item->getTitle());
            $st->addWeek(1);
            $n++;
        }
        self::assertEquals($endDay->copy()->startOfWeek()->diffInWeeks($startDay->copy()->startOfWeek()) + 1, $n);
        //month
        $endDay = $this->generateRandomDateAfter($start, false, true);
        $end = $endDay->toDateString();
        $st = $startDay->copy()->startOfMonth();
        $n = 0;
        foreach (DatePeriod::getPeriodGenerator(DatePeriod::TYPE_PERIOD_MONTH, $start, $end) as $item) {
            self::assertEquals($st->format('Y-m'), $item->getTitle());
            $st->addMonth(1);
            $n++;
        }
        self::assertEquals($endDay->copy()->startOfMonth()->diffInMonths($startDay->copy()->startOfMonth()) + 1, $n);
        //season
        $endDay = $this->generateRandomDateAfter($start, false, true);
        $end = $endDay->toDateString();
        $st = $startDay->copy()->startOfMonth();
        $n = 0;
        foreach (DatePeriod::getPeriodGenerator(DatePeriod::TYPE_PERIOD_SEASON, $start, $end) as $item) {
            self::assertEquals($st->format('Y-' . ceil($st->month / 3)), $item->getTitle());
            $st->addQuarter(1);
            $n++;
        }
        self::assertEquals(floor($endDay->copy()->startOfQuarter()->diffInMonths($startDay->copy()->startOfQuarter()) / 3) + 1, $n);
        //year
        $endDay = $this->generateRandomDateAfter($start, true);
        $end = $endDay->toDateString();
        $st = $startDay->copy()->startOfYear();
        $n = 0;
        foreach (DatePeriod::getPeriodGenerator(DatePeriod::TYPE_PERIOD_YEAR, $start, $end) as $item) {
            self::assertEquals($st->format('Y'), $item->getTitle());
            $st->addYear(1);
            $n++;
        }
        self::assertEquals($endDay->copy()->diffInYears($startDay->copy()->startOfYear()) + 1, $n);
    }

    /**
     * @param $date
     * @param bool $year
     * @param bool $month
     * @param bool $day
     * @param bool $hour
     * @param bool $minute
     * @param bool $second
     * @return Carbon
     */
    protected function generateRandomDateAfter($date, $year = true, $month = true, $day = true, $hour = true, $minute = true, $second = true)
    {
        $cb = new Carbon($date);
        if ($year) {
            $cb->addYears(mt_rand(0, 10));
        }
        if ($month) {
            $cb->addMonths(mt_rand(0, 11));
        }
        if ($day) {
            $cb->addDays(mt_rand(0, 30));
        }
        if ($hour) {
            $cb->addHours(mt_rand(0, 23));
        }
        if ($minute) {
            $cb->addMinutes(mt_rand(0, 59));
        }
        if ($second) {
            $cb->addSeconds(mt_rand(0, 59));
        }
        return $cb;
    }

}
