<?php

namespace App\Filter\Date;

use App\Filter;
use App\Model\FilteredModelInterface;
use DateTime;

/**
 * Date to filter (including given date)
 */
class To extends Filter\FilterAbstract implements Filter\FilterInterface
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
     * @param  FilteredModelInterface $date
     * @return bool
     */
    public function isSatisfied(FilteredModelInterface $date)
    {
        return $date->getAttribute('date') <= $this->date;
    }
}
