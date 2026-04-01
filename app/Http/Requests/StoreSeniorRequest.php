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

    protected function prepareForValidation()
    {
        if ($this->family) {

            $filtered = collect($this->family)
                ->filter(function ($member) {
                    return !empty($member['full_name']);
                })
                ->values() // reset indexes (VERY IMPORTANT)
                ->toArray();

            $this->merge([
                'family' => $filtered
            ]);
        }
    }

    public function rules(): array
    {
        return array_merge($this->baseRules(), [
            'osca_id_number' => 'required|string',
            'ncsc_registration_number' => 'nullable|string',
            'place_of_birth' => 'required|string',
            'occupation' => 'required|string',
            'pension_amount' => 'nullable|integer',
            'family' => 'nullable|array',
            'family.*.full_name' => 'required|string',
            'family.*.relationship' => 'required|string',
            'family.*.birthdate' => 'required|date',
            'family.*.occupation' => 'nullable|string',
            'family.*.civil_status' => 'nullable|string',
            'family.*.income' => 'nullable|numeric'
        ]);
    }
}
