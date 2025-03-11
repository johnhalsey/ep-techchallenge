<?php

use App\Client;
use App\Journal;
use Illuminate\Database\Seeder;

class JournalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Client::each(function ($client) {
            factory(Journal::class, 5)->create([
                'client_id' => $client->id
            ]);
        });
    }
}
