<?php

namespace App\Services;

use App\Models\ActionRequest;
use App\Models\PwdDetail;
use App\Models\SeniorDetail;
use Exception;
use Illuminate\Notifications\Action;
use Illuminate\Support\Facades\DB;

class RequestApprovalService
{

    protected $updateSeniorService;
    protected $updatePwdService;

    public function __construct(UpdateSeniorService $updateSeniorService, UpdatePwdService $updatePwdService)
    {
        
        $this->updateSeniorService = $updateSeniorService;
        $this->updatePwdService = $updatePwdService;
    }

    public function approve(ActionRequest $request, $adminId){

        if($request->status !== 'pending'){
            throw new Exception('Request already processed.');
        }

        DB::transaction(function () use ($request, $adminId){

            //find/define the model with the id passed
            $model = $request->model;
            
            if(!$model){
                throw new Exception('Target record not found.');
            }

            switch($request->type){

                case 'update': 
                    $this->handleUpdate($model, $request->payload);
                    break;
                
                case 'archive':
                    $this->handleArchive($model);
                    break;

                case 'delete':
                    $this->handleDelete($model);
                    break;

                default:
                    throw new \Exception('Invalid request type.');

            }

            $request->update([
                'status' => 'approved',
                'approved_by' => $adminId,
                'approved_at' => now()
            ]);


        });
    }


    public function reject(ActionRequest $request, $adminId)
    {
        if ($request->status !== 'pending') {
            throw new Exception('Request already processed.');
        }

        $request->update([
            'status' => 'rejected',
            'approved_by' => $adminId,
            'approved_at' => now()
        ]);
    }

    protected function handleUpdate($model, $payload)
    {
        if (!$payload) {
            throw new Exception('No data to update.');
        }

        if ($model instanceof SeniorDetail) {
            $this->updateSeniorService->update($model, $payload);
        } 
        elseif ($model instanceof PwdDetail) {
            $this->updatePwdService->update($model, $payload);
        } 
        else {
            throw new Exception('Unsupported model type.');
        }
    }


    // protected function handleUpdate($model, $payload){

    //     if(!$payload){
    //         throw new Exception('No data to update.');
    //     }

    //     if($model->type === 'senior'){
    //         $this->updateSeniorService->update($model, $payload);
    //     }
        
    //     $model->update($payload);
    // }


    protected function handleArchive($model){

        if(!$model){
            throw new Exception('Target record not found.');
        }

        $model->delete();
                
    }

    public function handleDelete($model){

        if(!$model){
            throw new Exception('Target record not found.');
        }

        $model->forceDelete();
    }






}