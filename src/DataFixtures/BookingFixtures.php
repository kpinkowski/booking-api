<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Booking;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use DateTime;

class BookingFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $user = $manager->getRepository(User::class)->findOneBy(['username' => UserFixtures::USERNAME]);
        $booking1 = $this->createBooking($user, new DateTime('01-07-2022'), new DateTime('10-07-2022'));
        $booking2 = $this->createBooking($user, new DateTime('03-07-2022'), new DateTime('08-07-2022'));
        $booking3 = $this->createBooking($user, new DateTime('02-07-2022'), new DateTime('05-07-2022'));

        $manager->persist($booking1);
        $manager->persist($booking2);
        $manager->persist($booking3);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }

    private function createBooking(User $user, DateTime $startDate, DateTime $endDate): Booking
    {
        $booking = new Booking();

        $booking->setStartDate($startDate);
        $booking->setEndDate($endDate);
        $booking->setBookingUser($user);

        return $booking;
    }
}
