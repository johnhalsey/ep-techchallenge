<?php

namespace Tests\Feature;

use App\User;
use App\Client;
use App\Journal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class JournalsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_journal_for_client()
    {
        $user = factory(User::class)->create();
        $client = factory(Client::class)->create([
            'user_id' => $user->id
        ]);
        $this->actingAs($user);

        $this->assertDatabaseCount('journals', 0);

        $response = $this->json(
            'POST',
            route('clients.journals.store', [
                'client' => $client->id,
            ]),
            [
                'entry' => 'I am a new journal entry',
            ]
        )->assertStatus(201);

        $this->assertDatabaseCount('journals', 1);
        $this->assertCount(1, $client->journals);
    }

    public function test_cannot_store_journal_without_entry()
    {
        $user = factory(User::class)->create();
        $client = factory(Client::class)->create([
            'user_id' => $user->id
        ]);
        $this->actingAs($user);

        $this->assertDatabaseCount('journals', 0);

        $response = $this->json(
            'POST',
            route('clients.journals.store', [
                'client' => $client->id,
            ]),
            [
                'entry' => '',
            ]
        )->assertStatus(422)
            ->assertJsonValidationErrors('entry')
            ->assertJsonFragment([
                'errors' => [
                    'entry' => ['The entry field is required.']
                ]
            ]);
    }
}
