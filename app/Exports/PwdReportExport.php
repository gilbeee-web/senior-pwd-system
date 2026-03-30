<?php

namespace App\Exports;

use App\Services\BeneficiaryReportService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class PwdReportExport implements FromView
{
   
    protected $request;
    protected $user;

    public function __construct($request, $user)
    {
        $this->request = $request;
        $this->user = $user;
    }

    public function view(): View
    {
        $service = new BeneficiaryReportService();

        $data = $service->getPwdQuery($this->request, $this->user)->get();

        return view('exports.pwd_report', [
            'data' => $data
        ]);
    }
}
