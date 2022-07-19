<?php

declare(strict_types=1);

namespace App\Tests\Unit\Vacancy\Manager;

use App\Entity\Vacancy;
use App\Vacancy\Exception\NegativeSlotException;
use App\Vacancy\Manager\VacancySlotManager;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class VacancySlotManagerTest extends TestCase
{
    private VacancySlotManager $vacancySlotManager;

    public function setUp(): void
    {
        parent::setUp();
        $this->vacancySlotManager = new VacancySlotManager();
    }

    /** @dataProvider increaseSlotDataProvider */
    public function testItIncreasesSlotAmount(int $currentSlots, int $increaseAmount, int $expectedSlots): void
    {
        $vacancy = new Vacancy();
        $vacancy->setSlots($currentSlots);

        $this->vacancySlotManager->increase($vacancy, $increaseAmount);

        Assert::assertSame($expectedSlots, $vacancy->getSlots());
    }

    /** @dataProvider decreaseSlotDataProvider*/
    public function testItDecreasesSlotAmount(int $currentSlots, int $decreaseAmount, int $expectedSlots): void
    {
        $vacancy = new Vacancy();
        $vacancy->setSlots($currentSlots);

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
