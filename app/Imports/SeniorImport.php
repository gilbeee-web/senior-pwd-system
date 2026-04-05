<?php

namespace App\Imports;

use App\Models\SeniorDetail;
use App\Services\Imports\SeniorImportService;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SeniorImport implements ToCollection, WithHeadingRow, WithCalculatedFormulas
{
    /**
    * @param Collection $collection
    */

    protected $importService;

    public function __construct()
    {
        $this->importService = app(SeniorImportService::class);
    }

    public function collection(Collection $rows)
    {
        //
        foreach ($rows as $row) {

            $this->importService->handle($row);

        }
    }

    public function getReport()
    {
        return [
            'imported' => $this->importService->imported,
            'skipped' => $this->importService->skipped,
            'invalid_barangay' => $this->importService->invalid_barangay,
            'duplicate_ids' => $this->importService->duplicate_ids,
        ];
    }
}
