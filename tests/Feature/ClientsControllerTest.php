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

        $expetecedClients = $user->clients()
            ->with(['bookings'])
            ->withCount(['bookings'])
            ->get();

        $this->get(route('clients.index'))
            ->assertStatus(200)
            ->assertViewIs('clients.index')
            ->assertViewHas('clients', $expetecedClients);
    }

    public function test_storing_client_validation_will_fail_if_name_missing()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $this->json(
            'POST',
            '/clients',
            [
                'name' => '',
                'email' => 'john@test.com',
            ]
        )->assertStatus(422)
            ->assertJsonValidationErrors(['name'])
            ->assertJsonFragment([
                'errors' => [
                    'name' => ['The name field is required.']
                ]
            ]);

    }

    public function test_storing_client_validation_will_fail_if_name_gt_190_chars()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $this->json(
            'POST',
            '/clients',
            [
                'name' => '12345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901',
                'email' => 'john@test.com',
            ]
        )->assertStatus(422)
            ->assertJsonValidationErrors(['name'])
            ->assertJsonFragment([
                'errors' => [
                    'name' => ['The name may not be greater than 190 characters.']
                ]
            ]);
    }

    public function test_storing_client_validation_email_required_without_phone()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $this->json(
            'POST',
            '/clients',
            [
                'name' => 'Test CLient',
                'email' => '',
                'phone' => ''
            ]
        )->assertStatus(422)
            ->assertJsonValidationErrors(['phone'])
            ->assertJsonFragment([
                'errors' => [
                    'email' => ['The email field is required when phone is not present.'],
                    'phone' => ['The phone field is required when email is not present.']
                ]
            ]);

        $this->json(
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
        $this->json(
            'POST',
            '/clients',
            [
                'name' => 'Test Client',
                'email' => 'arunas@example',
                'phone' => ''
            ]
        )->assertStatus(422)
            ->assertJsonValidationErrors(['email'])
            ->assertJsonFragment([
                'errors' => [
                    'email' => ['The email format is invalid.']
                ]
            ]);

        $this->json(
            'POST',
            '/clients',
            [
                'name' => 'Test Client',
                'email' => 'john@example.com',
                'phone' => ''
            ]
        )->assertStatus(201);
    }

    public function test_storing_client_email_not_required_with_phone()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $this->json(
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
        $this->json(
            'POST',
            '/clients',
            [
                'name' => 'Test CLient',
                'email' => '',
                'phone' => '123456ABN()'
            ]
        )->assertStatus(422)
            ->assertJsonValidationErrors(['phone'])
            ->assertJsonFragment([
                'errors' => [
                    'phone' => ['The phone format is invalid.']
                ]
            ]);

        $this->json(
            'POST',
            '/clients',
            [
                'name' => 'Test Client',
                'email' => '',
                'phone' => '+44000 123456'
            ]
        )->assertStatus(201)
            ->assertJsonMissingValidationErrors(['phone']);
    }


}
