<?php

namespace App\Filter\Date;

use App\Filter;
use App\Model\FilteredModelInterface;
use DateTime;
use Illuminate\Database\Eloquent\Model;

/**
 * Date in range filter (including begin date and end one)
 * @package App\Filter\Date
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
     * @param Model $date
     * @return boolean
     */
    public function isSatisfied(FilteredModelInterface $date)
    {
        return $date->getAttribute('date') >= $this->dateFrom && $date->getAttribute('date') <= $this->dateTo;
    }
}