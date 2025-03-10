<?php

namespace App\Policies;

use App\User;
use App\Client;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
{
    use HandlesAuthorization;

    public function manage(User $user, Client $client): bool
    {
        return $client->user_id === $user->id;
    }
}
