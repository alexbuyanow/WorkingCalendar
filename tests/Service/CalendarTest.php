<?php

namespace App\Service;

use DateTime;
use Illuminate\Support\Collection;

/**
 *
 * Working days calendar service test
 *
 * @package App\Service
 */
class CalendarTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test regular week working and weekend days
     *
     * @return void
     */
    public function testIsWorkingDayWithoutExcepted()
    {

        $calendar = new Calendar(new Collection());

        $dayMonday = new DateTime('2013-04-22');
        $this->assertTrue($calendar->isWorkingDay($dayMonday));

        $dayTuesday = new DateTime('2013-04-23');
        $this->assertTrue($calendar->isWorkingDay($dayTuesday));

        $dayWednesday = new DateTime('2013-04-24');
        $this->assertTrue($calendar->isWorkingDay($dayWednesday));

        $dayThursday = new DateTime('2013-04-25');
        $this->assertTrue($calendar->isWorkingDay($dayThursday));

        $dayFriday = new DateTime('2013-04-26');
        $this->assertTrue($calendar->isWorkingDay($dayFriday));

        $daySaturday = new DateTime('2013-04-27');
        $this->assertFalse($calendar->isWorkingDay($daySaturday));

        $daySunday = new DateTime('2013-04-28');
        $this->assertFalse($calendar->isWorkingDay($daySunday));
    }

    /**
     * Test holidays on week working days
     *
     * @return void
     */
    public function testIsWorkingDayWithExcepted()
    {
        $calendarEntities = new Collection(
            [
                $this->getDateModelMock('2013-04-22'),
                $this->getDateModelMock('2013-04-27'),
            ]
        );
        $calendar = new Calendar($calendarEntities);

        $this->assertFalse($calendar->isWorkingDay(new DateTime('2013-04-22')));
        $this->assertFalse($calendar->isWorkingDay(new DateTime('2013-04-22 12:00:00')));
        $this->assertTrue($calendar->isWorkingDay(new DateTime('2013-04-27')));
        $this->assertTrue($calendar->isWorkingDay(new DateTime('2013-04-27 12:00:00')));

    }

    /**
     * Test add working days without excepted days
     *  (holidays on working or working weekends)
     *
     * @return void
     */
    public function testAddWorkDaysWithoutExcepted()
    {
        $calendar  = new Calendar(new Collection());
        $startDate = new DateTime('2013-04-24');

        $startDateAndOneWorkDay = $calendar->add($startDate, 1);
        $this->assertEquals(new DateTime('2013-04-25'), $startDateAndOneWorkDay);

        $startDateAndWorkDaysWithOneHoliday = $calendar->add($startDate, 3);
        $this->assertEquals(new DateTime('2013-04-29'), $startDateAndWorkDaysWithOneHoliday);

        $startDateAndWorkDaysWithAnyHolidays = $calendar->add($startDate, 10);
        $this->assertEquals(new DateTime('2013-05-08'), $startDateAndWorkDaysWithAnyHolidays);
    }


    /**
     * Test add working days with excepted days
     *  (holidays on working or working weekends)
     *
     * @return void
     */
    public function testAddWorkDaysWithExcepted()
    {
        $startDate = new DateTime('2013-04-24');

        $calendarEntities = new Collection(
            [
                $this->getDateModelMock('2013-04-25'),
            ]
        );
        $calendar = new Calendar($calendarEntities);

        $startDateAndOneWorkDay = $calendar->add($startDate, 1);
        $this->assertEquals(new DateTime('2013-04-26'), $startDateAndOneWorkDay);

        $startDateAndWorkDaysWithOneHoliday = $calendar->add($startDate, 3);
        $this->assertEquals(new DateTime('2013-04-30'), $startDateAndWorkDaysWithOneHoliday);

        $startDateAndWorkDaysWithAnyHolidays = $calendar->add($startDate, 10);
        $this->assertEquals(new DateTime('2013-05-09'), $startDateAndWorkDaysWithAnyHolidays);


        $calendarEntities = new Collection(
            [
                $this->getDateModelMock('2013-04-27'),
            ]
        );
        $calendar = new Calendar($calendarEntities);

        $startDateAndWorkDaysWithOneHoliday = $calendar->add($startDate, 3);
        $this->assertEquals(new DateTime('2013-04-27'), $startDateAndWorkDaysWithOneHoliday);

        $startDateAndWorkDaysWithAnyHolidays = $calendar->add($startDate, 10);
        $this->assertEquals(new DateTime('2013-05-07'), $startDateAndWorkDaysWithAnyHolidays);
    }

    /**
     * Test sub working days without excepted days
     *  (holidays on working or working weekends)
     *
     * @return void
     */
    public function testSubWorkDaysWithoutExcepted()
    {
        $calendar  = new Calendar(new Collection());
        $startDate = new DateTime('2013-04-24');

        $startDateAndOneWorkDay = $calendar->sub($startDate, 1);
        $this->assertEquals(new DateTime('2013-04-23'), $startDateAndOneWorkDay);

        $startDateAndWorkDaysWithOneHoliday = $calendar->sub($startDate, 3);
        $this->assertEquals(new DateTime('2013-04-19'), $startDateAndWorkDaysWithOneHoliday);

        $startDateAndWorkDaysWithAnyHolidays = $calendar->sub($startDate, 10);
        $this->assertEquals(new DateTime('2013-04-10'), $startDateAndWorkDaysWithAnyHolidays);
    }

    /**
     * Test sub working days with excepted days
     *  (holidays on working or working weekends)
     *
     * @return void
     */
    public function testSubWorkDaysWithExcepted()
    {
        $startDate = new DateTime('2013-04-24');

        $calendarEntities = new Collection(
            [
                $this->getDateModelMock('2013-04-23'),
            ]
        );
        $calendar = new Calendar($calendarEntities);

        $startDateAndOneWorkDay = $calendar->sub($startDate, 1);
        $this->assertEquals(new DateTime('2013-04-22'), $startDateAndOneWorkDay);

        $startDateAndWorkDaysWithOneHoliday = $calendar->sub($startDate, 3);
        $this->assertEquals(new DateTime('2013-04-18'), $startDateAndWorkDaysWithOneHoliday);

        $startDateAndWorkDaysWithAnyHolidays = $calendar->sub($startDate, 10);
        $this->assertEquals(new DateTime('2013-04-09'), $startDateAndWorkDaysWithAnyHolidays);


        $calendarEntities = new Collection(
            [
                $this->getDateModelMock('2013-04-20'),
            ]
        );
        $calendar = new Calendar($calendarEntities);

        $startDateAndWorkDaysWithOneHoliday = $calendar->sub($startDate, 3);
        $this->assertEquals(new DateTime('2013-04-20'), $startDateAndWorkDaysWithOneHoliday);

        $startDateAndWorkDaysWithAnyHolidays = $calendar->sub($startDate, 10);
        $this->assertEquals(new DateTime('2013-04-11'), $startDateAndWorkDaysWithAnyHolidays);
    }

    /**
     * Test exception in working days count then first date later than second
     *
     * @return void
     */
    public function testCountWorkingDaysExceptionFirstDateLater()
    {
        $calendar = new Calendar(new Collection());

        $this->setExpectedException('InvalidArgumentException');
        $diffOneDay = $calendar->countWorkingDays(new DateTime('2013-04-25'), new DateTime('2013-04-24'));
        $this->assertEquals(1, $diffOneDay);
    }

    /**
     * Test working days count without excepted days
     *  (holidays on working or working weekends)
     *
     * @return void
     */
    public function testCountWorkingDaysWithoutExcepted()
    {
        $calendar = new Calendar(new Collection());

        $diffZeroDay = $calendar->countWorkingDays(
            new DateTime('2013-04-24'),
            new DateTime('2013-04-24')
        );
        $this->assertEquals(0, $diffZeroDay);

        $diffZeroDayWithTime = $calendar->countWorkingDays(
            new DateTime('2013-04-24 12:00:00'),
            new DateTime('2013-04-24 15:10:00')
        );
        $this->assertEquals(0, $diffZeroDayWithTime);

        $diffOneDay = $calendar->countWorkingDays(
            new DateTime('2013-04-24'),
            new DateTime('2013-04-25')
        );
        $this->assertEquals(1, $diffOneDay);

        $diffOneDay = $calendar->countWorkingDays(
            new DateTime('2013-04-26'),
            new DateTime('2013-04-27')
        );
        $this->assertEquals(0, $diffOneDay);

        $diffOneDayWithTime = $calendar->countWorkingDays(
            new DateTime('2013-04-24 12:00:00'),
            new DateTime('2013-04-25 15:10:00')
        );
        $this->assertEquals(1, $diffOneDayWithTime);

        $diffTenDays = $calendar->countWorkingDays(
            new DateTime('2013-04-24'),
            new DateTime('2013-05-08')
        );
        $this->assertEquals(10, $diffTenDays);

        $diffTenDaysWithTime = $calendar->countWorkingDays(
            new DateTime('2013-04-24 12:00:00'),
            new DateTime('2013-05-08 15:10:00')
        );
        $this->assertEquals(10, $diffTenDaysWithTime);
    }

    /**
     * Test working days count with excepted days
     *  (holidays on working or working weekends)
     *
     * @return void
     */
    public function testCountWorkingDaysWithExcepted()
    {
        $calendarEntities = new Collection(
            [
                $this->getDateModelMock('2013-04-25'),
            ]
        );
        $calendar = new Calendar($calendarEntities);

        $diffZeroDay = $calendar->countWorkingDays(new DateTime('2013-04-24'), new DateTime('2013-04-24'));
        $this->assertEquals(0, $diffZeroDay);

        $diffOneDay = $calendar->countWorkingDays(new DateTime('2013-04-24'), new DateTime('2013-04-25'));
        $this->assertEquals(0, $diffOneDay);

        $diffTenDays = $calendar->countWorkingDays(new DateTime('2013-04-24'), new DateTime('2013-05-08'));
        $this->assertEquals(9, $diffTenDays);


        $calendarEntities = new Collection(
            [
                $this->getDateModelMock('2013-04-27'),
            ]
        );
        $calendar = new Calendar($calendarEntities);

        $diffOneDay = $calendar->countWorkingDays(new DateTime('2013-04-26'), new DateTime('2013-04-27'));
        $this->assertEquals(1, $diffOneDay);

        $diffTenDays = $calendar->countWorkingDays(new DateTime('2013-04-24'), new DateTime('2013-05-08'));
        $this->assertEquals(11, $diffTenDays);
    }

    /**
     * Test nearest working day getting without excepted days
     *  (holidays on working or working weekends)
     *
     * @return void
     */
    public function testGetWorkingDayWithoutExcepted()
    {
        $calendar = new Calendar(new Collection());

        $this->assertEquals($calendar->getWorkingDay(new DateTime('2013-04-26')), new DateTime('2013-04-26'));
        $this->assertEquals($calendar->getWorkingDay(new DateTime('2013-04-27')), new DateTime('2013-04-29'));
        $this->assertEquals($calendar->getWorkingDay(new DateTime('2013-04-28')), new DateTime('2013-04-29'));
    }


    /**
     * Test nearest working day getting without excepted days
     *  (holidays on working or working weekends)
     *
     * @return void
     */
    public function testGetWorkingDayWithExcepted()
    {
        $calendarEntities = new Collection(
            [
                $this->getDateModelMock('2013-04-26'),
            ]
        );
        $calendar = new Calendar($calendarEntities);

        $this->assertEquals($calendar->getWorkingDay(new DateTime('2013-04-26')), new DateTime('2013-04-29'));
        $this->assertEquals($calendar->getWorkingDay(new DateTime('2013-04-27')), new DateTime('2013-04-29'));
        $this->assertEquals($calendar->getWorkingDay(new DateTime('2013-04-28')), new DateTime('2013-04-29'));

        $calendarEntities->push($this->getDateModelMock('2013-04-27'));

        $this->assertEquals($calendar->getWorkingDay(new DateTime('2013-04-26')), new DateTime('2013-04-27'));
        $this->assertEquals($calendar->getWorkingDay(new DateTime('2013-04-27')), new DateTime('2013-04-27'));
        $this->assertEquals($calendar->getWorkingDay(new DateTime('2013-04-28')), new DateTime('2013-04-29'));
    }

    /**
     * Get Date model mock
     *
     * @param $date
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getDateModelMock($date)
    {
        $mock = $this->getMock('App\Model\FilteredModelInterface', ['getAttribute']);
        $mock->expects($this->any())
            ->method('getAttribute')
            ->will($this->returnValue(new DateTime($date)));
        return $mock;
    }
}