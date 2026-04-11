<?php

namespace App\Services;

use App\Http\Requests\UpdateSeniorRequest;
use App\Models\ActionRequest;
use App\Models\SeniorDetail;
use Exception;
use Illuminate\Notifications\Action;
use Illuminate\Support\Facades\DB;

class UpdateSeniorService
{
    public function update($senior, $payload)
    {
        if (!$payload) {
            throw new Exception('No data to update.');
        }

        DB::transaction(function () use ($senior, $payload) {

            // Beneficiary
            if (isset($payload['beneficiary'])) {
                $senior->beneficiary->update($payload['beneficiary']);
            }

            // Address
            if (isset($payload['beneficiary_address'])) {
                $senior->beneficiary->address->update($payload['beneficiary_address']);
            }

            // Senior
            if (isset($payload['senior'])) {
                $senior->update($payload['senior']);
            }

            // Family
            if (isset($payload['family'])) {
                $this->syncFamilyMembers($payload['family'], $senior);
            }

        });
    }

    protected function syncFamilyMembers($family, $senior)
    {
        $existingIds = collect($family)->pluck('id')->filter();

        // Delete removed members
        $senior->familyMembers()
            ->whereNotIn('id', $existingIds)
            ->delete();

        foreach ($family as $member) {
            if (isset($member['id'])) {
                // Update existing
                $senior->familyMembers()
                    ->where('id', $member['id'])
                    ->update($member);
            } else {
                // Create new
                $senior->familyMembers()->create($member);
            }
        }
    }


    //  private function syncFamilyMembers(array $family, SeniorDetail $senior)
    // {
    //     // Get existing IDs from DB
    //     $existingIds = $senior->familyMembers()->pluck('id')->toArray();

    //     // Get incoming IDs from form
    //     $incomingIds = collect($family)
    //         ->pluck('id')
    //         ->filter()
    //         ->toArray();

    //     // DELETE removed members
    //     $idsToDelete = array_diff($existingIds, $incomingIds);

    //     if (!empty($idsToDelete)) {
    //         $senior->familyMembers()->whereIn('id', $idsToDelete)->delete();
    //     }

    //     foreach ($family as $member) {

    //         //check if the id is existing then update
    //         if (isset($member['id'])) {
    //             $senior->familyMembers()
    //                 ->where('id', $member['id'])
    //                 ->update([
    //                     'full_name' => $member['full_name'],
    //                     'relationship' => $member['relationship'],
    //                     'birthdate' => $member['birthdate'],
    //                     'occupation' => $member['occupation'] ?? null,
    //                     'civil_status' => $member['civil_status'] ?? null,
    //                     'income' => $member['income'] ?? 0,
    //                 ]);
    //         } else {
    //             // CREATE new if id is not existed
    //             $senior->familyMembers()->create([
    //                 'full_name' => $member['full_name'],
    //                 'relationship' => $member['relationship'],
    //                 'birthdate' => $member['birthdate'],
    //                 'occupation' => $member['occupation'] ?? null,
    //                 'civil_status' => $member['civil_status'] ?? null,
    //                 'income' => $member['income'] ?? 0,
    //             ]);
    //         }
    //     }
    // }

}