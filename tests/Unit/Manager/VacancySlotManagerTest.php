<?php

declare(strict_types=1);

namespace App\Tests\Unit\Manager;

use App\Entity\Vacancy;
use App\Exception\NegativeSlotException;
use App\Manager\VacancySlotManager;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class VacancySlotManagerTest extends TestCase
{
    private EntityManagerInterface $entityManagerMock;
    private VacancySlotManager $vacancySlotManager;

    public function setUp(): void
    {
        parent::setUp();
        $this->entityManagerMock = $this->createMock(EntityManagerInterface::class);
        $this->vacancySlotManager = new VacancySlotManager($this->entityManagerMock);
    }

    /** @dataProvider increaseSlotDataProvider */
    public function testItIncreasesSlotAmount(int $currentSlots, int $increaseAmount, int $expectedSlots): void
    {
        $vacancy = new Vacancy();
        $vacancy->setSlots($currentSlots);
        $this->entityManagerMock
            ->expects(self::once())
            ->method('flush');

        $this->vacancySlotManager->increase($vacancy, $increaseAmount);

        Assert::assertSame($expectedSlots, $vacancy->getSlots());
    }

    /** @dataProvider decreaseSlotDataProvider*/
    public function testItDecreasesSlotAmount(int $currentSlots, int $decreaseAmount, int $expectedSlots): void
    {
        $vacancy = new Vacancy();
        $vacancy->setSlots($currentSlots);
        $this->entityManagerMock
            ->expects(self::once())
            ->method('flush');

        $this->vacancySlotManager->decrease($vacancy, $decreaseAmount);

        Assert::assertSame($expectedSlots, $vacancy->getSlots());
    }

    public function testItThrowsExceptionWhenTryingToSetSlotsToNegativeValue(): void
    {
        $decreaseAmount = 6;
        $vacancy = new Vacancy();
        $vacancy->setSlots(5);

        $this->expectException(NegativeSlotException::class);

        $this->vacancySlotManager->decrease($vacancy, $decreaseAmount);
    }

    public function increaseSlotDataProvider(): array
    {
        return [
            [6, 1, 7],
            [4, 2, 6],
        ];
    }

    public function decreaseSlotDataProvider(): array
    {
        return [
            [6, 5, 1],
            [6, 6, 0],
        ];
    }
}
