<?php

namespace Modules\FieldService\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BusinessUser;
use App\Models\Product\Product;
use App\Models\Product\ProductVariation;
use App\Models\sale\sales;
use App\Repositories\LocationRepository;
use App\Repositories\UserManagement\BusinessUserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\FieldService\Entities\attendanceRecords;
use Modules\FieldService\Entities\FsCampaign;
use Modules\FieldService\Entities\FsSettings;
use Modules\FieldService\Entities\Questionnaires;
use Modules\Games\Entities\Spinwheel;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $CurrentCampaigns=FsCampaign::query()->orderBy('id','DESC')
        //                     ->whereDate('campaign_end_date', '>=', now())
        //                     ->whereDate('campaign_start_date', '<=', now())
        //                     ->with('location')
        //                     ->when(!hasView('campaign'), function ($query) {
        //                         $query->whereJsonContains('campaign_member', Auth::user()->id)
        //                             ->orWhere('campaign_leader', Auth::user()->id);
        //                     })
        //                     ->get();
        // $AllCampaigns=FsCampaign::query()->orderBy('id','DESC')
        //                             ->whereNotIn('id', $CurrentCampaigns->pluck('id')->toArray())
        //                             ->with('location')
        //                             ->when(!hasView('campaign'), function ($query) {
        //                                 $query->whereJsonContains('campaign_member', Auth::user()->id)
        //                                     ->orWhere('campaign_leader', Auth::user()->id);
        //                             })
        //                             ->get();
        return view('fieldservice::campaign.campaigns');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locations = LocationRepository::getTransactionLocation();
        $games = Spinwheel::select('id', 'name')->get();
        $questionnaires = Questionnaires::select('id', 'name')->get();

        return view('fieldservice::campaign.create', compact('locations', 'games', 'questionnaires'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $campaignData = $this->campaignData($request);
            $campaignData['created_at'] = now();
            $campaignData['created_by'] = Auth::user()->id;

            FsCampaign::create($campaignData);
            DB::commit();

            return redirect()->route('campaign.index')->with('success', 'Successfully Created');
        } catch (\Throwable $th) {
            DB::rollBack();

            return back()->with('error', 'Something Wrong');
        }
    }

    protected function requestJsonId($requestJson)
    {
        $categories = json_decode($requestJson);
        if ($categories) {
            $id = array_map(function ($c) {
                return $c->id;
            }, $categories);
            $idJson = json_encode($id);

            return $idJson;
        }

        return false;
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $attendanceCount = attendanceRecords::where('campaign_id', $id)->count();
        $campaign = FsCampaign::where('id', $id)->with('leader', 'location')->first();
        $campaignMemberId = json_decode($campaign->campaign_member);
        $campaignUsernames = '';
        $campaignUsers = [];
        if ($campaignMemberId) {
            $campaignUsers = BusinessUser::whereIn('id', $campaignMemberId)->get();
            if ($campaignUsers) {
                foreach ($campaignUsers as $key => $e) {
                    $seperator = $key == 0 ? '' : ' , ';
                    $campaignUsernames .= $seperator.$e->username;
                }
            }
        }
        $totalExpense = sales::where('channel_id', $id)->where('channel_type', 'campaign')->sum('total_sale_amount');

        // dd(json_decode($galleries->images));
        return view('fieldservice::campaign.view', compact('attendanceCount', 'campaign', 'campaignUsernames', 'totalExpense'));
    }

    public function viewWithOverAllReport($id)
    {
        $campaign = FsCampaign::where('id', $id)->with('leader', 'location')->first();

        return view('fieldservice::campaign.reportViews.viewWithReport', compact('campaign'));
    }

    public function viewWithGrallery($id)
    {
        $campaign = FsCampaign::where('id', $id)->with('leader', 'location')->first();

        return view('fieldservice::campaign.reportViews.viewWithGrallery', compact('campaign'));
    }

    public function viewWithProductSummary($id)
    {
        $campaign = FsCampaign::where('id', $id)->with('leader', 'location')->first();

        return view('fieldservice::campaign.reportViews.viewWithProductSummary', compact('campaign'));
    }

    public function viewWithAl($id)
    {
        $campaign = FsCampaign::where('id', $id)->with('leader', 'location')->first();

        return view('fieldservice::campaign.reportViews.viewWithAl', compact('campaign'));
    }

    // public function list2(){

    //     return view('fieldservice::campaign.list2');
    // }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FsCampaign $campaign)
    {

        $locations = LocationRepository::getTransactionLocation();

        $questionnaires = Questionnaires::select('id', 'name')->get();
        $games = Spinwheel::select('id', 'name')->get();
        // for employee
        $campaignMemberId = json_decode($campaign->campaign_member);
        $campaignUsernames = '';
        $campaignUsers = [];
        if ($campaignMemberId) {
            if ($campaignMemberId[0] == 'all') {
                $campaignUsernames .= 'All,';
            } else {
                $campaignUsers = BusinessUser::whereIn('id', $campaignMemberId)->get();
                if ($campaignUsers) {
                    foreach ($campaignUsers as $key => $e) {
                        $seperator = $key == 0 ? '' : ' , ';
                        $campaignUsernames .= $seperator.$e->username;
                    }
                }
            }
        }

        return view('fieldservice::campaign.edit', compact('campaign', 'locations', 'questionnaires', 'campaignUsers', 'campaignUsernames', 'games'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $campaignData = $this->campaignData($request);

            $campaignData['updated_at'] = now();
            $campaignData['updated_by'] = Auth::user()->id;

            FsCampaign::where('id', $id)->update($campaignData);
            DB::commit();

            return redirect()->route('campaign.index')->with('success', 'Successfully Updated');
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        FsCampaign::where('id', $id)->delete();

        return back()->with('success', 'Successfully Deleted');
    }

    public function spinwheel()
    {
        return view('fieldservice::campaign.spinwheel');
    }

    public function ptx(FsCampaign $campaign)
    {
        $fsSettings = FsSettings::whereIn('key', ['isUseCart', 'selectUom', 'selectPkg', 'enableBackDate', 'fsSettings', 'focCategoryId', 'activity_pos_layout'])
            ->get()->toArray();
        $isUseCart = 'false';
        $selectUom = 'true';
        $selectPkg = 'false';
        $enableBackDate = 'false';
        $focCategoryId = null;
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
        $saleLocation = $campaign->business_location_id;
        $samplingLocation = Auth::user()->default_location_id ?? 0;

        return view('fieldservice::campaign.activity', compact(
            'isUseCart', 'selectUom', 'selectPkg', 'enableBackDate',
            'campaign', 'samplingLocation', 'saleLocation', 'focCategoryId', 'activity_pos_layout'));
    }

    public function getuserSelectData(Request $request, BusinessUserRepository $users)
    {
        if (isset($request['query'])) {
            return $users->query()->select('id', 'username')
                ->where('username', 'like', '%'.$request['query'].'%')->paginate(20);
        } else {
            return $users->query()->select('id', 'username')->paginate(20);
        }
    }

    public function start(FsCampaign $campaign)
    {
        if ($campaign->campaign_leader != Auth::user()->id) {
            return response()->json(['error' => '403 Forbidden'], 403);
        } else {
            $campaign->status = 'start';
            $campaign->start_by = Auth::user()->id;
            $campaign->save();
        }

        return response()->json(['success' => 'Successfully Start Campaign'], 200);
    }

    public function close(FsCampaign $campaign)
    {
        if ($campaign->campaign_leader != Auth::user()->id) {
            return response()->json(['error' => '403 Forbidden'], 403);
        } else {
            logger('========close======');
            $campaign->status = 'close';
            $campaign->end_by = Auth::user()->id;
            $campaign->save();
        }

        return response()->json(['success' => 'Successfully Closed Campaign'], 200);
    }

    public function campaignData($request)
    {
        $campaignData = $request->only(
            'name',
            'description',
            'campaign_leader',
            'business_location_id',
            'game_id',
            'questionnaire_id',
            'campaign_member'
        );
        // prepare date
        $dateRange = $request->input('campaign_datetime');
        $dateArray = explode(' - ', $dateRange);
        $startDate = date_create_from_format('d/M/Y', trim($dateArray[0]))->format('Y-m-d');
        $endDate = date_create_from_format('d/M/Y', trim($dateArray[1]))->format('Y-m-d');

        // prepare member
        $Jsonmembers = $request->input('campaign_member');
        $members = $this->requestJsonId($Jsonmembers);
        $campaignData['campaign_start_date'] = $startDate;
        $campaignData['campaign_end_date'] = $endDate;
        $campaignData['campaign_member'] = $members;

        return $campaignData;
    }

    public function getProduct(Request $request)
    {
        $data = $request->data ?? [];
        $business_location_id = $request->toArray()['businessLocationId'] ?? null;
        $categoryId = $request->toArray()['categoryId'] ?? null;
        $keyword = $request->toArray()['query'];
        // logger($keyword);die;
        $variation_id = $data['variation_id'] ?? null;
        $relations = [
            'product.uom:id,name,short_name,unit_category_id,unit_type,value,rounded_amount',
            'product.uom.unit_category:id,name',
            'product.uom.unit_category.uomByCategory:id,name,short_name,unit_type,unit_category_id,value,rounded_amount',
            'product.product_variations.packaging.uom',
            'product.product_variations.additionalProduct.productVariation.product',
            'product.product_variations.additionalProduct.uom',
            'product.product_variations.additionalProduct.productVariation.variationTemplateValue',
        ];

        if (hasModule('ComboKit') && isEnableModule('ComboKit')) {
            $relations = [
                'product.rom.uom.unit_category.uomByCategory',
                'product.rom.rom_details.productVariation.product',
                'product.rom.rom_details.uom',
                ...$relations,
            ];
        }
        $products = ProductVariation::select(
            'products.name as name',
            'products.id as id',
            'products.product_code',
            'products.sku',
            'products.product_type',
            'products.has_variation',
            'products.lot_count',
            'products.uom_id',
            'products.purchase_uom_id',
            'products.can_sale',
            'products.is_recurring',
            'products.receipe_of_material_id',
            'products.image',

            'product_variations.product_id',
            'product_variations.variation_sku',
            'product_variations.variation_template_value_id',
            'product_variations.default_selling_price',
            'product_variations.id as variation_id',

            'variation_template_values.variation_template_id',
            'variation_template_values.name as variation_name',
            'variation_template_values.id as variation_template_values_id'
        )->whereNull('products.deleted_at')
            ->leftJoin('products', 'product_variations.product_id', '=', 'products.id')
        // ->leftJoin('product_variations', 'products.id', '=', 'product_variations.product_id')
            ->leftJoin('variation_template_values', 'product_variations.variation_template_value_id', '=', 'variation_template_values.id')
            ->leftJoin('location_product', 'products.id', '=', 'location_product.product_id')
            ->when($business_location_id != null, function ($query) use ($business_location_id) {
                $query->where('location_product.location_id', $business_location_id);
            })
            ->when($categoryId != null, function ($query) use ($categoryId) {
                $query->where('products.category_id', $categoryId);
            })
            ->when($keyword, function ($query) use ($keyword) {
                logger($keyword);
                $query->where(function ($query) use ($keyword) {
                    $query->where('can_sale', 1)
                        ->where('products.name', 'like', '%'.$keyword.'%')
                        ->orWhere('products.sku', 'like', '%'.$keyword.'%');
                });
            })
            ->when($variation_id, function ($query) use ($variation_id) {
                $query->where('product_variations.id', $variation_id);
            })
            ->with($relations)
            ->withSum(['stock' => function ($query) use ($business_location_id) {
                $locationIds = childLocationIDs($business_location_id);
                $query->whereIn('business_location_id', $locationIds);
            }], 'current_quantity')
            ->orderBy('id', 'ASC')->paginate(20);

        return response()->json($products, 200);
    }

    public function recentTx($campaign_id, $location_id)
    {
        $campaign = FsCampaign::where('id', $campaign_id)->first();

        return view('fieldservice::campaign.recentTx.index', compact('location_id', 'campaign_id', 'campaign'));
    }

    public function getrecentTxs($campaign_id, $location_id, Request $request)
    {
        $keyword = $request->toArray()['query'] ?? null;
        $datas = sales::orderBy('id', 'DESC')
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('sales_voucher_no', 'like', '%'.$keyword.'%');
            })
            ->where('business_location_id', $location_id)
            ->with('winlog', 'sale_details:id,sales_id,quantity,product_id,uom_id', 'sale_details.product:id,name', 'sale_details.uom:id,short_name')
            ->where('created_by', Auth::user()->id)
            ->where('channel_type', 'campaign')
            ->where('channel_id', $campaign_id)
            ->withSum('sale_details', 'quantity')
            ->paginate(50);

        return response()->json($datas, 200);
        // ->toArray();
        // dd($datas);
    }
}
