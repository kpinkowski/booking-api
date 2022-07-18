<?php

declare(strict_types=1);

namespace App\Booking\Exception;

use Exception;

class WrongDatesException extends Exception
{
    private const MESSAGE = 'The end date should be later than the start date.';
    private const CODE = 400;

    public function __construct()
    {
        parent::__construct(
            self::MESSAGE,
            self::CODE
        );
    }
}
