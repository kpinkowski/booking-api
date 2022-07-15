<?php

namespace App\Controller;

use App\Serializer\Normalizer\BookingNormalizer;
use App\Service\BookingService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;

class BookingController extends AbstractController
{
    private BookingService $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    #[Route('api/booking', name: 'app_booking')]
    public function list(Request $request): JsonResponse
    {
        $user = $this->getUser();
        $pageNumber = ($request->get('pageNumber')) ?: 1;
        $pagination = $this->bookingService->getAllForUser($user, $pageNumber);
        $normalizers = [new BookingNormalizer()];
        $serializer = new Serializer($normalizers);

        return $this->json([
            'items' => $serializer->normalize($pagination->getItems()),
            'total' => $pagination->getTotalItemCount(),
            'currentPage' => $pagination->getCurrentPageNumber(),
            'perPage' => $pagination->getItemNumberPerPage(),
        ]);
    }
}
