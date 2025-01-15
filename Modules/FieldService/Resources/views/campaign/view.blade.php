@extends('App.main.navBar')

@section('campaign_icon', 'active')
@section('campaign_show', 'active show')
@section('campaign_list_active', 'active')

@section('styles')
<style>
    .z-index-custom-5{
        z-index: 50 !important;
    }
    .bottomDiv{
        height: 200px;
    }
    .loaded {
        transition: background-image 0.3s ease-in-out;
    }
    .lazy-bg {
    width: 100%;
    height: 300px; /* Set a height for the container */
    background-size: cover;
    background-position: center;
    /* Optionally, add a placeholder background while the image is loading */
    background-color: #f0f0f0;
    }

</style>

@livewireStyles
{{-- <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}
@endsection
@section('title')
<!--begin::Heading-->
<h1 class="text-dark fw-bold my-0 fs-2">View Campaign</h1>
<!--end::Heading-->
<!--begin::Breadcrumb-->
<ul class="breadcrumb fw-semibold fs-base my-1">
    <li class="breadcrumb-item text-muted">Campaign</li>
    {{-- <li class="breadcrumb-item text-muted">
        <a href="" class="text-muted text-hover-primary">Crate</a>
    </li> --}}
    <li class="breadcrumb-item text-dark">View </li>
</ul>
<!--end::Breadcrumb-->
@endsection

@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Container-->
    <div class="container-xxl" id="">
        <a href="{{ route('campaign.index') }}"  class="btn btn-secondary btn-sm d-md-none py-2 px-3">
            <i class="fa-solid fa-angle-left fs-5 pe-1"></i> Back
        </a>
        <div class="col-12 mb-3">
            <div id="map" class="{{$campaign->location->gps_location ?'': 'd-none';}}" style="width: 100%; height: 250px;"></div>
        </div>
        <div class="row mb-5 d-none">
            <div class="col-12 col-sm-4 col-md-3 col-lg-4 mb-3">
                <div class="card ">
                    <div class="card-body">
                        <div class="d-flex flex-column">
                            <div class="fw-semibold fs-5 text-gray-600">
                                <i class="fa-solid fa-list-check fs-5 text-primary me-1"></i>
                                Total Attendance
                            </div>
                            <div class="attendance fs-xl-1 fw-bold mt-1">
                                {{$attendanceCount ?? 0}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-4 col-md-3 col-lg-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column">
                            <div class="fw-semibold fs-5 text-gray-600">
                                <i class="fa-solid fa-box fs-5 text-primary me-1"></i>
                                Total Useage Product
                            </div>
                            <div class="attendance fs-xl-1 fw-bold mt-1">
                                200
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-4 col-md-3 col-lg-4 mb-3">
                <div class="card ">
                    <div class="card-body">
                        <div class="d-flex flex-column">
                            <div class="fw-semibold fs-5 text-gray-600">
                                <i class="fa-solid fa-dollar fs-5 text-primary me-1"></i>
                                Total Expense
                            </div>
                            <div class="attendance fs-xl-1 fw-bold mt-1">
                                {{fprice($totalExpense)}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!--begin::Modals-->
        <div class="card mb-5">
            <div class="card-header">
                <div class="card-title">
                    {{$campaign->name}}
                </div>
                <div class="card-toolbar">
                    <button></button>
                </div>
            </div>
            <div class="card-body user-select-none">
                <!--begin::Form-->
                <form action="">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class=" -flex justify-content-between">
                                <div class="text-start mb-2">
                                    <span class="fw-semibold fs-7 text-gray-600">
                                        Outlet Location :
                                    </span>
                                </div>
                                <div class="text-start">
                                    <span class="fw-bold fs-7 text-gray-800">{{$campaign->location->name}}</span>
                                </div>
                            </div>
                            <div class="separator m-2"></div>
                            <div class=" -flex justify-content-between">
                                <div class="text-start mb-2">
                                    <span class="fw-semibold fs-7 text-gray-600">
                                        Campaign Name :
                                    </span>
                                </div>
                                <div class="text-start">
                                    <span class="fw-bold fs-7 text-gray-800">{{$campaign->name}}</span>
                                </div>
                            </div>
                            <div class="separator m-2"></div>
                            <div class=" -flex justify-content-between">
                                <div class="text-start mb-2">
                                    <span class="fw-semibold fs-7 text-gray-600">
                                        Campaign Date :
                                    </span>
                                </div>
                                <div class="text-start">
                                    <span class="fw-bold fs-7 text-gray-800">{{fdate($campaign->campaign_start_date,false,false)}} to {{fdate($campaign->campaign_end_date,false,false)}} </span>
                                </div>
                            </div>
                            <div class="separator m-2"></div>
                            <div class="">
                                <div class="text-start mb-2">
                                    <span class="fw-semibold fs-7 text-gray-600">
                                        Descritpion :
                                    </span>
                                </div>
                                <div class="text-start">
                                    <p class="fw-bold fs-7 text-gray-800">
                                        {{$campaign->description}}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class=" -flex justify-content-between">
                                <div class="text-start mb-2">
                                    <span class="fw-semibold fs-7 text-gray-600">
                                        Campaign Leader :
                                    </span>
                                </div>
                                <div class="text-start">
                                    <span class="fw-bold fs-7 text-gray-800">{{$campaign->leader->username}}</span>
                                </div>
                            </div>
                            <div class="separator m-2"></div>
                            <div class=" -flex justify-content-between">
                                <div class="text-start mb-2">
                                    <span class="fw-semibold fs-7 text-gray-600">
                                        Campaign Member :
                                    </span>
                                </div>
                                <div class="text-start mw-400px">
                                    <span class="fw-bold fs-7 text-gray-800">
                                        {{$campaignUsernames}}
                                    </span>
                                </div>
                            </div>
                            <div class="separator m-2"></div>
                            <div class=" -flex justify-content-between">
                                <div class="text-start mb-2">
                                    <span class="fw-semibold fs-7 text-gray-600">
                                        Campaign Status :
                                    </span>
                                </div>
                                <div class="text-start mw-400px">
                                    <span class="fw-bold fs-7 text-gray-800">
                                        @if ($campaign->status=='start')
                                            <span class="badge badge-light-success">Start</span>
                                        @elseif($campaign->status=='close')
                                            <span class="badge badge-light-success">Close</span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 d-none">
                            <iframe class="rounded rounded-1"
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d117039.23211533853!2d95.99325067917484!3d21.940498514671503!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30cb6d23f0d27411%3A0x24146be01e4e5646!2sMandalay!5e1!3m2!1sen!2smm!4v1701410680964!5m2!1sen!2smm"
                                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                            <div class="mt-3">
                                <button class="btn btn-sm btn-secondary">
                                    Get Geolocation
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <!--end::Form-->
            </div>
        </div>

        <livewire:CampaingViewReport :campaign_id="$campaign->id" />


    </div>
    <!--end::Container-->
</div>

<div class="modal fade editmodal" tabindex="-1" id="editt">
</div>



@endsection

@push('scripts')


@livewireScripts
<script src="{{asset('assets/plugins/custom/fslightbox/fslightbox.bundle.js')}}"></script>
{{-- post --}}
<script>

    var modal = new bootstrap.Modal($('#modal'));
    $('#addPhoto').click(function(){
        modal.show()
    });
    let campaign_id={{$campaign->id}};
    let authUserId={{Auth::user()->id}};
    let currentPage=0;
    let lastPage=1;
    let path="{{asset('storage/gallery/')}}";
    fetchData();
    window.addEventListener('scroll', scrollHandler);

    $(document).on('click', '.editmodalbtn', function(){
        let id=$(this).data('id');

        loadingOn();
        $('.editmodal').load(`/gallery/${id}/edit`, function() {
            $(this).modal('show');
            loadingOff();
        });
    });

    async function scrollHandler() {
        let contentDiv = document.getElementById('bottomDiv');
        if (window.innerHeight + window.scrollY >= contentDiv.offsetTop + contentDiv.offsetHeight ) {
            await fetchData();
            // setTimeout(function() {
            //     // Example: Load more content dynamically
            //     let newContent = document.createElement('p');
            //     newContent.textContent = 'More content';
            //     contentDiv.appendChild(newContent);
            // }, 1000); // Delay in milliseconds
        }
    }

     function fetchData() {
        if(currentPage<lastPage){

            currentPage++;
            $('#loadingPost').removeClass('d-none');
            $.ajax({
                url: `/gallery/get/${campaign_id}/data?page=${currentPage}`,
                type: 'GET',
                error:function(response){
                    this.submitBtn.text='Save';
                    this.submitBtn.disable=false;
                },
                success: (response)=>{
                    if(response.data.length <=0){
                        $('#loadingPost').addClass('d-none');
                    }
                    lastPage=response.last_page;
                    response.data.forEach(function(d,i){
                        let imgs=JSON.parse(d.images);
                        let imageDiv='';
                        let padding=5;
                        let zIndex=3;
                        imgs.forEach((img,index)=>{
                            imageDiv+=`
                            <div class="w-auto min-h-50px ps-2 ${index>0 ? 'position-absolute position-md-static z-index-'+zIndex+' ps-'+padding+' ps-md-0' : 'z-index-custom-5'}">
                                <a class="d-block overlay w-200px h-200px" data-fslightbox="lightbox-basic-${i}" href="${path}/${img}">

                                    <div data-src='${path}/${img}' class="overlay-wrapper bgi-no-repeat bg-gray-300 bgi-position-center bg-secondary bgi-size-cover card-rounded min-h-175px  w-200px h-200px lazy-bg"
                                        style="backgroun-color:gray;">
                                    </div>
                                    <div class="overlay-layer card-rounded bg-dark bg-opacity-25 shadow ">
                                        <i class="bi bi-eye-fill text-white fs-3x"></i>
                                    </div>
                                </a>
                            </div>
                            `;
                            padding+=4;
                            zIndex--;
                        })
                        // $profile='';

                        let profile='';
                        if(d.user.personal_info.profile_photo == null){
                            profile=`
                                    <div class="symbol-label fs-3 bg-light-primary text-primary">
                                        ${d.user.username[0]}
                                    </div>
                            `
                        }else{
                            profile=`
                                <img src="${d.user.personal_info.profile_photo}" width="100" heigh="100" />
                            `;
                        }
                        let actions='';
                        if(d.created_by==authUserId){
                            actions +=`
                            <div class="cursor-pointer px-3" id="DropDown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-gear cursor-pointer"></i>
                            </div>
                            <div class="z-3">
                                <ul class="dropdown-menu z-10 py-2 px-2 " aria-labelledby="DropDown" role="menu">
                                    <a class="dropdown-item p-1 view_detail  fw-semibold editmodalbtn" type="button" data-id="${d.id}">
                                        Edit
                                    </a>
                                    <a class="dropdown-item p-1 view_detail text-danger  fw-semibold removePost" type="button" data-href=""
                                        data-id="${d.id}">
                                        Delete
                                    </a>
                                </ul>
                            </div>`
                        }
                        $('.galleries').append(

                        `<div class="card mb-5 post-card">
                            <div class="card-body px-5">
                                <div class="d-flex mb-5">

                                    <div class="symbol symbol-40px me-3">
                                        ${profile}
                                    </div>
                                    <div class="">
                                        <div class='d-flex  justify-content-start gap-2 align-items-center'>
                                            <span class="fw-semibold fs-5">${d.user.personal_info.first_name ?? ''} ${d.user.personal_info.last_name ?? ''}</span>

                                            <div  class="text-end">
                                                ${actions}

                                            </div>
                                        </div>
                                        <span class="fw- fs-8">${d.created_at}</span>
                                    </div>
                                </div>
                                <div class="">
                                    <p class="fs-7 fw-semibold text-gray-700">
                                        ${d.note}
                                    </p>
                                </div>
                                <div class="p-0 row  justify-content-start align-items-center gap-5 position-relative">
                                    ${imageDiv}
                                </div>
                            </div>
                        </div>`
                        );
                        refreshFsLightbox();

                        $('#loadingPost').addClass('d-none');
                    })
                }
            })
        }
    }

</script>

{{-- post edit --}}
<script>
    $('#images').change((event) => {
        $('.preview').html('');
        if(event.target.files[0]){
            var files=event.target.files;
            var fileName = '';
            console.log(files);
            files.forEach((f,i)=>{
                fileName+=f.name+'<br>';
                url=URL.createObjectURL(f);
                $('.preview').append(`
                <div class="w-auto h-100px position-relative img-preview">
                    <img  src="${url}" alt=""  height="100px">
                    <div class="remove  position-absolute" style="right: -5px; top:-2px" data-index=${i}>
                        <i class="fa-solid fa-xmark-circle text-danger fs-3 cursor-pointer"></i>
                    </div>
                </div>
                `);
            })
            // $('#fileText').html(fileName);
        }else{
            $('#fileText').text('click to upload.');
        }
    });
    $(document).on('click','.remove',function(){
        $(this).closest(".img-preview").remove();
        const indexToRemove = $(this).data('index');
        const input = $('#images');
        let files = Array.from(input.prop('files'));

        // Remove the file at the specified index from the array
        files = files.filter((file, index) => index !== indexToRemove);
        console.log(files);

        // Clear the input field
        input.val('');

        // Re-populate the input field with the updated files array
        const fileList = new DataTransfer();
        files.forEach((file,i) => {
            fileList.items.add(file);
        });

        input[0].files = fileList.files;
        console.log(fileList.files);
    })


    $(document).on('change','#newimages',function(event){
        $('.newImagePreview').html('');
        if(event.target.files[0]){
            var files=event.target.files;
            var fileName = '';
            console.log(files,'====');
            files.forEach((f,i)=>{
                fileName+=f.name+'<br>';
                url=URL.createObjectURL(f);
                $('.newImagePreview').append(`
                <div class="w-auto h-100px position-relative img-preview">
                    <img  src="${url}" alt=""  height="100px">
                    <div class="newimagesRemove  position-absolute" style="right: -5px; top:-2px" data-index=${i}>
                        <i class="fa-solid fa-xmark-circle text-danger fs-3 cursor-pointer"></i>
                    </div>
                </div>
                `);
            })
            // $('#fileText').html(fileName);
        }else{
            $('#fileText').text('click to upload.');
        }
    });
    $(document).on('click','.newimagesRemove',function(){
        $(this).closest(".img-preview").remove();
        const indexToRemove = $(this).data('index');
        const input = $('#newimages');
        let files = Array.from(input.prop('files'));

        // Remove the file at the specified index from the array
        files = files.filter((file, index) => index !== indexToRemove);
        console.log(files);

        // Clear the input field
        input.val('');

        // Re-populate the input field with the updated files array
        const fileList = new DataTransfer();
        files.forEach((file,i) => {
            fileList.items.add(file);
        });

        input[0].files = fileList.files;
    })

    $(document).on("click",'.remove-added',function(){
        let removeFile=$('#remove_file');
        let filename=$(this).data('image');
        let filedata=JSON.parse(removeFile.val());
        filedata.push(filename);
        filedata = JSON.stringify(filedata);
        removeFile.val(filedata);
        $(this).closest(".img-added-preview").remove();
    })
</script>
{{-- post delete --}}
<script>
        // Attach click event listener to all delete buttons in the table
    $(document).on('click', '.removePost', function (e) {
        e.preventDefault();
        let id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to Delete this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#f1416c',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                url:`/gallery/${id}/delete`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: (s)=> {
                    $(this).closest('.post-card').remove();
                    success('Successfully Deleted');
                },
                errror:()=>{
                    error('Something Wrong');
                }
            })
            }
        });
    });

</script>
{{-- attendance table --}}
<script>
    let campaignId=@json($campaign->id);
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
                serverSide: true,
                ajax: {
                    url: '/campaign/attendance/get',
                    data:{
                        'campaign_id':campaignId
                    }
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
                    },
                    {
                        name:'status',
                        data:'status',
                    },
                    {
                        name:'attendance_photo',
                        data:'attendance_photo',
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
                // handleBusinessdropDownFilter();

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



        // var handleBusinessdropDownFilter = () => {
            // const filterStatus = document.querySelector('[data-filter="location"]');
            // $(filterStatus).on('change', e => {
            //     let value = e.target.value;
            //     console.log(value);
            //     if (value === 'all') {
            //         value = '';
            //     }
            //     datatable.column(0).search(value).draw();

            //     // datatable.search(value).draw();

            // });
        // }


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
                // handleBusinessdropDownFilter();
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

<script>
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
                    url: `/campaign/report/${campaign_id}/get`,
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
                refreshFsLightbox();
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

                reportDatatable.search(e.target.value).draw();
                // datatable.search(e.target.value).draw();
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
            }
        }
    }();

    // On document ready
    KTUtil.onDOMContentLoaded(function () {
        ktReportList.init();
    });


</script>


<script>
    let glocation=@json($campaign->location->gps_location);
    // if(glocation){
        let location_name="{{$campaign->location->name}}";
        geoSpllit=glocation.split('-');

        let lat=Number(geoSpllit[0]);
        let lng=Number(geoSpllit[1]);
        const myLatlng = { lat, lng };
        $("#kt_daterangepicker_1").daterangepicker();

        let geolocation=myLatlng;
        initMap();
        async function initMap() {
            // Request needed libraries.
            const { Map } = await google.maps.importLibrary("maps");
            const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");
            const map = new Map(document.getElementById("map"), {
            center: geolocation,
            zoom: 10.5,
            mapId: "4504f8b37365c3d0",
            });
            const marker = new AdvancedMarkerElement({
            map,
            position: geolocation,
            });

            const geocoder = new google.maps.Geocoder();
            const geocoderRequest = { location: geolocation };
            geocoder.geocode(geocoderRequest, (results, status) => {

                if (status === google.maps.GeocoderStatus.OK) {
                    console.log(results);
                    const address = results[2].formatted_address;
                    $('.currentLocationName').val(address);

                console.log("Address:", address);
                } else {
                console.error("Geocoding failed:", status);
                }
            });
        }
    // }else{
    //     $('#map').addClass('d-none');
    // }


</script>
<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB6y-549HrO6No2H4yELrxw-phFYRHo5I0&callback=initMap&v=weekly">
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
    var lazyBg = document.getElementsByClassName("lazy-bg");

    function lazyLoad() {
    for (var i = 0; i < lazyBg.length; i++) { if (elementInViewport(lazyBg[i]) && !lazyBg[i].classList.contains("loaded")) {
        lazyBg[i].style.backgroundImage="url("+ lazyBg[i].getAttribute("data-src") + ")" ;
        lazyBg[i].classList.add("loaded"); } } } function elementInViewport(el) { var rect=el.getBoundingClientRect();
        return ( rect.top>= 0 &&
        rect.left >= 0 &&
        rect.top <= (window.innerHeight || document.documentElement.clientHeight) ); } // Initial load lazyLoad(); // Lazy
            // load on scroll (you might want to debounce/throttle this in a production environment)
            window.addEventListener("scroll", lazyLoad); });
</script>
@endpush
