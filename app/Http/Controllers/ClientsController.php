<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use App\Http\Resources\ClientResource;
use App\Http\Requests\StoreClientRequest;

class ClientsController extends Controller
{
    public function index(Request $request)
    {
        $clients = $request->user()
            ->clients()
            ->withCount(['bookings'])
            ->get();

        return view('clients.index', [
            'clients' => ClientResource::collection($clients),
        ]);
    }

    public function create()
    {
        return view('clients.create');
    }

    public function show(Client $client)
    {
        return view('clients.show', [
            'client' => (new ClientResource($client))
                ->withBookings()
                ->withJournals()
        ]);
    }

    public function store(StoreClientRequest $request)
    {
        $client = new Client;
        $client->user_id = $request->user()->id;
        $client->name = $request->get('name');
        $client->email = $request->get('email');
        $client->phone = $request->get('phone');
        $client->address = $request->get('address');
        $client->city = $request->get('city');
        $client->postcode = $request->get('postcode');
        $client->save();

        return $client;
    }

    public function destroy(Client $client)
    {
        $client->delete();

        // attempted to return a 204 here, but axios did not pick this up
        // as a successful response for DELETE

        return response()->json();
    }
}
