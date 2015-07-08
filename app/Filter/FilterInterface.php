<?php

namespace App\Filter;

use Illuminate\Database\Eloquent\Model;

/**
 * Interface FilterInterface
 * @package App\Filter
 */
interface FilterInterface
{
    /**
     * Is Model satisfied to filter
     *
     * @param Model $object
     * @return boolean
     */
    public function isSatisfied(Model $object);

    /**
     * Getting callback for filtering
     *
     * @return \Callback
     */
    public function filterCallback();
}