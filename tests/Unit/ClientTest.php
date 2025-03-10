<?php

namespace Tests\Unit;

use App\User;
use App\Client;
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
}
