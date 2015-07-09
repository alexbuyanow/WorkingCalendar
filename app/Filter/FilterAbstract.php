<?php

namespace App\Filter;

use App\Model\FilteredModelInterface;

/**
 * Class FilterAbstract
 * @package App\Filter
 */
abstract class FilterAbstract implements FilterInterface
{
    /**
     * Is Model satisfied to filter
     *
     * @param FilteredModelInterface $object
     * @return boolean
     */
    abstract public function isSatisfied(FilteredModelInterface $object);

    /**
     * Getting callback for filtering
     *
     * @return \Callback
     */
    public function filterCallback()
    {
        return function(FilteredModelInterface $model)
        {
            return $this->isSatisfied($model);
        };
    }



}