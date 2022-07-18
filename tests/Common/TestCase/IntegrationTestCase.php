<?php

declare(strict_types=1);

namespace App\Tests\Common\TestCase;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class IntegrationTestCase extends KernelTestCase
{
    protected ContainerInterface $container;

    public function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        $this->container = self::$kernel->getContainer();
        $this->startTransaction();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->rollbackTransaction();
    }

    protected function get(string $service): ?object
    {
        return $this::$kernel->getContainer()->get($service);
    }

    protected function getEntityManager(): EntityManagerInterface
    {
        return self::$kernel->getContainer()->get('doctrine.orm.entity_manager');
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
