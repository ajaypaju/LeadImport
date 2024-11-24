<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessLeadImport;
use App\Models\ImportLog;
use App\Models\Lead;
use Illuminate\Http\Request;
use App\Services\FileService;
use App\Services\ImportService;
use App\Services\VerificationService;

class ImportExcelController extends Controller
{

    protected $fileService;
    protected $importService;
    protected $verificationService;

    public function __construct(
        FileService $fileService,
        ImportService $importService,
        VerificationService $verificationService
    ) {
        $this->fileService = $fileService;
        $this->importService = $importService;
        $this->verificationService = $verificationService;
    }

    public function showLeads()
    {
        $leads = Lead::paginate(10);
        return view('leads.index', compact('leads'))->with('activeTab', 'leads');
    }

    public function showImport()
    {
        $importData = ImportLog::paginate(10);
        return view('leads.index', compact('importData'))->with('activeTab', 'import');
    }

    public function upload(Request $request)
    {
        $request->validate(['file' => 'required|mimes:csv,xlsx,xls']);

        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $file->storeAs('imports', $fileName, 'public');

        try {

            $this->importService->processUpload($file, $fileName);

            return redirect()->back()->with('success', 'File validated successfully and importing');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            return redirect()->back()->with('error', 'File validation failed. Check the logs for details.');
        }
    }

    public function verify(ImportLog $importLog)
    {
        $filePath = $this->fileService->getFilePath($importLog->file_name);
        if (!$this->fileService->fileExists($filePath)) {
            return redirect()->back()->with('error', 'File not found.');
        }

        $paginatedData = $this->verificationService->getPreviewData($filePath);
        return view('leads.verify', compact('paginatedData', 'importLog'));
    }

    public function processFile(ImportLog $importLog)
    {
        $filePath = $this->fileService->getFilePath($importLog->file_name);
        if (!$this->fileService->fileExists($filePath)) {
            return redirect()->back()->with('error', 'File not found.');
        }

        $importLog->update(['status' => 'Processing']);
        $this->importService->processFile($filePath, $importLog->id);

        return redirect()->back()->with('success', 'File is being processed.');
    }
}
