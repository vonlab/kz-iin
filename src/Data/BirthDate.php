<?php

declare(strict_types=1);

namespace VonLab\KzIin\Data;

/**
 * Class representing an IIN birthdate
 */
final class BirthDate
{
    /**
     * @param int $year  The year component of the birthdate
     * @param int $month The month component of the birthdate
     * @param int $day   The day component of the birthdate
     */
    public function __construct(
        public readonly int $year,
        public readonly int $month,
        public readonly int $day
    ) {
    }
}
