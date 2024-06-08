<?php

namespace VonLab\KzIin\Tests;

use PHPUnit\Framework\TestCase;
use VonLab\KzIin\Data\BirthDate;
use VonLab\KzIin\Utils\DateConverter;

class IinBirthDateConverterTest extends TestCase
{
    /**
     * @return void
     */
    public function testFromString()
    {
        $dateString = '1990-01-01';
        $birthDate = DateConverter::fromString($dateString);

        $this->assertInstanceOf(BirthDate::class, $birthDate);
        $this->assertEquals(1990, $birthDate->year);
        $this->assertEquals(1, $birthDate->month);
        $this->assertEquals(1, $birthDate->day);
    }

    /**
     * @return void
     */
    public function testToDateString()
    {
        $birthDate = new BirthDate(1990, 1, 1);
        $dateString = DateConverter::toDateString($birthDate);

        $this->assertEquals('1990-01-01', $dateString);
    }
}
