<?php

namespace LimousineSearch\Exceptions;

use RuntimeException;
use Throwable;

class UnauthorizedException extends RuntimeException
{
    public function __construct(Throwable $previous = null)
    {
        parent::__construct('Unauthorized', 404, $previous);
    }
}