<?php

declare(strict_types=1);

namespace VonLab\KzIin\Constants;

/**
 * Class containing coefficients for calculating the IIN checksum
 */
class Coefficients
{
    /**
     * Array of coefficients for the first checksum calculation algorithm
     */
    public const COEFFICIENTS_1 = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11];

    /**
     * Array of coefficients for the second checksum calculation algorithm
     */
    public const COEFFICIENTS_2 = [3, 4, 5, 6, 7, 8, 9, 10, 11, 1, 2];
}
