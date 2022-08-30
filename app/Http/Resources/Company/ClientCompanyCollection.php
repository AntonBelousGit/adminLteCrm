<?php

namespace App\Http\Resources\Company;

use App\Http\Resources\PaginatedCollection;
use Illuminate\Http\Request;

class ClientCompanyCollection extends PaginatedCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            // Here we transform any item in paginated items to a resource

            'data' => $this->collection->transform(function ($client) {
                return new ClientCompanyResource($client);
            }),

            'pagination' => $this->pagination,
        ];
    }
}
