<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class BookingService implements BookingServiceInterface
{
    private const PER_PAGE = 10;

    private BookingRepository $bookingRepository;
    private EntityManagerInterface $entityManager;
    private PaginatorInterface $paginator;

    public function __construct(
        BookingRepository $bookingRepository,
        EntityManagerInterface $entityManager,
        PaginatorInterface $paginator
    ) {
        $this->bookingRepository = $bookingRepository;
        $this->entityManager = $entityManager;
        $this->paginator = $paginator;
    }

    public function getAllForUser(User $user, int $pageNumber, int $perPage = self::PER_PAGE): PaginationInterface
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

    public function book()
    {

    }

    public function cancel()
    {

    }
}
