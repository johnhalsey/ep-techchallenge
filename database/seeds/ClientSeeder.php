<?php

use App\User;
use App\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // delete any existing seeded users
        Client::query()->delete();
        User::query()->delete();

        for ($i = 0; $i < 15; $i++) {
            $user = factory(User::class)->create([
                'email'    => 'user' . $i . '@example.com',
                'password' => bcrypt('secret'),
            ]);

            factory(Client::class, 10)->create([
                'user_id' => $user->id,
            ]);
        }
    }
}
