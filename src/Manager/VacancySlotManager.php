<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Vacancy;
use App\Exception\NegativeSlotException;
use Doctrine\ORM\EntityManagerInterface;

class VacancySlotManager implements VacancySlotManagerInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function increase(Vacancy $vacancy, int $amount): void
    {
        $currentSlotsAmount = $vacancy->getSlots();
        $newSlotsAmount = $currentSlotsAmount + $amount;
        $vacancy->setSlots($newSlotsAmount);
        $this->entityManager->flush();
    }

    public function decrease(Vacancy $vacancy, int $amount): void
    {
        $currentSlotsAmount = $vacancy->getSlots();
        $newSlotsAmount = $currentSlotsAmount - $amount;

        if ($newSlotsAmount < 0) {
            throw new NegativeSlotException();
        }

        $vacancy->setSlots($newSlotsAmount);
        $this->entityManager->flush();
    }
}
