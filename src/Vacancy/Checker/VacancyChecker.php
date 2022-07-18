<?php

declare(strict_types=1);

namespace App\Vacancy\Checker;

use App\Repository\VacancyRepository;
use DateTime;

class VacancyChecker
{
    private VacancyRepository $vacancyRepository;

    public function __construct(VacancyRepository $vacancyRepository)
    {
        $this->vacancyRepository = $vacancyRepository;
    }

    public function check(DateTime $startDate, DateTime $endDate)
    {

    }
}
