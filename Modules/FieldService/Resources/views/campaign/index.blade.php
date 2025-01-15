@extends('App.main.navBar')

@section('campaign_icon', 'active')
@section('campaign_show', 'active show')
@section('campaign_list_active', 'active')



@section('styles')
<link href={{asset("assets/plugins/custom/datatables/datatables.bundle.css")}} rel="stylesheet" type="text/css" />
<style>
    .billDiv tr td {
        padding: 8px 0 !important;
    }

    tr td:nth-child(6) {
        text-align: end;
    }

    tr td:nth-child(7) {
        text-align: end;
    }

    tr td:nth-child(8) {
        text-align: end;
    }


    /* tr td:nth-child(4),tr td:nth-child(5){
            text-align: center;
        } */
    tr td:last-child {
        text-align: start;
    }
</style>
@endsection


@section('title')
<!--begin::Heading-->
<h1 class="text-dark fw-bold my-0 fs-4">Campaign</h1>
<!--end::Heading-->
<!--begin::Breadcrumb-->
<ul class="breadcrumb fw-semibold fs-base my-1">
    <li class="breadcrumb-item text-muted">campaign</li>
    <li class="breadcrumb-item text-dark">list</li>
</ul>
<!--end::Breadcrumb-->
@endsection
@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container-xxl" id="kt_content_container">
        <div class="accordion-collapse collapse" id="kt_accordion_1_body_2" aria-labelledby="kt_accordion_1_header_2"
            data-bs-parent="#kt_accordion_1">
            <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10 mb-5">

            </div>
        </div>
        <div class="card card-flush h-xl-100">
            <!--begin::Card header-->
            <div class="card-header border-0 px-5 px-sm-7 pt-6 pb-5">
                <!--begin::Card title-->
                <div class="card-title ">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                        <span class="svg-icon svg-icon-sm-2  position-absolute m-3 ms-sm-6">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                    transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                <path
                                    d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                    fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        <input type="text" data-kt-purchase-table-filter="search"
                            class="form-control fs-8 fs-sm-base form-control-sm form-control-solid w-100 w-sm-250px ps-10 ps-sm-15 "
                            placeholder="Search Campaign" />
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-purchase-table-toolbar="base">
                        <!--begin::Filter-->
                        <!--begin::Toolbar-->
                        <div class="d-none justify-content-end" data-kt-user-table-toolbar="base">
                            <!--begin::Filter-->
                            {{-- <button class="accordion-button fs-4 fw-semibold" type="button" data-bs-toggle="collapse"
                                data-bs-target="#kt_accordion_1_body_1" aria-expanded="true" aria-controls="kt_accordion_1_body_1">
                                Accordion Item #1
                            </button> --}}
                            <button type="button" class="btn btn-sm btn-light-primary me-3 collapsed fs-8 fs-sm-7" type="button"
                                data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_2" aria-expanded="false"
                                aria-controls="kt_accordion_1_body_2">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z"
                                            fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                Filter
                            </button>
                            <!--begin::Menu 1-->
                            <div class="menu menu-sub menu-sub-dropdown w-300px w-lg-600px w-md-450px" tabindex="-1" id="filter"
                                data-kt-menu="true">
                                <!--begin::Header-->
                                <div class="px-7 py-5">
                                    <div class="fs-5 text-dark fw-bold">Filter Options</div>
                                </div>
                                <!--end::Header-->
                                <!--begin::Separator-->
                                <div class="separator border-gray-200"></div>
                                <!--end::Separator-->
                                <!--begin::Content-->
                                <div class="px-7 py-5" data-kt-user-table-filter="form">
                                    <div class="d-flex flex-wrap justify-content-around">


                                    </div>
                                    <!--begin::Actions-->
                                    <div class="d-flex justify-content-end">
                                        <button type="reset" class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6"
                                            data-kt-menu-dismiss="true" data-kt-user-table-filter="reset">Reset</button>
                                        <button type="submit" class="btn btn-primary fw-semibold px-6" data-kt-menu-dismiss="true"
                                            data-kt-user-table-filter="filter">Apply</button>
                                    </div>
                                    <!--end::Actions-->
                                </div>
                                <!--end::Content-->
                            </div>
                            <!--end::Menu 1-->
                            <!--end::Filter-->
                        </div>
                        <!--end::Toolbar-->
                        <a href="{{route('campaign.create')}}">
                            <button class="btn btn-sm btn-primary fs-9 fs-sm-7">
                                Create New Campaign
                            </button>
                        </a>


                    </div>
                    <!--end::Toolbar-->
                    <!--begin::Group actions-->
                    <div class="d-flex justify-content-end align-items-center d-none" data-kt-purchase-table-toolbar="selected">
                        <div class="fw-bold me-5">
                            <span class="me-2" data-kt-purchase-table-select="selected_count"></span>Selected
                        </div>
                        <button type="button" class="btn btn-danger" data-kt-purchase-table-select="delete_selected">Delete
                            Selected</button>
                    </div>
                    <!--end::Group actions-->
                </div>
                <!--end::Card toolbar-->
            </div>

            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-3" id="stockHistoryTable">
                    <!--begin::Table head-->
                    <thead>
                        <!--begin::Table row-->
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th></th>
                            <th class="text-start min-w-100px">Actions</th>
                            <th class="text-start pe-3 min-w-100px">Name</th>
                            <th class="text-start pe-3 min-w-100px">Location</th>
                            <th class="text-start pe-3 min-w-100px text-start">Campagin Leader</th>
                            <th class="text-start pe-3 min-w-100px text-start">Campagin Date</th>
                        </tr>
                        <!--end::Table row-->
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody class="fw-bold text-gray-600 text-start fs-7">
                        @foreach ([1,3,4,5,6] as $i)
                        <tr>
                            <td></td>
                            <td>
                                <div class="dropdown ">
                                    <button class="btn m-2 btn-sm btn-light btn-primary fw-semibold fs-7  dropdown-toggle " type="button"
                                        id="purchaseDropDown" data-bs-toggle="dropdown" aria-expanded="false">
                                        Actions
                                    </button>
                                    <div class="z-3">
                                        <ul class="dropdown-menu z-10 p-5 " aria-labelledby="purchaseDropDown" role="menu">
                                            <a href="{{route('campaign.show',2)}}" class="dropdown-item p-2  px-3 view_detail  fw-semibold">view</a>
                                            <a href="{{route('campaign.edit',2)}}" class="dropdown-item p-2  px-3 view_detail  fw-semibold">Edit</a>
                                            <a href="{{route('campaign.checkIn',1)}}" class="dropdown-item p-2  px-3 view_detail  fw-semibold">Check In</a>
                                            <a href="{{route('campaign.checkOutForm',1)}}" class="dropdown-item p-2  px-3 view_detail  fw-semibold">Check Out</a>
                                            <a href="{{route('campaign.questionnaire')}}" class="dropdown-item p-2  px-3 view_detail  fw-semibold">Questionnaire</a>
                                        </ul>
                                    </div>

                                </div>
                            </td>
                            <td>December Promo</td>
                            <td>Yangon</td>
                            <td>John Doe</td>
                            <td>1-12-2023 to 1-1-2024</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
    </div>
    <!--end::Container-->
</div>

<div class="modal fade purchaseDetail" tabindex="-1"></div>
<div class="modal fade" tabindex="-1" id="folioPosting"></div>
@endsection

@push('scripts')
<script>
    "use strict";

        // Class definition
        var KTCustomersList = function () {
            // Define shared variables
            var datatable;
            var filterMonth;
            var filterPayment;
            var table

            // Private functions
            var initCustomerList = function () {
                // Set date data order
                const tableRows = table.querySelectorAll('tbody tr');

                tableRows.forEach(row => {
                    const dateRow = row.querySelectorAll('td');
                    const realDate = moment(dateRow[5].innerHTML, "DD MMM YYYY, LT").format(); // select date from 5th column in table
                    dateRow[5].setAttribute('data-order', realDate);
                });
                var prevBalance = 0;

                // Init datatable --- more info on datatables: https://datatables.net/manual/
                datatable = $(table).DataTable({
                    'columnDefs': [
                        // Disable ordering on column 0 (checkbox)
                        {
                            targets: [0], // Replace 0 with the index of the column you want to hide
                            visible: false,
                            searchable: true
                        },
                        { orderable: false, targets: 0 },
                    ],
                    order: [[0, ' ']],
                    processing: true,
                    serverSide: false,
                    // ajax: {
                    //     url: '/stock-history/get/list/',
                    // },
                    columns: [

                        {
                            name:'location',
                            data:'location'
                        },
                        {
                            name:'date',
                            data:'date',
                        },
                        {
                            data:'reference',
                            name: 'reference'
                        },
                        {
                            name:'product',
                            data:'product',
                        },
                        {
                            data: 'from',
                            name: 'from'
                        },
                        {
                            data: 'from',
                            name: 'from'
                        },

                    ],



                });

                // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
                datatable.on('draw', function () {

                    handleBusinessLocationFilter();

                });
            }



            // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
            var handleSearchDatatable = () => {
                const filterSearch = document.querySelector('[data-filter="input"]');
                filterSearch.addEventListener('keyup', function (e) {

                    datatable.column(2).search(e.target.value).draw();
                    // datatable.search(e.target.value).draw();
                });
            }



            var handleBusinessLocationFilter = () => {
                const filterStatus = document.querySelector('[data-filter="location"]');
                $(filterStatus).on('change', e => {
                    let value = e.target.value;
                    console.log(value);
                    if (value === 'all') {
                        value = '';
                    }
                    datatable.column(0).search(value).draw();

                    // datatable.search(value).draw();

                });
            }


            // Public methods
            return {
                init: function () {
                    table = document.querySelector('#stockHistoryTable');

                    if (!table) {
                        return;
                    }

                    initCustomerList();
                    // initToggleToolbar();
                    handleSearchDatatable();
                    // handleDeleteRows();
                    // // handleStatusFilter();
                    handleBusinessLocationFilter();
                    // DateRangeFilter();
                    // handleCustomerFilter();
                    // handleStatusFilter();
                    // handleDateFilterDatatable();
                }
            }
        }();

        // On document ready
        KTUtil.onDOMContentLoaded(function () {
            KTCustomersList.init();
        });


</script>
@endpush
