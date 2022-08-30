<?php

declare(strict_types=1);

namespace App\Services\Client;

use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Models\Client;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class ClientService
{
    /**
     * @return Paginator
     */
    public function index(): Paginator
    {
        return DB::table('clients')->orderByDesc('id')->simplePaginate(10);
    }

    /**
     * @param StoreClientRequest $storeClientRequest
     * @return Client|null
     */
    public function store(StoreClientRequest $storeClientRequest): ?Client
    {
        $client = Client::create($storeClientRequest->except('company_id'));
        $this->attachCompanies($client, $storeClientRequest->only('company_id'));

        return $client;
    }

    /**
     * @param UpdateClientRequest $updateClientRequest
     * @param Client $client
     * @return Client|null
     */
    public function update(UpdateClientRequest $updateClientRequest, Client $client): ?Client
    {
        $client->update($updateClientRequest->except('company_id'));
        $this->syncCompanies($client, $updateClientRequest->only('company_id'));

        return $client;
    }

    /**
     * @param Client $client
     * @return array
     */
    public function loadClientCompanyId(Client $client): array
    {
        $client->load('companies');

        return Arr::pluck($client->companies, 'id');
    }

    /**
     * @param Client $client
     * @return bool
     */
    public function delete(Client $client): bool
    {
        return $client->delete();
    }

    /**
     * * Get all prepare Clients
     * @return Collection
     */
    public function getAllClient(): Collection
    {
        return DB::table('clients')->select('id', 'client_name')->get();
    }

    /**
     * @param Client $client
     * @param array $companiesID
     *
     * @return void
     */
    private function attachCompanies(Client $client, array $companiesID): void
    {
        try {
            $client->companies()->attach($companiesID['company_id']);
        } catch (Throwable) {
            Log::info('New client (id:' . $client->id . ',name:' . $client->client_name . ') - attach companies problem');
        }
    }

    /**
     * @param Client $client
     * @param array $companiesID
     *
     * @return void
     */
    private function syncCompanies(Client $client, array $companiesID): void
    {
        try {
            $client->companies()->sync($companiesID['company_id']);
        } catch (Throwable) {
            Log::info('Client (id:' . $client->id . ',name:' . $client->client_name . ') - sync companies problem');
        }
    }
}
