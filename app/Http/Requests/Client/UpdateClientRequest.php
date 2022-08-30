<?php

declare(strict_types=1);

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'client_name'  => 'required|max:100|unique:clients,client_name,' . $this->client->id,
            'email' => 'required|email',
            'site' => 'required|string',
            'company_id' => 'required|array|min:1',
            'company_id.*' => 'required|string',
        ];
    }
}
