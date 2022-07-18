<?php

declare(strict_types=1);

namespace App\Vacancy\Exception;

use App\Constants\Date;
use Exception;
use DateTime;

class ThereIsNoVacancyForSuchDateException extends Exception
{
    private const MESSAGE = 'There is no vacancy available for date %s';
    private const CODE = 400;

    public function __construct(DateTime $dateTime)
    {
        parent::__construct(
            sprintf(
                self::MESSAGE,
                $dateTime->format(Date::DATE_FORMAT)
            ),
            self::CODE
        );
    }
}
