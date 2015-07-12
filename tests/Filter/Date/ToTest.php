<?php

namespace App\Filter\Date;

use DateTime;
use PHPUnit_Framework_TestCase;

/**
 * Date to filter test
 *
 * @package App\Filter\Date
 */
class ToTest extends PHPUnit_Framework_TestCase
{

    /**
     * Given date less than filter date
     *
     * @return void
     */
    public function testToTrueLess()
    {
        $filter = $this->createFilter();
        $this->assertTrue($filter->isSatisfied($this->getDateModelMock('2015-01-31')));
    }

    /**
     * Given date equal filter date
     *
     * @return void
     */
    public function testToTrueEqual()
    {
        $filter = new To(new DateTime('2015-02-01'));
        $this->assertTrue($filter->isSatisfied($this->getDateModelMock('2015-02-01')));
    }

    /**
     * Given date more than filter date
     *
     * @return void
     */
    public function testToFalseMore()
    {
        $filter = new To(new DateTime('2015-02-01'));
        $this->assertFalse($filter->isSatisfied($this->getDateModelMock('2015-02-02')));
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
     * @return To
     */
    private function createFilter()
    {
        return new To(new DateTime('2015-02-01'));
    }
}
