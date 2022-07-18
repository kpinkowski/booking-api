<?php

declare(strict_types=1);

namespace App\Tests\Integration\Booking\Handler;

use App\Booking\Handler\GetAllForUserHandler;
use App\Booking\Service\BookingServiceInterface;
use App\DataFixtures\UserFixtures;
use App\Repository\UserRepository;
use App\Tests\Common\TestCase\IntegrationTestCase;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Assert;

class GetAllForUserHandlerTest extends IntegrationTestCase
{
    private GetAllForUserHandler $getAllForUserHandler;
    private EntityManagerInterface $entityManager;

    public function setUp(): void
    {
        parent::setUp();
        $this->getAllForUserHandler = $this->container->get(GetAllForUserHandler::class);
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

        $pagination = $this->getAllForUserHandler->handle($user, 1, $expectedPageSize);
        Assert::assertCount($expectedPageSize, $pagination->getItems());
    }
}
