<?php

namespace App\Service;

use App\Filter\Date;
use DateInterval;
use DateTime;
use Illuminate\Support\Collection;

/**
 * Working calendar service
 *
 * @package App\Service
 */
class Calendar implements CalendarInterface
{

    const OPERATIONAL_DATE_FORMAT = 'Y-m-d';

    /**
     * Working days numbers
     *
     * @var array
     */
    private $weekWorkDayArray = array(1, 2, 3, 4, 5);

    /**
     * Weekend days numbers
     *
     * @var array
     */
    private $weekHolyDayArray = array(0, 6);

    /**
     * One day Interval object
     *
     * @var DateInterval
     */
    private $oneDayInterval;

    /**
     * Except days collection
     * - except if holiday get on working day
     * - except if weekend day stay working day
     *
     * @var Collection
     */
    private $exceptDaysCollection;


    /**
     * @param Collection $collection
     */
    public function __construct(Collection $collection)
    {
        $this->oneDayInterval          = new DateInterval('P1D');
        $this->exceptDaysCollection = $collection;
    }

    /**
     * Add N working days to date
     *
     * @param DateTime $date
     * @param integer $daysNumber
     * @return DateTime
     */
    public function add(DateTime $date, $daysNumber)
    {
        $workingDateObject = clone $date;
        $iterationValue    = 0;

        $fromFilter = new Date\From($this->normalizeDateToBegin($date));
        $exceptedDays = $this->exceptDaysCollection
            ->filter($fromFilter->filterCallback());

        while($iterationValue < $daysNumber)
        {
            $workingDateObject->add($this->oneDayInterval);
            $iterationValue += $this->incrementCounterIfDayWorking($workingDateObject, $exceptedDays);
        }

        return $workingDateObject;
    }

    /**
     * Sub N working days frpm date
     *
     * @param DateTime $date
     * @param int      $daysNumber
     * @return DateTime
     */
    public function sub(DateTime $date, $daysNumber)
    {
        $workingDateObject = clone $date;
        $iterationValue    = 0;

        $toFilter = new Date\To($this->normalizeDateToEnd($date));
        $exceptedDays = $this->exceptDaysCollection
            ->filter($toFilter->filterCallback());

        while($iterationValue < $daysNumber)
        {
            $workingDateObject->sub($this->oneDayInterval);
            $iterationValue += $this->incrementCounterIfDayWorking($workingDateObject, $exceptedDays);
        }

        return $workingDateObject;
    }

    /**
     * Working days count between dates
     *
     * @param DateTime $from
     * @param DateTime $to
     * @return integer
     * @throws Exception\InvalidArgumentException Date From later then date To
     */
    public function countWorkingDays(DateTime $from, DateTime $to)
    {
        if($from > $to)
        {
            throw new Exception\InvalidArgumentException('First date is later then second one');
        }

        $from       = clone $from;
        $to         = clone $to;
        $daysNumber = $this->normalizeDateToNoon($from)->diff($this->normalizeDateToNoon($to))->days;

        if($daysNumber === 0)
        {
            return 0;
        }

        $rangeFilter = new Date\Range(
            $this->normalizeDateToBegin($from),
            $this->normalizeDateToEnd($to)
        );
        $exceptedDays = $this->exceptDaysCollection
            ->filter($rangeFilter->filterCallback());

        $workingDateObject = clone $from;
        $iterationValue    = 0;

        while($daysNumber > 0)
        {
            $workingDateObject = $workingDateObject->add($this->oneDayInterval);
            $iterationValue   += $this->incrementCounterIfDayWorking($workingDateObject, $exceptedDays);
            $daysNumber--;
        }

        return $iterationValue;

    }

    /**
     * Is date working day
     *
     * @param DateTime $date
     * @return bool
     */
    public function isWorkingDay(DateTime $date)
    {
        return $this->isWorkingDayInCollection(
            $this->normalizeDateToBegin($date),
            $this->exceptDaysCollection
        );
    }

    /**
     * Is date working by collection
     *
     * @param DateTime   $date
     * @param Collection $exceptedDays
     * @return bool
     */
    private function isWorkingDayInCollection(DateTime $date, Collection $exceptedDays)
    {
        $isExcepted = $this->isExceptedByCollection($date, $exceptedDays);

        return
            ($this->isWeekWorkDay($date) && !$isExcepted) ||
            ($this->isWeekEndDay($date) && $isExcepted)
            ;
    }

    /**
     * Getting nearest working day
     *  (today if working or tomorrow if not)
     *
     * @param DateTime $date
     * @return DateTime
     */
    public function getWorkingDay(DateTime $date)
    {

        $fromFilter = new Date\From($this->normalizeDateToBegin($date));
        $exceptedDays = $this->exceptDaysCollection
            ->filter($fromFilter->filterCallback());

        while(!$this->isWorkingDay($date))
        {
            $date->add($this->oneDayInterval);
        }

        return $date;
    }


    /**
     * Is date week working date
     *
     * @param DateTime $date
     * @return bool
     */
    private function isWeekWorkDay(DateTime $date)
    {
        return in_array($date->format('w'), $this->weekWorkDayArray);
    }

    /**
     * Is date week weekend date
     *
     * @param DateTime $date
     * @return bool
     */
    private function isWeekEndDay(DateTime $date)
    {
        return in_array($date->format('w'), $this->weekHolyDayArray);
    }

    /**
     * Incremnt if day is working
     *
     * @param DateTime   $date
     * @param Collection $exceptedDays
     * @return integer
     */
    private function incrementCounterIfDayWorking($date, Collection $exceptedDays)
    {
        if($this->isWorkingDay($date))
        {
            return 1;
        }
        return 0;
    }

    /**
     * Is day excepted by collection
     *
     * @param DateTime   $date
     * @param Collection $exceptedDays
     * @return bool
     */
    private function isExceptedByCollection(DateTime $date, Collection $exceptedDays)
    {
        return !$exceptedDays
            ->filter((new Date\Equal($date))->filterCallback())
            ->isEmpty();
    }

    /**
     * Date formatter
     *
     * @param DateTime $date
     * @return string
     */
    private function getDateSqlFormat(DateTime $date)
    {
        return $date->format(static::OPERATIONAL_DATE_FORMAT);
    }

    /**
     * Get day beginning date (time 00:00:00)
     *
     * @param DateTime $date
     * @return DateTime
     */
    private function normalizeDateToBegin(DateTime $date)
    {
        $date = clone $date;
        return $date->modify('midnight');
    }

    /**
     * Get day ending date (time 23:59:59)
     *
     * @param DateTime $date
     * @return DateTime
     */
    private function normalizeDateToEnd(DateTime $date)
    {
        $date = clone $date;
        return $date->modify('tomorrow midnight -1 second');
    }

    /**
     * Get day noon date (time 12:00:00)
     *
     * @param DateTime $date
     * @return DateTime
     */
    private function normalizeDateToNoon(DateTime $date)
    {
        $date = clone $date;
        return $date->modify('noon');
    }
}
