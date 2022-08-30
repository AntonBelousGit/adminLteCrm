<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Client\SingleClientRequest;
use App\Http\Resources\Client\SingleClientResource;
use App\Services\Api\Client\ApiClientService;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return SingleClientResource
     */
    public function clientCompanies(SingleClientRequest $singleClientRequest, ApiClientService $apiClientService)
    {
        $client_id = $singleClientRequest->input('client_id');
        return new SingleClientResource($apiClientService->getClientWithCompanyResult($client_id));
    }

}
