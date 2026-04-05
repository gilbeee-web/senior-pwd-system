<?php

namespace App\Exports;

use App\Services\BeneficiaryReportService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class SeniorReportExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $request;
    protected $user;
    protected $columns;

    public function __construct($request, $user)
    {
        $this->request = $request;
        $this->user = $user;
        $this->columns = $request->columns ?? [];
    }

    public function view(): View
    {
        $service = new BeneficiaryReportService();

        $data = $service->getSeniorQuery($this->request, $this->user)->get();

        return view('exports.senior_report', [
            'data' => $data,
            'columns' => $this->columns
        ]);
    }
}
