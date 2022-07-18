<?php

declare(strict_types=1);

namespace App\Vacancy\Exception;

use App\Constants\Date;
use Exception;
use DateTime;

class NotEnoughSlotsForSuchDateException extends Exception
{
    private const MESSAGE = 'Not enough slots for date: %s. There are %s slots left. Tried to book: %s slots.';
    private const CODE = 400;

    public function __construct(DateTime $dateTime, int $currentSlots, int $bookAmount)
    {
        parent::__construct(
            sprintf(
                self::MESSAGE,
                $dateTime->format(Date::DATE_FORMAT),
                $currentSlots,
                $bookAmount
            ),
            self::CODE
        );
    }
}
