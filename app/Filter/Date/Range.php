<?php

namespace App\Filter\Date;

use App\Filter;
use App\Model\FilteredModelInterface;
use DateTime;

/**
 * Date in range filter (including begin date and end one)
 */
class Range extends Filter\FilterAbstract implements Filter\FilterInterface
{
    /** @var  DateTime */
    protected $dateFrom;

    /**
     * @param DateTime $dateFrom
     * @param DateTime $dateTo
     */
    public function __construct(DateTime $dateFrom, DateTime $dateTo)
    {
        $this->dateFrom         = $dateFrom;
        $this->dateTo           = $dateTo;
    }

    /**
     * Is Model satisfied to filter
     *
     * @param  FilteredModelInterface $date
     * @return bool
     */
    public function isSatisfied(FilteredModelInterface $date)
    {
        return $date->getAttribute('date') >= $this->dateFrom && $date->getAttribute('date') <= $this->dateTo;
    }
}
