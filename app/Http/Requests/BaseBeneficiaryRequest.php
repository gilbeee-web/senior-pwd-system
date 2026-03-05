<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseBeneficiaryRequest extends FormRequest
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
    public function baseRules(): array
    {
        return [
            //name and info -- benificaries table
            'last_name'   => 'required|string|max:255',
            'first_name'  => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'birthdate'   => 'required|date|before:today',
            'contact_number' => 'required|string|max:12',
            'civil_status' => 'required|string|max:255',
            'employment_status' => 'required|string|max:255',
            'gender' => 'required|string|max:255', 

            //beneficiary address
            'house_num' => 'required|string|max:10',
            'street_id'    => 'required|exists:streets,id',
            'municipality' => 'nullable|string|max:255',
            'province'     => 'nullable|string|max:255',
            'zip_code'     => 'nullable|string|max:10',


        ];
    }
}
