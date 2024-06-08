<?php

declare(strict_types=1);

namespace VonLab\KzIin\Contracts;

/**
 * Interface for IIN validators
 */
interface IinValidatorInterface
{
    /**
     * Validates the IIN
     *
     * @param  string $iin The IIN to be validated
     * @return bool
     */
    public function validate(string $iin): bool;
}
