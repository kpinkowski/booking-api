<?php

declare(strict_types=1);

namespace App\Vacancy\Manager;

use App\Entity\Vacancy;
use App\Vacancy\Exception\NegativeSlotException;

class VacancySlotManager implements VacancySlotManagerInterface
{
    public function increase(Vacancy $vacancy, int $amount): void
    {
        $currentSlotsAmount = $vacancy->getSlots();
        $newSlotsAmount = $currentSlotsAmount + $amount;
        $vacancy->setSlots($newSlotsAmount);
    }

    public function decrease(Vacancy $vacancy, int $amount): void
    {
        $currentSlotsAmount = $vacancy->getSlots();
        $newSlotsAmount = $currentSlotsAmount - $amount;

        if ($newSlotsAmount < 0) {
            throw new NegativeSlotException();
        }

        $vacancy->setSlots($newSlotsAmount);
    }
}
