<?php

namespace App\Controller;

use App\Booking\Handler\BookingHandler;
use App\Booking\Handler\GetAllForUserHandler;
use App\Serializer\Normalizer\BookingNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use DateTime;
use Exception;

class BookingController extends AbstractController
{
    private GetAllForUserHandler $getAllForUserHandler;
    private BookingHandler $bookHandler;

    public function __construct(
        GetAllForUserHandler $getAllForUserHandler,
        BookingHandler $bookHandler
    ) {
        $this->getAllForUserHandler = $getAllForUserHandler;
        $this->bookHandler = $bookHandler;
    }

    #[Route('api/booking', name: 'app_booking')]
    public function list(Request $request): JsonResponse
    {
        $user = $this->getUser();
        $pageNumber = ($request->get('pageNumber')) ?: 1;
        $pagination = $this->getAllForUserHandler->handle($user, $pageNumber);
        $normalizers = [new BookingNormalizer()];
        $serializer = new Serializer($normalizers);

        return $this->json([
            'items' => $serializer->normalize($pagination->getItems()),
            'total' => $pagination->getTotalItemCount(),
            'currentPage' => $pagination->getCurrentPageNumber(),
            'perPage' => $pagination->getItemNumberPerPage(),
        ]);
    }

    #[Route('api/booking/book', name: 'app_booking_book')]
    public function book(Request $request): JsonResponse
    {
        $startDate = $request->get('startDate');
        $endDate = $request->get('endDate');
        $amount = $request->get('amount');
        // TODO: add validation for request

        $user = $this->getUser();

        try {
            $this->bookHandler->handle($user, $startDate, $endDate, $amount);
        } catch (Exception $exception) {
            throw new HttpException($exception->getCode(), $exception->getMessage());
        }
    }
}
