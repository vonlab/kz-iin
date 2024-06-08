<?php

declare(strict_types=1);

namespace VonLab\KzIin\Contracts;

use VonLab\KzIin\Data\BirthDate;
use VonLab\KzIin\Enums\GenderEnum;

/**
 * Interface for IIN generators
 */
interface IinGeneratorInterface
{
    /**
     * Generates a valid IIN
     *
     * @param  BirthDate  $birthDate The birthdate to be used for generating the IIN
     * @param  GenderEnum $gender    The gender to be used for generating the IIN
     * @return string
     */
    public function generate(BirthDate $birthDate, GenderEnum $gender): string;
}
