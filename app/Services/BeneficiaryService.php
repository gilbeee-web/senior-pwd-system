<?php

namespace App\Services;

use App\Models\Beneficiary;
use App\Models\BeneficiaryAddress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BeneficiaryService{

    public function create(array $data, string $type)
    {
        

        $address = $this->createAddress($data);

        $beneficiary = $this->createBeneficiary($data, $type, $address->id);

        return $beneficiary;
        

        // return DB::transaction (function () use ($data, $type) {

        //     $address = $this->createAddress($data);

        //     $beneficiary = $this->createBeneficiary($data, $type, $address->id);

        //     return $beneficiary;
        // });
    }



    private function createAddress(array $data)
    {
        return BeneficiaryAddress::create([
            'house_num' => $data['house_num'],
            'street_id'    => $data['street_id'],
            'municipality' => $data['municipality'] ?? "General Tinio",
            'province'     => $data['province'] ?? "Nueva Ecija",
            'zip_code'     => $data['zip_code'] ?? "3104",
        ]);
    }

    private function createBeneficiary(array $data, string $type, int $addressId)
    {
        return Beneficiary::create([
            'type' => $type,
            'last_name' => $data['last_name'],
            'first_name' => $data['first_name'],
            'middle_name' => $data['middle_name'] ?? null,
            'extension' => $data['extension'] ?? null,
            'birthdate' => $data['birthdate'],
            'contact_number' => $data['contact_number'],
            'civil_status' => $data['civil_status'],
            'employment_status' => $data['employment_status'],
            'gender' => $data['gender'],
            'beneficiary_address_id' => $addressId,
            'life_status' => 'alive',
            'residence_status' => 'active',
            'created_by' => Auth::id(),
        ]);
    }


    public function update(Beneficiary $beneficiary, array $data)
    {
        return DB::transaction(function () use ($beneficiary, $data) {

            // Update Address
            $beneficiary->address->update([
                'house_num'   => $data['house_num'],
                'street_id'   => $data['street_id'],
                'municipality'=> $data['municipality'] ?? $beneficiary->address->municipality,
                'province'    => $data['province'] ?? $beneficiary->address->province,
                'zip_code'    => $data['zip_code'] ?? $beneficiary->address->zip_code,
            ]);

            // Update Beneficiary
            $beneficiary->update([
                'last_name'         => $data['last_name'],
                'first_name'        => $data['first_name'],
                'middle_name'       => $data['middle_name'] ?? null,
                'extension'         => $data['extension'] ?? null,
                'birthdate'         => $data['birthdate'],
                'contact_number'    => $data['contact_number'],
                'civil_status'      => $data['civil_status'],
                'employment_status' => $data['employment_status'],
                'gender'            => $data['gender'],
            ]);

            return $beneficiary;
        });
    }



}