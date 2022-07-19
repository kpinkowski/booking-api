<?php

namespace App\Controller;

use App\Booking\Handler\BookingHandler;
use App\Booking\Handler\GetAllForUserHandler;
use App\Serializer\Normalizer\BookingNormalizer;
use App\Validator\Constraint\BookRequestConstraint;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ConstraintViolationListNormalizer;
use Symfony\Component\Serializer\Serializer;
use DateTime;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BookingController extends AbstractController
{
    private GetAllForUserHandler $getAllForUserHandler;
    private BookingHandler $bookHandler;
    private ValidatorInterface $validator;

    public function __construct(
        GetAllForUserHandler $getAllForUserHandler,
        BookingHandler $bookHandler,
        ValidatorInterface $validator
    ) {
        $this->getAllForUserHandler = $getAllForUserHandler;
        $this->bookHandler = $bookHandler;
        $this->validator = $validator;
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
        $data = json_decode($request->getContent(), true);
        $user = $this->getUser();

        $validationResults = $this->validator->validate($data, BookRequestConstraint::get());
        if ($validationResults->count() > 0) {
            $serializer = new Serializer([new ConstraintViolationListNormalizer()]);
            $errors = $serializer->normalize($validationResults);

            return new JsonResponse([
                'message' => $errors['title'],
                'errors' => array_map(function ($item) {
                    return [$item['propertyPath'] => $item['title']];
                }, $errors['violations'])
            ], Response::HTTP_BAD_REQUEST);
        }

        try {
            $booking = $this->bookHandler->handle(
                $user,
                new DateTime($data['startDate']),
                new DateTime($data['endDate']),
                $data['amount']
            );
        } catch (Exception $exception) {
            return new JsonResponse(['message' => $exception->getMessage()], $exception->getCode());
        }

        return new JsonResponse(['bookingId' => $booking->getId()], Response::HTTP_OK);
    }
}
