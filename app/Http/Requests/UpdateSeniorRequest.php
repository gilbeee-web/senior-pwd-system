<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSeniorRequest extends StoreSeniorRequest
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
        return array_merge($this->baseRules(), [
            'osca_id_number' => [
                'required',
                'string',
                Rule::unique('senior_details', 'osca_id_number')->ignore($this->route('senior'))
            ],
            'ncsc_registration_number' => 'nullable|string',
            'place_of_birth' => 'sometimes|string',
            'occupation' => 'sometimes|string',
            'pension_amount' => 'nullable|integer',

            'family' => 'nullable|array',
            'family.*.id' => 'nullable|integer|exists:senior_family_members,id',

            'family.*.action' => 'nullable|string|in:create,update,delete',

            'family.*.full_name' => 'required|string',
            'family.*.relationship' => 'required|string',
            'family.*.birthdate' => 'required|date',
            'family.*.occupation' => 'nullable|string',
            'family.*.civil_status' => 'nullable|string',
            'family.*.income' => 'nullable|numeric'
        ]);
    }
}
