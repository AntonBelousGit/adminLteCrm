<?php

declare(strict_types=1);

namespace App\Services\Company;


use App\Http\Requests\Company\StoreCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Models\Company;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class CompanyService
{
    /**
     * @return Paginator
     */
    public function index(): Paginator
    {
        return DB::table('companies')->orderByDesc('id')->simplePaginate(10);
    }

    /**
     * @param StoreCompanyRequest $storeCompanyRequest
     * @return Company|null
     */
    public function store(StoreCompanyRequest $storeCompanyRequest): ?Company
    {
        $company = Company::create($storeCompanyRequest->except('client_id'));
        $this->attachClient($company, $storeCompanyRequest->only('client_id'));

        return $company;
    }

    /**
     * @param UpdateCompanyRequest $updateCompanyRequest
     * @param Company $company
     * @return Company|null
     */
    public function update(UpdateCompanyRequest $updateCompanyRequest, Company $company): ?Company
    {
        $company->update($updateCompanyRequest->except('client_id'));
        $this->syncClient($company, $updateCompanyRequest->only('client_id'));

        return $company;
    }

    /**
     * @param Company $company
     * @return bool
     */
    public function delete(Company $company): bool
    {
        return $company->delete();
    }

    /**
     * Get all prepare Companies
     * @return Collection
     */
    public function getAllCompanies(): Collection
    {
        return DB::table('companies')->select('id', 'company_name')->get();
    }

    /**
     * @param Company $company
     * @return array
     */
    public function loadClientCompanyId(Company $company): array
    {
        $company->load('clients');

        return Arr::pluck($company->clients, 'id') ?? [];
    }
    /**
     * @param Company $company
     * @param array $clientID
     * @return void
     */
    private function attachClient(Company $company, array $clientID): void
    {
        try {
            $company->clients()->attach($clientID['client_id']);
        } catch (Throwable) {
            Log::info('New company (id:' . $company->id . ',name:' . $company->company_name . ') - attach client problem');
        }
    }

    /**
     * @param Company $company
     * @param array $clientID
     * @return void
     */
    private function syncClient(Company $company, array $clientID): void
    {
        try {
            $company->clients()->sync($clientID['client_id']);
        } catch (Throwable) {
            Log::info('Company (id:' . $company->id . ',name:' . $company->company_name . ') - sync client problem');
        }
    }

}
