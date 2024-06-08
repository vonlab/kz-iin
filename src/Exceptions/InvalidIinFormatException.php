<?php

declare(strict_types=1);

namespace VonLab\KzIin\Exceptions;

class InvalidIinFormatException extends IinException
{
    /**
     * Exception thrown when the IIN format is invalid
     */
    public function __construct()
    {
        parent::__construct('Invalid IIN format.');
    }
}
