<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Models\Client;
use App\Services\Client\ClientService;
use App\Services\Company\CompanyService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ClientService $clientService
     * @return View
     */
    public function index(ClientService $clientService): View
    {
        $clients = $clientService->index();
        return view('adminlte::client.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param CompanyService $companyService
     * @return View
     */
    public function create(CompanyService $companyService): View
    {
        $companies = $companyService->getAllCompanies();
        return view('adminlte::client.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreClientRequest $storeClientRequest
     * @param ClientService $clientService
     * @return RedirectResponse
     */
    public function store(StoreClientRequest $storeClientRequest, ClientService $clientService): RedirectResponse
    {
        $client = $clientService->store($storeClientRequest);

        if ($client) {
            return redirect()->route('client.index')->with('success', 'Nice! Client created');
        }

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Client $client
     * @param CompanyService $companyService
     * @param ClientService $clientService
     * @return View
     */
    public function edit(Client $client, CompanyService $companyService, ClientService $clientService): View
    {
        $loadClientCompanyId = $clientService->loadClientCompanyId($client);
        $companies = $companyService->getAllCompanies();
        return view('adminlte::client.edit', compact('companies', 'client', 'loadClientCompanyId'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateClientRequest $updateClientRequest
     * @param Client $client
     * @param ClientService $clientService
     * @return RedirectResponse
     */
    public function update(UpdateClientRequest $updateClientRequest, Client $client, ClientService $clientService): RedirectResponse
    {
        $client = $clientService->update($updateClientRequest, $client);

        if ($client) {
            return redirect()->route('client.index')->with('success', 'Nice! Client updated');
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Client $client
     * @param ClientService $clientService
     * @return RedirectResponse
     */
    public function destroy(Client $client, ClientService $clientService): RedirectResponse
    {
        if ($clientService->delete($client)) {
            return redirect()->route('client.index')->with('success', 'Nice! Client deleted');
        }

        return back();
    }
}
