<?php

declare(strict_types=1);

namespace VonLab\KzIin\Utils;

use VonLab\KzIin\Data\BirthDate;

/**
 * Utility class for converting dates to and from strings
 */
class DateConverter
{
    /**
     * Creates a BirthDate DTO object from a string in YYYY-MM-DD format
     *
     * @param  string    $dateString A string representing the date in YYYY-MM-DD format
     * @return BirthDate
     */
    public static function fromString(string $dateString): BirthDate
    {
        [$year, $month, $day] = explode('-', $dateString);

        return new BirthDate((int)$year, (int)$month, (int)$day);
    }

    /**
     * Converts a BirthDate DTO object to a string in YYYY-MM-DD format
     *
     * @param  BirthDate $birthDate BirthDate DTO
     * @return string
     */
    public static function toDateString(BirthDate $birthDate): string
    {
        return sprintf('%04d-%02d-%02d', $birthDate->year, $birthDate->month, $birthDate->day);
    }
}
