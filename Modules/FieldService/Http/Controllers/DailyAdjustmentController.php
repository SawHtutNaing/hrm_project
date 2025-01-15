<?php

namespace Modules\FieldService\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product\Product;
use App\Models\Product\ProductVariation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DailyAdjustmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($location_id, $campaign_id)
    {
        return view('fieldservice::campaign.adjustment.index', compact('location_id', 'campaign_id'));
    }

    public function getProductStockData($location_id, Request $request)
    {
        $query_keyword = $request->toArray()['query'];
        $relations = [
            'product.uom:id,name,short_name,unit_category_id,unit_type,value,rounded_amount',
            'product.uom.unit_category:id,name',
            'product.uom.unit_category.uomByCategory:id,name,short_name,unit_type,unit_category_id,value,rounded_amount',
            'product.product_variations.packaging.uom',
            'product.product_variations.additionalProduct.productVariation.product',
            'product.product_variations.additionalProduct.uom',
            'product.product_variations.additionalProduct.productVariation.variationTemplateValue',
        ];
        $products = ProductVariation::select(
            'products.name as name',
            'products.image as image',
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
            ->where('location_product.location_id', $location_id)
            ->when($query_keyword, function ($query) use ($query_keyword) {
                $query->where(function ($query) use ($query_keyword) {
                    $query->where('can_sale', 1)
                        ->where('products.name', 'like', '%'.$query_keyword.'%')
                        ->orWhere('products.sku', 'like', '%'.$query_keyword.'%');
                });
            })
            ->withSum(['stock' => function ($query) use ($location_id) {
                $locationIds = childLocationIDs($location_id);
                $query->whereIn('business_location_id', $locationIds);
            }], 'current_quantity')
            ->with(...$relations)->paginate(200);

        return response()->json($products, 200);
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
