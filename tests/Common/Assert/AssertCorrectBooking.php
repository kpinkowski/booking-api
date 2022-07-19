<?php

declare(strict_types=1);

namespace App\Tests\Common\Assert;

use App\Entity\Booking;
use PHPUnit\Framework\Assert;
use DateTime;

class AssertCorrectBooking
{
    public static function assert(array $item, Booking $booking): void
    {
        Assert::assertEquals($booking->getId(), $item['id']);
        Assert::assertEquals($booking->getStartDate(), new DateTime($item['startDate']));
        Assert::assertEquals($booking->getEndDate(), new DateTime($item['endDate']));
    }
}
