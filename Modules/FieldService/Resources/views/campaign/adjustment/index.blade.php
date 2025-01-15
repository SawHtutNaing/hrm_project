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

<style>
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
<h1 class="text-dark fw-bold my-0 fs-2">Adjustment</h1>
<!--end::Heading-->
<!--begin::Breadcrumb-->
<ul class="breadcrumb fw-semibold fs-base my-1">
    <li class="breadcrumb-item text-muted">Daily </li>
    {{-- <li class="breadcrumb-item text-muted">
        <a href="" class="text-muted text-hover-primary">Crate</a>
    </li> --}}
    <li class="breadcrumb-item text-dark">Adjustment </li>
</ul>
<!--end::Breadcrumb-->
@endsection

@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content" style="height: 80vh;overflow: hidden;">
    <!--begin::Container-->
    <div class="container-xxl h-100 position-relative" id="location" >
        <div class="w-100 text-center">
            <h5 class="fw-bold">{{__('fieldservice::activity.stocks')}}</h5>
        </div>
        <div class="row mb-2 justify-content-start align-items-center">
            <a href="{{ route('campaign.ptx',$campaign_id) }}" class="w-auto  btn btn-secondary fs-5 btn-sm  mb-2">
                <i class="fa-solid fa-angle-left fs-5 pe-1"></i> Back
            </a>
        </div>
        <div class="row  h-100 " x-data="data()" x-init="fetchProduct();">
            <div class="col-12 pb-10 scrollableDiv" style="height: 90%; overflow-x: scroll;">
                <div class="row position-relative top-0 z-index-2">
                    {{-- <div class="row p-0"> --}}
                        <div class=" col-12 mb-3 position-sticky top-0  z-50" style="z-index: 99">
                            <div class="input-group  p-0 w-100">
                                <span class="input-group-text"><i class="fa-solid fa-search"></i></span>
                                <input type="search" class="form-control rounded-start-0 form-control rounded" id="product_search"
                                    name="product_search" placeholder="Search Product" data-kt-date-filter="date"
                                    data-allow-clear="true"  x-model.debounce.500ms="query" x-init="initFun" >
                                <div class="col-12">
                                    <div class="quick-search-results overflow-scroll rounded-1 p-3 position-absolute d-none card col-12 mt-5  card  autocomplete shadow"
                                        id="autocomplete" data-allow-clear="true"
                                        style="max-height: 300px;z-index: 100;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    {{-- </div> --}}
                    <template x-for="product in products">
                        <div class="col-12 col-md-6 col-lg-4 mb-3" @click="showModal(product);">
                            <div class="card">
                                <div class="card-body p-5">
                                    <div class="user-select-none cursor-pointer">
                                        <div class="fw-bold">
                                            <div class="row justify-content-betweeen align-items-center">
                                                <div class="col-12 d-flex flex-nowrap">
                                                    <div class="symbol symbol-75px me-3 w-auto">
                                                        <img x-show="!product.image" src="{{asset('assets/media/svg/files/blank-image.svg')}}"
                                                            class="rounded-3 theme-light-show mb-4 w-75px h-75px w-xxl-100px h-xxl-100px" alt="" />
                                                        <img x-show="!product.image" src="{{asset('assets/media/svg/files/blank-image-dark.svg')}}"
                                                            class="rounded-3 theme-dark-show mb-4 w-75px h-75px w-xxl-100px h-xxl-100px" alt="" />
                                                        <img x-show="product.image" :src=`/storage/product-image/${product.image}`
                                                            class="rounded-3 mb-4 w-75px h-75px w-xxl-100px h-xxl-100px" alt="" />
                                                    </div>
                                                    <div class="w-auto ms-1">
                                                        <div class="">
                                                            <span class="inline-block text-gray-800 fs-6" x-text="product.name">Alcohol 300ml (white rum)</span><br>
                                                            <span class="inline-block text-gray-500 fs-md-8 fs-5">SKU : <span class=" user-select-all"
                                                                    x-text="product.sku">4545</span></span>
                                                        </div>
                                                        <div class=" mt-1">
                                                            <span class="inline-block text-gray-800 fs-6" x-text="(product.aviableQty ?? 0)"></span>
                                                            <span class="inline-block text-gray-800 fs-6" x-text="product.uom.short_name "></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row justify-content-betweeen align-items-center">
                                                <div class="col-6">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                    <div class="loading row" x-show="productLoading">
                        <div class="col-12 col-md-6 mb-3">
                            <div class="card">
                                <div class="card-body p-5">
                                    <div class="user-select-none cursor-pointer">
                                        <div class="fw-bold">
                                            <div class="row justify-content-betweeen align-items-center">
                                                <div class="col-6 placeholder-glow">
                                                    <span class="inline-block text-gray-800 placeholder" >Alcohol 300ml (white
                                                        rum)</span>
                                                </div>
                                            </div>

                                            <div class="row justify-content-betweeen align-items-center">
                                                <div class="col-6 placeholder-glow">
                                                    <div class="col-6 placeholder"></div>
                                                </div>
                                                <div class="col-6 text-end placeholder-glow">
                                                    <div class="inline-block text-gray-700 fs-md-8 fs-5 placeholder">
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
                                                    <span class="inline-block text-gray-800 placeholder" >Alcohol 300ml (white
                                                        rum)</span>
                                                </div>
                                            </div>

                                            <div class="row justify-content-betweeen align-items-center">
                                                <div class="col-6 placeholder-glow">
                                                    <div class="col-6 placeholder"></div>
                                                </div>
                                                <div class="col-6 text-end placeholder-glow">
                                                    <div class="inline-block text-gray-700 fs-md-8 fs-5 placeholder">
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
            <div class="row position-absolute bottom-0 start-0 end-0">
                <ul class="pagination pagination-outline">
                    <li class="page-item next" x-show="pages.length > 1">
                        <a class="page-link page-text" href="#" @click.prevent="firstPage()">First</span></a>
                    </li>
                    <li class="page-item previous  "><a href="#" class="page-link" @click.prevent="previousPage()"><i class="previous"></i></a></li>
                    <template x-for="page in pages" :key="page">
                        <li class="page-item" :class="{ 'active': currentPage === page }">
                            <a href="#" class="page-link" @click.prevent="changePage(page)" x-text="page">

                            </a>
                        </li>
                    </template>
                    <li class="page-item next"><a href="#" class="page-link" @click.prevent="nextPage()"><i class="next"></i></a></li>
                    <li class="page-item next" x-show="pages.length > 1">
                        <a class="page-link page-text" href="#" @click.prevent="lastPage()" >Last</span></a>
                    </li>
                </ul>
            </div>



            <div class="modal fade " tabindex="-1" id="modal">
                <div class="modal-dialog w-md-600px modal-dialog-centered modal-dialog-scrollable">

                    <div class="modal-content mb-20">
                        <template x-if="modalData.name">
                            <div class="modal-body" >
                                <div class="row justify-content-start align-items-center">

                                    <div class="symbol symbol-65px symbol-md-100px me-1 w-auto">
                                        <div class="symbol-label theme-light-show" x-show="!modalData.image"
                                            style="background-image:url({{asset('assets/media/svg/files/blank-image.svg')}});">
                                        </div>
                                        <div class="symbol-label theme-dark-show" x-show="!modalData.image"
                                            style="background-image:url({{asset('assets/media/svg/files/blank-image-dark.svg')}});">
                                        </div>
                                        <div class="symbol-label" x-show="modalData.image">
                                            <img x-show="modalData.image" :src=`/storage/product-image/${modalData.image}`
                                                class="w-100 rounded" alt="" />
                                        </div>
                                    </div>
                                    <div class="w-auto">
                                        <span x-text="modalData.name" class="fs-3"></span>
                                        <div class="text-gray-500 fw-semibold  fs-md-8 fs-5 col-12">
                                            SKU:<span x-text="modalData.sku" class=" "></span>
                                        </div>
                                        <div class="inline-block text-primary fs-md-8 fs-5" x-show="modalData.type=='storable'">
                                            {{-- <span x-text="modalData.aviableQty.toFixed(2)"></span> --}}
                                            <span x-text="modalData.uom.short_name"></span> available
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-5" x-show="modalData.packagings.length >0 ? true :false ">
                                    <div class="col-12 col-md-6 mb-3 mb-md-0">
                                        <div class="row align-items-start">
                                            <div class="col-12 fs-md-8 fs-5 fw-bold text-gray-700">
                                                Packaging Qty
                                            </div>
                                            <div class="col-12">
                                                <input
                                                    class="form-control form-control-sm border-left-0 border-right-0 border-top-0 rounded-0"
                                                    x-model="modalData.packaging_quantity"
                                                     x-init="$watch('modalData.packaging_quantity',(val)=>{
                                                            {{-- updateSubtotal(modalData) --}}
                                                        })" @input="updateQtyByPkgQty(event)" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="row align-items-center">
                                            <div class="col-12 fs-md-8 fs-5 fw-bold text-gray-700">
                                                Packaging
                                            </div>
                                            <div class="col-12 fs-7 fw-bold text-gray-700">
                                                <select name="packaging" x-ref="pkgSelect" x-html="modalData.pkgOptions" data-placeholder="Select Package"
                                                    data-allow-clear="true" x-model="modalData.packaging_id" :id="$id('var')"
                                                    class=" form-select form-select-sm border-left-0 border-right-0 border-top-0 rounded-0"
                                                    x-init="
                                                            $nextTick(() => {
                                                                initPkgSelect2();
                                                            });
                                                        " id="">

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-8">
                                    <div class="col-12 col-md-6 mb-3 mb-md-0">
                                        <div class="row align-items-start mb-3">
                                            <div class="col-12 fs-md-8 fs-5 fw-bold text-gray-700 mb-3">
                                                Quantity
                                            </div>
                                            <div class="input-group inpDialer mb-5">
                                                <button class="btn btn-sm btn-icon btn-outline btn-active-color-danger decrease h-auto"
                                                    type="button" data-kt-dialer-control="decrease" @click="decrease();">
                                                    <i class="fa-solid fa-minus fs-2"></i>
                                                </button>
                                                <input type="text"
                                                    class="form-control form-control-sm quantity input_number form-control-sm h-10 fs-5"
                                                    placeholder="quantity" name="ds" data-kt-dialer-control="input"
                                                    x-model="modalData.aviableQty_for_update" @input="updatePkgQtyByQty()"/>
                                                <button class="btn btn-sm btn-icon btn-outline btn-active-color-primary increase h-auto"
                                                    type="button" data-kt-dialer-control="increase" @click="increase()">
                                                    <i class="fa-solid fa-plus fs-2"></i>
                                                </button>
                                            </div>
                                            {{-- stocksIndex --}}
                                            {{-- <div class="text-center">
                                                <span class="fs-9 text-danger"
                                                    x-text="stocks[modalData.stocksIndex] ? stocks[modalData.stocksIndex].message: ''">
                                                </span>
                                            </div> --}}
                                        </div>
                                    </div>

                                    <div class=" col-md-6 mb-3 mb-md-0">
                                        <div class="row align-items-start">
                                            <div class="col-12 fs-md-8 fs-5 fw-bold text-gray-700">
                                                UOM
                                            </div>
                                            <div class="col-12">
                                                <select x-html="modalData.options"
                                                x-ref="uomSelect" x-model="modalData.uom_for_update"
                                                    class="form-select form-select-sm  border-left-0 border-right-0 border-top-0 rounded-0 "
                                                    x-init="
                                                            $nextTick(() => {
                                                                initSelect2();
                                                            });
                                                            $watch('modalData.uom_id',()=>{
                                                                $($el).trigger('change');
                                                            })
                                                        " data-hide-search="true">

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-light" @click.prevent='closeModal' >Close</button>
                            <button type="button" class="btn btn-sm btn-primary" @click.prevent='saveChanges' x-text="saving ? 'Saving.....' : 'Save' " :disabled="saving">Save</button>
                        </div>
                    </div>
                </div>
            </div>




        </div>

    </div>
</div>


@endsection

@push('scripts')

<script>
    const location_id="{{$location_id ?? 0}}";
    const modal = new bootstrap.Modal($('#modal'));
    const data=()=>{
        return{
            currentPage:1,
            per_page:20,
            totalPages:1,
            query:null,
            products:[],
            modalData:{},
            cloneData:{},
            saving:false,
            productLoading:false,
            initFun(){
                this.$watch('query', ()=>{
                    console.log(this.query);
                    if(this.query.trim().length >1 || this.query.trim()==''){
                        this.productLoading=true;
                        this.products=[];
                        this.fetchProduct();
                    }
                })
            },
            async fetchProduct(){
                this.productLoading=true;
                await this.fetching(this.currentPage);
                this.productLoading=false;
            },
            async changePage(page){
                if(page <=this.totalPages ){
                    this.products=[];
                    this.productLoading=true;
                    await this.fetching(page);
                    this.productLoading=false;
                }
            },
            get pages() {
                const range = 1;
                const start = Math.max(1, this.currentPage - range);
                const end = Math.min(this.totalPages, this.currentPage + range);
                return Array.from({ length: end - start + 1 }, (_, i) => start + i);
            },
            async showModal(data){
                uoms=data.uoms;
                pkgs=data.packagings;
                this.modalData=data;
                this.cloneData={...data};
                this.modalData.pkgOptions = await this.packagingOption(pkgs);
                this.modalData.options=await this.uomOption(uoms,data.uom_id);
                modal.show();
            },
            increase(){
                this.modalData.aviableQty_for_update++;
                this.updatePkgQtyByQty();

            },
            decrease(){
                this.modalData.aviableQty_for_update--;
                this.updatePkgQtyByQty();
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

            initPkgSelect2(){
                const selectElement = $(this.$refs.pkgSelect).on('change',(e)=>{
                    let  value=e.target.value;
                    if(value){
                        let pkg=this.modalData.packagings.find((pkg)=>pkg.id==value);
                        this.modalData.packaging_id=value;
                        this.modalData.uom_id = pkg.uom_id;
                        this.modalData.uom = pkg.uom;
                        let pkgQty=this.modalData.packaging_quantity ?? 1;
                        let calQty=changeQtyOnUom(this.modalData.refUom.id,this.modalData.uom_for_update,pkg.quantity,this.modalData.uoms)
                        this.modalData.aviableQty_for_update =calQty * pkgQty;
                    }else{
                        this.modalData.packaging_id=null;
                    }
                }); // Use this.$refs.uomSelect
                selectElement.select2();
            },
            updateQtyByPkgQty(envent){
                value=event.target.value;
                let pkgId=this.modalData.packaging_id;
                if (pkgId) {
                    let pkg=this.modalData.packagings.find((pkg)=>pkg.id==pkgId);
                    let totalQty=value* pkg.quantity;
                    let result=changeQtyOnUom(this.modalData.refUom.id,this.modalData.uom_for_update,totalQty,this.modalData.uoms);
                    this.modalData.aviableQty_for_update =result;
                }
            },
            updatePkgQtyByQty(){
                value=this.modalData.aviableQty_for_update;
                let pkgId=this.modalData.packaging_id;
                if(pkgId){
                    let pkg=this.modalData.packagings.find((pkg)=>pkg.id==pkgId);
                    let result=changeQtyOnUom(this.modalData.uom_for_update,pkg.uom_id,value,this.modalData.uoms);
                    let totalQty=result / pkg.quantity;
                    this.modalData.packaging_quantity =totalQty;
                }
            },
            initSelect2() {
                const selectElement = $(this.$refs.uomSelect); // Use this.$refs.uomSelect
                selectElement.select2().on('change', (e) => {
                    value=e.target.value;
                    this.modalData.uom_for_update = value;
                    this.updatePkgQtyByQty();
                });
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
            async saveChanges(){
                this.saving=true;
                await this.save().then(()=>{
                    modal.hide();
                    this.modalData.aviableQty_for_update=this.modalData.aviableQty;
                    this.modalData.uom_for_update=this.modalData.uom_id;
                    success('SuccessFully Updated ');
                    this.modalData={};
                    this.cloneData={};
                }).catch(()=>{})
                this.saving=false;
            },
            closeModal(){
                modal.hide();
                this.modalData.aviableQty_for_update=this.modalData.aviableQty;
                this.modalData.uom_for_update=this.modalData.uom_id;
                this.modalData={};
                this.cloneData={};
            },
            save(){
                let data={
                    "business_location": location_id,
                    "variation_id": this.modalData.variation_id,
                    "gnd_quantity": this.modalData.aviableQty_for_update,
                    "uom_id": this.modalData.uom_for_update,
                    "packaging_quantity": this.modalData.packaging_id,
                    "packaging_id": this.modalData.packaging_quantity,
                };
                return new Promise((resolve, reject)=>{
                    $.ajax({
                        url: `/stock-adjustment/quick-store`,
                        type: 'POST',
                        headers:{
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data,
                        error:function(response){
                            error(response.message);
                            reject(response.message);
                        },
                        success: (result)=>{
                            console.log(result);
                            if(result.data.adjust_type !='no changes'){
                                let refUOm=this.modalData.refUom;
                                let uoms=this.modalData.uoms;
                                this.modalData.aviableQty=changeQtyOnUom(refUOm.id,this.modalData.uom_id,result.data.after_ground_quantity,uoms);
                            }
                            resolve(result);
                        }
                    })
                })
            },
            fetching(page){
                return new Promise((resolve, reject)=>{
                    $.ajax({
                        url: `/daily/adjust/${location_id}/get/product?page=${page}`,
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
                            console.log(result.data);
                            await this.reStructureData(result.data).then((data)=>{
                                this.products=data;
                                resolve(data);
                            });
                        }
                    })
                })
            },
            reStructureData(datas){
                return new Promise((resolve,reject)=>{
                    let resultData=[];
                    datas.forEach((data)=>{
                        let uoms=data.product.uom.unit_category.uom_by_category;
                        let refUom=getRefUom(uoms);
                        let aviableQty=changeQtyOnUom(refUom.id,data.uom_id,data.stock_sum_current_quantity,uoms);
                        let VariationName=data.variation_name ? ' ('+data.variation_name +') ' :'';
                        resultData.push({
                            'variation_name':data.variation_name,
                            'refUom':refUom,
                            'variation_id':data.variation_id,
                            'image':data.image,
                            'uoms':uoms,
                            'sku':data.sku,
                            'name':data.name + VariationName,
                            'packagings':data.product.product_variations.packaging,
                            'uom_id':data.product.uom_id,
                            'uom_for_update':data.product.uom_id,
                            'uom':data.product.uom,
                            'stock_sum_current_quantity':data.stock_sum_current_quantity,
                            'aviableQty':aviableQty,
                            'aviableQty_for_update':aviableQty,
                            "packaging_quantity": 1,
                            "packaging_id": null,
                        })
                    })
                    resolve(resultData);
                    return resultData;
                })
            },

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
