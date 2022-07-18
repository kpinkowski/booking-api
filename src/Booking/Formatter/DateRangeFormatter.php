<?php

declare(strict_types=1);

namespace App\Booking\Formatter;

use DateTime;
use DatePeriod;
use DateInterval;

class DateRangeFormatter
{
    private const INTERVAL = 'P1D';

    public function format(DateTime $startDate, DateTime $endDate): DatePeriod
    {
        return new DatePeriod($startDate, new DateInterval(self::INTERVAL), $endDate);
    }
}
