<?php

declare(strict_types=1);

namespace App\Vacancy\Manager;

use App\Entity\Vacancy;

interface VacancySlotManagerInterface
{
    public function increase(Vacancy $vacancy, int $amount);
    public function decrease(Vacancy $vacancy, int $amount);
}
