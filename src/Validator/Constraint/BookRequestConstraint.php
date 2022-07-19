<?php

declare(strict_types=1);

namespace App\Validator\Constraint;

use App\Constants\Date;
use Symfony\Component\Validator\Constraints;
use DateTime;

class BookRequestConstraint
{
    public static function get(): Constraints\Collection
    {
        return new Constraints\Collection([
            'startDate' => [
                new Constraints\NotBlank(),
                new Constraints\Type('string'),
                new Constraints\Date(),

            ],
            'endDate' => [
                new Constraints\NotBlank(),
                new Constraints\Type('string'),
                new Constraints\Date(),
            ],
            'amount' => [
                new Constraints\NotBlank(),
                new Constraints\Type('int'),
                new Constraints\Positive(),
            ]
        ]);
    }
}
