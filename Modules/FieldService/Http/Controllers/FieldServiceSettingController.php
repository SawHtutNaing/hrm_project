<?php

namespace Modules\FieldService\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\FieldService\Entities\FsSettings;

class FieldServiceSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fsSettings = FsSettings::whereIn('key', ['isUseCart', 'selectUom', 'selectPkg', 'enableBackDate', 'focCategoryId', 'activity_pos_layout'])
            ->get()->toArray();
        $categories = Category::select('id', 'name')->get();
        $isUseCart = 'false';
        $selectUom = 'true';
        $selectPkg = 'false';
        $enableBackDate = 'false';
        $focCategoryId = null;
        $activity_pos_layout = 'default';
        foreach ($fsSettings as $setting) {
            $value = $setting['value'] == 0 ? 'false' : 'true';
            if ($setting['key'] == 'isUseCart') {
                $isUseCart = $value;
            } elseif ($setting['key'] == 'selectUom') {
                $selectUom = $value;
            } elseif ($setting['key'] == 'selectPkg') {
                $selectPkg = $value;
            } elseif ($setting['key'] == 'enableBackDate') {
                $enableBackDate = $value;
            } elseif ($setting['key'] == 'focCategoryId') {
                $focCategoryId = $setting['value'];
            } elseif ($setting['key'] == 'activity_pos_layout') {
                $activity_pos_layout = $setting['value'];
            }
        }

        // dd($isUseCart,$selectPkg,$selectUom);
        return view('fieldservice::settings.index', compact('isUseCart', 'selectUom', 'selectPkg', 'enableBackDate', 'categories', 'focCategoryId', 'activity_pos_layout'));
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
    public function store(Request $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $datas = $request->except('_token');
            $isUseCart = isset($datas['isUseCart']) ? $datas['isUseCart'] : false;
            $selectUom = isset($datas['selectUom']) ? $datas['selectUom'] : false;
            $selectPkg = isset($datas['selectPkg']) ? $datas['selectPkg'] : false;
            $enableBackDate = isset($datas['enableBackDate']) ? $datas['enableBackDate'] : false;
            $focCategoryId = isset($datas['focCategoryId']) ? $datas['focCategoryId'] : null;
            $activity_pos_layout = isset($datas['activity_pos_layout']) ? $datas['activity_pos_layout'] : 'default';
            // dd($isUseCart,$selectUom,$selectPkg);
            $this->storeOrUpdate('isUseCart', $isUseCart);
            $this->storeOrUpdate('selectUom', $selectUom);
            $this->storeOrUpdate('selectPkg', $selectPkg);
            $this->storeOrUpdate('enableBackDate', $enableBackDate);
            $this->storeOrUpdate('focCategoryId', $focCategoryId);
            $this->storeOrUpdate('activity_pos_layout', $activity_pos_layout);
            DB::commit();

            return back()->with('success', 'Successfully Updated!');
        } catch (\Throwable $th) {
            DB::rollBack();

            return back()->with('error', $th->getMessage());
        }
    }

    public function storeOrUpdate($key, $value)
    {
        $isExist = FsSettings::where('key', $key)->exists();
        if (! $isExist) {
            $setting = FsSettings::create([
                'key' => $key,
                'value' => $value,
            ]);

            return $setting;
        } else {
            $setting = FsSettings::where('key', $key)->first()->update([
                'value' => $value,
            ]);

            return $setting;
        }
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
