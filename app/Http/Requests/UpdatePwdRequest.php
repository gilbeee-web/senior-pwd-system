<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePwdRequest extends BaseBeneficiaryRequest
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
            'pwd_id_number' => [
                'sometimes',
                'string',
                Rule::unique('pwd_details', 'pwd_id_number')
                    ->ignore($this->route('pwd')) // ignore current model and proceed to update to avoid unique error taken id
            ],
            'disability_type' => 'sometimes|string',
            'guardian_name' => 'sometimes|string',
            'blood_type' => 'sometimes|string',
            'educational_attainment' => 'sometimes|string',
            'date_id_issued' => 'sometimes|string'
        ]);
    }
}
