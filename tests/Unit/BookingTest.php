<?php

namespace Tests\Unit;

use App\Client;
use App\Booking;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_time_slot_attribute()
    {
        Carbon::setTestNow(Carbon::now());

        $client = factory(Client::class)->create();

        $start = Carbon::now()->addHours(2);
        $end = Carbon::now()->addHours(3);

        $booking = factory(Booking::class)->create([
            'client_id' => $client->id,
            'start' => $start,
            'end' => $end,
        ]);

        $this->assertEquals(Carbon::parse($start)->format('l j F Y H:i') . ' to ' . Carbon::parse($end)->format('H:i'), $booking->time_slot);
    }
}
