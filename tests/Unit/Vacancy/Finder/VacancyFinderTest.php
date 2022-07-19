<?php

declare(strict_types=1);

namespace App\Tests\Unit\Vacancy\Finder;

use App\Entity\Vacancy;
use App\Repository\VacancyRepository;
use App\Vacancy\Exception\NotEnoughSlotsForSuchDateException;
use App\Vacancy\Exception\ThereIsNoVacancyForSuchDateException;
use App\Vacancy\Finder\VacancyFinder;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use DateTime;

class VacancyFinderTest extends TestCase
{
    private VacancyRepository $vacancyRepositoryMock;
    private VacancyFinder $vacancyFinder;

    public function setUp(): void
    {
        parent::setUp();
        $this->vacancyRepositoryMock = $this->createMock(VacancyRepository::class);
        $this->vacancyFinder = new VacancyFinder($this->vacancyRepositoryMock);
    }

    public function testItReturnsVacancyIfAllRequirementsWereFulfilled(): void
    {
        $expectedVacancy = new Vacancy();
        $expectedVacancy->setSlots(2);
        $amount = 1;

        $this->vacancyRepositoryMock
            ->expects(self::once())
            ->method('findOneBy')
            ->willReturn($expectedVacancy);

        $vacancy = $this->vacancyFinder->find(new DateTime(), $amount);

        Assert::assertSame($expectedVacancy, $vacancy);
    }

    public function testItThrowsExceptionWhenThereIsNoVacancy(): void
    {
        $expectedVacancy = new Vacancy();
        $amount = 1;

        $this->vacancyRepositoryMock
            ->expects(self::once())
            ->method('findOneBy')
            ->willReturn(null);

        $this->expectException(ThereIsNoVacancyForSuchDateException::class);

        $this->vacancyFinder->find(new DateTime(), $amount);
    }

    public function testItThrowsExceptionWhenThereAreNotEnoughSlots(): void
    {
        $expectedVacancy = new Vacancy();
        $expectedVacancy->setSlots(0);
        $amount = 1;

        $this->vacancyRepositoryMock
            ->expects(self::once())
            ->method('findOneBy')
            ->willReturn($expectedVacancy);

        $this->expectException(NotEnoughSlotsForSuchDateException::class);

        $this->vacancyFinder->find(new DateTime(), $amount);
    }
}
