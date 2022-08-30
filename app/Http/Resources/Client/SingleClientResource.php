<?php

namespace App\Http\Resources\Client;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SingleClientResource extends JsonResource
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
            'client_name' => $this->client_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'web' => $this->site,
            'companies' => CompanyClientResource::collection($this->whenLoaded('companies')),
        ];
    }
}
