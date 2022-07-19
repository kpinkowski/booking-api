<?php

declare(strict_types=1);

namespace App\Booking\Exception;

use Exception;

class PastDatesException extends Exception
{
    private const MESSAGE = 'Cannot book on past dates.';
    private const CODE = 400;

    public function __construct()
    {
        parent::__construct(
            self::MESSAGE,
            self::CODE
        );
    }
}
