<?php
/**
 * Created by PhpStorm.
 * User: wuwentao
 * Date: 2017/9/18
 * Time: 10:20
 */

namespace Wwtg99\DatePeriod;


use Carbon\Carbon;
use Carbon\CarbonInterval;

class DatePeriod extends CarbonInterval
{

    /**
     * date type
     */
    const TYPE_DATE = 1;
    const TYPE_DATETIME = 2;

    /**
     * period type
     */
    const TYPE_PERIOD_NONE = 0;
    const TYPE_PERIOD_SECOND = 1;
    const TYPE_PERIOD_MINUTE = 2;
    const TYPE_PERIOD_HOUR = 3;
    const TYPE_PERIOD_DAY = 4;
    const TYPE_PERIOD_WEEK = 5;
    const TYPE_PERIOD_MONTH = 6;
    const TYPE_PERIOD_SEASON = 7;
    const TYPE_PERIOD_YEAR = 8;

    /**
     * @var int
     */
    protected $dateType = DatePeriod::TYPE_DATE;

    /**
     * @var int
     */
    protected $periodType = DatePeriod::TYPE_PERIOD_NONE;

    /**
     * @var Carbon
     */
    protected $start;

    /**
     * @var Carbon
     */
    protected $end;

    /**
     * @var string
     */
    protected $title;

    /**
     * @param int $periodType
     * @param $start
     * @param $end
     * @param int $dateType
     * @return array
     */
    public static function getPeriodArray($periodType, $start = null, $end = null, $dateType = DatePeriod::TYPE_DATE)
    {
        if ($start) {
            $startDay = new Carbon($start);
        } else {
            $startDay = Carbon::yesterday();
        }
        if ($end) {
            $endDay = new Carbon($end);
        } else {
            $endDay = Carbon::today();
        }
        switch ($periodType) {
            case DatePeriod::TYPE_PERIOD_SECOND: $arr = static::secondArray($startDay, $endDay); break;
            case DatePeriod::TYPE_PERIOD_MINUTE: $arr = static::minuteArray($startDay, $endDay); break;
            case DatePeriod::TYPE_PERIOD_HOUR: $arr = static::hourArray($startDay, $endDay); break;
            case DatePeriod::TYPE_PERIOD_DAY: $arr = static::dayArray($startDay, $endDay); break;
            case DatePeriod::TYPE_PERIOD_WEEK: $arr = static::weekArray($startDay, $endDay); break;
            case DatePeriod::TYPE_PERIOD_MONTH: $arr = static::monthArray($startDay, $endDay); break;
            case DatePeriod::TYPE_PERIOD_SEASON: $arr = static::seasonArray($startDay, $endDay); break;
            case DatePeriod::TYPE_PERIOD_YEAR: $arr = static::yearArray($startDay, $endDay); break;
            default: $arr = static::nonePeriodArray($startDay, $endDay);
        }
        return $arr;
    }

    /**
     * @param int $periodType
     * @param $start
     * @param $end
     * @param int $dateType
     * @return \Generator|void
     */
    public static function getPeriodGenerator($periodType, $start = null, $end = null, $dateType = DatePeriod::TYPE_DATE)
    {
        if ($start) {
            $startDay = new Carbon($start);
        } else {
            $startDay = Carbon::yesterday();
        }
        if ($end) {
            $endDay = new Carbon($end);
        } else {
            $endDay = Carbon::today();
        }
        switch ($periodType) {
            case DatePeriod::TYPE_PERIOD_SECOND: return static::secondGenerator($startDay, $endDay);
            case DatePeriod::TYPE_PERIOD_MINUTE: return static::minuteGenerator($startDay, $endDay);
            case DatePeriod::TYPE_PERIOD_HOUR: return static::hourGenerator($startDay, $endDay);
            case DatePeriod::TYPE_PERIOD_DAY: return static::dayGenerator($startDay, $endDay);
            case DatePeriod::TYPE_PERIOD_WEEK: return static::weekGenerator($startDay, $endDay);
            case DatePeriod::TYPE_PERIOD_MONTH: return static::monthGenerator($startDay, $endDay);
            case DatePeriod::TYPE_PERIOD_SEASON: return static::seasonGenerator($startDay, $endDay);
            case DatePeriod::TYPE_PERIOD_YEAR: return static::yearGenerator($startDay, $endDay);
            default: {
                foreach (static::nonePeriodArray($startDay, $endDay) as $item) {
                    yield $item;
                }
            }
        }
    }

    /**
     * @return string
     */
    public function getStartString()
    {
        if ($this->getDateType() == DatePeriod::TYPE_DATETIME) {
            return $this->start->toDateTimeString();
        } else {
            return $this->start->toDateString();
        }
    }

    /**
     * @return string
     */
    public function getEndString()
    {
        if ($this->getDateType() == DatePeriod::TYPE_DATETIME) {
            return $this->end->toDateTimeString();
        } else {
            return $this->end->toDateString();
        }
    }

    /**
     * @return int
     */
    public function getDateType()
    {
        return $this->dateType;
    }

    /**
     * @param int $dateType
     * @return DatePeriod
     */
    public function setDateType($dateType)
    {
        $this->dateType = $dateType;
        return $this;
    }

    /**
     * @return int
     */
    public function getPeriodType()
    {
        return $this->periodType;
    }

    /**
     * @param int $periodType
     * @return DatePeriod
     */
    public function setPeriodType($periodType)
    {
        $this->periodType = $periodType;
        return $this;
    }

    /**
     * @return Carbon
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param Carbon $start
     * @return DatePeriod
     */
    public function setStart($start)
    {
        $this->start = $start;
        return $this;
    }

    /**
     * @return Carbon
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @param Carbon $end
     * @return DatePeriod
     */
    public function setEnd($end)
    {
        $this->end = $end;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return DatePeriod
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Format the instance as a string using the forHumans() function.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle() . " From " . $this->getStartString() . ' to ' . $this->getEndString();
    }

    protected static function secondArray($startDay, $endDay)
    {
        throw new \Exception('Not supported yet');
    }

    protected static function minuteArray($startDay, $endDay)
    {
        throw new \Exception('Not supported yet');
    }

    protected static function hourArray($startDay, $endDay)
    {
        throw new \Exception('Not supported yet');
    }

    /**
     * @param Carbon $startDay
     * @param Carbon $endDay
     * @return array
     */
    protected static function dayArray($startDay, $endDay)
    {
        $arr = [];
        while ($endDay->gte($startDay)) {
            $dp = new DatePeriod(null, null, null, 1, null, null, null);
            $dp->setStart($startDay->copy());
            $dp->setTitle($startDay->toDateString());
            $dp->setEnd($startDay->addDay()->copy());
            $arr[] = $dp;
        }
        return $arr;
    }

    /**
     * @param Carbon $startDay
     * @param Carbon $endDay
     * @return array
     */
    protected static function weekArray($startDay, $endDay)
    {
        $arr = [];
        $startDay->startOfWeek();
        while ($endDay->gte($startDay)) {
            $dp = new DatePeriod(null, null, 1, null, null, null, null);
            $dp->setStart($startDay->copy());
            $dp->setTitle($startDay->format('Y-m ') . 'W' . $startDay->weekOfMonth);
            $dp->setEnd($startDay->addWeek()->copy());
            $arr[] = $dp;
        }
        return $arr;
    }

    /**
     * @param Carbon $startDay
     * @param Carbon $endDay
     * @return array
     */
    protected static function monthArray($startDay, $endDay)
    {
        $arr = [];
        $startDay->startOfMonth();
        while ($endDay->gte($startDay)) {
            $dp = new DatePeriod(null, 1);
            $dp->setStart($startDay->copy());
            $dp->setTitle($startDay->format('Y-m'));
            $dp->setEnd($startDay->addMonth()->copy());
            $arr[] = $dp;
        }
        return $arr;
    }

    protected static function seasonArray($startDay, $endDay)
    {
        throw new \Exception('Not supported yet');
    }

    /**
     * @param Carbon $startDay
     * @param Carbon $endDay
     * @return array
     */
    protected static function yearArray($startDay, $endDay)
    {
        $arr = [];
        $startDay->startOfYear();
        while ($endDay->gte($startDay)) {
            $dp = new DatePeriod(1);
            $dp->setStart($startDay->copy());
            $dp->setTitle($startDay->format('Y'));
            $dp->setEnd($startDay->addYear()->copy());
            $arr[] = $dp;
        }
        return $arr;
    }

    protected static function secondGenerator($startDay, $endDay)
    {
        throw new \Exception('Not supported yet');
    }

    protected static function minuteGenerator($startDay, $endDay)
    {
        throw new \Exception('Not supported yet');
    }

    protected static function hourGenerator($startDay, $endDay)
    {
        throw new \Exception('Not supported yet');
    }

    /**
     * @param Carbon $startDay
     * @param Carbon $endDay
     * @return \Generator
     */
    protected static function dayGenerator($startDay, $endDay)
    {
        while ($endDay->gte($startDay)) {
            $dp = new DatePeriod(null, null, null, 1, null, null, null);
            $dp->setStart($startDay->copy());
            $dp->setTitle($startDay->toDateString());
            $dp->setEnd($startDay->addDay()->copy());
            yield $dp;
        }
    }

    /**
     * @param Carbon $startDay
     * @param Carbon $endDay
     * @return \Generator
     */
    protected static function weekGenerator($startDay, $endDay)
    {
        $startDay->startOfWeek();
        while ($endDay->gte($startDay)) {
            $dp = new DatePeriod(null, null, 1);
            $dp->setStart($startDay->copy());
            $dp->setTitle($startDay->format('Y-m ') . 'W' . $startDay->weekOfMonth);
            $dp->setEnd($startDay->addWeek()->copy());
            yield $dp;
        }
    }

    /**
     * @param Carbon $startDay
     * @param Carbon $endDay
     * @return \Generator
     */
    protected static function monthGenerator($startDay, $endDay)
    {
        $startDay->startOfMonth();
        while ($endDay->gte($startDay)) {
            $dp = new DatePeriod(null, 1);
            $dp->setStart($startDay->copy());
            $dp->setTitle($startDay->format('Y-m'));
            $dp->setEnd($startDay->addMonth()->copy());
            yield $dp;
        }
    }

    protected static function seasonGenerator($startDay, $endDay)
    {
        throw new \Exception('Not supported yet');
    }

    /**
     * @param Carbon $startDay
     * @param Carbon $endDay
     * @return \Generator
     */
    protected static function yearGenerator($startDay, $endDay)
    {
        $startDay->startOfYear();
        while ($endDay->gte($startDay)) {
            $dp = new DatePeriod(1);
            $dp->setStart($startDay->copy());
            $dp->setTitle($startDay->format('Y'));
            $dp->setEnd($startDay->addYear()->copy());
            yield $dp;
        }
    }

    /**
     * @param Carbon $startDay
     * @param Carbon $endDay
     * @return array
     */
    protected static function nonePeriodArray($startDay, $endDay)
    {
        $dp = $endDay->diff($startDay);
        if (!$dp) {
            return [];
        }
        $dp = new DatePeriod($dp->y, $dp->m, null, $dp->d, $dp->h, $dp->i, $dp->s);
        $dp->setStart($startDay);
        $dp->setEnd($endDay);
        $dp->setTitle($startDay->toDateString() . ' ~ ' . $endDay->toDateString());
        return [$dp];
    }

}