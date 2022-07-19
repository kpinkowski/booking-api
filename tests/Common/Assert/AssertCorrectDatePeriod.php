<?php

declare(strict_types=1);

namespace App\Tests\Common\Assert;

use App\Constants\Date;
use DatePeriod;
use DateTime;
use DateInterval;
use PHPUnit\Framework\Assert;

class AssertCorrectDatePeriod
{
    public static function assert(DateTime $startDate, DateTime $endDate, DatePeriod $datePeriod)
    {
        Assert::assertEquals($startDate, $datePeriod->getStartDate());
        Assert::assertEquals($endDate, $datePeriod->getEndDate());
        Assert::assertEquals(new DateInterval(Date::DATE_INTERVAL), $datePeriod->getDateInterval());
    }
}
