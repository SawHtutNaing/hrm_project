<?php

namespace Modules\FieldService\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\locationAddress;
use App\Models\settings\businessLocation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OutletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('fieldservice::index');
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
            $location_code = businessLocationCode();
            $locationData = [
                'business_id' => Auth::user()->business_id,
                'location_code' => $location_code,
                'name' => $request['name'],
                'is_acitve' => 1,
                'allow_purchase_order' => 0,
                'allow_sale_order' => 0,
                'allow_pickup_order' => 0,
                'parent_location_id' => $request['parentOutletId'],
                'outlet_type' => $request['outlet_type'],
                'location_type' => 2,
                'inventory_flow' => 'fifo',
                'price_lists_id' => 1,
                'gps_location' => '',
            ];
            $locationData = businessLocation::create($locationData);
            $address = [
                'location_id' => $locationData->id,
                'mobile' => $request['mobile'],
                'alternate_number' => $request['alternate_number'],
                'email' => $request['email'],
                'address' => $request['address'],
                'country' => $request['country'],
                'state' => $request['state'],
                'city' => $request['city'],
                'zip_postal_code' => $request['zip_postal_code'],

            ];
            locationAddress::create($address);
            $lname = businessLocationName($locationData);
            logger($lname);
            DB::commit();

            return response()->json([
                'success' => 'Successfylly Crated',
                'locationData' => $locationData,
                'lname' => $lname,
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'error' => $th->getMessage(),
            ], 500);
            // throw $th;
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
