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

    public function testIsWorkingDayWithoutExceptedDays()
    {
        $collection     = $this->getEmptyCollectionMock(2);
        $calendar       = new Calendar($collection);

        $this->assertTrue($calendar->isWorkingDay($this->getDateTimeWorkingDateMock()));
        $this->assertFalse($calendar->isWorkingDay($this->getDateTimeWeekEndDateMock()));
    }

    public function testIsWorkingDayWithExceptedDays()
    {
        $collection     = $this->getNotEmptyCollectionMock(2);
        $calendar       = new Calendar($collection);

        $this->assertFalse($calendar->isWorkingDay($this->getDateTimeWorkingDateMock()));
        $this->assertTrue($calendar->isWorkingDay($this->getDateTimeWeekEndDateMock()));
    }

    /**
     * Test add working days without excepted days
     *  (holidays on working or working weekends)
     *
     * @return void
     */
    public function testAddWorkDaysWithoutExceptedDays()
    {
        $collection     = $this->getEmptyCollectionMock(1);
        $calendar       = new Calendar($collection);

        $workDate       = $this->getDateTimeWorkingDateMock();
        $workDate
            ->expects($this->atLeast(1))
            ->method('add')
            ->willReturnSelf();

        $this->assertInstanceOf('\DateTime', $calendar->add($workDate, 1));

        $weekEndDate    = $this->getDateTimeWeekEndDateMock();
        $weekEndDate
            ->expects($this->atLeast(1))
            ->method('add')
            ->willReturn($workDate);

        $this->assertInstanceOf('\DateTime', $calendar->add($weekEndDate, 1));
    }


    /**
     * Test add working days with excepted days
     *  (holidays on working or working weekends)
     *
     * @return void
     */
    public function testAddWorkDaysWithExceptedDays()
    {
        $collection     = $this->getNotEmptyCollectionMock(1);
        $calendar       = new Calendar($collection);

        $weekEndDate    = $this->getDateTimeWeekEndDateMock();
        $workDate       = $this->getDateTimeWorkingDateMock();
        $workDate
            ->expects($this->atLeast(1))
            ->method('add')
            ->willReturn($weekEndDate);

        $this->assertInstanceOf('\DateTime', $calendar->add($workDate, 1));

        $weekEndDate
            ->expects($this->atLeast(1))
            ->method('add')
            ->willReturnSelf();

        $this->assertInstanceOf('\DateTime', $calendar->add($weekEndDate, 1));
    }

    /**
     * Test sub working days without excepted days
     *  (holidays on working or working weekends)
     *
     * @return void
     */
    public function testSubWorkDaysWithoutExceptedDays()
    {
        $collection     = $this->getEmptyCollectionMock(1);
        $calendar       = new Calendar($collection);

        $workDate       = $this->getDateTimeWorkingDateMock();
        $workDate
            ->expects($this->atLeast(1))
            ->method('sub')
            ->willReturnSelf();

        $this->assertInstanceOf('\DateTime', $calendar->sub($workDate, 1));

        $weekEndDate    = $this->getDateTimeWeekEndDateMock();
        $weekEndDate
            ->expects($this->atLeast(1))
            ->method('sub')
            ->willReturn($workDate);

        $this->assertInstanceOf('\DateTime', $calendar->sub($weekEndDate, 1));
    }

    /**
     * Test sub working days with excepted days
     *  (holidays on working or working weekends)
     *
     * @return void
     */
    public function testSubWorkDaysWithExceptedDays()
    {
        $collection     = $this->getNotEmptyCollectionMock(1);
        $calendar       = new Calendar($collection);

        $weekEndDate    = $this->getDateTimeWeekEndDateMock();
        $workDate       = $this->getDateTimeWorkingDateMock();
        $workDate
            ->expects($this->atLeast(1))
            ->method('sub')
            ->willReturn($weekEndDate);

        $this->assertInstanceOf('\DateTime', $calendar->sub($workDate, 1));

        $weekEndDate
            ->expects($this->atLeast(1))
            ->method('sub')
            ->willReturnSelf();

        $this->assertInstanceOf('\DateTime', $calendar->sub($weekEndDate, 1));
    }

    /**
     * Test working days count without excepted days
     *  (holidays on working or working weekends)
     *
     * @return void
     */
    public function testCountWorkingDaysWithoutExceptedDays()
    {
        $collection     = $this->getEmptyCollectionMock(0);
        $calendar       = new Calendar($collection);

        $dateFrom       = $this->getAbstractDateTimeMock();
        $dateTo         = $this->getAbstractDateTimeMock();

        $dateFrom
            ->expects($this->any())
            ->method('diff')
            ->willReturn($this->createDaysInterval(0));

        $this->assertEquals(0, $calendar->countWorkingDays($dateFrom, $dateTo));

        $dateFrom       = $this->getAbstractDateTimeMock();
        $dateFrom
            ->expects($this->atLeast(1))
            ->method('add')
            ->willReturn($this->getDateTimeWorkingDateMock());
        $dateFrom
            ->expects($this->any())
            ->method('diff')
            ->willReturn($this->createDaysInterval(1));

        $this->assertEquals(1, $calendar->countWorkingDays($dateFrom, $dateTo));
    }

    /**
     * Test working days count with excepted days
     *  (holidays on working or working weekends)
     *
     * @return void
     */
    public function testCountWorkingDaysWithExceptedDays()
    {
        $collection     = $this->getEmptyCollectionMock(1);
        $calendar       = new Calendar($collection);

        $dateFrom       = $this->getAbstractDateTimeMock();
        $dateTo         = $this->getAbstractDateTimeMock();

        $dateFrom
            ->expects($this->any())
            ->method('diff')
            ->willReturn($this->createDaysInterval(0));

        $this->assertEquals(0, $calendar->countWorkingDays($dateFrom, $dateTo));

        $dateFrom       = $this->getAbstractDateTimeMock();
        $dateFrom
            ->expects($this->atLeast(1))
            ->method('add')
            ->willReturn($this->getDateTimeWorkingDateMock());
        $dateFrom
            ->expects($this->any())
            ->method('diff')
            ->willReturn($this->createDaysInterval(1));

        $this->assertEquals(1, $calendar->countWorkingDays($dateFrom, $dateTo));
    }

    /**
     * Test exception in working days count then first date later than second
     *
     * @return void
     */
    public function testCountWorkingDaysExceptionFirstDateLater()
    {
        $collection     = $this->getEmptyCollectionMock(0);
        $calendar       = new Calendar($collection);

        $this->setExpectedException('InvalidArgumentException');
        $diffOneDay = $calendar->countWorkingDays(new DateTime('2013-04-25'), new DateTime('2013-04-24'));
        $this->assertEquals(1, $diffOneDay);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|DateTime
     */
    private function getAbstractDateTimeMock()
    {
        $date = $this->getMock(
            '\DateTime',
            ['add', 'sub', 'modify', 'format', 'diff']
        );

        $date
            ->expects($this->any())
            ->method('modify')
            ->willReturnSelf();

        return $date;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|DateTime
     */
    private function getDateTimeWorkingDateMock()
    {
        $date = $this->getAbstractDateTimeMock();

        $date
            ->expects($this->any())
            ->method('format')
            ->with('w')
            ->willReturn(1);

        return $date;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|DateTime
     */
    private function getDateTimeWeekEndDateMock()
    {
        $date = $this->getAbstractDateTimeMock();

        $date
            ->expects($this->any())
            ->method('format')
            ->with('w')
            ->willReturn(6);

        return $date;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getAbstractCollectionMock()
    {
        $collection = $this->getMock(
            'Illuminate\Support\Collection',
            ['filter', 'isEmpty']
        );
        $collection
            ->expects($this->any())
            ->method('filter')
            ->withAnyParameters()
            ->willReturnSelf();

        return $collection;
    }

    /**
     * @param integer $atLeastTimes
     * @return \PHPUnit_Framework_MockObject_MockObject|Collection
     */
    private function getEmptyCollectionMock($atLeastTimes)
    {
        $collection = $this->getAbstractCollectionMock();
        $collection
            ->expects($this->atLeast($atLeastTimes))
            ->method('isEmpty')
            ->willReturn(true);

        return $collection;
    }

    /**
     * @param integer $atLeastTimes
     * @return \PHPUnit_Framework_MockObject_MockObject|Collection
     */
    private function getNotEmptyCollectionMock($atLeastTimes)
    {
        $collection = $this->getAbstractCollectionMock();
        $collection
            ->expects($this->atLeast($atLeastTimes))
            ->method('isEmpty')
            ->willReturn(false);

        return $collection;
    }

    /**
     * @param integer $days
     * @return \DateInterval
     */
    private function createDaysInterval($days)
    {
        return (new DateTime())->add(new \DateInterval(sprintf('P%sD', $days)))->diff(new DateTime());
    }
}