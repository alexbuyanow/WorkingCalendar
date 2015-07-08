<?php

namespace App\Filter\Date;

use App\Filter;
use DateTime;
use Illuminate\Database\Eloquent\Model;

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
     * @param Model $date
     * @return boolean
     */
    public function isSatisfied(Model $date)
    {
//        var_dump($this->date, $date->date, $date->date >= $this->date);
        return $date->date >= $this->date;
//        return $date->getDate() >= $this->date;
    }
}