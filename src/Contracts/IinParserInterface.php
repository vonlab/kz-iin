<?php

declare(strict_types=1);

namespace VonLab\KzIin\Contracts;

use VonLab\KzIin\Data\IinData;

/**
 * Interface for IIN parsers
 */
interface IinParserInterface
{
    /**
     * Parses the IIN and returns a IinData object
     *
     * @param  string  $iin The IIN to be parsed
     * @return IinData
     */
    public function parse(string $iin): IinData;
}
