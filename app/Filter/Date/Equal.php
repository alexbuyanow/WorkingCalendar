<?php

namespace App\Filter\Date;

use App\Filter;
use App\Model\FilteredModelInterface;
use DateTime;
use Illuminate\Database\Eloquent\Model;

/**
 * Date equal to given filter
 * @package App\Filter\Date
 */
class Equal extends Filter\FilterAbstract implements Filter\FilterInterface
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
     * @param Model $date
     * @return boolean
     */
    public function isSatisfied(FilteredModelInterface $date)
    {
        return $this->date == $date->getAttribute('date');
    }
}