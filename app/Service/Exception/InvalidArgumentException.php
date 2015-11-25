<?php

namespace App\Service\Exception;

use InvalidArgumentException as BaseException;

class InvalidArgumentException extends BaseException
{
    protected $code = 400;
}
