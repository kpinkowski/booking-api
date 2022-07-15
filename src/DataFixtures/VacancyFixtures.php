<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Vacancy;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use DateTime;

class VacancyFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 30; $i++) {
            $vacancy = $this->createVacancy(new DateTime($i.'-07-2022'), 5);
            $manager->persist($vacancy);
        }

        $manager->flush();
    }

    private function createVacancy(DateTime $date, int $slotAmount): Vacancy
    {
        $vacancy = new Vacancy();

        $vacancy->setDate($date);
        $vacancy->setSlots($slotAmount);

        return $vacancy;
    }
}
