<?php

declare(strict_types=1);

namespace VonLab\KzIin\Exceptions;

class InvalidControlDigitException extends IinException
{
    /**
     * Exception thrown when the control digit is invalid
     */
    public function __construct()
    {
        parent::__construct('Invalid control digit in IIN.');
    }
}
