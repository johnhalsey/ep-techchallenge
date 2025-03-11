<?php

namespace Tests\Unit\Resources;

use App\Client;
use App\Booking;
use Carbon\Carbon;
use Tests\TestCase;
use App\Http\Resources\BookingResource;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookingResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_booking_hasEnded()
    {
        $client = factory(Client::class)->create();
        $booking = factory(Booking::class)->create([
            'client_id' => $client->id,
            'start' => Carbon::now()->subDays(2),
            'end' => Carbon::now()->subDays(2)->addHour(),
        ]);

        $resource = new BookingResource($booking);
        $array = $resource->toArray(request());
        $this->assertEquals(Booking::PAST, $array['state']);

        $booking = factory(Booking::class)->create([
            'client_id' => $client->id,
            'start' => Carbon::now()->subDays(2),
            'end' => Carbon::now()->addHour(),
        ]);

        $resource = new BookingResource($booking);
        $array = $resource->toArray(request());
        $this->assertEquals(Booking::FUTURE, $array['state']);

    }
}
