<?php

namespace Tests\Unit;

use App\User;
use App\Client;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_clients()
    {
        $user = factory(User::class)->create();

        factory(Client::class, 5)->create([
            'user_id' => $user->id
        ]);

        $user = $user->refresh();
        $this->assertEquals(5, $user->clients()->count());
    }
}
