<?php

declare(strict_types=1);

namespace VonLab\KzIin\Exceptions;

class InvalidIinLengthException extends IinException
{
    /**
     * Exception thrown when the IIN length is invalid
     */
    public function __construct()
    {
        parent::__construct('Invalid IIN length.');
    }
}
