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

        $this->json(
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

    public function test_auth_can_delete_client_journal()
    {
        $user = factory(User::class)->create();
        $client = factory(Client::class)->create([
            'user_id' => $user->id
        ]);
        $journal = factory(Journal::class)->create([
            'client_id' => $client->id,
        ]);

        $this->actingAs($user);

        $this->assertCount(1, $client->journals);

        $this->json(
            'DELETE',
            route('clients.journals.destroy', [
                'client' => $client->id,
                'journal' => $journal->id,
            ])
        )->assertStatus(200);
        $client = $client->refresh();
        $this->assertCount(0, $client->journals);
    }

    public function test_another_clients_user_cannot_delete_client()
    {
        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $client = factory(Client::class)->create([
            'user_id' => $user->id
        ]);

        $this->actingAs($user2);

        $this->json(
            'DELETE',
            route('clients.destroy', [
                'client' => $client->id,
            ])
        )->assertStatus(403);

        $this->assertDatabaseCount('clients', 1);
    }
}
