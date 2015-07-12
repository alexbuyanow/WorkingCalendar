<?php

namespace App\Filter\Date;

use DateTime;
use PHPUnit_Framework_TestCase;

/**
 * Date Equal filter test
 *
 * @package App\Filter\Date
 */
class EqualTest extends PHPUnit_Framework_TestCase
{

    /**
     * Equal true testing
     *
     * @return void
     */
    public function testTrueEqual()
    {
        $filter = $this->createFilter();
        $this->assertTrue($filter->isSatisfied($this->getDateModelMock('2015-01-01')));
    }

    /**
     * Equal false testing
     *
     * @param
     */
    public function testFalseEqual()
    {
        $filter = $this->createFilter();
        $this->assertFalse($filter->isSatisfied($this->getDateModelMock('2015-01-02')));
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
     * @return Equal
     */
    private function createFilter()
    {
        return new Equal(new DateTime('2015-01-01'));
    }
}
