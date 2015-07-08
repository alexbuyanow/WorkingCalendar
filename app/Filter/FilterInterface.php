<?php

namespace App\Filter;

use App\Model\FilteredModelInterface;
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
    public function isSatisfied(FilteredModelInterface $object);

    /**
     * Getting callback for filtering
     *
     * @return \Callback
     */
    public function filterCallback();
}