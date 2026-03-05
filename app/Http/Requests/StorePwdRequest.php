<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePwdRequest extends BaseBeneficiaryRequest
{
    // /**
    //  * Determine if the user is authorized to make this request.
    //  */
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
                'required',
                'string',
                Rule::unique('pwd_details', 'pwd_id_number')
                    ->ignore($this->route('pwd')) // ignore current model and proceed to update to avoid unique error taken id
            ],
            'disability_type' => 'required|string',
            'guardian_name' => 'required|string',
            'blood_type' => 'required|string',
            'educational_attainment' => 'required|string',
            'date_id_issued' => 'required|date'
        ]);
    }
}
