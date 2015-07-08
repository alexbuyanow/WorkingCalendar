<?php

namespace App\Filter\Date;

use App\Filter;
use DateTime;
use Illuminate\Database\Eloquent\Model;

/**
 * Date to filter (including given date)
 * @package App\Filter\Date
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
     * @param Model $date
     * @return boolean
     */
    public function isSatisfied(Model $date)
    {
        return $date->date <= $this->date;
    }
}