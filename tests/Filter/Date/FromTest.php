<?php

namespace App\Filter\Date;

use DateTime;
use PHPUnit_Framework_TestCase;

/**
 * Date from filter test
 *
 * @package App\Filter\Date
 */
class FromTest extends PHPUnit_Framework_TestCase
{

    /**
     * Given date more than filter date
     *
     * @return void
     */
    public function testFromTrueMore()
    {
        $filter = $this->createFilter();
        $this->assertTrue($filter->isSatisfied($this->getDateModelMock('2015-02-02')));
    }

    /**
     * Given date equal filter date
     *
     * @return void
     */
    public function testFromTrueEqual()
    {
        $filter = $this->createFilter();
        $this->assertTrue($filter->isSatisfied($this->getDateModelMock('2015-02-01')));
    }

    /**
     * Given date less than filter date
     *
     * @return void
     */
    public function testFromFalseLess()
    {
        $filter = $this->createFilter();
        $this->assertFalse($filter->isSatisfied($this->getDateModelMock('2015-01-31')));
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
     * @return From
     */
    private function createFilter()
    {
        return new From(new DateTime('2015-02-01'));
    }
}
