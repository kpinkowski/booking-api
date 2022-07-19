<?php

declare(strict_types=1);

namespace App\Tests\Unit\Booking\Formatter;

use App\Booking\Exception\WrongDatesException;
use App\Booking\Formatter\DateRangeFormatter;
use App\Tests\Common\Assert\AssertCorrectDatePeriod;
use PHPUnit\Framework\TestCase;
use DateTime;

class DateRangeFormatterTest extends TestCase
{
    private DateRangeFormatter $dateRangeFormatter;

    public function setUp(): void
    {
        parent::setUp();
        $this->dateRangeFormatter = new DateRangeFormatter();
    }

    /**
     * @dataProvider correctDatesDataProvider
     */
    public function testItReturnsCorrectTimePeriod(DateTime $startDate, DateTime $endDate): void
    {
        $period = $this->dateRangeFormatter->format($startDate, $endDate);
        AssertCorrectDatePeriod::assert($startDate, $endDate, $period);
    }

    /**
     * @dataProvider incorrectDatesDataProvider
     */
    public function testItThrowsExceptionWhenDatesAreWrong(DateTime $startDate, DateTime $endDate): void
    {
        $this->expectException(WrongDatesException::class);
        $this->dateRangeFormatter->format($startDate, $endDate);
    }

    public function correctDatesDataProvider(): array
    {
        return [
            [new DateTime('01-07-2022'), new DateTime('02-07-2022')],
            [new DateTime('01-07-2022'), new DateTime('02-08-2022')],
        ];
    }

    public function incorrectDatesDataProvider(): array
    {
        return [
            [new DateTime('01-07-2022'), new DateTime('02-06-2022')],
            [new DateTime('02-07-2022'), new DateTime('01-07-2022')],
        ];
    }
}
