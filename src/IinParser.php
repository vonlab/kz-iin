<?php

declare(strict_types=1);

namespace VonLab\KzIin;

use VonLab\KzIin\Contracts\IinParserInterface;
use VonLab\KzIin\Data\BirthDate;
use VonLab\KzIin\Data\IinData;
use VonLab\KzIin\Enums\GenderEnum;
use VonLab\KzIin\Exceptions\InvalidIinFormatException;
use VonLab\KzIin\Utils\IinHelper;

/**
 * Class for parsing Kazakhstan IIN
 */
class IinParser implements IinParserInterface
{
    /**
     * Parses the IIN and returns a IinData object
     *
     * @param  string                    $iin The IIN to be parsed
     * @throws InvalidIinFormatException
     * @return IinData
     */
    public function parse(string $iin): IinData
    {
        if (!IinHelper::isValidIinFormat($iin)) {
            throw new InvalidIinFormatException();
        }

        $yearPart = substr($iin, 0, 2);
        $monthPart = substr($iin, 2, 2);
        $dayPart = substr($iin, 4, 2);

        $centuryGenderDigit = (int)$iin[6];

        $century = (int)(floor(($centuryGenderDigit - 1) / 2) + 18);
        $fullYear = $century * 100 + (int)$yearPart;

        $birthDate = new BirthDate((int)$fullYear, (int)$monthPart, (int)$dayPart);

        $gender = $centuryGenderDigit % 2 === 1 ? GenderEnum::Male : GenderEnum::Female;

        $registrationNumber = (int)substr($iin, 7, 4);
        $controlDigit = (int)$iin[11];

        return new IinData(
            $birthDate,
            $gender,
            $centuryGenderDigit,
            $registrationNumber,
            $controlDigit
        );
    }
}
