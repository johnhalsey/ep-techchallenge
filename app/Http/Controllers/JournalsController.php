<?php

namespace App\Http\Controllers;

use App\Client;
use App\Journal;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\ClientResource;
use App\Http\Requests\StoreClientJournalRequest;

class JournalsController extends Controller
{
    public function create(Request $request, Client $client): View
    {
        return view('clients.journals.create', [
            'client' => new ClientResource($client),
        ]);
    }

    public function store(StoreClientJournalRequest $request, Client $client): JsonResponse
    {
        $client->journals()->create([
            'entry' => $request->input('entry'),
        ]);

        return response()->json('OK', 201);
    }

    public function destroy(Request $request, Client $client, Journal $journal): JsonResponse
    {
        $journal->delete();

        return response()->json();
    }
}
