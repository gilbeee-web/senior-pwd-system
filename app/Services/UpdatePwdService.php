<?php 

namespace App\Services;
use Exception;
use Illuminate\Notifications\Action;
use Illuminate\Support\Facades\DB;

class UpdatePwdService{

    public function update($pwd, $payload)
    {
        if (!$payload) {
            throw new Exception('No data to update.');
        }

        DB::transaction(function () use ($pwd, $payload) {

            // Beneficiary
            if (isset($payload['beneficiary'])) {
                $pwd->beneficiary->update($payload['beneficiary']);
            }

            // Address
            if (isset($payload['beneficiary_address'])) {
                $pwd->beneficiary->address->update($payload['beneficiary_address']);
            }

            // pwd details
            if (isset($payload['pwd'])) {
                $pwd->update($payload['pwd']);
            }

        });
    }

}