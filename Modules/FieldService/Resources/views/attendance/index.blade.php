@extends('App.main.navBar')


@section('campaign_icon', 'active')
@section('campaign_show', 'active show')
@section('attendance_list_active', 'active show')


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
<h1 class="text-dark fw-bold my-0 fs-4">Attendance</h1>
<!--end::Heading-->
<!--begin::Breadcrumb-->
<ul class="breadcrumb fw-semibold fs-base my-1">
    <li class="breadcrumb-item text-muted">Attendance</li>
    <li class="breadcrumb-item text-dark">list</li>
</ul>
<!--end::Breadcrumb-->
@endsection
@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container-xxl" id="kt_content_container">
        {{-- <livewire:fieldservice.AttendanceList  /> --}}
    </div>
    <!--end::Container-->
</div>

<div class="modal fade purchaseDetail" tabindex="-1"></div>
<div class="modal fade" tabindex="-1" id="folioPosting"></div>
@endsection

@push('scripts')
<script src="{{asset('assets/plugins/custom/fslightbox/fslightbox.bundle.js')}}"></script>
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
            var prevBalance = 0;

            // Init datatable --- more info on datatables: https://datatables.net/manual/
            datatable = $(table).DataTable({
                'columnDefs': [
                    {
                        targets: [0],
                        visible: false,
                        searchable: true
                    },
                ],
                // order: [[1, 'desc']],

                pageLength: 30,
                lengthMenu: [10, 20, 30, 50,40,80],
                processing: true,
                serverSide: false,
                ajax: {
                    url: '/campaign/attendance/get',
                },
                columns: [
                    {
                        name:'campaign_id',
                        data:'campaign_id',
                    },
                    {
                        name:'campaign',
                        data:'campaign',
                    },
                    {
                        data:'employee',
                        name: 'employee'
                    },
                    {
                        name:'location_name',
                        data:'location_name',
                    },{
                        name:'attendance_photo',
                        data:'attendance_photo',
                    },
                    {
                        name:'status',
                        data:'status',
                    },
                    {
                        data: 'checkout_datetime',
                        name: 'checkout_datetime'
                    },

                    {
                        data: 'checkout_datetime',
                        name: 'checkout_datetime'
                    },

                ],



            });

            // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
            datatable.on('draw', function () {
                refreshFsLightbox();
                handleBusinessdropDownFilter();

            });
        }



        // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
        var handleSearchDatatable = () => {
            const filterSearch = document.querySelector('[data-filter="input"]');
            filterSearch.addEventListener('keyup', function (e) {

                datatable.search(e.target.value).draw();
                // datatable.search(e.target.value).draw();
            });
        }



        var handleBusinessdropDownFilter = () => {
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
                table = document.querySelector('#attendanceTable');

                if (!table) {
                    return;
                }

                initCustomerList();
                // initToggleToolbar();
                handleSearchDatatable();
                // handleDeleteRows();
                // // handleStatusFilter();
                handleBusinessdropDownFilter();
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
