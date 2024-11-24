<?php

namespace App\Imports;

use App\Models\ImportLog;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;

class LeadImport implements ToCollection, WithValidation, WithHeadingRow, ShouldQueue, WithChunkReading, SkipsOnFailure
{
    use Importable;

    protected $fileName;
    protected $emailsInFile = [];
    protected $totalRows = 0;
    protected $chunkSize;
    protected static $failureLogged = false;

    public function __construct($fileName)
    {
        $this->fileName = $fileName;
    }

    public function collection(Collection $rows)
    {
        $this->totalRows += $rows->count();
    }

    public function rules(): array
    {
        return [
            'first_name'   => 'required|string|max:255',
            'last_name'    => 'nullable|string|max:255',
            'email'        => [
                'required',
                'email',
                Rule::unique('leads', 'email'),
                function ($attribute, $value, $fail) {
                    if (in_array($value, $this->emailsInFile)) {
                        $fail('The email ' . $value . ' is duplicated in the file.');
                    }
                    $this->emailsInFile[] = $value;
                },
            ],
            'mobile_number'=> 'required|numeric',
            'street_1'     => 'nullable|string|max:255',
            'street_2'     => 'nullable|string|max:255',
            'city'         => 'nullable|string|max:255',
            'state'        => 'nullable|string|max:255',
            'country'      => 'nullable|string|max:255',
            'lead_source'  => 'nullable|string|max:255',
            'status'       => 'nullable|string',
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'first_name.required'   => 'The first name is required.',
            'email.required'        => 'The email field is required.',
            'email.email'           => 'The email must be a valid email address.',
            'mobile_number.required'=> 'The mobile number is required.',
            'mobile_number.numeric' => 'The mobile number must be numeric.',
        ];
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public function onFailure(Failure ...$failures)
    {
        if (self::$failureLogged) {
            return;
        }

        $errorMessages = [];

        foreach ($failures as $failure) {
            $errorMessages[] = "Row {$failure->row()}: " . implode(', ', $failure->errors());
        }

        ImportLog::updateOrCreate(
            ['file_name' => $this->fileName],
            [
                'status' => 'Failure',
                'error_message' => implode('; ', $errorMessages),
            ]
        );

        self::$failureLogged = true;
    }

}
