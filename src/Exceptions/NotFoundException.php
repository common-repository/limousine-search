<?php

namespace LimousineSearch\Exceptions;

use RuntimeException;
use Throwable;

class NotFoundException extends RuntimeException
{
    public function __construct($message = "Not Found", Throwable $previous = null)
    {
        parent::__construct($message, 404, $previous);
    }
}