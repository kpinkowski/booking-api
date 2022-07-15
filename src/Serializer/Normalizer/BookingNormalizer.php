<?php

declare(strict_types=1);

namespace App\Serializer\Normalizer;

use App\Entity\Booking;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class BookingNormalizer implements NormalizerInterface
{
    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        /** @var Booking $object */
        return [
            'id' => $object->getId(),
            'startDate' => $object->getStartDate()->format('d-m-Y'),
            'endDate' => $object->getEndDate()->format('d-m-Y'),
        ];
    }

    public function supportsNormalization(mixed $data, string $format = null): bool
    {
        return $data instanceof Booking;
    }
}
