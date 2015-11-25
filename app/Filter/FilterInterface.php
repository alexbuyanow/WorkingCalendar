<?php

namespace App\Filter;

use App\Model\FilteredModelInterface;

/**
 * Interface FilterInterface
 */
interface FilterInterface
{
    /**
     * Is Model satisfied to filter
     *
     * @param  FilteredModelInterface $object
     * @return bool
     */
    public function isSatisfied(FilteredModelInterface $object);

    /**
     * Getting callback for filtering
     *
     * @return \Callback
     */
    public function filterCallback();
}
