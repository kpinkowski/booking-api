<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use Knp\Component\Pager\Pagination\PaginationInterface;

interface BookingServiceInterface
{
    public function getAllForUser(User $user, int $pageNumber): PaginationInterface;
    public function book();
    public function cancel();
}
