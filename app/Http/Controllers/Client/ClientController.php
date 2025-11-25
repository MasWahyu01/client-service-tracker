<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Models\Client;
use App\Services\ClientService;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct(
        protected ClientService $clientService
    ) {
        // Nanti disini bisa tambah middleware auth & policy.
        // $this->middleware('auth');
    }

    /**
     * Display a listing of the clients.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['q', 'status', 'segment']);

        $clients = $this->clientService->paginateClients($filters, 10);

        return view('clients.index', [
            'clients' => $clients,
            'filters' => $filters,
        ]);
    }

    /**
     * Show the form for creating a new client.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created client in storage.
     */
    public function store(StoreClientRequest $request)
    {
        $client = $this->clientService->createClient($request->validated());

        return redirect()
            ->route('clients.show', $client)
            ->with('success', 'Client created successfully.');
    }

    /**
     * Display the specified client.
     */
    public function show(Client $client)
    {
        // Nanti bisa kita load relationships: services & interaction logs
        $client->load([
            'services',
            'interactionLogs' => function ($q) {
                $q->latest();
            },
        ]);

        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified client.
     */
    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified client in storage.
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        $this->clientService->updateClient($client, $request->validated());

        return redirect()
            ->route('clients.show', $client)
            ->with('success', 'Client updated successfully.');
    }

    /**
     * Remove the specified client from storage.
     */
    public function destroy(Client $client)
    {
        $this->clientService->deleteClient($client);

        return redirect()
            ->route('clients.index')
            ->with('success', 'Client deleted successfully.');
    }
}
