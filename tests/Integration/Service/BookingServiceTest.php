<?php

declare(strict_types=1);

namespace App\Tests\Integration\Service;

use App\DataFixtures\UserFixtures;
use App\Repository\UserRepository;
use App\Service\BookingService;
use App\Service\BookingServiceInterface;
use App\Tests\Common\TestCase\IntegrationTestCase;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Assert;
use Symfony\Component\DependencyInjection\ContainerInterface;

class BookingServiceTest extends IntegrationTestCase
{
    private ContainerInterface $container;
    private BookingServiceInterface $bookingService;
    private EntityManagerInterface $entityManager;

    public function setUp(): void
    {
        $this->bookingService = $this->container->get(BookingService::class);
        $this->userRepository = $this->container->get(UserRepository::class);
        $this->entityManager = $this->container->get('doctrine.orm.entity_manager');
    }

    public function testItReturnsPaginatedBookingList(): void
    {
        $expectedPageSize = 1;
        $user = $this->userRepository
            ->findOneBy([
                'username' => UserFixtures::USERNAME
            ]);

        $pagination = $this->bookingService->getAllForUser($user, 1, $expectedPageSize);
        Assert::assertCount($expectedPageSize, $pagination->getItems());
    }
}
