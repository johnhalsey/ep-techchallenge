<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use App\Http\Resources\ClientResource;

class ClientsController extends Controller
{
    public function index(Request $request)
    {
        $clients = $request->user()->clients;

        foreach ($clients as $client) {
            $client->append('bookings_count');
        }

        return view('clients.index', ['clients' => $clients]);
    }

    public function create()
    {
        return view('clients.create');
    }

    public function show($client)
    {
        $client = Client::where('id', $client)->with('bookings')->first();

        return view('clients.show', ['client' => (new ClientResource($client))->withBookings()]);
    }

    public function store(Request $request)
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

    public function destroy($client)
    {
        Client::where('id', $client)->delete();

        // attempted to return a 204 here, but axios did not pick this up
        // as a successful response for DELETE

        return response()->json();
    }
}
