<?php

declare(strict_types=1);

namespace App\Tests\Api\Controller;

use App\Repository\BookingRepository;
use App\Tests\Common\Assert\AssertCorrectBooking;
use App\Tests\Common\Assert\AssertCorrectPaginationStructure;
use App\Tests\Common\TestCase\ApiTestCase;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;

class BookingControllerTest extends ApiTestCase
{
    private BookingRepository $bookingRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->bookingRepository = self::getContainer()->get(BookingRepository::class);
    }

    public function testItReturnsCorrectResponseCodeForBookingList(): void
    {
        $this->client->request(Request::METHOD_GET, '/api/booking');
        $response = $this->client->getResponse();
        Assert::assertSame(200, $response->getStatusCode());
    }

    public function testItGetsListOfUsersBookings(): void
    {
        $this->client->request(Request::METHOD_GET, '/api/booking');
        $response = $this->client->getResponse()->getContent();
        $decodedResponse = json_decode($response, true, 512, JSON_THROW_ON_ERROR);
        $items = $decodedResponse['items'];

        foreach ($items as $item) {
            $booking = $this->bookingRepository->find($item['id']);
            AssertCorrectBooking::assert($item, $booking);
        }
    }

    public function testItReturnsCorrectPaginationData(): void
    {
        $this->client->request(Request::METHOD_GET, '/api/booking');

        $response = $this->client->getResponse()->getContent();
        $data = json_decode($response, true, 512, JSON_THROW_ON_ERROR);

        AssertCorrectPaginationStructure::assert($data);
    }
}
