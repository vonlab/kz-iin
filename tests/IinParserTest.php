<?php

declare(strict_types=1);

namespace VonLab\KzIin\Tests;

use PHPUnit\Framework\TestCase;
use VonLab\KzIin\Data\IinData;
use VonLab\KzIin\Enums\GenderEnum;
use VonLab\KzIin\Exceptions\InvalidIinFormatException;
use VonLab\KzIin\IinParser;
use VonLab\KzIin\Utils\DateConverter;

class IinParserTest extends TestCase
{
    /**
     * @var IinParser
     */
    private IinParser $parser;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->parser = new IinParser();
    }

    /**
     * @throws InvalidIinFormatException
     * @return void
     */
    public function testParseValidIIN()
    {
        $iinData = $this->parser->parse('950304300140');

        $this->assertInstanceOf(IinData::class, $iinData);
        $this->assertEquals('1995-03-04', DateConverter::toDateString($iinData->birthDate));
        $this->assertEquals(GenderEnum::Male, $iinData->gender);
        $this->assertEquals(14, $iinData->registrationNumber);
        $this->assertEquals(0, $iinData->controlDigit);
    }

    /**
     * @throws InvalidIinFormatException
     * @return void
     */
    public function testParseInvalidIINFormat()
    {
        $this->expectException(InvalidIinFormatException::class);
        $this->parser->parse('invalid-iin');
    }

    /**
     * @throws InvalidIinFormatException
     * @return void
     */
    public function testParseFemaleIIN()
    {
        $iinData = $this->parser->parse('930706400151');

        $this->assertInstanceOf(IinData::class, $iinData);
        $this->assertEquals('1993-07-06', DateConverter::toDateString($iinData->birthDate));
        $this->assertEquals(GenderEnum::Female, $iinData->gender);
        $this->assertEquals(15, $iinData->registrationNumber);
        $this->assertEquals(1, $iinData->controlDigit);
    }

    /**
     * @throws InvalidIinFormatException
     * @return void
     */
    public function testParseMaleIIN()
    {
        $iinData = $this->parser->parse('910202300101');

        $this->assertInstanceOf(IinData::class, $iinData);
        $this->assertEquals('1991-02-02', DateConverter::toDateString($iinData->birthDate));
        $this->assertEquals(GenderEnum::Male, $iinData->gender);
        $this->assertEquals(10, $iinData->registrationNumber);
        $this->assertEquals(1, $iinData->controlDigit);
    }

    /**
     * @throws InvalidIinFormatException
     * @return void
     */
    public function testParse19thCenturyIIN()
    {
        $iinData = $this->parser->parse('990101100400');

        $this->assertInstanceOf(IinData::class, $iinData);
        $this->assertEquals('1899-01-01', DateConverter::toDateString($iinData->birthDate));
        $this->assertEquals(GenderEnum::Male, $iinData->gender);
        $this->assertEquals(40, $iinData->registrationNumber);
        $this->assertEquals(0, $iinData->controlDigit);
    }

    /**
     * @throws InvalidIinFormatException
     * @return void
     */
    public function testParse20thCenturyIIN()
    {
        $iinData = $this->parser->parse('900101300070');

        $this->assertInstanceOf(IinData::class, $iinData);
        $this->assertEquals('1990-01-01', DateConverter::toDateString($iinData->birthDate));
        $this->assertEquals(GenderEnum::Male, $iinData->gender);
        $this->assertEquals(7, $iinData->registrationNumber);
        $this->assertEquals(0, $iinData->controlDigit);
    }

    /**
     * @throws InvalidIinFormatException
     * @return void
     */
    public function testParse21stCenturyIIN()
    {
        $iinData = $this->parser->parse('010101500550');

        $this->assertInstanceOf(IinData::class, $iinData);
        $this->assertEquals('2001-01-01', DateConverter::toDateString($iinData->birthDate));
        $this->assertEquals(GenderEnum::Male, $iinData->gender);
        $this->assertEquals(55, $iinData->registrationNumber);
        $this->assertEquals(0, $iinData->controlDigit);
    }
}
