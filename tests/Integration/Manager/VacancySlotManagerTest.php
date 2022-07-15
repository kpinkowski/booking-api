<?php

declare(strict_types=1);

namespace App\Tests\Integration\Manager;

use App\Entity\Vacancy;
use App\Manager\VacancySlotManager;
use App\Tests\Common\TestCase\IntegrationTestCase;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Assert;

class VacancySlotManagerTest extends IntegrationTestCase
{
    private VacancySlotManager $vacancySlotManager;
    private EntityManagerInterface $entityManager;

    public function setUp(): void
    {
        parent::setUp();
        $this->vacancySlotManager = $this->container->get(VacancySlotManager::class);
        $this->entityManager = $this->container->get('doctrine.orm.entity_manager');
    }

    public function testItIncreasesSlots(): void
    {
        $initialSlot = 1;
        $increaseSlot = 1;
        $vacancy = new Vacancy();
        $vacancy->setDate(new DateTime());
        $vacancy->setSlots($initialSlot);
        $this->entityManager->persist($vacancy);
        $this->entityManager->flush();

        $this->vacancySlotManager->increase($vacancy, $increaseSlot);
        $this->entityManager->refresh($vacancy);

        Assert::assertEquals($initialSlot + $increaseSlot, $vacancy->getSlots());
    }

    public function testItDecreasesSlots(): void
    {
        $initialSlot = 1;
        $decreaseSlot = 1;
        $vacancy = new Vacancy();
        $vacancy->setDate(new DateTime());
        $vacancy->setSlots($initialSlot);
        $this->entityManager->persist($vacancy);
        $this->entityManager->flush();

        $this->vacancySlotManager->decrease($vacancy, $decreaseSlot);
        $this->entityManager->refresh($vacancy);

        Assert::assertEquals($initialSlot - $decreaseSlot, $vacancy->getSlots());
    }
}
