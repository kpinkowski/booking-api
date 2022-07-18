<?php

declare(strict_types=1);

namespace App\Vacancy\Finder;

use App\Constants\Date;
use App\Entity\Vacancy;
use App\Repository\VacancyRepository;
use App\Vacancy\Exception\NotEnoughSlotsForSuchDateException;
use App\Vacancy\Exception\ThereIsNoVacancyForSuchDateException;
use DateTime;

class VacancyFinder implements VacancyFinderInterface
{
    private VacancyRepository $vacancyRepository;

    public function __construct(VacancyRepository $vacancyRepository)
    {
        $this->vacancyRepository = $vacancyRepository;
    }

    public function find(DateTime $date, int $amount): Vacancy
    {
        $vacancy = $this->vacancyRepository->findOneBy(['date' => $date]);

        if (!$vacancy) {
            throw new ThereIsNoVacancyForSuchDateException($date);
        }

        if (($vacancy->getSlots() - $amount) < 0) {
            throw new NotEnoughSlotsForSuchDateException($date, $vacancy->getSlots(), $amount);
        }

        return $vacancy;
    }
}
