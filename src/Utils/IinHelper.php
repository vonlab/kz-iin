<?php

declare(strict_types=1);

namespace VonLab\KzIin\Utils;

use VonLab\KzIin\Constants\Coefficients;
use VonLab\KzIin\Data\BirthDate;
use VonLab\KzIin\Enums\GenderEnum;
use VonLab\KzIin\Exceptions\InvalidIinFormatException;

/**
 * Helper class for working with Kazakhstan IIN
 */
class IinHelper
{
    /**
     * Get the century and gender digit based on the birth year and gender.
     *
     * @param  BirthDate  $birthDate The birthdate to determine the century-gender digit
     * @param  GenderEnum $gender    The gender to determine the century-gender digit
     * @return int
     */
    public static function getCenturyGenderDigit(BirthDate $birthDate, GenderEnum $gender): int
    {
        $century = intdiv($birthDate->year, 100) + 1;
        $genderDigit = $gender === GenderEnum::Male ? 1 : 0;

        return (($century - 18) * 2) - $genderDigit;
    }

    /**
     * Calculate the Control Digit (checksum) of the IIN.
     *
     * @param  string $iin The IIN string for which the checksum is calculated
     * @return int
     */
    public static function calculateControlDigit(string $iin): int
    {
        $sum1 = self::calculateWeightedSum($iin, Coefficients::COEFFICIENTS_1);

        $checksum = $sum1 % 11;

        if ($checksum === 10) {
            $sum2 = self::calculateWeightedSum($iin, Coefficients::COEFFICIENTS_2);
            $checksum = $sum2 % 11;
        }

        return $checksum === 10 ? 0 : $checksum;
    }

    /**
     * Calculates the weighted sum of digits using the provided coefficients.
     *
     * @param  string          $iin          The IIN string used for summing
     * @param  array<int, int> $coefficients The coefficients array used for summing
     * @return int
     */
    private static function calculateWeightedSum(string $iin, array $coefficients): int
    {
        return array_sum(array_map(function ($coeff, $digit) {
            return $coeff * (int)$digit;
        }, $coefficients, str_split($iin)));
    }

    /**
     * Validate the Control Digit (checksum) of the given IIN.
     *
     * @param  string                    $iin The IIN string to validate control digit
     * @throws InvalidIinFormatException
     * @return bool
     */
    public static function isValidControlDigit(string $iin): bool
    {
        if (!self::isValidIinFormat($iin)) {
            throw new InvalidIinFormatException();
        }

        $expectedChecksum = (int)$iin[11];
        $calculatedChecksum = self::calculateControlDigit(substr($iin, 0, 11));

        return $expectedChecksum === $calculatedChecksum;
    }

    /**
     * Validate the format of the IIN.
     * Checks that the IIN is 12 digits long and contains only digits
     *
     * @param  string $iin The IIN string to validate format
     * @return bool
     */
    public static function isValidIinFormat(string $iin): bool
    {
        return preg_match('/^\d{12}$/', $iin) === 1;
    }
}
