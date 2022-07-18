<?php

declare(strict_types=1);

namespace App\Tests\Common\TestCase;

use App\DataFixtures\UserFixtures;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

abstract class ApiTestCase extends WebTestCase
{
    private ContainerInterface $container;
    protected KernelBrowser $client;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = $this->createAuthenticatedClient(
            UserFixtures::USERNAME,
            UserFixtures::PASSWORD
        );
        self::bootKernel();
        $this->container = self::$kernel->getContainer();
        $this->startTransaction();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->rollbackTransaction();
    }

    protected function createAuthenticatedClient($username = 'user', $password = 'password'): KernelBrowser
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/login_check',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'username' => $username,
                'password' => $password,
            ], JSON_THROW_ON_ERROR)
        );

        $data = json_decode(
            $client->getResponse()->getContent(),
            true,
            512,
            JSON_THROW_ON_ERROR
        );
        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

        return $client;
    }

    private function startTransaction(): void
    {
        $connection = $this->getEntityManager()->getConnection();
        $connection->beginTransaction();
    }

    private function rollbackTransaction(): void
    {
        $connection = $this->getEntityManager()->getConnection();
        $this->cleanUpDatabase();
        $connection->close();
    }

    private function cleanUpDatabase(): void
    {
        $connection = $this->getEntityManager()->getConnection();
        if ($connection->isTransactionActive()) {
            try {
                while ($connection->getTransactionNestingLevel() > 0) {
                    $connection->rollback();
                }
            } catch (\PDOException $e) {}
        }
    }
}

