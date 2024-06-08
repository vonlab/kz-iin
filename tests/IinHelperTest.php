<?php

declare(strict_types=1);

namespace VonLab\KzIin\Tests;

use PHPUnit\Framework\TestCase;
use VonLab\KzIin\Data\BirthDate;
use VonLab\KzIin\Enums\GenderEnum;
use VonLab\KzIin\Exceptions\InvalidIinFormatException;
use VonLab\KzIin\Utils\IinHelper;

class IinHelperTest extends TestCase
{
    /**
     * @return void
     */
    public function testGetCenturyGenderDigit19thCenturyMale(): void
    {
        $birthDate = new BirthDate(1899, 1, 1);
        $gender = GenderEnum::Male;
        $this->assertEquals(1, IinHelper::getCenturyGenderDigit($birthDate, $gender));
    }

    /**
     * @return void
     */
    public function testGetCenturyGenderDigit19thCenturyFemale(): void
    {
        $birthDate = new BirthDate(1899, 1, 1);
        $gender = GenderEnum::Female;
        $this->assertEquals(2, IinHelper::getCenturyGenderDigit($birthDate, $gender));
    }

    /**
     * @return void
     */
    public function testGetCenturyGenderDigit20thCenturyMale(): void
    {
        $birthDate = new BirthDate(1990, 1, 1);
        $gender = GenderEnum::Male;
        $this->assertEquals(3, IinHelper::getCenturyGenderDigit($birthDate, $gender));
    }

    /**
     * @return void
     */
    public function testGetCenturyGenderDigit20thCenturyFemale(): void
    {
        $birthDate = new BirthDate(1990, 1, 1);
        $gender = GenderEnum::Female;
        $this->assertEquals(4, IinHelper::getCenturyGenderDigit($birthDate, $gender));
    }

    /**
     * @return void
     */
    public function testGetCenturyGenderDigit21thCenturyMale(): void
    {
        $birthDate = new BirthDate(2000, 1, 1);
        $gender = GenderEnum::Male;
        $this->assertEquals(5, IinHelper::getCenturyGenderDigit($birthDate, $gender));
    }

    /**
     * @return void
     */
    public function testGetCenturyGenderDigit21thCenturyFemale(): void
    {
        $birthDate = new BirthDate(2000, 1, 1);
        $gender = GenderEnum::Female;
        $this->assertEquals(6, IinHelper::getCenturyGenderDigit($birthDate, $gender));
    }

    /**
     * @return void
     */
    public function testCalculateControlDigit(): void
    {
        $iin = '12345678901';
        $expectedControlDigit = IinHelper::calculateControlDigit($iin);
        $this->assertEquals(3, $expectedControlDigit);
    }

    /**
     * @throws InvalidIinFormatException
     * @return void
     */
    public function testIsValidControlDigit(): void
    {
        $iin = '123456789013';
        $this->assertTrue(IinHelper::isValidControlDigit($iin));

        $iin = '123456789010';
        $this->assertFalse(IinHelper::isValidControlDigit($iin));
    }

    /**
     * @throws InvalidIinFormatException
     * @return void
     */
    public function testInvalidIINFormatException(): void
    {
        $this->expectException(InvalidIinFormatException::class);
        IinHelper::isValidControlDigit('invalid-iin');
    }

    /**
     * @return void
     */
    public function testValidateIinFormat(): void
    {
        $this->assertTrue(IinHelper::isValidIinFormat('123456789012'));
        $this->assertFalse(IinHelper::isValidIinFormat('invalid-iin'));
    }
}
