<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PreviewLeadImport implements ToCollection, WithHeadingRow
{
    public $data;

    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        $this->data = $rows;
    }
}
