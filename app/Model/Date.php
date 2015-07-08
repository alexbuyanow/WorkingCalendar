<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Excepted date model
 *
 * @package App\Model
 */
class Date extends Model
{

    protected $table = 'date';
    protected $primaryKey = 'date';


    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function newCollection(array $models = array())
    {
        return (new Collection($models))->sortBy('date');
    }

}