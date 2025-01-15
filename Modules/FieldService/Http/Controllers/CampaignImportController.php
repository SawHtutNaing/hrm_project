<?php

namespace Modules\FieldService\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Modules\FieldService\Imports\CampaignImport;

class CampaignImportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('fieldservice::campaign.import.Import');
    }

    public function download()
    {
        $path = public_path('Excel/Import_Campaign_Template.xlsx');
        if (! file_exists($path)) {
            abort(404);
        }
        $headers = [
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="Import_Campaign_Template.xlsx"',
        ];

        return response()->download($path, 'Campaign_Template_To_Import.xlsx', $headers);
    }

    public function import(Request $request)
    {
        try {

            request()->validate([
                'importCampaign' => 'required|mimes:xlx,xls,xlsx,csv|max:2048',
            ], [
                'importCampaign' => 'Import file is required!',
            ]);
            $file = $request->file('importCampaign');
            $import = new CampaignImport;
            Excel::import($import, $file);

            return back()->with('success', 'Successfylly Imported');
        } catch (\Throwable $th) {
            // DB::rollBack();

            $failures = null;
            if ($th instanceof \Illuminate\Validation\ValidationException) {
                $failures = $th->failures();
            }
            $error = ['error-swal' => $th->getMessage(), 'failures' => $failures];

            return back()->with($error);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('fieldservice::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('fieldservice::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('fieldservice::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
