<?php

namespace App\Filter\Date;

use DateTime;
use PHPUnit_Framework_TestCase;

/**
 * Date range filter test
 *
 * @package App\Filter\Date
 */
class RangeTest extends PHPUnit_Framework_TestCase
{

    /**
     * Date inside range
     *
     * @return void
     */
    public function testTrueInsideRange()
    {
        $filter = $this->createFilter();
        $this->assertTrue($filter->isSatisfied($this->getDateModelMock('2015-02-02')));
    }

    /**
     * Date equal range begin
     *
     * @return void
     */
    public function testTrueEqualRangeBegin()
    {
        $filter = $this->createFilter();
        $this->assertTrue($filter->isSatisfied($this->getDateModelMock('2015-02-01')));
    }

    /**
     * Date equal range end
     *
     * @return void
     */
    public function testTrueEqualRangeEnd()
    {
        $filter = $this->createFilter();
        $this->assertTrue($filter->isSatisfied($this->getDateModelMock('2015-02-10')));
    }

    /**
     * Date out of range (less than begin)
     *
     * @return void
     */
    public function testFalseRangeOutsideLess()
    {
        $filter = $this->createFilter();
        $this->assertFalse($filter->isSatisfied($this->getDateModelMock('2015-01-31')));
    }

    /**
     * Date out of range (more than end)
     *
     * @return void
     */
    public function testFalseRangeOutsideMore()
    {
        $filter = $this->createFilter();
        $this->assertFalse($filter->isSatisfied($this->getDateModelMock('2015-02-31')));
    }

    /**
     * @param $date
     * @return \PHPUnit_Framework_MockObject_MockObject|\App\Model\FilteredModelInterface
     */
    private function getDateModelMock($date)
    {
        $mock = $this->getMock('App\Model\FilteredModelInterface', ['getAttribute']);
        $mock->expects($this->any())
            ->method('getAttribute')
            ->will($this->returnValue(new DateTime($date)));
        return $mock;
    }

    /**
     * Filter object creating
     *
     * @return Range
     */
    private function createFilter()
    {
        return new Range(new DateTime('2015-02-01'), new DateTime('2015-02-10'));
    }
}
