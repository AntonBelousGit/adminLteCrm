<?php

namespace App\Http\Resources\Company;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;

class SingleCompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'   => $this->id,
            'company_name' => $this->company_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'web' => $this->site,
            'clients' => new ClientCompanyCollection(
                new LengthAwarePaginator(
                    $this->whenLoaded('clients')->forPage($this->extra->page, $this->extra->pagination),
                    $this->clients_count,
                    $this->extra->pagination,
                    $this->extra->page
                )
            ),
        ];
    }
}
