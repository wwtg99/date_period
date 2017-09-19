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
        $start = $faker->date();
        $startDay = new Carbon($start);
        //none period
        $endDay = $this->generateRandomDateAfter($start);
        $end = $endDay->toDateString();
        $arr = DatePeriod::getPeriodArray(DatePeriod::TYPE_PERIOD_NONE, $start, $end);
        self::assertEquals(1, count($arr));
        self::assertEquals($start, $arr[0]->getStartString());
        self::assertEquals($end, $arr[0]->getEndString());
        //day
        $endDay = $this->generateRandomDateAfter($start, false, false, true);
        $end = $endDay->toDateString();
        $arr = DatePeriod::getPeriodArray(DatePeriod::TYPE_PERIOD_DAY, $start, $end);
        self::assertEquals($endDay->diffInDays($startDay) + 1, count($arr));
        $st = $startDay->copy();
        foreach ($arr as $item) {
            self::assertEquals($st->toDateString(), $item->getTitle());
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
        $st = $startDay->copy();
        foreach ($arr as $item) {
            self::assertEquals($st->format('Y-m'), $item->getTitle());
            $st->addMonth(1);
        }
        //year
        $endDay = $this->generateRandomDateAfter($start, true);
        $end = $endDay->toDateString();
        $arr = DatePeriod::getPeriodArray(DatePeriod::TYPE_PERIOD_YEAR, $start, $end);
        self::assertEquals($endDay->diffInYears($startDay->copy()->startOfYear()) + 1, count($arr));
        $st = $startDay->copy();
        foreach ($arr as $item) {
            self::assertEquals($st->format('Y'), $item->getTitle());
            $st->addYear(1);
        }
    }

    public function testDatePeriodGenerator()
    {
        //date type
        $faker = Factory::create();
        $start = $faker->date();
        $startDay = new Carbon($start);
        //none period
        $endDay = $this->generateRandomDateAfter($start);
        $end = $endDay->toDateString();
        foreach (DatePeriod::getPeriodGenerator(DatePeriod::TYPE_PERIOD_NONE, $start, $end) as $item) {
            self::assertEquals($start, $item->getStartString());
            self::assertEquals($end, $item->getEndString());
        }
        //day
        $endDay = $this->generateRandomDateAfter($start, false, false, true);
        $end = $endDay->toDateString();
        $st = $startDay->copy();
        foreach (DatePeriod::getPeriodGenerator(DatePeriod::TYPE_PERIOD_DAY, $start, $end) as $item) {
            self::assertEquals($st->toDateString(), $item->getTitle());
            $st->addDay(1);
        }
        //week
        $endDay = $this->generateRandomDateAfter($start, false, false, true);
        $end = $endDay->toDateString();
        $st = $startDay->copy()->startOfWeek();
        foreach (DatePeriod::getPeriodGenerator(DatePeriod::TYPE_PERIOD_WEEK, $start, $end) as $item) {
            self::assertEquals($st->format('Y-m') . ' W' . $st->weekOfMonth, $item->getTitle());
            $st->addWeek(1);
        }
        //month
        $endDay = $this->generateRandomDateAfter($start, false, true);
        $end = $endDay->toDateString();
        $st = $startDay->copy()->startOfMonth();
        foreach (DatePeriod::getPeriodGenerator(DatePeriod::TYPE_PERIOD_MONTH, $start, $end) as $item) {
            self::assertEquals($st->format('Y-m'), $item->getTitle());
            $st->addMonth(1);
        }
        //year
        $endDay = $this->generateRandomDateAfter($start, true);
        $end = $endDay->toDateString();
        $st = $startDay->copy()->startOfYear();
        foreach (DatePeriod::getPeriodGenerator(DatePeriod::TYPE_PERIOD_MONTH, $start, $end) as $item) {
            self::assertEquals($st->format('Y'), $item->getTitle());
            $st->addYear(1);
        }
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
