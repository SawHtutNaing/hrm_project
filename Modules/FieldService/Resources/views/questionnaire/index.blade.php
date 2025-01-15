@extends('App.main.navBar')


@section('campaign_icon', 'active')
@section('campaign_show', 'active show')
@section('questionnaire_list_active', 'active show')


@section('styles')
{{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}
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
<h1 class="text-dark fw-bold my-0 fs-4">Questionnaire</h1>
<!--end::Heading-->
<!--begin::Breadcrumb-->
<ul class="breadcrumb fw-semibold fs-base my-1">
    <li class="breadcrumb-item text-muted">Questionnaire</li>
    <li class="breadcrumb-item text-dark">list</li>
</ul>
<!--end::Breadcrumb-->
@endsection
@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container-xxl" id="kt_content_container">
        <div class="card card-flush h-xl-100">
            <!--begin::Card header-->
            <div class="row card-header mt-10">
                <div class="w-auto">
                    <input type="text" class="form-control form-control-sm" placeholder="Search...."
                    data-filter="input">
                </div>
                @if(hasCreate('questionnaire'))
                <div class="w-auto">
                    <button href="#" class="btn btn-sm btn-primary"  data-bs-toggle="modal" data-bs-target="#modal">
                        Add Questionnaire
                    </button>
                </div>
                @endif
            </div>

            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-3" id="attendanceTable">
                    <!--begin::Table head-->
                    <thead>
                        <!--begin::Table row-->
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            {{-- <th class="text-start min-w-100px">Actions</th> --}}

                            <th class="text-start"> Id</th>
                            <th class="text-start pe-3 min-w-100px">Name</th>
                            <th class="text-start pe-3 min-w-100px">url</th>
                            <th class="text-start pe-3 min-w-300px">Actions</th>
                        </tr>
                        <!--end::Table row-->
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody class="fw-bold text-gray-600 text-start fs-7">
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


<div class="modal fade " tabindex="-1" id="modal">
    <div class="modal-dialog w-md-600px w-100 " id="formDiv">
        <div class="modal-content " >
            <div class="modal-header py-2">
                <h3 class="modal-title">Add Questionnaire</h3>
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>

            <form action="{{route('quest.store')}}" method="POST" id="form">
                @csrf
            <div class="modal-body">
                    <div class="mb-5 fv-row">
                        <label for="" class="form-label">Questionnaire Form Name</label>
                        <input type="text" class="form-control form-control-sm" x-model='name' name="name" placeholder="Name">
                    </div>

                    <div class="fv-row">
                        <label for="" class="form-label">Url</label>
                        <input type="text" class="form-control form-control-sm"  x-model='url' name="url" placeholder="url">
                    </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-sm" :disabled="button.disabled" x-text="button.text" @click="save()" data-kt-action="submit">Create</button>
            </div>
                </form>
        </div>
    </div>
</div>


<div class="modal modal-lg fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" id="editModal">

</div>
@endsection

@push('scripts')
<script>
    $(document).on('click', '.edit', function(e){
        e.preventDefault();
        loadingOn();
        $('#editModal').load($(this).data('href'), function() {
            $(this).modal('show');
            loadingOff();
        });
    });
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
                // 'columnDefs': [
                //     {
                //         targets: [0],
                //         visible: false,
                //         searchable: true
                //     },
                // ],
                // order: [[1, 'desc']],

                pageLength: 30,
                lengthMenu: [10, 20, 30, 50,40,80],
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/questionnaire/get',
                },
                columns: [
                    {
                        name:'id',
                        data:'id',
                    },
                    {
                        name:'name',
                        data:'name',
                    },
                    {
                        data:'url',
                        name: 'url',
                        render:function(data){
                            return truncateString(data,80)
                        },
                    },
                    {
                        data:'actions',
                        name: 'actions'
                    },

                ],




            });

            // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
            datatable.on('draw', function () {

                handleBusinessdropDownFilter();

                handleDeleteRows();

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

        var handleDeleteRows = () => {
            // Select all delete buttons
            const deleteButtons = document.querySelectorAll('[data-kt-table="delete_row"]');
            console.log(deleteButtons,'-');
            deleteButtons.forEach(d => {
                // Delete button on click
                d.addEventListener('click', function (e) {
                    e.preventDefault();
                    console.log('hello');
                    // Select parent row
                    const parent = e.target.closest('tr');

                    // Get purchase name
                    const columnName = parent.querySelectorAll('td')[1].innerText;

                    // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
                    Swal.fire({
                        text: "Are you sure you want to delete '" + columnName +"' ?",
                        icon: "warning",
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: "Yes, delete!",
                        cancelButtonText: "No, cancel",
                        customClass: {
                            confirmButton: "btn fw-bold btn-danger",
                            cancelButton: "btn fw-bold btn-active-light-primary"
                        }
                    }).then(function (result) {
                        if (result.value) {
                            let id=d.getAttribute('data-id')
                                $.ajax({
                                    url: `/questionnaire/${id}/delete`,
                                    type: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    success: function(s) {
                                        datatable.ajax.reload();
                                        Swal.fire({
                                            text: "You have deleted " + columnName + "!.",
                                            icon: "success",
                                            buttonsStyling: false,
                                            confirmButtonText: "Ok, got it!",
                                            customClass: {
                                                confirmButton: "btn fw-bold btn-primary",
                                            }
                                        }).then(function () {
                                            success(s.success);
                                        });
                                    }
                                })
                        } else if (result.dismiss === 'cancel') {
                            Swal.fire({
                                text: columnName + " was not deleted.",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary",
                                }
                            });
                        }
                    });
                })
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
                handleDeleteRows();
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

<script >
    function form(){
        return{
            name:'',
            url:'',
            button:{
                disabled:false,
                text:'Create'
            },
            save(){
                console.log(datatable);
                datatable.ajax.reload();
            }
        }
    }
    function truncateString(str, limit) {
        if (str.length <= limit) {
            return str;
        }
        return str.substring(0, limit) + '...';
        }

</script>

{{-- vaidatro --}}
<script>
            // user update validation
            var inputValidator = function () {
        // Shared variables

        const element = document.getElementById("formDiv");
        const form = element.querySelector("#form");
        // Init add schedule modal
        var initValidator = () => {
            var validationFields = {
                        name: {
                            validators: {
                                notEmpty: { message: "* Name is required" },
                            },
                        },
                        url: {
                            validators: {
                                notEmpty: { message: "* Questionnaire Url is required" },
                            },
                        },
                    };
            var validator = FormValidation.formValidation(
                form,
                {
                    fields:validationFields,

                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: '.fv-row',
                            eleInvalidClass: '',
                            eleValidClass: ''
                        })
                    },

                }
            );
            // Submit button handler
            const submitButton = element.querySelector('[data-kt-action="submit"]');
            submitButton.addEventListener('click', function (e) {
                if (validator) {
                    validator.validate().then(function (status) {
                        if (status == 'Valid') {
                            e.currentTarget=true;
                            return true;
                        } else {
                            e.preventDefault();
                            // Show popup warning. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                            Swal.fire({
                                text: "Sorry, looks like there are some errors detected, please try again.",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });
                        }
                    });
                }
            });


        }

        // Select all handler

        return {
            // Public functions
            init: function () {
                initValidator();
            }
        };
    }();
    // On document ready
    KTUtil.onDOMContentLoaded(function () {
        inputValidator.init();
    });
</script>
@endpush
