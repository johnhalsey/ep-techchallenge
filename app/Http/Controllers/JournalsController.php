<?php

namespace App\Http\Controllers;

use App\Client;
use App\Journal;
use Illuminate\Http\Request;
use App\Http\Resources\ClientResource;
use App\Http\Requests\StoreClientJournalRequest;

class JournalsController extends Controller
{
    public function create(Request $request, Client $client)
    {
        return view('clients.journals.create', [
            'client' => new ClientResource($client),
        ]);
    }

    public function store(StoreClientJournalRequest $request, Client $client)
    {
        $client->journals()->create([
            'entry' => $request->input('entry'),
        ]);

        return response()->json('OK', 201);
    }

    public function destroy(Request $request, Client $client, Journal $journal)
    {
        $journal->delete();

        return response()->json();
    }
}
