<?php

declare(strict_types=1);

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
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
            'company_name'  => 'required|max:100|unique:companies,company_name',
            'email' => 'required|email',
            'phone' => 'required|string',
            'site' => 'required|string',
            'client_id' => 'nullable|array',
            'client_id.*' => 'nullable|string',
        ];
    }
}
