# KzIIN Library

[![Latest Stable Version](https://poser.pugx.org/vonlab/kz-iin/v/stable)](https://packagist.org/packages/vonlab/kz-iin)
[![License](https://poser.pugx.org/vonlab/kz-iin/license)](https://packagist.org/packages/vonlab/kz-iin)
[![Coverage Status](https://coveralls.io/repos/github/vonlab/kz-iin/badge.svg?branch=main)](https://coveralls.io/github/vonlab/kz-iin?branch=main)

This library provides tools for validating, parsing, and generating Kazakhstan Individual Identification Numbers (IIN).

## About Kazakhstan IIN

In Kazakhstan, the Individual Identification Number (IIN) is a unique identifier assigned to individuals. 
The IIN is composed of 12 digits, where each digit represents specific information about the individual, 
such as the date of birth, gender, and a unique identifier for individuals born on the same date. 
More detailed information about the structure and purpose of the IIN can be found 
[here](https://ru.wikipedia.org/wiki/%D0%98%D0%BD%D0%B4%D0%B8%D0%B2%D0%B8%D0%B4%D1%83%D0%B0%D0%BB%D1%8C%D0%BD%D1%8B%D0%B9_%D0%B8%D0%B4%D0%B5%D0%BD%D1%82%D0%B8%D1%84%D0%B8%D0%BA%D0%B0%D1%86%D0%B8%D0%BE%D0%BD%D0%BD%D1%8B%D0%B9_%D0%BD%D0%BE%D0%BC%D0%B5%D1%80).

## Features

- Validate Kazakhstan IINs
- Parse Kazakhstan IINs to extract useful information
- Generate valid Kazakhstan IINs
- Exception handling for various validation errors

## Installation

You can install the package via composer:

```sh
composer require vonlab/kz-iin
```

## Usage

### Validating an IIN

To validate an IIN, use the `IinValidator` class.

#### With Exception Handling

```php
<?php

use VonLab\KzIin\IinParser;
use VonLab\KzIin\IinValidator;

$validator = new IinValidator(new IinParser());

try {
    if ($validator->validate('your-iin-here')) {
        echo "IIN is valid.";
    }
} catch (\Exception $e) {
    echo "Validation failed: " . $e->getMessage();
}
```

#### Without Exception Handling

```php
use VonLab\KzIin\IinParser;
use VonLab\KzIin\IinValidator;

$validator = new IinValidator(new IinParser());

if ($validator->isValid('your-iin-here')) {
    echo "IIN is valid.";
} else {
    echo "Validation failed: " . $validator->getError();
}
```

### IIN Generation

To generate an IIN, use the `IinGenerator` class.

```php
<?php

use VonLab\KzIin\IinGenerator;
use VonLab\KzIin\Enums\GenderEnum;
use VonLab\KzIin\Data\BirthDate;

// Generate an IIN with random birthdate and gender
$generator = new IinGenerator();
$iin = $generator->generate();
echo "Generated IIN: $iin";

// Generate an IIN with specific birthdate and gender
$birthDate = new BirthDate(1990, 1, 1);
$gender = GenderEnum::Male;
$iin = $generator->generate($birthDate, $gender);
echo "Generated IIN: $iin";
```

### Parsing an IIN

To parse an IIN, use the `IinParser` class.

```php
<?php

use VonLab\KzIin\IinParser;
use VonLab\KzIin\Utils\DateConverter;
use VonLab\KzIin\Exceptions\InvalidIinFormatException;

$parser = new IinParser();

try {
    $iinData = $parser->parse('your-iin-here');
    
    echo "Birth Date: " . DateConverter::toDateString($iinData->birthDate);
    echo "Year of birth: " . $iinData->birthDate->year;
    echo "Month of birth: " . $iinData->birthDate->month;
    echo "Day of birth: " . $iinData->birthDate->day;
    echo "Gender: " . $iinData->gender->value;
    echo "Century Gender Digit: " . $iinData->centuryGenderDigit;
    echo "Registration Number: " . $iinData->registrationNumber;
    echo "Control Digit: " . $iinData->controlDigit;
} catch (InvalidIinFormatException $e) {
    echo "Invalid IIN format: " . $e->getMessage();
}
```

## Additional Information

### Exception Classes

The library provides specific exception classes to handle various validation errors:

- `InvalidIinLengthException`
- `InvalidIinCharacterException`
- `InvalidBirthDateException`
- `InvalidCenturyGenderDigitException`
- `InvalidControlDigitException`
- `InvalidIinFormatException`

### Utility Classes

The library includes utility classes for internal calculations and date handling:

- `IinHelper`: Contains methods for checksum calculations and century/gender digit extraction.
- `DateConverter`: Utility class for date format conversions.

### Docker Support

A minimal `docker-compose.yml` is included for setting up the development environment.

## Testing

The library includes a comprehensive set of unit tests. To run the tests, use the following command:

```sh
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Support

If you encounter any issues or have questions, feel free to open an issue on GitHub.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.

