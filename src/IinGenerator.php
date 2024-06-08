<?php

declare(strict_types=1);

namespace VonLab\KzIin;

use DateTime;
use VonLab\KzIin\Contracts\IinGeneratorInterface;
use VonLab\KzIin\Data\BirthDate;
use VonLab\KzIin\Enums\GenderEnum;
use VonLab\KzIin\Utils\IinHelper;

/**
 * Class for generating Kazakhstan IIN
 */
class IinGenerator implements IinGeneratorInterface
{
    /**
     * Generate a valid IIN based on provided or random birthdate and gender.
     *
     * @param  BirthDate|null  $birthDate The birthdate to be used for generating the IIN
     * @param  GenderEnum|null $gender    The gender to be used for generating the IIN
     * @return string
     */
    public function generate(BirthDate $birthDate = null, GenderEnum $gender = null): string
    {
        if ($birthDate === null) {
            $birthDate = $this->generateRandomBirthDate();
        }

        if ($gender === null) {
            $gender = $this->generateRandomGender();
        }

        $year = $birthDate->year % 100;
        $month = str_pad((string)$birthDate->month, 2, '0', STR_PAD_LEFT);
        $day = str_pad((string)$birthDate->day, 2, '0', STR_PAD_LEFT);

        $centuryGenderDigit = IinHelper::getCenturyGenderDigit($birthDate, $gender);

        $iinWithoutControlDigit = "{$year}{$month}{$day}{$centuryGenderDigit}" . $this->generateRandomRegistrationNumber();
        $controlDigit = IinHelper::calculateControlDigit($iinWithoutControlDigit);

        return $iinWithoutControlDigit . $controlDigit;
    }

    /**
     * Generate a random registration number.
     *
     * @return string
     */
    protected function generateRandomRegistrationNumber(): string
    {
        return str_pad((string)rand(0, 9999), 4, '0', STR_PAD_LEFT);
    }

    /**
     * Generate a random birthdate.
     *
     * @return BirthDate
     */
    protected function generateRandomBirthDate(): BirthDate
    {
        $birthDate = (new DateTime())->modify('-' . rand(18, 60) . ' years');

        return new BirthDate(
            (int)$birthDate->format('Y'),
            (int)$birthDate->format('n'),
            (int)$birthDate->format('j')
        );
    }

    /**
     * Generate a random gender.
     *
     * @return GenderEnum
     */
    protected function generateRandomGender(): GenderEnum
    {
        return rand(0, 1) ? GenderEnum::Male : GenderEnum::Female;
    }
}
