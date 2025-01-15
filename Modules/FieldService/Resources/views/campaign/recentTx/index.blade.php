@extends('App.main.navBar')

@section('campaign_icon', 'active')
@section('campaign_show', 'active show')
@section('campaign_list_active', 'active')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/spinwheel/css/reset.css') }}">
{{--
<link rel="stylesheet" href="{{ public_path('modules/FieldService/css/style.css') }}"> --}}
<link rel="stylesheet" href="{{ asset('assets/spinwheel/css/superwheel.min.css') }}">
<!-- Alpine Plugins -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700&display=swap" rel="stylesheet">

<style>
    * {
        font-family: 'Roboto', sans-serif;
    }
    #custom {
        width: 0%;
        height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 10;
    }

    .card-responsive {
        height: 90%;
    }

    .actions {
        height: 10%;
    }

    .productCard:active {
        border: 2px solid #009cf784;
    }

    .customTooltip {
        position: absolute;
        top: -40px;
        left: 0px;
        right: 0px;
        background-color: white;
        border: 0.6px solid #0000001a;
        border-radius: 5px;
        width: auto;
        z-index: 500;
        display: none;
    }

    .tootltipCtrl:hover .customTooltip {
        display: block;
    }

    @media only screen and (max-width: 768px) {
        .card-responsive {
            height: 100%;
        }
    }

    .w-fit {
        width: fit-content;
    }
</style>
@endsection
@section('title')
<!--begin::Heading-->
<h1 class="text-dark fw-bold my-0 fs-2">Recent Transactions</h1>
<!--end::Heading-->
<!--begin::Breadcrumb-->
<ul class="breadcrumb fw-semibold fs-base my-1">
    <li class="breadcrumb-item text-muted">FieldService </li>
    {{-- <li class="breadcrumb-item text-muted">
        <a href="" class="text-muted text-hover-primary">Crate</a>
    </li> --}}
    <li class="breadcrumb-item text-muted">Recent </li>
    <li class="breadcrumb-item text-dark">Transaction </li>
</ul>
<!--end::Breadcrumb-->
@endsection

@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content" style="height: 80vh;overflow: hidden;">
    <!--begin::Container-->
    <div class="container-xxl h-100 position-relative" id="location">

        <div class="row mb-2 justify-content-start align-items-center">
            <a href="{{ route('campaign.ptx',$campaign_id) }}"
                class="w-auto btn btn-secondary btn-sm py-3 px-3 mb-2 fs-9">
                <i class="fa-solid fa-angle-left fs-5 pe-1"></i> {{__('fieldservice::actions.back')}}
            </a>
        </div>
        <div class="row  h-100 " x-data="data()" x-init="fetchDatas();">
            <div class="col-12 pb-10 scrollableDiv" style="height: 90%; overflow-x: scroll;">
                <div class="row position-sticky top-0 z-index-2">
                    <div class="row p-0">
                        <div class=" col-12 mb-3">
                            <div class="input-group p-0 w-100">
                                <input type="search" class="form-control form-control-sm rounded" id="product_search"
                                    name="product_search" placeholder="Search...." data-kt-date-filter="date"
                                    data-allow-clear="true" x-model.debounce.500ms="query" x-init="initFun">
                                {{-- <span class="input-group-text"> --}}
                                    <button
                                        class="btn btn-sm btn-primary input-group-text rounded rounded-start-0">search</button>
                                    {{-- </span> --}}
                                <div class="col-12">
                                    <div class="quick-search-results overflow-scroll rounded-1 p-3 position-absolute d-none card col-12 mt-5  card  autocomplete shadow"
                                        id="autocomplete" data-allow-clear="true"
                                        style="max-height: 300px;z-index: 100;">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="" x-show="(datas.length < 1 && !cardLoading)">
                            <div   class="col-12 h-100px text-center border-dotted border-gray-300 d-flex justify-content-center align-items-center rounded">
                                No Data Found!
                            </div>
                        </div>
                        <template x-for="data in datas">
                            <div class="col-12 col-md-6 col-lg-4 mb-3" >
                                <div class="card">
                                    <div class="card-body p-5">
                                        <div class="user-select-none ">
                                            <div class="fw-bold">
                                                <div class="row justify-content-betweeen align-items-center">
                                                    <div class="col-12 d-flex flex-nowrap">
                                                        <div class="col-12 ms-1">
                                                            {{-- <div class="">
                                                                <span class="inline-block text-gray-800 fs-md-6 fs-5 "
                                                                    x-text="data.sale_details[0].product.name">Alcohol 300ml (white
                                                                    rum)</span>
                                                                <div class=" text-gray-900 fs-8 mt-1">Date:
                                                                    <span class=" user-select-all" x-text="new Date(data.created_at).toLocaleString()">4545</span>
                                                                </div>
                                                            </div> --}}


                                                            <div class=" mt-5 row justify-content-between">
                                                                <div class="inline-block text-gray-900 fs-8 w-auto ">
                                                                    <span class="inline-block text-gray-800 fs-md-6 fs-5 "
                                                                    x-text="data.sale_details[0].product.name">Alcohol 300ml (white
                                                                    rum)</span>
                                                                </div>
                                                                <div class="inline-block text-gray-900 fs-8 w-auto">
                                                                    <span class=" user-select-all" x-text="new Date(data.created_at).toLocaleString()">4545</span>
                                                            </div>
                                                            <div class=" mt-5 row flex-column justify-content-between">
                                                                <div class="inline-block text-gray-900 fs-md-6 w-auto mb-3 ">
                                                                    <span class="text-gray-700">
                                                                        {{__('fieldservice::activity.quantity')}}:&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                                    <span class=" user-select-all" x-text="Math.floor(data.sale_details[0].quantity)"></span>
                                                                    <span class=" user-select-all" x-text="data.sale_details[0].uom.short_name"></span>
                                                                </div>
                                                                <div class="inline-block text-gray-900 fs-md-6 w-auto">
                                                                    <span class="text-gray-700"> {{__('fieldservice::activity.total_price')}}:&nbsp;&nbsp;</span>
                                                                    <span class=" user-select-all" x-text=" Math.floor(data.total_sale_amount)">4545</span>
                                                                    Ks
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer py-3 px-2 mt-3">
                                        <div class="">
                                            <a x-show=" data.winlog.length < data.sale_details[0].quantity " x-bind:href="`/game/spinwheel/${campaign.game_id}/play/${data.id}/${campaign_id}`"  class="btn btn-outline btn-outline-primary btn-sm fs-9 px-3 py-2 position-relative">
                                                {{__('fieldservice::actions.play_game')}}
                                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                    <span x-text="data.sale_details[0].quantity - data.winlog.length"></span>
                                                {{-- <span class="visually-hidden">unread messages</span> --}}
                                            </a>
                                            <a x-show="data.winlog && data.winlog.length >= data.sale_details[0].quantity  " href="#" x-bind:href="`/game/spinwheel/${campaign.game_id}/play/${data.id}/${campaign_id}`" class="btn btn-outline btn-outline-success btn-sm fs-9 px-3 py-2">
                                                {{__('fieldservice::actions.view_win_history')}}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <div class="loading row" x-show="cardLoading">
                            <div class="col-12 col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body p-5">
                                        <div class="user-select-none cursor-pointer">
                                            <div class="fw-bold">
                                                <div class="row justify-content-betweeen align-items-center">
                                                    <div class="col-6 placeholder-glow">
                                                        <span class="inline-block text-gray-800 placeholder">Alcohol
                                                            300ml (white
                                                            rum)</span>
                                                    </div>
                                                </div>

                                                <div class="row justify-content-betweeen align-items-center">
                                                    <div class="col-6 placeholder-glow">
                                                        <div class="col-6 placeholder"></div>
                                                    </div>
                                                    <div class="col-6 text-end placeholder-glow">
                                                        <div class="inline-block text-gray-600 fs-8 placeholder">
                                                            <span></span>
                                                            loading.....
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row justify-content-betweeen align-items-center">
                                                    <div class="col-12 placeholder-glow">
                                                        <div class="col-8 placeholder">

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body p-5">
                                        <div class="user-select-none cursor-pointer">
                                            <div class="fw-bold">
                                                <div class="row justify-content-betweeen align-items-center">
                                                    <div class="col-6 placeholder-glow">
                                                        <span class="inline-block text-gray-800 placeholder">Alcohol
                                                            300ml (white
                                                            rum)</span>
                                                    </div>
                                                </div>

                                                <div class="row justify-content-betweeen align-items-center">
                                                    <div class="col-6 placeholder-glow">
                                                        <div class="col-6 placeholder"></div>
                                                    </div>
                                                    <div class="col-6 text-end placeholder-glow">
                                                        <div class="inline-block text-gray-600 fs-8 placeholder">
                                                            <span></span>
                                                            loading.....
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row justify-content-betweeen align-items-center">
                                                    <div class="col-12 placeholder-glow">
                                                        <div class="col-8 placeholder">

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row position-absolute  start-0 end-0" style="bottom: -20px">
                    <ul class="pagination pagination-outline py-5" style="z-index: 9999;">
                        <li class="page-item next" x-show="pages.length > 1">
                            <a class="page-link page-text" href="#" @click.prevent="firstPage()">First</span></a>
                        </li>
                        <li class="page-item previous  ">
                            <a href="#" class="page-link"
                                @click.prevent="previousPage()">
                                <i class="previous"></i>
                            </a></li>
                        <template x-for="page in pages" :key="page">
                            <li class="page-item" :class="{ 'active': currentPage === page }">
                                <a href="#" class="page-link" @click.prevent="changePage(page)" x-text="page">

                                </a>
                            </li>
                        </template>
                        <li class="page-item next"><a href="#" class="page-link" @click.prevent="nextPage()"><i
                                    class="next"></i></a></li>
                        <li class="page-item next" x-show="pages.length > 1">
                            <a class="page-link page-text" href="#" @click.prevent="lastPage()">Last</span></a>
                        </li>
                    </ul>
                </div>
            </div>




        </div>

    </div>
</div>


@endsection

@push('scripts')

<script>
    const location_id="{{$location_id ?? 0}}";
    const campaign_id="{{$campaign_id ?? 0}}";
    const campaign=@json($campaign ?? []);
    const data=()=>{
        return{

            currentPage:1,
            per_page:20,
            totalPages:1,
            query:null,
            datas:[],
            modalData:{},
            cloneData:{},
            saving:false,
            cardLoading:false,
            initFun(){
                this.$watch('query', ()=>{
                    if(this.query.trim().length >1 || this.query.trim()==''){
                        this.cardLoading=true;
                        this.datas=[];
                        this.fetchDatas();
                    }
                })
            },
            async fetchDatas(){
                this.cardLoading=true;
                await this.fetching(this.currentPage);
                this.cardLoading=false;
            },
            async changePage(page){
                if(page <=this.totalPages ){
                    this.datas=[];
                    this.cardLoading=true;
                    await this.fetching(page);
                    this.cardLoading=false;
                }
            },
            get pages() {
                const range = 1;
                const start = Math.max(1, this.currentPage - range);
                const end = Math.min(this.totalPages, this.currentPage + range);
                return Array.from({ length: end - start + 1 }, (_, i) => start + i);
            },
            previousPage(){
                if(this.currentPage>1){
                    this.changePage(this.currentPage-1);
                }
            },
            nextPage(){
                this.changePage(this.currentPage+1);
            },
            lastPage(){
                this.currentPage=Math.floor(this.totalPages);
                this.changePage(this.currentPage);
            },
            firstPage(){
                this.currentPage=1;
                this.changePage(1);
            },
            fetching(page){
                return new Promise((resolve, reject)=>{
                    $.ajax({
                        url: `/campaign/${campaign_id}/get/${location_id}/recent/txs?page=${page}`,
                        type: 'GET',
                        headers:{
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data:{
                            query:this.query,
                        },
                        error:function(response){
                            error(response.message);
                            reject(response.message);
                        },
                        success:async (result)=>{
                            this.currentPage=result.current_page,
                            this.totalPages=result.total/result.per_page;
                            console.log(result,'==');
                            this.datas=result.data;
                            resolve(result.data);
                            // await this.reStructureData(result.data).then((data)=>{
                            //     resolve(data);
                            // });
                        }
                    })
                })
            },
            // reStructureData(datas){
            //     return new Promise((resolve,reject)=>{
            //         let resultData=[];
            //         datas.forEach((data)=>{
            //             let uoms=data.uom.unit_category.uom_by_category;
            //             let refUom=getRefUom(uoms);
            //             let aviableQty=changeQtyOnUom(refUom.id,data.uom_id,data.stock_sum_current_quantity,uoms);
            //             resultData.push({

            //                 'refUom':refUom,
            //                 'variation_id':data.variation_id,
            //                 'image':data.image,
            //                 'uoms':uoms,
            //                 'sku':data.sku,
            //                 'name':data.name,
            //                 'packagings':data.product_variations.packaging,
            //                 'uom_id':data.uom_id,
            //                 'uom_for_update':data.uom_id,
            //                 'uom':data.uom,
            //                 'stock_sum_current_quantity':data.stock_sum_current_quantity,
            //                 'aviableQty':aviableQty,
            //                 'aviableQty_for_update':aviableQty,
            //                 "packaging_quantity": 1,
            //                 "packaging_id": null,
            //             })
            //         })
            //         resolve(resultData);
            //         return resultData;
            //     })
            // },

        };
    }

    function getRefUom(uoms){
        return uoms.find(uom=>uom.unit_type=="reference");
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
        return roundToFourDecimal(resultQty);
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
    function roundToFourDecimal(number) {
        // Round the number to 4 decimal places
        let roundedNumber = number.toFixed(4);

        // Remove trailing zeros
        roundedNumber = roundedNumber.replace(/\.?0+$/, '');

        return roundedNumber;
    }

</script>

@endpush
