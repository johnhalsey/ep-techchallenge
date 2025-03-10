<?php

namespace Tests\Feature;

use App\User;
use App\Client;
use App\Http\Resources\ClientResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClientsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_index_only_their_own_clients()
    {
        $user = factory(User::class)->create();
        factory(Client::class, 5)->create([
            'user_id' => $user->id
        ]);

        $user2 = factory(User::class)->create();
        factory(Client::class, 5)->create([
            'user_id' => $user2->id
        ]);

        $user3 = factory(User::class)->create();
        factory(Client::class, 5)->create([
            'user_id' => $user3->id
        ]);

        $this->actingAs($user);

        $expetecedClients = $user->clients;

        foreach ($expetecedClients as $client) {
            $client->append('bookings_count');
        }

        $this->get(route('clients.index'))
            ->assertStatus(200)
            ->assertViewIs('clients.index')
            ->assertViewHas('clients', $expetecedClients);

    }
}
