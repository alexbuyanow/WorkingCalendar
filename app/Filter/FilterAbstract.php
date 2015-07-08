<?php

namespace App\Filter;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FilterAbstract
 * @package App\Filter
 */
abstract class FilterAbstract implements FilterInterface
{
    /**
     * Is Model satisfied to filter
     *
     * @param Model $object
     * @return boolean
     */
    abstract public function isSatisfied(Model $object);

    /**
     * Getting callback for filtering
     *
     * @return \Callback
     */
    public function filterCallback()
    {
        return function(Model $model)
        {
            return $this->isSatisfied($model);
        };
    }



}