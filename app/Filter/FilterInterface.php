<?php

namespace App\Filter;

use App\Model\FilteredModelInterface;

/**
 * Interface FilterInterface
 * @package App\Filter
 */
interface FilterInterface
{
    /**
     * Is Model satisfied to filter
     *
     * @param FilteredModelInterface $object
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