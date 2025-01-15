@extends('App.main.navBar')


@section('campaign_icon', 'active')
@section('campaign_show', 'active show')
@section('campaign_setting_active', 'active show')


@section('styles')
{{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}
<style>

</style>
@endsection


@section('title')
<!--begin::Heading-->
<h1 class="text-dark fw-bold my-0 fs-4">Field Service</h1>
<!--end::Heading-->
<!--begin::Breadcrumb-->
<ul class="breadcrumb fw-semibold fs-base my-1">
    <li class="breadcrumb-item text-muted">Settings</li>
    {{-- <li class="breadcrumb-item text-dark">Create</li> --}}
</ul>
<!--end::Breadcrumb-->
@endsection
@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container-xxl" id="kt_content_container">
        <div class="card card-flush h-xl-100">
            <!--begin::Card body-->
            <div class="card-body">
                <div class=" setting-tab " id="business_setting_sale" >
                    <!--begin::Heading-->
                    <div class="row fv-row row-cols flex-wrap">
                        <form id="form" action="{{route('fieldServiceSetting.store')}}" method="POST">
                            @csrf
                            <div class="col-md-12   col-lg-4">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input cursor-pointer" type="checkbox" name="isUseCart" value="true" role="switch"
                                        id="isUseCart" @checked($isUseCart=='true' )>
                                    <label class="form-check-label text-gray-800 fw-bold" for="isUseCart">Use Cart</label>
                                </div>

                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input cursor-pointer" type="checkbox" name="selectUom" value="true" role="switch"
                                        id="selectUom" @checked($selectUom=='true' )>
                                    <label class="form-check-label text-gray-800 fw-bold" for="selectUom">Use UOM</label>
                                </div>
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input cursor-pointer" type="checkbox" name="selectPkg" value="true" role="switch"
                                        id="selectPkg" @checked($selectPkg=='true' )>
                                    <label class="form-check-label text-gray-800 fw-bold" for="selectPkg">Use Pkg</label>
                                </div>


                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input cursor-pointer" type="checkbox" name="enableBackDate" value="true" role="switch"
                                        id="enableBackDate" @checked($enableBackDate=='true' )>
                                    <label class="form-check-label text-gray-800 fw-bold" for="enableBackDate">Enable Back Date</label>
                                </div>

                                <div class=" mb-3">
                                    <label class="form-label text-gray-800 fw-bold" for="foc_category">FOC Category :</label>
                                    <select name="focCategoryId" id="foc_category" data-kt-select2="true"  class="form-select form-select-sm" data-control="select2">
                                        <option disabled selected>Select Category</option>
                                        @foreach ($categories as $category)
                                            <option @selected($focCategoryId==$category['id']) value="{{$category['id']}}">{{$category['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class=" mb-3">
                                    <label class="form-label text-gray-800 fw-bold" for="activity_pos_layout">Activity POS Layout :</label>
                                    {{-- @dd($activity_pos_layout); --}}
                                    <select name="activity_pos_layout" id="activity_pos_layout" class="form-select form-select-sm" data-kt-select2="true" data-control="select2">
                                        <option value="default" @selected($activity_pos_layout=='default')>Default</option>
                                        <option value="win_brothers" @selected($activity_pos_layout=='win_brothers')>Win Brothers</option>
                                    </select>
                                </div>


                            </div>
                            <button type="submit" class="btn btn-primary btn-sm mt-5">Save Setting</button>
                        </form>
                    </div>

                </div>
            </div>
            <!--end::Card body-->
        </div>
    </div>
    <!--end::Container-->
</div>


@endsection

@push('scripts')

<script>
    // $(['data-kt-select2="true"']).select2();
</script>

@endpush






