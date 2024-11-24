<?php

namespace App\Services;

use App\Imports\PreviewLeadImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Pagination\LengthAwarePaginator;

class VerificationService
{
    public function getPreviewData(string $filePath, int $perPage = 10)
    {
        $previewData = Excel::toCollection(new PreviewLeadImport, storage_path('app/' . $filePath));
        $currentPage = request()->get('page', 1);

        return new LengthAwarePaginator(
            $previewData[0]->forPage($currentPage, $perPage),
            $previewData[0]->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }
}
