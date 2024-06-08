<?php

declare(strict_types=1);

namespace VonLab\KzIin\Data;

use VonLab\KzIin\Enums\GenderEnum;

/**
 * Class representing a parsed IIN
 */
final class IinData
{
    /**
     * @param BirthDate  $birthDate          The birthdate extracted from the IIN
     * @param GenderEnum $gender             The gender extracted from the IIN
     * @param int        $centuryGenderDigit The century-gender digit extracted from the IIN
     * @param int        $registrationNumber The registration number extracted from the IIN
     * @param int        $controlDigit       The control digit extracted from the IIN
     */
    public function __construct(
        public readonly BirthDate  $birthDate,
        public readonly GenderEnum $gender,
        public readonly int        $centuryGenderDigit,
        public readonly int        $registrationNumber,
        public readonly int        $controlDigit,
    ) {
    }
}
