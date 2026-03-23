<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Services\Imports\PwdImportService;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class PwdImport implements ToCollection, WithHeadingRow, WithCalculatedFormulas
{
    /**
    * @param Collection $collection
    */

    protected $importService;

    public function __construct()
    {
        $this->importService = app(PwdImportService::class);
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
