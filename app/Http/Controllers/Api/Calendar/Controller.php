<?php

namespace App\Http\Controllers\Api\Calendar;

use App\Http\Controllers\Controller as BaseController;
use App\Model\Date;
use App\Service\Calendar;
use App\Service\CalendarInterface;
use DateTime;

/**
 * Working days Api controller
 *
 * @package App\Http\Controllers\Api\Calendar
 */
class Controller extends BaseController
{

    protected $dateFormat = Calendar::OPERATIONAL_DATE_FORMAT;

    /** @var  Date */
    protected $date;

    /** @var  CalendarInterface */
    protected $calendarService;


    /**
     * @param Calendar $calendarService
     * @param Date $date
     */
    public function __construct(Calendar $calendarService, Date $date)
    {
        $this->calendarService      = $calendarService;
        $this->date                 = $date;
    }

    /**
     * @param string $date
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function isWorkingDay($date)
    {
        return response()->json(
            [
                'success'        => true,
                'is_working'     => $this->calendarService->isWorkingDay($this->getDateFromString($date)),
            ]
        );
    }

    /**
     * @param string $date
     * @param integer $days
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addWorkingDays($date, $days)
    {
        return response()->json(
            [
                'success'        => true,
                'result_date'    => $this->calendarService->add($this->getDateFromString($date), $days)->format($this->dateFormat),
            ]
        );
    }

    /**
     * @param string $date
     * @param integer $days
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addDays($date, $days)
    {
        $modifyString = sprintf('+%s days', $days);
        return response()->json(
            [
                'success'        => true,
                'result_date'    => $this->getModifiedDate($date, $modifyString)->format($this->dateFormat),
            ]
        );
    }

    /**
     * @param string $date
     * @param integer $days
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function subWorkingDays($date, $days)
    {
        return response()->json(
            [
                'success'        => true,
                'result_date'    => $this->calendarService->sub($this->getDateFromString($date), $days)->format($this->dateFormat),
            ]
        );
    }

    /**
     * @param string $date
     * @param integer $days
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function subDays($date, $days)
    {
        $modifyString = sprintf('-%s days', $days);
        return response()->json(
            [
                'success'        => true,
                'result_date'    => $this->getModifiedDate($date, $modifyString)->format($this->dateFormat),
            ]
        );
    }

    /**
     * @param string $dateFrom
     * @param string $dateTo
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function countWorkingDays($dateFrom, $dateTo)
    {
        return response()->json(
            [
                'success'        => true,
                'result_count'    => $this->calendarService
                    ->countWorkingDays(
                        $this->getDateFromString($dateFrom),
                        $this->getDateFromString($dateTo)
                    ),
            ]
        );
    }

    /**
     * @param string $dateFrom
     * @param string $dateTo
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function countDays($dateFrom, $dateTo)
    {
        return response()->json(
            [
                'success'        => true,
                'result_count'    => $this->getDateFromString($dateFrom)
                    ->diff($this->getDateFromString($dateTo))->days,
            ]
        );
    }


    /**
     * Convert string date to DateTime
     *
     * @param string $date
     * @return DateTime
     * @throws Exception\InvalidArgumentException invalid date string
     */
    private function getDateFromString($date)
    {
        $dateObject = DateTime::createFromFormat($this->dateFormat, $date);

        if($dateObject && $date == $dateObject->format($this->dateFormat))
        {
            return $dateObject;
        }

        $exceptionString = sprintf('Invalid date %s', $date);
        throw new Exception\InvalidArgumentException($exceptionString, 400);
    }

    /**
     * Date modifier
     *
     * @param string $date
     * @param string $modifyString
     * @return DateTime
     */
    private function getModifiedDate($date, $modifyString)
    {
        return $this->getDateFromString($date)->modify($modifyString);
    }

}