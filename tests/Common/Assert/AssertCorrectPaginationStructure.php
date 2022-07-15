<?php

declare(strict_types=1);

namespace App\Tests\Common\Assert;

use PHPUnit\Framework\Assert;

class AssertCorrectPaginationStructure
{
    public static function assert(array $data)
    {
        Assert::assertArrayHasKey('perPage', $data);
        Assert::assertArrayHasKey('currentPage', $data);
        Assert::assertArrayHasKey('total', $data);
        Assert::assertArrayHasKey('items', $data);
    }
}
