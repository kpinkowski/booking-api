<?php

declare(strict_types=1);

namespace App\Tests\Common\TestCase;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class IntegrationTestCase extends KernelTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        $this->container = self::$kernel->getContainer();
    }
}
