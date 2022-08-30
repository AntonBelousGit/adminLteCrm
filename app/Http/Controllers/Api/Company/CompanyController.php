<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Company\CompanyIndexRequest;
use App\Http\Requests\Api\Company\SingleCompanyRequest;
use App\Http\Resources\Company\AllCompaniesResource;
use App\Http\Resources\Company\SingleCompanyResource;
use App\Services\Api\Company\ApiCompanyService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(CompanyIndexRequest $request, ApiCompanyService $apiCompanyService)
    {
        $paginate = [
            'pagination' => $request->input('pagination', 1000),
            'page' => $request->input('page', 1),
        ];

        return AllCompaniesResource::collection($apiCompanyService->getCompaniesPaginationResult($paginate));
    }

    /**
     * @param SingleCompanyRequest $request
     * @param ApiCompanyService $apiCompanyService
     * @return SingleCompanyResource
     */
    public function companyClients(SingleCompanyRequest $request, ApiCompanyService $apiCompanyService)
    {
        $company_id = $request->input('company_id');
        $paginate = [
            'pagination' => $request->input('pagination', 5),
            'page' => $request->input('page', 1),
        ];
        return new SingleCompanyResource($apiCompanyService->getSingleCompanyWithPaginationClientResult($company_id,$paginate));
    }
}
