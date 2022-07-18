<?php

declare(strict_types=1);

namespace App\Tests\Common\Assert;

use App\Entity\Booking;
use App\Entity\User;
use PHPUnit\Framework\Assert;
use DateTime;

class AssertCorrectBookingCreated
{
    public static function assert(
        Booking $booking,
        DateTime $startDate,
        DateTime $endDate,
        int $amount,
        User $user
    ): void
    {
        Assert::assertEquals($startDate, $booking->getStartDate());
        Assert::assertEquals($endDate, $booking->getEndDate());
        Assert::assertEquals($user, $booking->getBookingUser());
    }
}
