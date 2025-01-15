@extends('App.main.navBar')

@section('campaign_icon', 'active')
@section('campaign_show', 'active show')
@section('campaign_list_active', 'active')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/spinwheel/css/reset.css') }}">
{{-- <link rel="stylesheet" href="{{ public_path('modules/FieldService/css/style.css') }}"> --}}
<link rel="stylesheet" href="{{ asset('assets/spinwheel/css/superwheel.min.css') }}">
<!-- Alpine Plugins -->
<script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{hybrid_asset('assets/css/loader.style.css')}}">

<style>
    *{
        font-family: Arial, Helvetica, sans-serif;
    }
    #custom{
        width: 0%;
        height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 10;
    }
    .card-responsive{
        height: 90%;
    }
    .actions{
        height: 10%;
    }
    .productCard:active{
        border: 2px solid #009cf784;
    }
    .customTooltip{
        position: absolute;
        top: -40px;
        left: 0px;
        right: 0px;
        background-color: white;
        border: 0.6px solid #0000001a;
        border-radius: 5px ;
        width: auto;
        z-index: 500;
        display: none;
    }
    .tootltipCtrl:hover .customTooltip{
        display: block;
    }
    @media only screen and (max-width: 768px) {
        .card-responsive{
            height: 100%;
        }
    }
    .w-fit{
        width: fit-content;
    }
    .product-drawer{
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        margin-left: 2px;
        margin-right: 2px;
        background: white;
        padding: 10px 0px;
        border-top: 1px solid gray;
        border-radius: 10px 10px 0px 0px;
    }
</style>
@endsection
@section('title')
<!--begin::Heading-->
<h1 class="text-dark fw-bold my-0 fs-2">Products</h1>
<!--end::Heading-->
<!--begin::Breadcrumb-->
<ul class="breadcrumb fw-semibold fs-base my-1">
    <li class="breadcrumb-item text-muted">Campaign</li>
    {{-- <li class="breadcrumb-item text-muted">
        <a href="" class="text-muted text-hover-primary">Crate</a>
    </li> --}}
    <li class="breadcrumb-item text-dark">Product </li>
</ul>
<!--end::Breadcrumb-->
@endsection

@section('content')
<div id="loading-page">
    <div class="loader">

    </div>
    <div class="loadingLogo">
        <img src="{{hybrid_asset('default/pico.png')}}"  alt="" width="50px">
    </div>
</div>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content" style="height: 80vh;overflow: hidden;" >
    <!--begin::Container-->
    <div class="container-xxl h-100 position-relative" id="location"  x-data="cards()"  >
        <div class="row">
            <div class="w-md-auto  col-6 text-start" x-ignore>
                <a href="{{ route('campaign.index') }}" class="w-100  btn btn-secondary fs-5 btn-sm  mb-2">
                     <i class="fa-solid fa-angle-left fs-4 pe-1"></i> {{__('fieldservice::actions.back')}}
                </a>
            </div>
        </div>

        <div class="separator separator-dotted my-5"></div>
        <div class="row mb-2 justify-content-start align-items-center">

            <div class="w-md-auto mb-2 col-6" x-ignore>
                <a href="{{route('campaign.questionnaire',$campaign->questionnaire_id ?? 0)}}">
                    <div class="card">
                        <div class="card-body py-3 px-5">
                            <div class="d-flex align-items-center">
                                <img src="{{asset('assets/spinwheel/icons/questionnaire.png')}}" width="25px" height="25px"
                                    class="image" alt="">
                                <div class="text fs-5 text-gray-800 fw-bold ps-2  d-md-block">
                                    {{__('fieldservice::actions.questionnaire')}}</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="w-md-auto mb-2 col-6" x-ignore>
                <a href="{{route('dailyAdjust.index',[
                                'location_id'=>$saleLocation,
                                'campaign_id'=>$campaign->id
                                ])}}">
                    <div class="card">
                        <div class="card-body py-3 px-5">
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-sliders fs-3 text-primary"></i>
                                <div class="text fs-5 text-gray-800 fw-bold ps-2  d-md-block">
                                    {{__('fieldservice::actions.daily_adjustment')}}</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="w-md-auto mb-2 col-6" x-ignore>
                <a href="{{route('campaign.recentTx',[
                                    'campaign_id'=>$campaign->id ,
                                    'location_id'=>$saleLocation
                                    ])
                                }}">
                    <div class="card">
                        <div class="card-body py-3 px-5">
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-rotate-right fs-3 text-success"></i>
                                <div class="text fs-5 text-gray-800 fw-bold ps-2  d-md-block">
                                    {{__('fieldservice::actions.recent_tx')}}</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="separator separator-dotted my-5"></div>
            <div class="w-md-auto mb-2 col-6" >
                <div class="card cursor-pointer" @click=" openDrawer('sale') ">
                    <div class="card-body py-5 px-5">
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-wine-bottle fs-3 text-primary"></i>
                            {{-- <i class="fa-solid fa-shop fs-3 text-primary"></i> --}}
                            <div class="text fs-6 text-gray-800 fw-bold ps-2  d-md-block"

                            >
                                {{  __('fieldservice::actions.sale_items')}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-md-auto mb-2 col-6" >
                <div class="card cursor-pointer"  @click=" openDrawer('sample') ">
                    <div class="card-body py-5 px-5">
                        <div class="d-flex align-items-center">

                            <i class="fa-solid fa-wine-bottle fs-3 text-success"></i>
                            {{-- <i class="fa-solid fa-shop fs-3 text-primary"></i> --}}
                            <div class="text fs-6 text-gray-800 fw-bold ps-2  d-md-block">
                                {{__('fieldservice::actions.sample_items')}}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-md-auto mb-2 col-6">
                <div class="card cursor-pointer"  @click=" openDrawer('foc',{{$focCategoryId}}) ">
                    <div class="card-body py-5 px-5">
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-wine-bottle fs-3 text-dark"></i>
                            {{-- <i class="fa-solid fa-shop fs-3 text-primary"></i> --}}
                            <div class="text fs-6 text-gray-800 fw-bold ps-2  d-md-block">
                                {{__('fieldservice::actions.foc_items')}}</div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($isUseCart =='true')
            <div class="col-12 w-auto mb-2 cursor-pointer user-select-none cartDiv" :class="isUseCart ? 'd-block d-md-none' : 'd-none'">
                <div class="">
                    <div class="card">
                        <div class="card-body py-4 px-6">
                            <span class="position-absolute top-1  translate-middle badge rounded-pill bg-danger "
                                x-text="carts.length" style="right: -11px">
                                0
                            </span>
                            <div class="d-flex justify-content-center align-items-center">
                                <i class="fa-solid fa-cart-shopping text-primary"></i>
                                <div class="text fs-7 text-gray-800 fw-bold ps-2">cart</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <div class="row  h-100 "
            :class="activity_pos_layout != 'default' ? 'product-drawer' :'' "
            x-show="ui.productsDrawer"
            x-transition:enter="transition ease-out duration-600"
             x-init="fetchProduct()"  >
            <div :class="isUseCart ? 'col-md-8' : 'col-12'" class="pb-10 scrollableDiv" style="height: 90%; overflow-x: scroll;"  @scroll.infinite="loadMore">
                <div class="card position-sticky top-0 z-index-3  mb-3" >
                    <div class="card-body p-0">
                        <div class="row p-0 mt-3">
                            <div class="col-12 mb-5 mb-md-0 p " x-show="ui.productsDrawer">
                                <div class="row justify-between px-3">
                                    <div class="col-6">
                                        <h4 class="fw-bold"
                                            x-text="channelData.current=='sale' ? '{{  __('fieldservice::actions.sale_items')}}':
                                            channelData.current=='foc'?'{{  __('fieldservice::actions.foc_items')}}' :'{{  __('fieldservice::actions.sample_items')}}' ">
                                            {{__('fieldservice::actions.sale_items')}}
                                        </h4>
                                    </div>
                                    <div class="col-6 text-end">
                                        <button x-show="activity_pos_layout != 'default'" class="btn btn-sm btn-danger w-auto py-3 py-md-2" @click="closeDrawer()">Close</button>
                                    </div>
                                </div>
                            </div>
                            <div class="separator separator-dotted"></div>
                            <div class="col-md-3 col-12 mb-3 mb-md-0" x-show="!ui.productsDrawer">
                                <button class="btn btn-sm btn-success w-100 py-5 py-md-2" x-show="channelData.current=='sale' && channelData.current!='foc'"  @click=" switchChannel('sample') "> {{__('fieldservice::activity.click_to_sampling')}}</button>
                                <button class="btn btn-sm btn-primary w-100 py-5 py-md-2" x-show="channelData.current=='sample' && channelData.current!='foc'"  @click="switchChannel('sale') ">{{__('fieldservice::activity.click_to_sale')}}</button>
                                {{-- <select name="location_id" id="location_id" x-model="businessLocationId" class="form-select form-select-sm" aria-placeholder="Select"
                                x-init="$($el).select2({minimumResultsForSearch: Infinity}).on('change', (e) => {
                                    businessLocationId = e.target.value;
                                    reFetch();
                                })">
                                    @foreach ($locations as $l)
                                        <option value="{{$l->id}}" @selected($defaultLocation==$l->id)>{{businessLocationName($l)}}</option>
                                    @endforeach
                                </select> --}}
                            </div>
                            <div class="col-md-9 col-12 mb-3 mb-md-0">
                                <div class="input-group p-0 w-100">
                                    <span class="input-group-text"><i class="fa-solid fa-search"></i></span>
                                    <input type="search" class="form-control form-control-sm rounded rounded-start-0 text-gray-800 border-gray-500"
                                        id="product_search" name="product_search" placeholder="Search Product " data-kt-date-filter="date"
                                        data-allow-clear="true" x-model.debounce.500ms="search">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row align-items-lg-stretch p-2"  >
                    <div class="mb-2">
                        <button class="btn btn-sm btn-outline fw-semibold" @click='changeView("list")'  x-show='currentView =="card" '>
                            <i class="fa-solid fa-list me-2"></i> list view
                        </button>


                        <button class="btn btn-sm btn-outline fw-semibold" @click='changeView("card")'  x-show='currentView =="list" '>
                            <i class="fa-solid fa-rectangle-list me-2"></i> Card view
                        </button>
                    </div>
                    {{-- @foreach (range(1,50) as $i) --}}
                    <template x-if=" currentView=='list' ">
                        <template   x-for="(product,i) in products" :key="i" >
                            <div  class="p-1 col-lg-2 col-md-2 col-6 col-sm-4 cursor-pointer user-select-none "  @click="addToCart(product)">
                                <div class="card productCard h-100"  >
                                    <div class="card-body text-center p-3" >
                                        <img x-show="!product.image" src="{{asset('assets/media/svg/files/blank-image.svg')}}"
                                            class="rounded-3 theme-light-show mb-4 w-100px h-100px w-xxl-100px h-xxl-100px" alt="" />
                                        <img  x-show="!product.image"  src="{{asset('assets/media/svg/files/blank-image-dark.svg')}}"
                                            class="rounded-3 theme-dark-show mb-4 w-100px h-100px w-xxl-100px h-xxl-100px" alt="" />
                                        <img  x-show="product.image"  :src=`/storage/product-image/${product.image}`
                                                class="rounded-3 mb-4 w-100px h-100px w-xxl-100px h-xxl-100px" alt="" />
                                        <div class="mb-2 position-relative tootltipCtrl" :title="product.name" >
                                            <div class="  customTooltip" x-text="product.name "></div>
                                            <div class="text-center" >
                                                <span x-text="product.name.slice(0,20)"></span><br>
                                                <span  class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-7 mb-3 pos-product-name" x-text="product.variation_name ? '('+product.variation_name+')'  : '' "></span>
                                                <span class="text-gray-400 fw-semibold d-block fs-8 mt-1" x-text="product.sku"></span>
                                            </div>
                                        </div>
                                        <span class="text-primary text-end fw-bold fs-6" x-text="product.default_selling_price ?? 00"></span><br>
                                        <span class="fs-9 text-danger"
                                        x-show="
                                        (product.stock_sum_current_quantity==null || product.stock_sum_current_quantity <= 0)  && product.product_type=='storable' "> * Out of stock</span>
                                        <span class="fs-9 " x-show="product.stock_sum_current_quantity!=null "> &nbsp;</span>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </template>

                    <template x-if=" currentView=='card' ">
                        <template x-if=" currentView=='list' " x-for="(product,i) in products" :key="i" >
                            <div  class=" p-1 col-lg-2 col-md-2 col-12 col-sm-4 cursor-pointer user-select-none "  @click="addToCart(product)">
                                <div class="card productCard h-100"  >
                                    <div class="card-body text-start p-3 d-flex" >
                                        <div class="">
                                            <img x-show="!product.image" src="{{asset('assets/media/svg/files/blank-image.svg')}}"
                                            class="rounded-3 theme-light-show mb-4 w-50px h-2w-50px w-xxl-2w-50px h-xxl-2w-50px" alt="" />
                                            <img  x-show="!product.image"  src="{{asset('assets/media/svg/files/blank-image-dark.svg')}}"
                                                class="rounded-3 theme-dark-show mb-4 w-50px h-2w-50px w-xxl-2w-50px h-xxl-2w-50px" alt="" />
                                            <img  x-show="product.image"  :src=`/storage/product-image/${product.image}`
                                                class="rounded-3 mb-4 w-50px h-2w-50px w-xxl-2w-50px h-xxl-2w-50px" alt="" />
                                        </div>
                                        <div class="">
                                            <div class="mb-1 position-relative tootltipCtrl" :title="product.name" >
                                                <div class="  customTooltip" x-text="product.name "></div>
                                                <div class="text-start" >
                                                    <span class="fw-bold" x-text="product.name.slice(0,20)"></span><br>
                                                    <span  class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-7 mb-3 pos-product-name" x-text="product.variation_name ? '('+product.variation_name+')'  : '' "></span>
                                                    <span class="text-gray-400 fw-semibold d-block fs-8 mt-1" x-text="product.sku"></span>
                                                </div>
                                            </div>
                                            <div class="">
                                            Price : <span class="text-primary text-end fw-bold fs-6" x-text="product.default_selling_price ?? 00"></span>
                                            </div>
                                            <span class="fs-9 text-danger"
                                            x-show="
                                            (product.stock_sum_current_quantity==null || product.stock_sum_current_quantity <= 0)  && product.product_type=='storable' "> * Out of stock</span>
                                            <span class="fs-9 " x-show="product.stock_sum_current_quantity!=null "> </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </template>
                    {{-- @endforeach --}}
                </div>
                <div class="bottomDiv"></div>
                <div class="" x-show="pageLoading">
                    <div class="card bg-transparent">
                        <div class="card-body text-center py-3">
                            <i class="fa-solid fa-spinner fa-spin-pulse text-primary me-1"></i>  <span class="fs-6 text-gray-700">Loading </span>
                        </div>
                    </div>
                </div>
            </div>
            <div :class="isUseCart ? 'd-md-block col-md-4' : 'd-none'" class="    position-md-static position-absolute z-index-3 cart-container ps-0 ps-md-3 cardToggle"  style="top: 0px;display: none;height: 90%;">
                <div class="card card-responsive " style=" border-bottom-right-radius: 0;">
                    <div class="card-title py-3 px-3 border-1 fw-bold" style="border-bottom: 1px solid rgba(0, 0, 0, 0.164) !important;">
                        <div class="row justify-content-between align-items-center">
                            <div class="w-auto">
                                Cart
                            </div>
                            <div class="w-auto cursor-pointer cartDiv  d-block d-md-none cardDivBtn"  >
                                <i class="fa-solid fa-xmark fs-3 pe-5"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-3 pt-0 h-100 overflow-scroll ">
                        <div class="" x-show="carts.length<1">
                            <div class="fw-bold mt-5">
                                <div class="row justify-content-betweeen align-items-center">
                                    <div class="col-12 text-center">
                                        <span class="inline-block text-gray-600 user-select-none" >There is no product in carts</span>
                                    </div>
                                </div>
                            </div>
                            <div class="separator my-3 border-gray-300"></div>
                        </div>
                        <template x-for="(cart,i) in carts" :key="i" >
                            <div class="user-select-none cursor-pointer"  @click="showModal(cart);" @click.stop="isRemoveing">
                                <div class="fw-bold mt-5">
                                    <div class="row justify-content-betweeen align-items-center">
                                        <div class="col-6">
                                            <span class="inline-block text-gray-800" x-text="cart.name">Alcohol 300ml (white rum)</span>
                                        </div>
                                        <div class="col-6 text-end">
                                            <button class="btn btn-secondary btn-sm "  @click="removeFromCart(i)">
                                                <i class="fa-solid  fa-trash text-danger"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="row justify-content-betweeen align-items-center"  >
                                        <div class="col-6">
                                            <span class="inline-block text-gray-500 fs-8" >SKU : <span class=" user-select-all" x-text="cart.sku"></span></span>
                                        </div>
                                        <div class="col-6 text-end" >
                                            <div class="inline-block text-gray-600 fs-8" x-show="cart.type!='service'">
                                                <span x-text="cart.aviableQty.toFixed(2)"></span>
                                                <span x-text="cart.uom.short_name"></span>
                                                available
                                            </div>
                                            <span class="fs-9 text-danger" x-text="stocks[cart.stocksIndex] ? stocks[cart.stocksIndex].message: ''">
                                            </span>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="row">
                                            <div class="col-6">
                                                <span x-text="cart.quantity"></span>
                                                <span x-text="cart.uom.short_name"></span>
                                            </div>
                                            <div class="col-6 text-end pe-0">
                                                <span x-text="cart.subtotal_with_discount"></span> ks
                                            </div>
                                        </div>
                                        <div class="col-12" x-show="cart.packaging_id && cart.packagings.length>0">
                                            <span x-text="cart.packaging_quantity"></span>x
                                            <span x-text="getPkgText(cart)"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-3 border-gray-300"></div>
                                </div>
                            </div>
                        </template>

                    </div>
                    <div class="d-flex justify-content-between align-items-center border border-top-1">
                        <div class="fw-bold p-3 fs-1">Subtotal</div>
                        <div class="fw-bold p-3 fs-1">
                            <span x-text="subtotal"></span> Ks
                        </div>
                    </div>
                </div>
                <div class="actions" >
                    <button :class="channelData.current=='sale' ? 'btn-primary' : 'btn-success' " class="btn btn-sm btn-primary w-100 h-100" @click="save"
                    :disabled="submitBtn.disable"
                    x-text="channelData.current=='sale' ? saveSaleText:saveSamplingText  "
                    >

                    </button>
                </div>
            </div>
        </div>




        <div class="modal fade " tabindex="-1" id="modal">
            <div class="modal-dialog w-md-600px modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content mb-20">
                    {{-- <div class="modal-header py-2">
                        <h3 class="modal-title" x-text="modalData.name" >Modal</h3>
                    </div> --}}
                    <template  x-if="modalData.name" >
                        <div class="modal-body">
                            <div class="row justify-content-start align-items-center">

                                <div class="symbol symbol-100px h-100px m-1 mb-3 me-1 w-auto" >
                                    <div class="symbol-label theme-light-show" x-show="!modalData.image" style="background-image:url({{asset('assets/media/svg/files/blank-image.svg')}});"></div>
                                    <div class="symbol-label theme-dark-show" x-show="!modalData.image" style="background-image:url({{asset('assets/media/svg/files/blank-image-dark.svg')}});"></div>
                                    <div class="symbol-label" x-show="modalData.image" >
                                        <img  x-show="modalData.image"
                                         :src=`/storage/product-image/${modalData.image}`
                                        class="w-100px rounded" alt="" />
                                    </div>
                                </div>
                                <div class="w-auto">
                                    <span x-text="modalData.name" class="fs-3 mb-2"></span>
                                    <div class="text-gray-980 fw-semibold  fs-8 col-12">
                                        SKU:<span x-text="modalData.sku" class=" "></span>
                                    </div>
                                    <div class="inline-block text-primary fw-bold fs-6 mt-2" x-show="modalData.type=='storable'">
                                        <span x-text="modalData.aviableQty?modalData.aviableQty.toFixed(2):0 "></span>
                                        <span x-text="modalData.uom ?modalData.uom.short_name: '' "></span> available
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-10">
                                <div class=" col-12 mb-2 mb-md-0">
                                    <div class="row align-items-center mb-5">
                                        <div class="w-auto fs-6 fw-bold text-gray-800">
                                          {{__('fieldservice::activity.unit_price')}} :
                                        </div>
                                        <div class="w-auto col-12 col-lg-8">
                                            <input class="fs-5  text-gray-800 form-control form-control-sm border-left-0 border-right-0 border-top-0 rounded-0" x-model="modalData.uom_price"
                                            x-init="$watch('modalData.uom_price',()=>{
                                                updateSubtotal(modalData)
                                            })" />
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row mt-3" x-show="modalData.packagings && modalData.packagings.length >0 && selectPkg =='true' ">
                                <div class=" col-6 mb-3 mb-md-0">
                                    <div class="row align-items-start">
                                        <div class="col-12 fs-6 fw-bold text-gray-800">
                                            Packaging Qty
                                        </div>
                                        <div class="col-12 input-group">
                                            <button class="btn btn-sm btn-icon btn-outline btn-active-color-danger decrease" type="button"
                                                data-kt-dialer-control="decrease" @click="pkgDecrease(modalData);">
                                                <i class="fa-solid fa-minus fs-2"></i>
                                            </button>
                                            <input class="form-control form-control-sm  rounded-0" x-model="modalData.packaging_quantity"
                                            x-init="$watch('modalData.packaging_quantity',(val)=>{
                                                updateSubtotal(modalData)
                                            })"
                                            @input="updateQtyByPkgQty()"
                                             />
                                             <button class="btn btn-sm btn-icon btn-outline btn-active-color-primary increase" type="button"
                                                data-kt-dialer-control="increase" @click="pkgIncrease(modalData)">
                                                <i class="fa-solid fa-plus fs-2"></i>
                                            </button>
                                        </div>
                                        <div class="text-center" x-show="selectUom =='false' ">
                                            <span class="fs-9 text-danger" x-text="stocks[modalData.stocksIndex] ? stocks[modalData.stocksIndex].message: ''">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="row align-items-center">
                                        <div class="col-12 fs-6 fw-bold text-gray-800">
                                            Packaging
                                        </div>
                                        <div class="col-12 fs-6 fw-bold text-gray-800">
                                            <select name="packaging" id="pkgSelect" x-ref="pkgSelect" x-html="modalData.pkgOptions" data-allow-clear="true" x-model="modalData.packaging_id" class=" form-select form-select-sm border-left-0 border-right-0 border-top-0 rounded-0"
                                            x-init="
                                                $nextTick(() => {
                                                    initPkgSelect2();
                                                });
                                            "
                                            id="">

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3" x-show="selectUom=='true'">
                                <div class=" col-6 mb-3 mb-md-0">
                                    <div class="row align-items-start">
                                        <div class="col-12 fs-6 fw-bold text-gray-800">
                                            {{__('fieldservice::activity.quantity')}}
                                        </div>
                                        <div class="input-group inpDialer">
                                            <button class="btn btn-sm btn-icon btn-outline btn-active-color-danger decrease" type="button"
                                                data-kt-dialer-control="decrease" @click="decrease(modalData);">
                                                <i class="fa-solid fa-minus fs-2"></i>
                                            </button>
                                            <input type="text"  class="form-control form-control-sm quantity input_number form-control-sm h-10"
                                                placeholder="quantity" name="ds" data-kt-dialer-control="input" x-model="modalData.quantity"
                                                @input="updatePkgQtyByQty(event)"
                                                x-init="
                                                    checkStock(modalData);
                                                    $watch('modalData.quantity',function(value,prevalue){
                                                        updateSubtotal(modalData);

                                                        if(modalData.type=='storable'){
                                                            {{-- currentUomId, newUomId, currentQty,uoms --}}
                                                            checkStock(modalData);
                                                        }
                                                    })
                                                " />
                                            <button class="btn btn-sm btn-icon btn-outline btn-active-color-primary increase" type="button"
                                                data-kt-dialer-control="increase"  @click="increase(modalData)">
                                                <i class="fa-solid fa-plus fs-2"></i>
                                            </button>
                                        </div>
                                        {{-- stocksIndex --}}
                                        <div class="text-center">
                                            <span class="fs-9 text-danger"  x-text="stocks[modalData.stocksIndex] ? stocks[modalData.stocksIndex].message: ''" > </span>
                                        </div>
                                    </div>
                                </div>

                                <div class=" col-6 mb-3 mb-md-0" x-show="selectUom">
                                    <div class="row align-items-start">
                                        <div class="col-12 fs-6 fw-bold fw-bold text-gray-800">

                                            {{__('fieldservice::activity.uom')}}
                                        </div>
                                        <div class="col-12">
                                            <select x-html="modalData.options" x-ref="uomSelect" x-model="modalData.uom_id" class="fs-5 form-select form-select-sm  border-left-0 border-right-0 border-top-0 rounded-0 "
                                            x-init="
                                                $nextTick(() => {
                                                    initSelect2();
                                                });
                                                $watch('modalData.uom_id',()=>{
                                                   $($el).trigger('change');
                                                })
                                            " data-hide-search="true" >

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-10">
                                    <label for="" class="form-label">Default input style</label>
                                    <input class="form-control" x-show="enableBackDate" x-ref="flatpicker" x-init="$nextTick(()=>{
                                        initFlatPicker();
                                    })" placeholder="Pick a date" id="kt_datepicker_1"/>
                                </div>
                            </div>
                            <div class="mt-5">
                                <div class=" col-12 mb-2 mb-md-0">
                                    <div class="row align-items-center mb-5">
                                        <div class="w-auto fs-6 fw-bold text-gray-800">
                                          Total  Price :
                                        </div>
                                        <div class="w-auto col-12 col-lg-8 fs-5 fw-bold">
                                            <span x-text="modalData.subtotal" ></span> ks
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </template>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" x-show="!isUseCart" class="btn btn-sm btn-primary" :class="channelData.current=='sale' ? 'btn-primary' : 'btn-success' "
                         x-text="channelData.current=='sale' ? saveSaleText : saveSamplingText  " @click="save"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Container-->


</div>

<script>
 window.addEventListener('load', function () {
            // Hide the loading page when the website is loaded
        var loadingPage = document.getElementById('loading-page');
        loadingPage.style.display = 'none';
    });
</script>
@endsection

@push('scripts')
<script>
    let campaign=@json($campaign);
    let campaignId="{{$campaign->id }}";
    var game_id=campaign.game_id ;
    var saleLocation={{$saleLocation}};
    var samplingLocation={{$samplingLocation}};
    var save_sale_items="{{__('fieldservice::activity.save_sale_items')}}";
    var save_sample_items="{{__('fieldservice::activity.save_sample_items')}}";
    var saving="{{__('fieldservice::activity.saving')}}";
</script>
<script src="{{ asset('customJs/debounce.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/js-confetti@latest/dist/js-confetti.browser.js"></script>


<script src="{{asset('assets/spinwheel/js/jquery.superwheel.min.js')}}"></script>
<script src="{{asset('/modules/fieldservice/js/main.js')}}"></script>

<script>

    var modal = new bootstrap.Modal($('#modal'));
    let prevScrollPos=40000;
    let page=1;
    let lastPage=100;
    let campaign_id=campaign.id;
    let producturi='{{route('campaign.getProduct')}}';
    let location_id=$('#location_id').val();
    let isUseCart="{{$isUseCart}}";
    let selectUom="{{$selectUom}}";
    let selectPkg="{{$selectPkg}}";
    let enableBackDate="{{$enableBackDate}}";
    let activity_pos_layout="{{$activity_pos_layout}}";
    function cards(){
        const jsDate = new Date();

        // Format the date in MySQL datetime format
        const mysqlDatetime = jsDate.toISOString().slice(0, 19).replace('T', ' ');
        return{
            viewTypes:['card','list'],
            currentView:'list',
            carts:[],
            stocks:[],
            search:'',
            selectUom,
            selectPkg,
            subtotal:0,
            products:[],
            modalData:{},
            sold_at:mysqlDatetime,
            saving:saving,
            isRemoveing:false,
            pageLoading:false,
            selectedProduct:[],
            saveSaleText:save_sale_items,
            saveSamplingText:save_sample_items,
            isUseCart:isUseCart !='false' ? true:false,
            enableBackDate:enableBackDate !='false' ? true:false,
            businessLocationId:{{$samplingLocation ?? '0'}},
            categoryId:null,
            submitBtn:{
                text:'Save',
                disable:false,
            },
            ui:{
                'productsDrawer': false
            },
            channelData:{
            current:'sample',
            saleText:'Click to Sampling',
            sampleText:'Click to Sale',
            },
            changeView(viewType="card"){
                this.currentView =viewType;
                this.reFetch();
                console.log(this.currentView);

            },
            getCurrentDateTime(){
                return jsDate.toISOString().slice(0, 19).replace('T', ' ');
            },
             getCurrentDateTimeInMySQLFormat() {
                // Create a new Date object
                const currentDate = new Date();

                // Get date components
                const year = currentDate.getFullYear();
                const month = String(currentDate.getMonth() + 1).padStart(2, '0');
                const day = String(currentDate.getDate()).padStart(2, '0');

                // Get time components
                const hours = String(currentDate.getHours()).padStart(2, '0');
                const minutes = String(currentDate.getMinutes()).padStart(2, '0');
                const seconds = String(currentDate.getSeconds()).padStart(2, '0');

                // Concatenate date and time in MySQL datetime format
                const mysqlDateTime = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;

                return mysqlDateTime;
                },
            cal_subtotal(){
                let sale_amount=0;
                this.carts.forEach(cart=>sale_amount+=cart.uom_price * cart.quantity);
                this.subtotal=sale_amount;
            },
            openDrawer(channel,categoryId=null){
                this.ui.productsDrawer=true;
                console.log(categoryId,'categoryId');
                this.switchChannel(channel,categoryId);
            },
            closeDrawer(){
                this.ui.productsDrawer=false;
            },
            switchChannel(channel,categoryId=null){
                if(this.carts.length>0 && this.isUseCart){
                    Swal.fire({
                        title:"Are You Sure To Leave.",
                        text:'Products are exists in the Cart.',
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#f1416c',
                        confirmButtonText: 'Save & Switch Channel',
                        cancelButtonText: 'Switch Channel',
                        customClass: {
                            confirmButton: "btn btn-sm btn-primary",
                            cancelButton: "btn btn-sm btn-danger"
                        }
                    }).then((result)=>{
                        if(!result.value){
                            this.channelData.current=channel;
                            if(channel=='sale'){
                                this.businessLocationId=saleLocation;
                                this.categoryId=null;
                            }else if(channel=='foc'){
                                this.businessLocationId=null;
                                this.categoryId=categoryId;
                            }
                            else{
                                this.businessLocationId=samplingLocation;
                                this.categoryId=null;
                            }

                            this.carts=[];
                            this.stocks=[];
                            this.modalData={};
                            this.reFetch();
                        };
                    });
                }else{
                    this.channelData.current=channel;
                    if(channel=='sale'){
                        this.businessLocationId=saleLocation;
                        this.categoryId=null;
                    }else if(channel=='foc'){
                        this.businessLocationId=null;
                        this.categoryId=categoryId;
                    }else{
                        this.businessLocationId=samplingLocation;
                        this.categoryId=null;
                    }

                    this.carts=[];
                    this.stocks=[];
                    this.modalData={};
                    this.reFetch();
                }
            },
            async addToCart(result){
                this.modalData={};
                let stocksIndex=await this.setStocks(result);
                if(result.stock_sum_current_quantity <= 0 && result.product_type=="storable"){
                    error('Product Out of stock');
                    return;
                }
                if(this.carts.length >=100){
                    error('Cart is Full.Please Save this 100 lines first')
                }else{
                    this.modalData={};
                    let cartProduct=await this.prepareCartData(result);
                    cartProduct.stocksIndex=stocksIndex ?? null;
                    this.carts=[...this.carts,cartProduct];
                    this.modalData=cartProduct;
                    modal.show();
                    this.updateSubtotal(cartProduct)
                }


            },
            showModal(data){
                this.modalData={};
                this.modalData=data;
                modal.show();
            },
            hideModal(){
                this.modalData={};
                modal.hide();
                // console.log(modal);
            },
            async setStocks(result){
                return new Promise((resolve)=>{
                    let variation_id=result.variation_id;
                    let index=this.stocks.findIndex((s)=>s.variation_id==variation_id);
                    if(index < 0){
                        this.stocks=[...this.stocks,{
                            'variation_id':variation_id,
                            'aviableQty':result.stock_sum_current_quantity,
                            'message':'',
                            'is_valid':true,
                        }];
                        resolve(this.stocks.length - 1);
                        return this.stocks.length - 1;
                    }else{
                        resolve(index);
                        return index;
                    }
                })
            },
            validateStocks(){
                console.log(this.stocks);
                let stockCheck=this.stocks.find((s)=>s.is_valid ==false);
                if(stockCheck){
                    this.submitBtn.text='Save';
                    this.submitBtn.disable=false;
                    return 'invalid';
                }else{
                    return 'valid';
                }
            },
            checkStock(cart){
                return new Promise((resolve, reject)=>{
                    let currentStock=0;
                    if(this.stocks[cart.stocksIndex]){
                        let avaiQty=this.stocks[cart.stocksIndex].aviableQty;
                        this.carts.forEach((c)=>{
                            if(c.variation_id == cart.variation_id && c.type=='storable'){
                                let data= changeQtyOnUom(c.uom_id,c.ref_uom.id,c.quantity,c.uoms);
                                currentStock+=data;
                            }
                        })
                        if(currentStock > avaiQty){
                            this.stocks[cart.stocksIndex].message='* out of stock';
                            this.stocks[cart.stocksIndex].is_valid=false;
                        }else{
                            this.stocks[cart.stocksIndex].message=''
                            this.stocks[cart.stocksIndex].is_valid=true;
                        }
                        currentStock=0;
                    }
                    resolve(currentStock);
                })
            },

            updateSubtotal(cart){
                let subtotal=cart.uom_price*cart.quantity;
                cart.subtotal=subtotal;
                cart.subtotal_with_discount=subtotal;
                cart.subtotal_with_tax=subtotal;
                this.cal_subtotal();
            },
            async prepareCartData(result){
                let uoms=result.product.uom.unit_category.uom_by_category;
                let pkgs=result.product.product_variations.packaging;
                let refUom=uoms.find((uoms) => uoms.unit_type =='reference');
                let aviableQty=0;
                if(result.product_type =='storable'){
                    aviableQty=changeQtyOnUom(refUom.id,result.uom_id,result.stock_sum_current_quantity,uoms)
                }else if(result.product_type=="consumeable"){
                    let res=await this.romAviableQtyCheck(this.businessLocationId,result.product_id);
                    aviableQty=changeQtyOnUom(refUom.id,result.uom_id,res,uoms);
                    if(aviableQty <=0){
                        error('Out of Stock');
                    return;
                    }
                }else{
                    aviableQty=0;
                }
                return {
                    'id':result.id,
                    'image':result.image,
                    'name':result.name,
                    'sku':result.variation_sku,
                    'quantity':1,
                    'product_id': result.product_id,
                    'type':result.product_type,
                    'variation_id': result.variation_id,
                    'uom_id': result.uom_id,
                    'uoms':uoms,
                    'uom_price': result.default_selling_price ?? 0,
                    'subtotal': result.default_selling_price ?? 0,
                    'discount_type': 'fixed',
                    'per_item_discount': 0,
                    'subtotal_with_discount': result.default_selling_price ?? 0,
                    'currency_id': 1,
                    'price_list_id':1,
                    'tax_amount':0,
                    'per_item_tax': 0,
                    'subtotal_with_tax': result.default_selling_price ?? 0,
                    'note': '',
                    'messsage':'',
                    'uom':result.product.uom,
                    'ref_uom':refUom,
                    'packaging_id':null,
                    'packaging_quantity':0,
                    'packagings':pkgs,
                    'aviableQty':Number(aviableQty),
                    'options':this.uomOption(uoms,result.uom_id),
                    'pkgOptions':this.packagingOption(pkgs),
                };
            },
            uomOption(uoms,def) {
                let uomOption='';
                uoms.forEach((uom)=>{
                    uomOption+=`<option value="${uom.id}" ${uom.id== def ? 'selected' : ''}>${uom.short_name}</option>`;
                });
                return uomOption;
            },
            packagingOption(pkgs,def){
                let pkgOption='<option disabled selected>Select Packaging</option>';
                pkgs.forEach((pkg)=>{
                    pkgOption+=`<option value="${pkg.id}" ${pkg.id== def ? 'selected' : ''}>${pkg.packaging_name}</option>`;
                });
                return pkgOption;
            },
            removeFromCart(index){
                isRemoveing=true;
                let data=this.carts[index];
                this.modalData={};
                this.carts.splice(index,1);
                this.checkStock(data);
            },

            data(){
                let sale_amount=0;
                this.carts.forEach(cart=>sale_amount+=cart.uom_price * cart.quantity);
                sold_at=enableBackDate=='false' ? this.getCurrentDateTimeInMySQLFormat() :this.sold_at;
                return {
                    'sale_details':this.carts,
                    'campaign_id':campaign_id,
                    'type':'campaign',
                    'business_location_id':this.businessLocationId,
                    'contact_id':3,
                    'status':'delivered',
                    'sale_amount':sale_amount,
                    'total_item_discount':0,
                    'totalItemDiscount': 0,
                    'extraDiscountType': 'fixed',
                    'extraDiscountAmount': 0,
                    'total_sale_amount': sale_amount,
                    'paid_amount': sale_amount,
                    'paymentStatus': 'paid',
                    'balanceAmount': 0.0,
                    'currencyId': 1,
                    'channel_id':campaign_id,
                    'sold_at':sold_at,
                }
            },
            async save(){
                if(this.carts.length<=0){
                    Swal.fire({
                        title:"Need to Add product to Save.",
                        icon: "error",
                        customClass: {
                            confirmButton: "btn btn-sm btn-primary"
                        }
                    });
                };
                this.submitBtn.text='Saving....';
                this.submitBtn.disable=true;


                if(!this.isUseCart){
                    this.saveSaleText=this.saving;
                    this.saveSamplingText=this.saving;
                }
                let stockCheck=this.validateStocks();
                if(stockCheck == 'invalid'){
                    Swal.fire({
                        title:"Product Out of stock!.",
                        icon: "error",
                        customClass: {
                            confirmButton: "btn btn-sm btn-primary"
                        }
                    })
                    return;
                }
                let submitBtn=this.submitBtn;
                let data=await this.data();
                this.subtotal=0;
                $.ajax({
                    url: `/sell/create`,
                    type: 'POST',
                    data: data,
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    error:function(response){
                        submitBtn.text='Save';
                        submitBtn.disable=false;
                        if(response.status=='401'){
                            error('Permission Denined');
                        }else if(response.status !=200){
                            console.log(response,'sdf');
                            error(response)
                        }
                        if(!this.isUseCart){
                            this.saveSaleText=save_sale_items;
                            this.saveSamplingText=save_sample_items;
                        }
                    },
                    success: (response)=>{
                        let quantity = Math.floor(data.sale_details[0].quantity ?? 0);
                        if(!this.isUseCart){
                            this.hideModal();
                            this.saveSaleText=save_sale_items;
                            this.saveSamplingText=save_sample_items;
                        }
                        this.submitBtn.text='Save';
                        this.submitBtn.disable=false;

                        if(response.status!=200){
                            error(response.message);
                        }else{
                            this.carts=[];
                            this.stocks=[];
                            let channel= this.channelData.current;
                            if(channel=='sale'){
                                Swal.fire({
                                    title:"Successfully Created.",
                                    icon: "success",
                                    html:`
                                        <h4 class="mt-3">game ကစားခွင့် <b class="text-primary">( ${quantity} )</b> ကြိမ်ရရှိပါသည်။</h4>
                                    `,
                                    showCancelButton: true,
                                    buttonsStyling: false,
                                    confirmButtonText: `
                                    {{__('fieldservice::actions.play_game')}}
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        ${quantity}
                                        <span class="visually-hidden">unread messages</span>
                                    </span>`,
                                    cancelButtonText: "{{__('fieldservice::actions.cancle')}}",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary position-relative",
                                        cancelButton: "btn fw-bold btn-secondary"
                                    }
                                }).then(function (result) {
                                    if(result.isConfirmed){
                                        window.location.href=`/game/spinwheel/${campaign.game_id}/play/${response.data}/${campaignId}`
                                    }
                                })
                            }else{

                                Swal.fire({
                                    title:"Successfully Created.",
                                    icon: "success",
                                    customClass: {
                                        confirmButton: "btn btn-sm btn-primary"
                                    }
                                }).then(()=>{
                                })
                            }
                            this.fetchProduct(true);
                        }
                        $('.cardToggle').toggle();
                    }
                })

            },

            fetchProduct(init=true){
                this.fetching(init);
                this.$watch('search', ()=>{
                    if(this.search.trim().length >2 || this.search.trim()==''){
                        this.reFetch();
                    }
                })

            },
            reFetch(){
                page=1;
                lastPage=100;
                this.products=[];
                this.pageLoading=false;
                this.fetching(true);
            },
            fetching(init=true){
                console.log(this.categoryId,'this.categoryId');
               let query=this.search.trim() ?? null;
                if(!this.pageLoading && page<=lastPage){
                    this.pageLoading=true;
                    $.ajax({
                        url: `${producturi}?page=${page}`,
                        type: 'GET',
                        data: {
                            'query':query,
                            'businessLocationId':this.businessLocationId,
                            'categoryId':this.categoryId,
                        },
                        headers:{
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        error:function(response){
                            error(response.message);
                        },
                        success: (result)=>{
                            if(init){
                                this.products=result.data;
                            }else{
                                this.products=[...this.products,...result.data];
                            }
                            lastPage=result.last_page;
                            this.pageLoading=false;
                        }
                    })
                }else{
                    this.pageLoading=false;
                }
            },

            decrease(cart){
                let qty=cart.quantity;
                if(qty >1){
                    cart.quantity=qty-1;
                }
                this.updatePkgQtyByQty();
            },
            increase(cart){
                cart.quantity++;
                this.updatePkgQtyByQty();

            },
            pkgDecrease(data){
                let qty=data.packaging_quantity;
                if(qty >1){
                    data.packaging_quantity=qty-1;
                    this.updateQtyByPkgQty();
                    this.checkStock(data);
                }
            },
            pkgIncrease(data){
                data.packaging_quantity++;
                this.updateQtyByPkgQty();
                this.checkStock(data);
            },

            loadMore() {
                const bottomDiv = document.querySelector('.bottomDiv');
                const scrollableDiv = document.querySelector('.scrollableDiv');
                if (
                    bottomDiv &&
                    scrollableDiv &&
                    bottomDiv.getBoundingClientRect().top <= scrollableDiv.getBoundingClientRect().bottom &&
                    prevScrollPos > bottomDiv.getBoundingClientRect().top
                ) {
                    page++;

                    this.pageLoading=false;
                    this.fetchProduct(false);
                }
                prevScrollPos=bottomDiv.getBoundingClientRect().top;
            },
            uomchange(event,i){
                alert(event.target.value,i);
            },

            initSelect2() {
                const selectElement = $(this.$refs.uomSelect); // Use this.$refs.uomSelect
                selectElement.select2().on('change', (e) => {
                    prevValue=this.modalData.uom_id;
                    value=e.target.value;
                    this.updateSubtotal(this.modalData);
                    if(this.modalData.type=='storable'){
                        let data= changeQtyOnUom(prevValue,value,this.modalData.aviableQty,this.modalData.uoms);
                        this.modalData.aviableQty=data;
                        this.modalData.uom=this.modalData.uoms.find((uom)=>uom.id==value);
                        this.checkStock(this.modalData);
                    }
                    this.modalData.uom_id = value;
                    this.updatePkgQtyByQty(e);
                });
            },
            initFlatPicker(){
                const selectElement = $(this.$refs.flatpicker); // Use this.$refs.uomSelect
                selectElement.flatpickr({
                    onChange:(selectedDates,dateStr,timestr)=>{
                        this.sold_at=dateStr;
                    }
                });
            },
            initPkgSelect2(){
                const selectElement = $(this.$refs.pkgSelect); // Use this.$refs.uomSelect
                console.log(this.modalData);
                // selectElement.val(result.product_variations.packaging[0].id).trigger('change');
                selectElement.select2()
                .on('change', (e) => {
                    let  value=e.target.value;
                    if(value){
                        let pkg=this.modalData.packagings.find((pkg)=>pkg.id==value);
                        this.modalData.packaging_id=value;
                        this.modalData.uom_id = pkg.uom_id;
                        this.modalData.uom = pkg.uom;
                        this.modalData.quantity = Math.floor(pkg.quantity);
                        this.modalData.packaging_quantity = 1;
                    }else{
                        this.modalData.packaging_id=null;
                    }
                });
                if(this.modalData.packagings[0]){
                    selectElement.val(this.modalData.packagings[0].id).trigger('change');
                }
            },
            updateQtyByPkgQty(){
                value=this.modalData.packaging_quantity;
                let pkgId=this.modalData.packaging_id;
                let pkg=this.modalData.packagings.find((pkg)=>pkg.id==pkgId);
                let totalQty=value* pkg.quantity;
                let result=changeQtyOnUom(pkg.uom_id,this.modalData.uom_id,totalQty,this.modalData.uoms);
                this.modalData.quantity =result;
            },
            updatePkgQtyByQty(){
                value=this.modalData.quantity;
                let pkgId=this.modalData.packaging_id;
                if(pkgId){
                    let pkg=this.modalData.packagings.find((pkg)=>pkg.id==pkgId);
                    let Qty=changeQtyOnUom(this.modalData.uom_id,pkg.uom_id,value,this.modalData.uoms);
                    result = Qty/pkg.quantity;
                    this.modalData.packaging_quantity =result;
                }
            },
            getPkgText(cart){
               let pkg= cart.packagings.find((pkg)=>pkg.id==cart.packaging_id);
               return pkg ? pkg.packaging_name :'';
            },
            romAviableQtyCheck(locationId,productId){
                return new Promise((resolve, reject)=>{
                    $.ajax({
                        url: `/sell/rom/aviable/qty/check`,
                        data:{
                            locationId,productId
                        },
                        type: 'GET',
                        error:function(e){
                            status=e.status;
                            if(status==405){
                                warning('Method Not Allow!');
                            }else if(status==419){
                                error('Session Expired')
                            }else{
                                console.log(' Something Went Wrong! Error Status: '+status )
                            };
                            resolve(0);
                        },
                        success: function(results){
                            console.log(results,'dssfffffffs');
                             resolve(results);
                        }
                    })
                })

            }
        }
    }
        function changeQtyOnUom(currentUomId, newUomId, currentQty,uoms) {
            let newUomInfo = uoms.find((uomItem) => uomItem.id == newUomId);
            let currentUomInfo = uoms.find((uomItem) => uomItem.id == currentUomId);
            let refUomInfo = uoms.find((uomItem) => uomItem.unit_type =="reference");
            let currentRefQty = isNullOrNan(getReferenceUomInfoByCurrentUomQty(currentQty,currentUomInfo,refUomInfo).qtyByReferenceUom);
            let currentUomType = currentUomInfo.unit_type;
            let newUomType = newUomInfo.unit_type;
            let newUomRounded = newUomInfo.rounded_amount || 1;
            let newUomValue=newUomInfo.value;
            let currentUomValue=currentUomInfo.value;
            let resultQty;
            let resultPrice;

            if ( newUomType == 'bigger') {
                resultQty = currentRefQty / newUomInfo.value;
            } else if (newUomType == 'smaller') {
                resultQty = currentRefQty * newUomInfo.value;
            } else {
                resultQty = currentRefQty;
            }
            return resultQty;
        }

        function getReferenceUomInfoByCurrentUomQty(qty, currentUom, referenceUom) {
            const currentUomType = currentUom.unit_type;
            const currentUomValue = currentUom.value;
            const referenceUomId = referenceUom.id;
            const referenceRoundedAmount = isNullOrNan(referenceUom.rounded_amount,4) ;
            const referenceValue = referenceUom.value;

            let result;
            if (currentUomType === 'reference') {
                result = qty * referenceValue;
            } else if (currentUomType === 'bigger') {
                result = qty * currentUomValue;
            } else if (currentUomType === 'smaller') {
                result = qty / currentUomValue;
            } else {
                result = qty;
            }
            let roundedResult=result;
            return {
                qtyByReferenceUom: roundedResult,
                referenceUomId: referenceUomId
            };
        }

</script>
<script>


    $('input').off('focus').on('focus', function() {
        // Select the text in the input field
        $(this).select();
    });


    $('.cartDiv').click(()=>{
        $('.cardToggle').toggle();
    })



    let searchNewRow = (index, productId, productType, variation_id = null, name, countOrSku, variNameOrSelectAll, unit, css_class) => {
        return `
            <li data-productId="${productId}" data-index="${index}" data-productType="${productType}" data-variation_id="${variation_id}" id="searchItem" class="list-group-item bg-light cursor-pointer pos-product-search bg-hover-secondary p-3 ${css_class}" id="searchItem">
                <h4 class="fs-6 ps-7 pt-3 me-4 ${css_class}">
                    ${name} - (${countOrSku}) ${variNameOrSelectAll}
                </h4>
                <p class="ps-7 pt-1 ${css_class}">${unit} </p>
            </li>
        `;
    }


</script>
@endpush
