@extends('App.main.navBar')

@section('campaign_icon', 'active')
@section('campaign_show', 'active show')
@section('campaign_report_active', 'active')

@section('styles')
@endsection
@section('title')
<!--begin::Heading-->
<h1 class="text-dark fw-bold my-0 fs-2">Campaign</h1>
<!--end::Heading-->
<!--begin::Breadcrumb-->
<ul class="breadcrumb fw-semibold fs-base my-1">
    <li class="breadcrumb-item text-muted">Camgpaign</li>
    {{-- <li class="breadcrumb-item text-muted">
        <a href="" class="text-muted text-hover-primary">Crate</a>
    </li> --}}
    <li class="breadcrumb-item text-dark">Report </li>
</ul>
<!--end::Breadcrumb-->
@livewireStyles
@endsection

@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="">
    <!--begin::Container-->
    <div class="container-xxl" id="">
        <livewire:fieldservice.over-all-report-table   />

    </div>
    <!--end::Container-->
</div>

@endsection

@push('scripts')
@livewireScripts
{{-- <script>
    var reportDatatable;
    "use strict";

    // Class definition
    var ktReportList = function () {
        var table
        // Private functions
        var initReportList = function () {

            reportDatatable = $(table).DataTable({
                'columnDefs': [],
                // order: [[1, 'desc']],
                pageLength: 30,
                lengthMenu: [10, 20, 30, 50,40,80],
                processing: true,
                serverSide: true,
                ajax: {
                    url: `/campaign/report/get/all`,
                    data: function (data) {
                        data.from_date=$('#kt_daterangepicker_4').data('daterangepicker').startDate.format('YYYY-MM-DD');
                        data.to_date=$('#kt_daterangepicker_4').data('daterangepicker').endDate.format('YYYY-MM-DD');
                    }
                },
                columns: [

                    {
                        name:'name',
                        data:'name',
                    },
                    {
                    name:'category',
                    data:'category',
                    },
                    {
                        name:'quantity',
                        data:'quantity',
                    },
                    {
                        name:'uom',
                        data:'uom',
                    },
                    {
                        data:'pkgQty',
                        name: 'pkgQty'
                    },
                    {
                        name:'pkg',
                        data:'pkg',
                    },
                    {
                        name:'outlet',
                        data:'outlet',
                    },
                    {
                        name:'employeelocation',
                        data:'employeelocation',
                    },
                    {
                        name:'campaign_name',
                        data:'campaign_name',
                    },
                    {
                        name:'employee',
                        data:'employee',
                    },
                    {
                        data: 'date',
                        name: 'date'
                    }

                ],



            });

            // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
            reportDatatable.on('draw', function () {
                handleOutletFilterDatatable();
                handleEmployee();
                handleCategoryFilter();
            });

        }

        var start = moment().subtract(1, "M");
        var end = moment();

        function cb(start, end) {
            $("#kt_daterangepicker_4").html(start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY"));
            reportDatatable.draw();
            console.log('here');
        }

        $("#kt_daterangepicker_4").daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                "Today": [moment(), moment()],
                "Yesterday": [moment().subtract(1, "days"), moment().subtract(1, "days")],
                "Last 7 Days": [moment().subtract(6, "days"), moment()],
                "Last 30 Days": [moment().subtract(29, "days"), moment()],
                "This Month": [moment().startOf("month"), moment().endOf("month")],
                "Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
            }
        }, cb);

        // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
        var handleSearchDatatable = () => {
            const filterSearch = document.querySelector('[data-filter="report-input"]');
            filterSearch.addEventListener('keyup', function (e) {
                reportDatatable.column(0).search(e.target.value).draw();
            });
        }

        var handleOutletFilterDatatable = () => {
            const filterSearch = document.querySelector('[data-kt-table-filter="outlet"]');
            $(filterSearch).on('change', e => {
             reportDatatable.column(6).search(e.target.value).draw();
            });
        }
        var handleEmployee = () => {
            const filterSearch = document.querySelector('[data-kt-table-filter="employee"]');
            $(filterSearch).on('change', e => {
             reportDatatable.column(9).search(e.target.value).draw();
            });
        }
        var handleCategoryFilter=()=>{
            const filterSearch = document.querySelector('[data-kt-table-filter="category"]');
            $(filterSearch).on('change', e => {
            reportDatatable.column(1).search(e.target.value).draw();
            });
        }

        // Public methods
        return {
            init: function () {
                table = document.querySelector('#campaignReportTable');

                if (!table) {
                    return;
                }
                initReportList();
                handleSearchDatatable();
                handleOutletFilterDatatable();
                handleEmployee();
                handleCategoryFilter();
            }
        }
    }();

    // On document ready
    KTUtil.onDOMContentLoaded(function () {
        ktReportList.init();
    });


</script> --}}
@endpush
