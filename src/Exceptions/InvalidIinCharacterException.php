<?php

declare(strict_types=1);

namespace VonLab\KzIin\Exceptions;

class InvalidIinCharacterException extends IinException
{
    /**
     * Exception thrown when the IIN contains invalid characters
     */
    public function __construct()
    {
        parent::__construct('IIN contains non-digit characters.');
    }
}
