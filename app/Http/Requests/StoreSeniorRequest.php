<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSeniorRequest extends BaseBeneficiaryRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'osca_id_number' => 'required|string',
            'ncsc_registration_number' => 'nullable|string',
            'place_of_birth' => 'required|string',
            'occupation' => 'required|string',
            'other_skills' => 'nullable|string',
            'pension_amount' => 'nullable|integer',
            'living_reason' => 'required|string'
        ];
    }
}
