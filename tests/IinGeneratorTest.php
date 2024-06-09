<?php

declare(strict_types=1);

namespace VonLab\KzIin\Tests;

use Mockery;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;
use VonLab\KzIin\Data\BirthDate;
use VonLab\KzIin\Enums\GenderEnum;
use VonLab\KzIin\Exceptions\InvalidIinFormatException;
use VonLab\KzIin\IinGenerator;
use VonLab\KzIin\Utils\IinHelper;

class IinGeneratorTest extends TestCase
{
    /**
     * @return void
     */
    public function tearDown(): void
    {
        Mockery::close();
    }

    /**
     * @throws InvalidIinFormatException
     */
    public function testGenerateWithGivenBirthDateAndGender(): void
    {
        $generator = new IinGenerator();

        $birthDate = new BirthDate(1990, 1, 1);
        $gender = GenderEnum::Male;
        $iin = $generator->generate($birthDate, $gender);

        $this->assertIsString($iin);
        $this->assertEquals(12, strlen($iin));

        $this->assertTrue(IinHelper::isValidControlDigit($iin));

        $this->assertSame('90', substr($iin, 0, 2));
        $this->assertSame('01', substr($iin, 2, 2));
        $this->assertSame('01', substr($iin, 4, 2));
        $this->assertSame('3', $iin[6]);  // Century digit for 1990s and male
    }

    /**
     * @throws InvalidIinFormatException
     * @return void
     */
    public function testGenerateWithoutParameters()
    {
        $generatorMock = Mockery::mock(IinGenerator::class)->makePartial();

        $birthDate = new BirthDate(1990, 1, 1);
        $gender = GenderEnum::Male;

        $generatorMock->shouldAllowMockingProtectedMethods();
        $generatorMock->shouldReceive('generateRandomBirthDate')
            ->once()
            ->andReturn($birthDate);

        $generatorMock->shouldReceive('generateRandomGender')
            ->once()
            ->andReturn($gender);

        $iin = $generatorMock->generate();

        $this->assertIsString($iin);
        $this->assertEquals(12, strlen($iin));

        $this->assertTrue(IinHelper::isValidControlDigit($iin));

        $this->assertEquals('90', substr($iin, 0, 2));
        $this->assertEquals('01', substr($iin, 2, 2));
        $this->assertEquals('01', substr($iin, 4, 2));
        $this->assertSame('3', $iin[6]);
    }

    /**
     * @throws ReflectionException
     * @return void
     */
    public function testGenerateRandomBirthDate()
    {
        $generator = new IinGenerator();

        $reflection = new ReflectionClass($generator);
        $method = $reflection->getMethod('generateRandomBirthDate');

        $birthDate = $method->invoke($generator);

        $this->assertInstanceOf(BirthDate::class, $birthDate);

        $currentYear = (int)date('Y');
        $birthYear = $birthDate->year;

        $this->assertGreaterThanOrEqual($currentYear - 60, $birthYear);
        $this->assertLessThanOrEqual($currentYear - 18, $birthYear);
    }

    /**
     * @throws ReflectionException
     * @return void
     */
    public function testGenerateRandomGender()
    {
        $generator = new IinGenerator();

        $reflection = new ReflectionClass($generator);
        $method = $reflection->getMethod('generateRandomGender');

        $gender = $method->invoke($generator);

        $this->assertInstanceOf(GenderEnum::class, $gender);
        $this->assertContains($gender, [GenderEnum::Male, GenderEnum::Female]);
    }
}
