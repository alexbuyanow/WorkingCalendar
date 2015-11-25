<?php

namespace App\Service;

use DateTime;

/**
 * Working calendar service interface
 */
interface CalendarInterface
{
    /**
     * Add N working days to date
     *
     * @param  DateTime $date
     * @param  int      $daysNumber
     * @return DateTime
     */
    public function add(DateTime $date, $daysNumber);

    /**
     * Sub N working days frpm date
     *
     * @param  DateTime $date
     * @param  int      $daysNumber
     * @return DateTime
     */
    public function sub(DateTime $date, $daysNumber);

    /**
     * Working days count between dates
     *
     * @param  DateTime                           $from
     * @param  DateTime                           $to
     * @return int
     * @throws Exception\InvalidArgumentException Date From later then date To
     */
    public function countWorkingDays(DateTime $from, DateTime $to);

    /**
     * Is date working day
     *
     * @param  DateTime $date
     * @return bool
     */
    public function isWorkingDay(DateTime $date);

    /**
     * Getting nearest working day
     *  (today if working or tomorrow if not)
     *
     * @param  DateTime $date
     * @return DateTime
     */
    public function getWorkingDay(DateTime $date);
}
