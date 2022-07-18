<?php

declare(strict_types=1);

namespace App\Booking\Handler;

use App\Entity\User;
use DateTime;

class BookingHandler
{
    public function handle(User $user, DateTime $startDate, DateTime $endDate, int $amount): void
    {

    }
}
