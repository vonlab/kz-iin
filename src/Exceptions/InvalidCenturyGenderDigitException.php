<?php

declare(strict_types=1);

namespace VonLab\KzIin\Exceptions;

class InvalidCenturyGenderDigitException extends IinException
{
    /**
     * Exception thrown when the century/gender digit is invalid
     */
    public function __construct()
    {
        parent::__construct('Invalid century gender digit in IIN.');
    }
}
