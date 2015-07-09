<?php

namespace App\Filter\Date;

use App\Filter;
use App\Model\FilteredModelInterface;
use DateTime;

/**
 * Date from filter (including given date)
 * @package App\Filter\Date
 */
class From extends Filter\FilterAbstract implements Filter\FilterInterface
{

    /** @var  DateTime */
    protected $date;


    /**
     * @param DateTime $date
     */
    public function __construct(DateTime $date)
    {
        $this->date         = $date;
    }

    /**
     * Is Model satisfied to filter
     *
     * @param FilteredModelInterface $date
     * @return boolean
     */
    public function isSatisfied(FilteredModelInterface $date)
    {
        return $date->getAttribute('date') >= $this->date;
    }
}