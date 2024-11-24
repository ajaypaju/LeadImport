<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\ImportLog;

class AfterImportJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    protected $fileName;

    /**
     * Create a new job instance.
     */
    public function __construct($fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        ImportLog::firstOrCreate(
            ['file_name' => $this->fileName],
            [
                'status' => 'Ready to import',
                'error_message' => null,
            ]
        );
    }
}
