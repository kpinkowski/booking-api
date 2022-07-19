<?php

declare(strict_types=1);

namespace App\Tests\Unit\Serializer\Normalizer;

use App\Entity\Booking;
use App\Entity\Vacancy;
use App\Serializer\Normalizer\BookingNormalizer;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class BookingNormalizerTest extends TestCase
{
    private BookingNormalizer $bookingNormalizer;

    public function setUp(): void
    {
        $this->bookingNormalizer = new BookingNormalizer();
    }

    public function testItReturnsNormalizedStructure(): void
    {
        $booking = new Booking();
        $booking->setStartDate(new \DateTime());
        $booking->setEndDate(new \DateTime());

        $normalizedBooking = $this->bookingNormalizer->normalize($booking);

        Assert::assertArrayHasKey('id', $normalizedBooking);
        Assert::assertArrayHasKey('startDate', $normalizedBooking);
        Assert::assertArrayHasKey('endDate', $normalizedBooking);
    }

    public function testItReturnsCorrectDateFormat(): void
    {
        $booking = new Booking();
        $expectedStartDate = '01-01-2001';
        $expectedEndDate = '02-01-2001';
        $booking->setStartDate(new \DateTime($expectedStartDate));
        $booking->setEndDate(new \DateTime($expectedEndDate));

        $normalizedBooking = $this->bookingNormalizer->normalize($booking);

        Assert::assertSame($expectedStartDate, $normalizedBooking['startDate']);
        Assert::assertSame($expectedEndDate, $normalizedBooking['endDate']);
    }

    public function testItSupportsCorrectObject(): void
    {
        $supports = $this->bookingNormalizer->supportsNormalization(new Booking());
        Assert::assertTrue($supports);
    }

    public function testItDoesNotSupportIncorrectObject(): void
    {
        $supports = $this->bookingNormalizer->supportsNormalization(new Vacancy());
        Assert::assertFalse($supports);
    }
}
