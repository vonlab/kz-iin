<?php

declare(strict_types=1);

namespace VonLab\KzIin\Tests;

use PHPUnit\Framework\TestCase;
use VonLab\KzIin\Data\BirthDate;
use VonLab\KzIin\Enums\GenderEnum;
use VonLab\KzIin\Exceptions\InvalidIinFormatException;
use VonLab\KzIin\IinGenerator;
use VonLab\KzIin\Utils\IinHelper;

class IinGeneratorTest extends TestCase
{
    /**
     * @throws InvalidIinFormatException
     */
    public function testGenerateWithGivenBirthDateAndGender(): void
    {
        $generator = new IinGenerator();

        $birthDate = new BirthDate(1990, 1, 1);
        $gender = GenderEnum::Male;
        $iin = $generator->generate($birthDate, $gender);

        $this->assertTrue(IinHelper::isValidControlDigit($iin));

        $this->assertSame('90', substr($iin, 0, 2));
        $this->assertSame('01', substr($iin, 2, 2));
        $this->assertSame('01', substr($iin, 4, 2));
        $this->assertSame('3', $iin[6]);  // Century digit for 1990s and male
    }
}
