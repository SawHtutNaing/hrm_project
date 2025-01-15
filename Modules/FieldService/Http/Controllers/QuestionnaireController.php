<?php

namespace Modules\FieldService\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\FieldService\Entities\Questionnaires;
use Yajra\DataTables\Facades\DataTables;

class QuestionnaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('fieldservice::questionnaire.index');
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
        try {
            DB::beginTransaction();
            Questionnaires::create([
                'name' => $request->name,
                'url' => $request->url,
            ]);
            DB::commit();

            return back()->with('success', 'Successfully Created');
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    /**
     * Show the specified resource.
     */
    public function show(Questionnaires $questionnaires)
    {
        return view('fieldservice::campaign.questionnaire', compact('questionnaires'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Questionnaires $questionnaires)
    {
        return view('fieldservice::questionnaire.edit', compact('questionnaires'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            Questionnaires::where('id', $id)->first()->update([
                'name' => $request->name,
                'url' => $request->url,
            ]);
            DB::commit();

            return back()->with('success', 'Successfully Updated');
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Questionnaires $questionnaires)
    {

        $questionnaires->delete();

        return response()->json(['success' => 'Successfully Deleted'], 200);
    }

    public function getData()
    {
        $questionnaires = Questionnaires::orderBy('id', 'DESC');

        return DataTables::of($questionnaires)
            ->addColumn('actions', function ($q) {
                $html = '';
                if (hasUpdate('questionnaire')) {
                    $html .= '<a  class="btn btn-sm btn-info py-1 edit me-2" data-href="'.route('quest.edit', $q->id).'" data-kt-table="Play">Edit</a>';
                }
                if (hasDelete('questionnaire')) {
                    $html .= '<button type="button" class="btn btn-sm btn-danger py-1" data-id="'.$q->id.'" data-kt-table="delete_row">Delete</button>';
                }

                return $html;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
}
