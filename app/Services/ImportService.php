<?php

namespace App\Services;

use App\Jobs\AfterImportJob;
use App\Jobs\ProcessLeadImport;
use App\Imports\LeadImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportService
{
    public function processUpload($file, string $fileName)
    {
        Excel::queueImport(new LeadImport($fileName), $file)->chain([
            new AfterImportJob($fileName),
        ]);
    }

    public function processFile(string $filePath, int $importLogId)
    {
        ProcessLeadImport::dispatch($filePath, $importLogId);
    }
}
