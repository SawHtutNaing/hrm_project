<?php

namespace Modules\FieldService\Http\Controllers;

use App\Exports\DailyReportExport;
use App\Helpers\UomHelper;
use App\Http\Controllers\Controller;
use App\Models\BusinessUser;
use App\Models\Product\Category;
use App\Models\Product\ProductVariation;
use App\Models\productPackaging;
use App\Models\sale\sale_details;
use App\Models\settings\businessLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class CampaignReportController extends Controller
{
    public function index()
    {
        $locations = businessLocation::select('name', 'id', 'parent_location_id')->get();
        $employee = BusinessUser::select('username', 'id')->get();
        $categories = Category::select('name', 'id')->get();

        return view('fieldservice::campaign.report.index', compact('locations', 'employee', 'categories'));
    }

    public function itemReport()
    {
        $locations = businessLocation::select('name', 'id', 'parent_location_id')->get();
        $employee = BusinessUser::select('username', 'id')->get();
        $categories = Category::select('name', 'id')->get();

        return view('fieldservice::campaign.report.item', compact('locations', 'employee', 'categories'));
    }

    public function getTxByCampaign($id, Request $request)
    {
        $datas = sale_details::select('sale_details.variation_id',
            'products.name',
            'product_variations.variation_sku',
            'sales.sold_by',
            'ref_uom_id',
            'product_packaging_transactions.product_packaging_id',
            'sales.created_at',
            DB::raw('SUM(decrease_qty) as quantity')
        )
            ->leftJoin('sales', 'sale_details.sales_id', '=', 'sales.id')
            ->where('sales.channel_type', '=', 'campaign')
            ->where('sales.channel_id', '=', $id)
            ->leftJoin('product_variations', 'sale_details.variation_id', 'product_variations.id')
            ->leftJoin('products', 'sale_details.product_id', 'products.id')
            ->leftJoin('stock_histories', 'sale_details.id', 'stock_histories.transaction_details_id')
            ->where('stock_histories.transaction_type', '=', 'sale')
            ->leftJoin(
                'product_packaging_transactions',
                function ($join) {
                    $join->on('sale_details.id', '=', 'product_packaging_transactions.transaction_details_id')
                        ->where('product_packaging_transactions.transaction_type', '=', 'sale');
                }
            )
            ->groupBy('sale_details.variation_id', 'sales.created_at', 'product_packaging_transactions.product_packaging_id', 'sales.sold_by', 'products.name', 'stock_histories.ref_uom_id', 'product_variations.variation_sku');

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $datas = $datas->whereDate('sales.created_at', '>=', $request->from_date)->whereDate('sales.created_at', '<=', $request->to_date);
        }

        return DataTables::of($datas)
            ->editColumn('employee', function ($data) {
                $username = BusinessUser::where('id', $data->sold_by)->first()->username;

                return $username;
            })
            ->orderColumn('employee', function ($query, $order) {
                $query->orderBy('sales.sold_by', $order);
            })
            ->editColumn('quantity', function ($data) {
                $productVar = ProductVariation::select('product_id')->where('id', $data->variation_id)
                    ->with('product:id,uom_id', 'product.uom:id,short_name')->first();
                $data->uom = $productVar->product->uom;
                $data->product_id = $productVar->product->id;

                return UomHelper::changeQtyOnUom($data->ref_uom_id, $productVar->product->uom_id, $data->quantity);
            })
            ->editColumn('uom', function ($data) {
                return '<span data-id='.$data->uom->id.'>'.$data->uom->short_name.'</span>';
            })
            ->editColumn('pkgQty', function ($data) {
                $productPkg = $data->product_packaging_id;
                if ($productPkg) {
                    $pkgData = productPackaging::where('id', $productPkg)->first();
                    $data->pkgData = $pkgData;
                    $refPkgQty = UomHelper::changeQtyOnUom($pkgData->uom_id, $data->ref_uom_id, $pkgData->quantity);

                    // dd($data->quantity , $pkgQty, $pkgData->quantity, $pkgData->uom_id, $data->ref_uom_id);
                    return fquantity($data->quantity / $refPkgQty);
                } else {
                    return 0;
                }
            })
            ->editColumn('pkg', function ($data) {
                if ($data->pkgData) {
                    return $data->pkgData->packaging_name;
                } else {
                    return '';
                }
            })
            ->editColumn('date', function ($data) {
                return fdate($data->created_at);
            })
            ->rawColumns(['uom', 'pkg'])
            ->make(true);
    }

    public function getAllTx(Request $request)
    {
        $datas = sale_details::select(
            'sale_details.variation_id',
            'fscampaign.name as campaign_name',
            'fscampaign.id as campaign_id',
            'fscampaign.business_location_id as campaign_business_location_id',
            'sales.business_location_id as sales_business_location_id',
            'products.name',
            'product_variations.variation_sku',
            'sales.sold_by',
            'ref_uom_id',
            'product_packaging_transactions.product_packaging_id',
            'sales.created_at',
            'categories.name as category_name',
            DB::raw('SUM(decrease_qty) as quantity')
        )
            ->leftJoin('sales', 'sale_details.sales_id', '=', 'sales.id')
            ->where('sales.channel_type', '=', 'campaign')
            ->leftJoin('fscampaign', 'sales.channel_id', 'fscampaign.id')
            ->leftJoin('product_variations', 'sale_details.variation_id', 'product_variations.id')
            ->leftJoin('products', 'sale_details.product_id', 'products.id')

            ->leftJoin('categories', 'products.category_id', 'categories.id')
            ->leftJoin('stock_histories', 'sale_details.id', 'stock_histories.transaction_details_id')
            ->where('stock_histories.transaction_type', '=', 'sale')
            ->leftJoin(
                'product_packaging_transactions',
                function ($join) {
                    $join->on('sale_details.id', '=', 'product_packaging_transactions.transaction_details_id')
                        ->where('product_packaging_transactions.transaction_type', '=', 'sale');
                }
            )
            ->groupBy('sale_details.variation_id',
                'sales.business_location_id',
                'categories.name',
                'fscampaign.name', 'fscampaign.business_location_id', 'fscampaign.id', 'sales.created_at', 'product_packaging_transactions.product_packaging_id', 'sales.sold_by', 'products.name', 'stock_histories.ref_uom_id', 'product_variations.variation_sku');

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $datas = $datas->whereDate('sales.created_at', '>=', $request->from_date)->whereDate('sales.created_at', '<=', $request->to_date);
        }

        return DataTables::of($datas)
            ->filterColumn('category', function ($query, $id) {
                $query->where('categories.id', $id);
            })
            ->filterColumn('outlet', function ($query, $id) {
                $query->where('fscampaign.business_location_id', $id);
            })
            ->filterColumn('employee', function ($query, $id) {
                $query->where('sales.sold_by', $id);
            })
            ->orderColumn('name', function ($data, $order) {
                $data->orderBy('products.name', $order);
            })
            ->filterColumn('name', function ($data, $keyword) {
                $data->where('products.name', 'like', '%'.$keyword.'%');
            })

            ->addColumn('category', function ($data) {
                return $data->category_name;
            })
            ->addColumn('outlet', function ($data) {
                if ($data->campaign_business_location_id && ($data->sales_business_location_id == $data->campaign_business_location_id)) {
                    $bl = businessLocation::where('id', $data->campaign_business_location_id)->select('name')->first();

                    return $bl->name;
                }

                return '';
            })
            ->addColumn('employeelocation', function ($data) {
                if ($data->sales_business_location_id && ($data->sales_business_location_id != $data->campaign_business_location_id)) {
                    $bl = businessLocation::where('id', $data->sales_business_location_id)->first();

                    return $bl->name;
                }

                return '';
            })
            ->addColumn('employee', function ($data) {
                $username = BusinessUser::where('id', $data->created_by)->select('username')->first()->username;

                return $username;
            })
            ->addColumn('quantity', function ($data) {
                $productVar = ProductVariation::select('product_id')->where('id', $data->variation_id)
                    ->with('product:id,uom_id', 'product.uom:id,short_name')->first();
                if ($productVar) {

                    $data->uom = $productVar->product->uom;
                    $data->product_id = $productVar->product->id;

                    return UomHelper::changeQtyOnUom($data->ref_uom_id, $productVar->product->uom_id, $data->quantity);
                } else {
                    return 0;
                }
            })
            ->addColumn('uom', function ($data) {
                if ($data->uom) {

                    return '<span data-id='.$data->uom->id.'>'.$data->uom->short_name.'</span>';
                }
            })
            ->addColumn('pkgQty', function ($data) {
                $productPkg = $data->product_packaging_id;
                if ($productPkg) {
                    $pkgData = productPackaging::where('id', $productPkg)->first();
                    $data->pkgData = $pkgData;
                    $refPkgQty = UomHelper::changeQtyOnUom($pkgData->uom_id, $data->ref_uom_id, $pkgData->quantity);

                    // dd($data->quantity , $pkgQty, $pkgData->quantity, $pkgData->uom_id, $data->ref_uom_id);
                    return fquantity($data->quantity / $refPkgQty);
                } else {
                    return 0;
                }
            })
            ->addColumn('pkg', function ($data) {
                if ($data->pkgData) {
                    return $data->pkgData->packaging_name;
                } else {
                    return '';
                }
            })
            ->addColumn('date', function ($data) {
                return fdate($data->created_at);
            })
            ->rawColumns(['uom', 'pkg'])
            ->make(true);
    }

    public function exportDailyReport(Request $request, $campaignId)
    {
        // dd($request->dateRange);
        // Split the string by the delimiter '-'
        if ($request->dateRange) {
            $dateParts = explode('-', $request->dateRange);

            // Trim whitespace from each part
            $fromDate = date_create(trim($dateParts[0]))->format('Y-m-d');
            $toDate = date_create(trim($dateParts[0]))->format('Y-m-d');
        } else {
            $fromDate = now()->format('Y-m-d');
            $toDate = now()->format('Y-m-d');
        }
        $date = now()->format('d-M-y');

        return Excel::download(new DailyReportExport($campaignId, $fromDate, $toDate), $fileName);
    }
}
