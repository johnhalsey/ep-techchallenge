<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\ClientResource;
use App\Http\Requests\StoreClientRequest;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientsController extends Controller
{
    public function index(Request $request): View
    {
        $clients = $request->user()
            ->clients()
            ->withCount(['bookings'])
            ->get();

        return view('clients.index', [
            'clients' => ClientResource::collection($clients),
        ]);
    }

    public function create(): View
    {
        return view('clients.create');
    }

    public function show(Client $client): View
    {
        return view('clients.show', [
            'client' => (new ClientResource($client->load(['bookings', 'journals'])))
        ]);
    }

    public function store(StoreClientRequest $request): JsonResource
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

        return new ClientResource($client);
    }

    public function destroy(Client $client): JsonResponse
    {
        $client->delete();

        // attempted to return a 204 here, but axios did not pick this up
        // as a successful response for DELETE

        return response()->json();
    }
}
