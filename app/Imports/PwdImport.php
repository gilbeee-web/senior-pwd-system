<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Services\Imports\PwdImportService;

class PwdImport implements ToCollection, WithHeadingRow
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
}
