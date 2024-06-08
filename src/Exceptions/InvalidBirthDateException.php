<?php

declare(strict_types=1);

namespace VonLab\KzIin\Exceptions;

class InvalidBirthDateException extends IinException
{
    /**
     * Exception thrown when the birthdate is invalid
     */
    public function __construct()
    {
        parent::__construct('Invalid birthdate in IIN.');
    }
}
