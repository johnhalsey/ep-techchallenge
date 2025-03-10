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

    public function test_storing_client_validation_will_fail_if_name_missing()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $this->call(
            'POST',
            '/clients',
            [
                'name' => ''
            ]
        )->assertStatus(302)
            ->assertSessionHasErrors(['name']);
    }

    public function test_storing_client_validation_will_fail_if_name_gt_190_chars()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $this->call(
            'POST',
            '/clients',
            [
                'name' => '12345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901'
            ]
        )->assertStatus(302)
            ->assertSessionHasErrors(['name']);
    }

    public function test_storing_client_validation_email_required_without_phone()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $this->call(
            'POST',
            '/clients',
            [
                'name' => 'Test CLient',
                'email' => '',
                'phone' => ''
            ]
        )->assertStatus(302)
            ->assertSessionHasErrors(['email']);

        $this->call(
            'POST',
            '/clients',
            [
                'name' => 'Test CLient',
                'email' => '',
                'phone' => '01234567890'
            ]
        )->assertStatus(201);
    }

    public function test_storing_client_validation_email_is_invalid()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $this->call(
            'POST',
            '/clients',
            [
                'name' => 'Test Client',
                'email' => 'arunas@example',
                'phone' => ''
            ]
        )->assertStatus(302)
            ->assertSessionHasErrors(['email']);

        $this->call(
            'POST',
            '/clients',
            [
                'name' => 'Test Client',
                'email' => 'john@example.com',
                'phone' => ''
            ]
        )->assertStatus(201);
    }

    public function test_storing_client_validation_phone_is_required_without_email()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $this->call(
            'POST',
            '/clients',
            [
                'name' => 'Test CLient',
                'email' => '',
                'phone' => ''
            ]
        )->assertStatus(302)
            ->assertSessionHasErrors(['phone']);

        $this->call(
            'POST',
            '/clients',
            [
                'name' => 'Test CLient',
                'email' => '',
                'phone' => '079666111222'
            ]
        )->assertStatus(201);
    }

    public function test_storing_client_validation_phone_is_valid()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $this->call(
            'POST',
            '/clients',
            [
                'name' => 'Test CLient',
                'email' => '',
                'phone' => '123456ABN()'
            ]
        )->assertStatus(302)
            ->assertSessionHasErrors(['phone']);

        $this->call(
            'POST',
            '/clients',
            [
                'name' => 'Test Client',
                'email' => '',
                'phone' => '+44000 123456'
            ]
        )->assertStatus(201)
            ->assertSessionMissing('phone');
    }


}
