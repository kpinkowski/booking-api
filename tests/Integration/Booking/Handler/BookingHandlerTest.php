<?php

declare(strict_types=1);

namespace App\Tests\Integration\Booking\Handler;

use App\Booking\Exception\WrongDatesException;
use App\Booking\Handler\BookingHandler;
use App\DataFixtures\UserFixtures;
use App\Repository\BookingRepository;
use App\Repository\UserRepository;
use App\Tests\Common\Assert\AssertCorrectBookingCreated;
use App\Tests\Common\TestCase\IntegrationTestCase;
use App\Vacancy\Exception\NotEnoughSlotsForSuchDateException;
use App\Vacancy\Exception\ThereIsNoVacancyForSuchDateException;
use DateTime;

class BookingHandlerTest extends IntegrationTestCase
{
    private BookingHandler $bookingHandler;
    private UserRepository $userRepository;
    private BookingRepository $bookingRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->bookingHandler = $this->container->get(BookingHandler::class);
        $this->userRepository = $this->container->get(UserRepository::class);
        $this->bookingRepository = $this->container->get(BookingRepository::class);
    }

    /**
     * @dataProvider correctBookingDataProvider
     */
    public function testItDoesHandleBookingIfAllRequirementsAreFulfilled(
        DateTime $startDate,
        DateTime $endDate,
        int $amount
    ): void
    {
        $user = $this->userRepository->findOneBy(['username' => UserFixtures::USERNAME]);
        $booking = $this->bookingHandler->handle($user, $startDate, $endDate, $amount);
        AssertCorrectBookingCreated::assert($booking, $startDate, $endDate, $amount, $user);
    }

    /**
     * @dataProvider wrongDatesDataProvider
     */
    public function testItThrowsExceptionWhenDatesAreWrong(
        DateTime $startDate,
        DateTime $endDate,
        int $amount
    ): void
    {
        $user = $this->userRepository->findOneBy(['username' => UserFixtures::USERNAME]);
        $this->expectException(WrongDatesException::class);
        $this->bookingHandler->handle($user, $startDate, $endDate, $amount);
    }

    /**
     * @dataProvider noVacancyDataProvider
     */
    public function testItThrowsExceptionWhenThereAreNoVacancy(
        DateTime $startDate,
        DateTime $endDate,
        int $amount
    ): void
    {
        $user = $this->userRepository->findOneBy(['username' => UserFixtures::USERNAME]);
        $this->expectException(ThereIsNoVacancyForSuchDateException::class);
        $this->bookingHandler->handle($user, $startDate, $endDate, $amount);
    }

    /**
     * @dataProvider noSlotsDataProvider
     */
    public function testItThrowsExceptionWhenThereAreNoSlotsAvailable(
        DateTime $startDate,
        DateTime $endDate,
        int $amount
    ): void
    {
        $user = $this->userRepository->findOneBy(['username' => UserFixtures::USERNAME]);
        $this->expectException(NotEnoughSlotsForSuchDateException::class);
        $this->bookingHandler->handle($user, $startDate, $endDate, $amount);
    }

    public function correctBookingDataProvider(): array
    {
        return [
            [new DateTime('01-07-2022'), new DateTime('02-07-2022'), 1],
            [new DateTime('10-07-2022'), new DateTime('15-07-2022'), 3],
        ];
    }

    public function wrongDatesDataProvider(): array
    {
        return [
            [new DateTime('03-07-2022'), new DateTime('02-07-2022'), 1],
        ];
    }

    public function noVacancyDataProvider(): array
    {
        return [
            [new DateTime('01-08-2022'), new DateTime('02-08-2022'), 1],
        ];
    }

    public function noSlotsDataProvider(): array
    {
        return [
            [new DateTime('01-07-2022'), new DateTime('02-07-2022'), 6],
        ];
    }
}
