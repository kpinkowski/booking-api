<?php

declare(strict_types=1);

namespace App\Booking\Handler;

use App\Booking\Exception\WrongDatesException;
use App\Booking\Formatter\DateRangeFormatter;
use App\Entity\Booking;
use App\Entity\User;
use App\Vacancy\Finder\VacancyFinderInterface;
use App\Vacancy\Manager\VacancySlotManagerInterface;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class BookingHandler
{
    private DateRangeFormatter $dateRangeFormatter;
    private VacancyFinderInterface $vacancyFinder;
    private VacancySlotManagerInterface $vacancySlotManager;
    private EntityManagerInterface $entityManager;

    public function __construct(
        DateRangeFormatter $dateRangeFormatter,
        VacancyFinderInterface $vacancyFinder,
        VacancySlotManagerInterface $vacancySlotManager,
        EntityManagerInterface $entityManager
    ) {
        $this->dateRangeFormatter = $dateRangeFormatter;
        $this->vacancyFinder = $vacancyFinder;
        $this->vacancySlotManager = $vacancySlotManager;
        $this->entityManager = $entityManager;
    }

    public function handle(User $user, DateTime $startDate, DateTime $endDate, int $amount): Booking
    {
        $booking = new Booking();
        $booking->setBookingUser($user);
        $booking->setStartDate($startDate);
        $booking->setEndDate($endDate);
        $booking->setAmount($amount);

        $dateRange = $this->dateRangeFormatter->format($startDate, $endDate);

        foreach ($dateRange->getIterator() as $date) {
            $vacancy = $this->vacancyFinder->find($date, $amount);
            $this->vacancySlotManager->decrease($vacancy, $amount);
        }

        $this->entityManager->persist($booking);
        $this->entityManager->flush();

        return $booking;
    }
}
