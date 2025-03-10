<?php

namespace Tests\Unit;

use App\User;
use App\Client;
use App\Booking;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientTest extends TestCase
{
    use RefreshDatabase;

    public function test_user()
    {
        $user = factory(User::class)->create();

        $client = factory(Client::class)->create([
            'user_id' => $user->id
        ]);

        $this->assertEquals($user->id, $client->user->id);
    }

    public function test_booking_are_returned_in_chonological_order()
    {
        Carbon::setTestNow(now());

        $client = factory(Client::class)->create();
        for($i = 0; $i < 10; $i++) {
            factory(Booking::class)->create([
                'client_id' => $client->id,
                'created_at' => Carbon::now()->subDays($i),
            ]);
        }

        $bookings = $client->bookings;
        $this->assertEquals(Carbon::now()->subDays(9)->toDateTimeString(), $bookings[0]->created_at->toDateTimeString());
        $this->assertEquals(Carbon::now()->subDays(8)->toDateTimeString(), $bookings[1]->created_at->toDateTimeString());
        $this->assertEquals(Carbon::now()->subDays(7)->toDateTimeString(), $bookings[2]->created_at->toDateTimeString());
        $this->assertEquals(Carbon::now()->subDays(6)->toDateTimeString(), $bookings[3]->created_at->toDateTimeString());
        $this->assertEquals(Carbon::now()->subDays(5)->toDateTimeString(), $bookings[4]->created_at->toDateTimeString());
        $this->assertEquals(Carbon::now()->subDays(4)->toDateTimeString(), $bookings[5]->created_at->toDateTimeString());
        $this->assertEquals(Carbon::now()->subDays(3)->toDateTimeString(), $bookings[6]->created_at->toDateTimeString());
        $this->assertEquals(Carbon::now()->subDays(2)->toDateTimeString(), $bookings[7]->created_at->toDateTimeString());
        $this->assertEquals(Carbon::now()->subDays(1)->toDateTimeString(), $bookings[8]->created_at->toDateTimeString());
        $this->assertEquals(Carbon::now()->subDays(0)->toDateTimeString(), $bookings[9]->created_at->toDateTimeString());



    }
}
