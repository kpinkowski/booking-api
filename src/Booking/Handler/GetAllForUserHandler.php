<?php

declare(strict_types=1);

namespace App\Booking\Handler;

use App\Constants\Pagination;
use App\Entity\User;
use App\Repository\BookingRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class GetAllForUserHandler
{
    private BookingRepository $bookingRepository;
    private PaginatorInterface $paginator;

    public function __construct(BookingRepository $bookingRepository, PaginatorInterface $paginator)
    {
        $this->bookingRepository = $bookingRepository;
        $this->paginator = $paginator;
    }

    public function handle(User $user, int $pageNumber, int $perPage = Pagination::PER_PAGE): PaginationInterface
    {
        $query = $this->bookingRepository
            ->createQueryBuilder('b')
            ->where('b.bookingUser = :userId')
            ->setParameter('userId', $user->getId())
            ->getQuery();

        return $this->paginator->paginate(
            $query,
            $pageNumber,
            $perPage
        );
    }
}
