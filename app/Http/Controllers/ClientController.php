<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    public function index()
    {
        return inertia('Clients/Index', [
            'clients' => Client::query()
                ->when(request('search'), function ($query, $search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('document', 'like', "%{$search}%");
                    });
                })
                ->when(request('status'), function ($query, $status) {
                    $query->where('status', $status);
                })
                ->paginate(15)
                ->withQueryString(),
        ]);
    }

    public function create()
    {
        return inertia('Clients/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients',
            'phone' => 'nullable|string|max:20',
            'document' => 'required|string|unique:clients',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'status' => 'required|in:active,inactive'
        ]);

        Client::create($validated);
        return redirect()->route('clients.index')->with('success', 'Cliente creado exitosamente');
    }

    public function edit(Client $client)
    {
        return inertia('Clients/Create', [
            'client' => $client
        ]);
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('clients')->ignore($client->id)],
            'phone' => 'nullable|string|max:20',
            'document' => ['required', 'string', Rule::unique('clients')->ignore($client->id)],
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'status' => 'required|in:active,inactive'
        ]);

        $client->update($validated);
        return redirect()->route('clients.index')->with('success', 'Cliente actualizado exitosamente');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Cliente eliminado exitosamente');
    }
}
