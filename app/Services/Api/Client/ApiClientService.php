<?php

declare(strict_types=1);

namespace App\Services\Api\Client;

use App\Models\Client;
use Illuminate\Database\Eloquent\Builder;

class ApiClientService
{
    /**
     * @param int $client_id
     * @return Client
     */
    public function getClientWithCompanyResult(int $client_id): Client
    {
        return $this->getClientBuilder()->with('companies')->find($client_id);
    }

    /**
     * @return Builder
     */
    private function getClientBuilder(): Builder
    {
        return Client::query();
    }
}
