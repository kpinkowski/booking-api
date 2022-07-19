<?php

namespace App\Vacancy\Finder;

use App\Entity\Vacancy;
use DateTime;

interface VacancyFinderInterface
{
    public function find(DateTime $date, int $amount): Vacancy;
}
