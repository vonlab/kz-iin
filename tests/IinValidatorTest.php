<?php

declare(strict_types=1);

namespace VonLab\KzIin\Tests;

use PHPUnit\Framework\TestCase;
use VonLab\KzIin\Exceptions\InvalidBirthDateException;
use VonLab\KzIin\Exceptions\InvalidCenturyGenderDigitException;
use VonLab\KzIin\Exceptions\InvalidControlDigitException;
use VonLab\KzIin\Exceptions\InvalidIinCharacterException;
use VonLab\KzIin\Exceptions\InvalidIinLengthException;
use VonLab\KzIin\IinParser;
use VonLab\KzIin\IinValidator;

class IinValidatorTest extends TestCase
{
    /**
     * @var IinValidator
     */
    protected IinValidator $validator;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $parser = new IinParser();
        $this->validator = new IinValidator($parser);
    }

    /**
     * @throws InvalidBirthDateException
     * @throws InvalidCenturyGenderDigitException
     * @throws InvalidControlDigitException
     * @throws InvalidIinCharacterException
     * @throws InvalidIinLengthException
     * @return void
     */
    public function testInvalidIINLengthException()
    {
        $this->expectException(InvalidIinLengthException::class);
        $this->validator->validate('12345678901');
    }

    /**
     * @throws InvalidBirthDateException
     * @throws InvalidCenturyGenderDigitException
     * @throws InvalidControlDigitException
     * @throws InvalidIinCharacterException
     * @throws InvalidIinLengthException
     * @return void
     */
    public function testInvalidIINCharacterException()
    {
        $this->expectException(InvalidIinCharacterException::class);
        $this->validator->validate('12345678901A');
    }

    /**
     * @throws InvalidBirthDateException
     * @throws InvalidCenturyGenderDigitException
     * @throws InvalidControlDigitException
     * @throws InvalidIinCharacterException
     * @throws InvalidIinLengthException
     * @return void
     */
    public function testInvalidCenturyGenderDigitException()
    {
        $this->expectException(InvalidCenturyGenderDigitException::class);
        $this->validator->validate('990101712345');
    }

    /**
     * @throws InvalidBirthDateException
     * @throws InvalidCenturyGenderDigitException
     * @throws InvalidControlDigitException
     * @throws InvalidIinCharacterException
     * @throws InvalidIinLengthException
     * @return void
     */
    public function testInvalidBirthDateException()
    {
        $this->expectException(InvalidBirthDateException::class);
        $this->validator->validate('991701612345');
    }

    /**
     * @throws InvalidBirthDateException
     * @throws InvalidCenturyGenderDigitException
     * @throws InvalidControlDigitException
     * @throws InvalidIinCharacterException
     * @throws InvalidIinLengthException
     * @return void
     */
    public function testInvalidControlDigitException()
    {
        $this->expectException(InvalidControlDigitException::class);
        $this->validator->validate('990101300000');
    }

    /**
     * @throws InvalidBirthDateException
     * @throws InvalidCenturyGenderDigitException
     * @throws InvalidControlDigitException
     * @throws InvalidIinCharacterException
     * @throws InvalidIinLengthException
     * @return void
     */
    public function testValidateTrue()
    {
        $this->assertTrue($this->validator->validate('990101300122'));
    }

    /**
     * @return void
     */
    public function testIsValidTrue()
    {
        $this->assertTrue($this->validator->isValid('990101300122'));
    }

    /**
     * @return void
     */
    public function testIsValidFalse()
    {
        $this->assertFalse($this->validator->isValid('990101300000'));
    }

    /**
     * @return void
     */
    public function testGetError()
    {
        $invalidIin = '12345';
        $result = $this->validator->isValid($invalidIin);

        $this->assertFalse($result);

        $lastError = $this->validator->getError();
        $this->assertSame((new InvalidIinLengthException())->getMessage(), $lastError);
    }
}
