<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\StoreCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Models\Company;
use App\Services\Client\ClientService;
use App\Services\Company\CompanyService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(CompanyService $companyService)
    {
        $companies = $companyService->index();
        return view('adminlte::companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param ClientService $clientService
     * @return View
     */
    public function create(ClientService $clientService): View
    {
        $clients = $clientService->getAllClient();
        return view('adminlte::companies.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCompanyRequest $storeCompanyRequest
     * @param CompanyService $companyService
     * @return RedirectResponse
     */
    public function store(StoreCompanyRequest $storeCompanyRequest, CompanyService $companyService): RedirectResponse
    {
        $company = $companyService->store($storeCompanyRequest);

        if ($company) {
            return redirect()->route('company.index')->with('success', 'Nice! Company created');
        }

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Company $company
     * @param CompanyService $companyService
     * @param ClientService $clientService
     * @return View
     */
    public function edit(Company $company, CompanyService $companyService, ClientService $clientService): View
    {
        $loadCompanyClientId = $companyService->loadClientCompanyId($company);
        $clients = $clientService->getAllClient();
        return view('adminlte::companies.edit', compact('company', 'clients', 'loadCompanyClientId'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCompanyRequest $updateCompanyRequest
     * @param Company $company
     * @param CompanyService $companyService
     * @return RedirectResponse
     */
    public function update(UpdateCompanyRequest $updateCompanyRequest, Company $company, CompanyService $companyService): RedirectResponse
    {
        $company = $companyService->update($updateCompanyRequest, $company);

        if ($company) {
            return redirect()->route('company.index')->with('success', 'Nice! Client updated');
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Company $company
     * @param CompanyService $companyService
     * @return RedirectResponse
     */
    public function destroy(Company $company, CompanyService $companyService): RedirectResponse
    {
        if ($companyService->delete($company)) {
            return redirect()->route('client.index')->with('success', 'Nice! Company deleted');
        }

        return back();
    }
}
