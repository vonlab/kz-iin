<?php

declare(strict_types=1);

namespace VonLab\KzIin;

use Exception;
use VonLab\KzIin\Contracts\IinParserInterface;
use VonLab\KzIin\Contracts\IinValidatorInterface;
use VonLab\KzIin\Data\BirthDate;
use VonLab\KzIin\Exceptions\InvalidBirthDateException;
use VonLab\KzIin\Exceptions\InvalidCenturyGenderDigitException;
use VonLab\KzIin\Exceptions\InvalidControlDigitException;
use VonLab\KzIin\Exceptions\InvalidIinCharacterException;
use VonLab\KzIin\Exceptions\InvalidIinLengthException;
use VonLab\KzIin\Utils\IinHelper;

/**
 * Class for validating Kazakhstan IIN
 */
class IinValidator implements IinValidatorInterface
{
    /**
     * The parser instance used for extracting IIN components
     *
     * @var IinParserInterface
     */
    protected IINParserInterface $parser;

    /**
     * Validation error
     *
     * @var string|null
     */
    protected ?string $error = null;

    /**
     * @param IinParserInterface $parser The parser instance
     */
    public function __construct(IinParserInterface $parser)
    {
        $this->parser = $parser;
    }

    /**
     * Validates the IIN and throws exceptions in case of invalid IIN.
     *
     * @param  string                             $iin The IIN to be validated
     * @throws InvalidBirthDateException
     * @throws InvalidCenturyGenderDigitException
     * @throws InvalidControlDigitException
     * @throws InvalidIinCharacterException
     * @throws InvalidIinLengthException
     * @return bool
     */
    public function validate(string $iin): bool
    {
        if (!$this->hasValidLength($iin)) {
            throw new InvalidIinLengthException();
        }

        if (!$this->containsOnlyDigits($iin)) {
            throw new InvalidIinCharacterException();
        }

        $iinData = $this->parser->parse($iin);

        if (!$this->isValidCenturyGenderDigit($iinData->centuryGenderDigit)) {
            throw new InvalidCenturyGenderDigitException();
        }

        if (!$this->isValidBirthDate($iinData->birthDate)) {
            throw new InvalidBirthDateException();
        }

        if (!$this->isValidControlDigit($iin, $iinData->controlDigit)) {
            throw new InvalidControlDigitException();
        }

        return true;
    }

    /**
     * Validates the IIN without throwing exceptions and returns a boolean result.
     *
     * @param  string $iin The IIN to be validated
     * @return bool
     */
    public function isValid(string $iin): bool
    {
        try {
            return $this->validate($iin);
        } catch (Exception $e) {
            $this->error = $e->getMessage();

            return false;
        }
    }

    /**
     * Gets the validation error.
     *
     * @return ?string
     */
    public function getError(): ?string
    {
        return $this->error;
    }

    /**
     * Checks that the IIN is 12 digits long
     *
     * @param  string $iin The IIN to be validated
     * @return bool
     */
    protected function hasValidLength(string $iin): bool
    {
        return strlen($iin) === 12;
    }

    /**
     * Checks that the IIN contains only digits
     *
     * @param  string $iin The IIN to be validated
     * @return bool
     */
    protected function containsOnlyDigits(string $iin): bool
    {
        return preg_match('/^\d{12}$/', $iin) === 1;
    }

    /**
     * Checks that the century/gender digit is within the valid range (1-6)
     *
     * @param  int  $centuryGenderDigit The century/gender digit extracted from the IIN
     * @return bool
     */
    protected function isValidCenturyGenderDigit(int $centuryGenderDigit): bool
    {
        return $centuryGenderDigit >= 1 && $centuryGenderDigit <= 6;
    }

    /**
     * Checks that the birthdate is valid
     *
     * @param  BirthDate $birthDate The birthdate extracted from the IIN
     * @return bool
     */
    protected function isValidBirthDate(BirthDate $birthDate): bool
    {
        return checkdate($birthDate->month, $birthDate->day, $birthDate->year);
    }

    /**
     * Checks that the control digit of the IIN is valid
     *
     * @param  string $iin          The IIN to be validated
     * @param  int    $controlDigit The control digit extracted from the IIN
     * @return bool
     */
    protected function isValidControlDigit(string $iin, int $controlDigit): bool
    {
        return IinHelper::calculateControlDigit(substr($iin, 0, -1)) === $controlDigit;
    }
}
