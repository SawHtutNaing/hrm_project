@extends('App.main.navBar')

@section('styles')
{{-- css file for this page --}}
@endsection


@section('campaign_icon', 'active')
@section('campaign_show', 'active show')
@section('campaign_import_active','active')


@section('title')
<!--begin::Heading-->
<h1 class="text-dark fw-bold my-0 fs-4">Import Campaigns</h1>
<!--end::Heading-->
<!--begin::Breadcrumb-->
<ul class="breadcrumb fw-semibold fs-base my-1">
    <li class="breadcrumb-item text-muted">Campaign</li>
    <li class="breadcrumb-item text-dark">Import</li>
</ul>
<!--end::Breadcrumb-->
@endsection
@section('content')
@if(session('failures'))
<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" tabindex="-1"
    id="error_modal">
    <div class="modal-dialog modal-dialog-scrollable mw-850px">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Error Found in excel</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-danger ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <div class="table-responsive table-striped">
                    <div class="table-body">
                        <table class="table table-row-dashed table-row-gray-300">
                            <thead>
                                <tr class="fw-bold fs-5 text-danger border-bottom border-gray-200">
                                    <th>Row No</th>
                                    <th>Reason</th>
                                    <th>Values</th>
                                </tr>
                            </thead>
                            <tbody style="max-height: 300px; overflow-y: auto;">
                                @foreach (session('failures') as $failure)
                                <tr>
                                    <td class="text-danger">{{ $failure->row() }}</td>
                                    <td class="text-danger">{{ implode(', ', $failure->errors()) }}</td>
                                    <td class="">
                                        Outlet Name : <span class="text-gray-700">{{ $failure->values()['outlet_name']
                                            }}</span><br>
                                        Campaign Name : <span class="text-gray-700">{{
                                            $failure->values()['campaign_name'] }}</span> <br>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endif
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Container-->
    <div class="container-xxl" id="kt_content_container">
        <!--begin::Main column-->
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
            @if (isset($errors) && $errors->any())
            <div>
                @foreach ($errors->all() as $error)
                <div class="alert alert-danger">
                    {{ $error }}
                </div>
                @endforeach
            </div>
            @endif
            @if(isset($errorMessage))
            <div class="alert alert-danger">
                {{ $errorMessage }}
            </div>
            @endif
            @if(session('error-swal'))
            <div class="alert alert-danger">
                {{ session('error-swal') }}
            </div>
            @endif
            <form id="importForm" action="{{ route('campaign.import') }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <div class="card card-flush py-4">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Import Campaigns</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row mb-5">
                            <div class="col-md-6 col-md-offset-3">
                                <div class="">
                                    <label class=" form-label" for="formFileSm">{{__('product/import-product.file_to_import') }}</label>

                                    <input class="form-control form-control-sm" id="formFileSm" type="file"
                                        name="importCampaign" />
                                    @error('import-products')

                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <button id="submitBtn" type="submit" class="btn btn-primary btn-sm me-10">
                                <span id="indicator-label">{{ __('product/import-product.submit') }}</span>
                                <span id="loadingSpinner" class="indicator-progress" style="display: none;">
                                    Products importing... <span
                                        class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                                <input type="hidden" value="0" id="checkBtn">
                            </button>
                        </div>

                        <div class="mt-5">
                            <a href="{{route('download.campaignExcelTemplate')}}"
                                class="btn btn-light-primary btn-sm">
                                <i class="fas fa-download"></i>{{ __('product/import-product.download_template_file') }}
                            </a>
                        </div>
                    </div>
                </div>
            </form>
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>{{ __('product/import-product.instructions') }}</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <strong>Follow the instructions carefully before importing the file.</strong>
                    <p class="mt-4">The columns of the file should be in the following order.</p>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped g-3">
                            <thead>
                                <tr class="fw-bold fs-6 text-gray-800">
                                    <th>Column Number</th>
                                    <th>Column Name</th>
                                    <th>Instruction</th>
                                </tr>
                            </thead>
                            @php
                            $Instructions = [
                                [
                                    'name' => 'Outlet Name',
                                    'is_req' => true,
                                    'instruction' => 'Name Of Outlet',
                                    'note'=>'Outlet Must be created'
                                ],
                                [
                                    'name' => 'Campaign Name',
                                    'is_req' => false,
                                    'instruction' => 'Name of the Campaign',
                                ],
                                [
                                    'name' => 'Game Template Name',
                                    'is_req' => false,
                                    'instruction' => "Name Of Game Tempalte. Eg: Game 1 ",
                                    'note'=>'Game Template Must be created'
                                ],
                                [
                                    'name' => 'Questionnaires',
                                    'is_req' => false,
                                    'instruction' => 'Question Form Name',
                                    'note'=>'Form Must Be Created',
                                ],

                                [
                                    'name' => 'Date',
                                    'is_req' => true,
                                    'instruction' => 'Date Range Of Campaign Eg: 1-1-2024/20-2-2024',
                                ],
                                [
                                    'name' => 'Campaign Leader',
                                    'is_req' => true,
                                    'instruction' => 'Username of leader Eg: johndoe',
                                    'note'=>'Leader of Campaign',

                                ],[
                                    'name' => 'Campaign Member',
                                    'is_req' => false,
                                    'instruction' => 'Member of campaign Eg: jake|rosy|johndoe',
                                    'note'=>"To assign all user please use as  'All' "
                                ],[
                                    'name' => 'Description',
                                    'is_req' => false,
                                    'instruction' => 'Description',
                                ],


                            ];
                            @endphp
                            <tbody>
                                @foreach ($Instructions as $i=>$ins)
                                @php
                                $i++;
                                @endphp
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>
                                        {{$ins['name']}}
                                        <span></span>
                                        <span class="text-muted {{$ins['is_req']?'required':''}}">
                                            {{$ins['is_req']?'(Required)':'(Optional)'}}
                                        </span>
                                    </td>
                                    <td>
                                        {{$ins['instruction']}}
                                        @if(isset($ins['note']))
                                        <br>
                                        <span class="text-gray-600">
                                            {{$ins['note']}}
                                        </span>
                                        @endif
                                    </td>
                                </tr>

                                @endforeach

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            </>
            <!--end::Main column-->

        </div>
        <!--end::Container-->
    </div>
    <!--end::Content-->

    <div class="modal fade" id="import_process_modal" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-hidden="true" tabindex="-1" aria-modal="true" role="dialog">
        <!--begin::Modal dialog-->
        <div class="modal-dialog mw-700px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header pb-0 border-0 d-flex justify-content-end">

                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-5 mx-xl-10 pt-0 pb-15">
                    <!--begin::Heading-->
                    <div class="text-center mb-13">
                        <!--begin::Title-->
                        <h1 class="d-flex justify-content-center align-items-center mb-3">Importing locations<span
                                class="loading-dots"></span></h1>
                        <!--end::Title-->
                        <!--begin::Description-->
                        <div class="text-muted fw-semibold fs-5">Please wait until the import process is complete.</div>
                        <!--end::Description-->
                    </div>
                    <!--end::Heading-->
                    <!--begin::Users-->
                    <div class="mh-475px scroll-y me-n7 pe-7">

                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0"
                                aria-valuemax="100" style="width: 100%"></div>
                        </div>
                    </div>
                    <!--end::Users-->
                </div>
                <!--end::Modal Body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>

    @endsection

    @push('scripts')

    <script>
        $(document).ready(function() {
            $('#error_modal').modal('show');
        });
    </script>
    <script>
        var interval;

        function startLoadingDots() {
            var dots = 0;
            interval = setInterval(function () {
                $('.loading-dots').text(Array(dots % 4).fill('.').join(''));
                dots++;
            }, 500);
        }

        @if(session('success-swal'))
        Swal.fire({
            text: '{{session('success-swal')}}',
            icon: "success",
            buttonsStyling: false,
            showCancelButton: false,
            confirmButtonText: "Ok, got it.",
            customClass: {
                confirmButton: "btn btn-primary",
            }
        })
        clearInterval(interval);
        @endif

        $(document).ready(function () {
            $('#importForm').submit(function (event) {

                $('#submitBtn').prop('disabled', true);

                $('#loadingSpinner').css('display', 'inline-block');
                $('#indicator-label').css('display', 'none');
                $('#import_process_modal').modal('show');
                startLoadingDots();
            });

        });


    </script>



    @endpush
