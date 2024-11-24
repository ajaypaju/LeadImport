<?php

namespace App\Jobs;

use App\Models\ImportLog;
use App\Models\Lead;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ProcessLeadImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $filePath;
    public $importLogId;

    /**
     * Create a new job instance.
     */
    public function __construct($filePath, $importLogId)
    {
        $this->filePath = $filePath;
        $this->importLogId = $importLogId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Excel::import(new class implements \Maatwebsite\Excel\Concerns\ToModel, \Maatwebsite\Excel\Concerns\WithChunkReading, \Maatwebsite\Excel\Concerns\WithHeadingRow {
                public function model(array $row)
                {
                    return new Lead([
                        'first_name' => $row['first_name'],
                        'last_name' => $row['last_name'],
                        'email' => $row['email'],
                        'mobile_number' => $row['mobile_number'],
                        'street_1' => $row['street_1'],
                        'street_2' => $row['street_2'] ?? null,
                        'city' => $row['city'],
                        'state' => $row['state'],
                        'country' => $row['country'],
                        'lead_source' => $row['lead_source'],
                        'status' => $row['status'],
                    ]);
                }

                public function chunkSize(): int
                {
                    return 500;
                }
            }, storage_path('app/' . $this->filePath));

            ImportLog::find($this->importLogId)->update(['status' => 'Success']);
        } catch (\Exception $e) {
            Log::error('Import failed: ' . $e->getMessage());
            ImportLog::find($this->importLogId)->update([
                'status' => 'Failure',
                'error_message' => $e->getMessage(),
            ]);
        }
    }
}
