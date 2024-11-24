<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class FileService
{
    public function fileExists(string $path): bool
    {
        return file_exists(storage_path('app/' . $path));
    }

    public function getFilePath(string $fileName): string
    {
        return 'public/imports/' . $fileName;
    }
}
