<?php

namespace App\Http\Controllers\Api\Calendar\Exception;

use InvalidArgumentException as BaseException;

class InvalidArgumentException extends BaseException
{
    protected $code = 400;

}