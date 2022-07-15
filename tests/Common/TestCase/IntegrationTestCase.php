<?php

declare(strict_types=1);

namespace App\Tests\Common\TestCase;

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
    }
}
