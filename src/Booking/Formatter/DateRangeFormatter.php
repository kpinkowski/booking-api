<?php

declare(strict_types=1);

namespace App\Booking\Formatter;

use App\Booking\Exception\WrongDatesException;
use App\Constants\Date;
use DateTime;
use DatePeriod;
use DateInterval;

class DateRangeFormatter
{
    public function format(DateTime $startDate, DateTime $endDate): DatePeriod
    {
        if ($startDate >= $endDate) {
            throw new WrongDatesException();
        }

        return new DatePeriod($startDate, new DateInterval(Date::DATE_INTERVAL), $endDate);
    }
}
