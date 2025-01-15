@extends('App.main.navBar')

@section('setting_active','active')
@section('setting_active_show','active show')
@section('location_here_show','here show')
@section('location_add_nav','active')

@section('styles')
<link href="{{asset('customCss/businessSetting.css')}}" rel="stylesheet" type="text/css" />

<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<style>
    .screenshot-image {
            width: 150px;
            height: 90px;
            border-radius: 4px;
            border: 2px solid whitesmoke;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.1);
            position: absolute;
            bottom: 5px;
            left: 10px;
            background: white;
        }

        .display-cover {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 70%;
            margin: 5% auto;
            position: relative;
        }

        video {
            width: 100%;
            transform: scaleX(-1);
            background: rgba(0, 0, 0, 0.2);
        }

        .video-options {
            position: absolute;
            left: 20px;
            top: 30px;
        }

        .controls {
            position: absolute;
            right: 20px;
            top: 20px;
            display: flex;
        }

        .controls > button {
            width: 45px;
            height: 45px;
            text-align: center;
            border-radius: 100%;
            margin: 0 6px;
            background: transparent;
        }

        .controls > button:hover svg {
            color: white !important;
        }

        @media (min-width: 300px) and (max-width: 400px) {
            .controls {
                flex-direction: column;
            }

            .controls button {
                margin: 5px 0 !important;
            }
        }

        .controls > button > svg {
            height: 20px;
            width: 18px;
            text-align: center;
            margin: 0 auto;
            padding: 0;
        }

        .controls button:nth-child(1) {
            border: 2px solid #D2002E;
        }

        .controls button:nth-child(1) svg {
            color: #D2002E;
        }

        .controls button:nth-child(2) {
            border: 2px solid #008496;
        }

        .controls button:nth-child(2) svg {
            color: #008496;
        }

        .controls button:nth-child(3) {
            border: 2px solid #00B541;
        }

        .controls button:nth-child(3) svg {
            color: #00B541;
        }

        .controls > button {
            width: 45px;
            height: 45px;
            text-align: center;
            border-radius: 100%;
            margin: 0 6px;
            background: transparent;
        }

        .controls > button:hover svg {
            color: white;
        }
</style>
@endsection
@section('title')
<!--begin::Heading-->
<h1 class="text-dark fw-bold my-0 fs-2">Attendance</h1>
<!--end::Heading-->
<!--begin::Breadcrumb-->
<ul class="breadcrumb fw-semibold fs-base my-1">
    <li class="breadcrumb-item text-muted">Attendance</li>
    {{-- <li class="breadcrumb-item text-muted">
        <a href="" class="text-muted text-hover-primary">Crate</a>
    </li> --}}
    <li class="breadcrumb-item text-dark">Check Out </li>
</ul>
<!--end::Breadcrumb-->
@endsection

@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content" >
    <!--begin::Container-->
    <div class="container-xxl" id="location" x-data="AlpineData()">
        <a href="{{ route('campaign.index') }}" class="btn btn-secondary btn-sm d-md-none py-2 px-3 mb-2">
            <i class="fa-solid fa-angle-left fs-5 pe-1"></i> Back
        </a>
        <!--begin::Modals-->
        <div class="card">
            <div class="card-header justify-content-center align-items-center min-h-unset h-auto">
                <div class="text-center  p-3">
                    <h2 class="">{{$campaign->name}}</h2>
                </div>
            </div>

            <div class="capture-div" x-show=" currentTag == 'camera' ">
                <div class="col-md-8 col-12 m-auto mt-5">
                    <video autoplay class="rounded video"></video>
                    <canvas class="d-none"></canvas>
                    <img class="screenshot-image d-none" alt="">
                </div>
                <div class="buttons text-center my-5">
                    <button class="btn btn-sm btn-light p-md-3 px-3"  @click="reCapture" x-show="isCaptured">
                        <i class="fa-solid fa-xmark-circle fs-1 pe-0 text-danger"></i>
                    </button>
                    <button class="btn btn-sm btn-primary text-dark text-center p-md-3 px-8  " x-show="!isCaptured" :class=" exact=='user' ?'btn-secondary' :'btn-primary' " title="Turn camera" @click="turnCamera">
                        <i class="fa-solid fa-rotate text-white fs-4 pe-0"></i>
                    </button>
                    <button class="btn btn-sm btn-primary text-center p-md-3 p-7 rounded-circle screenshot " x-show="!isCaptured" title="ScreenShot" @click="screenshot">
                        <i class="fa-solid fa-camera text-white fs-2 pe-0"></i>
                    </button>
                    <button class="btn btn-sm btn-light  p-md-3 px-3"  @click="confirmCapture()"  x-show="isCaptured && !isReCapture">
                        <i class="fa-solid fa-circle-check fs-1 pe-0 text-success"></i>
                    </button>
                </div>
            </div>

            <div class="card-body user-select-none" >
                <!--begin::Form-->
                <div class=""  x-show=" currentTag == 'geo' ">
                    <form action="{{route('campaign.checkOut',$campaign->id)}}" method="POST" id="checkOutForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="attendanceId" value="{{$attendanceRecord->id}}">
                        <div class="row justify-content-center" >
                            <div class="d-none">
                                <input type="file" name="checkOutPhoto" id="checkInPhoto">
                            </div>
                            <div class="row justify-content-center">
                                <div class="row ">
                                    <div id="map" class="col-md-9 mb-1" style=" height: 250px;"></div>
                                    <div class="col-12 mb-1 col-md-3 border-1 border-dashed border border-gray-400 d-flex justify-content-center align-items-center">
                                        <span class="text-center text-gray-400" id="previewText">Image Preview</span>
                                        <img  src="" id="previewImg" class="d-none" alt=""  style="width: 100%;">
                                    </div>
                                </div>
                                <div class="row mb-12">
                                    <div class="mt-3 text-center">
                                        <button class="btn btn-sm btn-primary mb-3 mb-md-0" type="button" id="btn">
                                        <i class="fa-solid fa-location-crosshairs"></i>  Check Out From Arrived Location
                                        </button>

                                        <button class="btn btn-sm btn-success mb-3 mb-md-0" type="button" id="btn" @click="toCapture()">
                                            <i class="fa-solid fa-camera-retro"></i> Capture Check Out Photo
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-8 col-12 border border-1 p-3 pt-5 border-gray-300 rounded-1">
                                <div class="mb-1">
                                    <div class="text-gray-600 fs-7 fw-semibold">
                                        <span>
                                            <i class="fa-solid fa-user fs-7 me-3"></i>
                                        </span>
                                        {{__('fieldservice::campaign.employee_name')}}
                                    </div>
                                    <div class="d-block fw-bold fs-7  mt-2">
                                        <span class="me-8"></span>
                                        <span class="text-gray-900">
                                            {{Auth::user()->username}}
                                        </span>
                                    </div>
                                </div>
                                <div class="separator mb-4"></div>
                                <div class="">
                                    <div class="text-gray-600 fw-semibold fs-7 fw-semibold">
                                        <span>
                                            <i class="fa-solid fa-location-pin fs-7 me-3"></i>
                                        </span>
                                        {{__('fieldservice::campaign.check_in_location')}}
                                    </div>
                                    <div class="d-block fw-bold fs-7  mt-2 ">
                                        <span class="me-8"></span>
                                        <span class="text-gray-900">
                                            {{$attendanceRecord->location_name}}
                                        </span>
                                    </div>
                                </div>

                                <div class="separator mb-4"></div>
                                <div class="">
                                    <div class="text-gray-600 fw-semibold fs-7 fw-semibold">
                                        <span>
                                            <i class="fa-solid fa-location-pin fs-7 me-3"></i>
                                        </span>
                                        {{__('fieldservice::campaign.check_out_location')}}
                                    </div>
                                    <div class="d-block fw-bold fs-7  mt-2 ">
                                        <span class="me-8"></span>
                                        <span class="text-gray-900 currentLocationName">
                                            {{$attendanceRecord->location_name}}
                                        </span>
                                    </div>
                                </div>
                                <input type="hidden" name="checkout_location_name" value="Mandalay (41.2999392 - 20.2302)"
                                    class="form-control form-control-sm form-group currentLocationName"  id="">

                                <input type="hidden" name="checkout_gps_location" value="12.222 - 34.434"
                                    class="form-control form-control-sm form-group "  id="currentLocationGeolocation">

                                <div class="separator mb-4"></div>
                                <div class="">
                                    <div class="text-gray-600 fw-semibold fs-7 fw-semibold">
                                        <span>
                                            <i class="fa-solid fa-clock fs-7 me-3"></i>
                                        </span>
                                        {{__('fieldservice::campaign.check_in_date')}}
                                    </div>
                                    <div class="d-block fw-bold fs-7  mt-2 mb-1">
                                        <span class="me-8"></span>
                                        <span class="text-gray-900">
                                            {{fdate($attendanceRecord->checkin_datetime)}}
                                        </span>
                                    </div>
                                </div>
                                <div class="separator mb-4"></div>
                                <div class="">
                                    <div class="text-gray-600 fw-semibold fs-7 fw-semibold">
                                        <span>
                                            <i class="fa-solid fa-clock fs-7 me-3"></i>
                                        </span>
                                        {{__('fieldservice::campaign.check_out_date')}}
                                    </div>
                                    <div class="d-block fw-bold fs-7  mt-2 mb-1">
                                        <span class="me-8"></span>
                                        <span class="text-gray-900">
                                            {{fdate(now())}}
                                            <input type="hidden" name="checkout_datetime" value="{{now()}}">
                                        </span>
                                    </div>
                                </div>
                                <div class="separator mb-4"></div>
                                <div class="mb-1">
                                    <div class="text-gray-600 fw-semibold fs-7 fw-semibold">
                                        <span>
                                            <i class="fa-solid fa-hourglass-half fs-7 me-3"></i>
                                        </span>
                                        {{__('fieldservice::campaign.total_hours')}}
                                    </div>
                                    <div class="d-block fw-bold fs-7  mt-2 mb-1">
                                        <span class="me-8"></span>
                                        <span class="text-gray-900">
                                            {{round(hourDiffFromDate(now(),$attendanceRecord->checkin_datetime),2)}}
                                            <input type="hidden" name="hours_worked" value="{{round(hourDiffFromDate(now(),$attendanceRecord->checkin_datetime),2)}}">
                                        </span>
                                    </div>
                                </div>
                                <div class="separator mb-2"></div>
                                <div class="mb-1 text-center">
                                    <button class="btn btn-sm btn-danger" id="checkout" type="submit">
                                        {{__('fieldservice::actions.confirm')}}
                                    </button>
                                </div>
                                {{-- <div class="">
                                    <label class="form-label required">Note</label>
                                    <textarea class="form-control" data-kt-autosize="true" cols="10" rows="5"></textarea>
                                </div> --}}
                            </div>
                        </div>
                    </form>
                </div>
                <!--end::Form-->
            </div>
        </div>
        <div class="card mt-10">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table  align-middle table-row-dashed fs-6 gy-3">
                        <thead>
                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                <th>No</th>
                                <th>Descriptions</th>
                                <th>Qty </th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody class="fw-bold text-gray-600 text-start fs-7">
                            @foreach ($sales as $index=>$sale)
                                @php
                                  $productInfo= getProductNameInfos($sale->variation_id);
                                @endphp
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>{{$productInfo['product_name']}} {{$productInfo['variation_name']}}</td>
                                    <td> {{fquantity($sale->quantity)}} {{$sale->uom->short_name}} </td>
                                    <td>{{fprice($sale->subtotal_with_discount)}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{$sales->links()}}
                </div>
            </div>
        </div>
    </div>
    <!--end::Container-->
</div>

@endsection

@push('scripts')
<script>
    let sureMessage="{{__('fieldservice::actions.are_you_sure_to_check_out')}}";
    let yes="{{__('fieldservice::actions.Yes_check_out')}}";
    let no="{{__('fieldservice::actions.no_check_out')}}";
    $("#flatPicker").flatpickr();
    $('#checkout').click(function(e){
        e.preventDefault();
        Swal.fire({
            text: `${sureMessage}။`,
            icon: "warning",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText:yes,
            cancelButtonText: no,
            customClass: {
                confirmButton: "btn btn-sm fw-bold btn-danger",
                cancelButton: "btn btn-sm fw-bold btn-active-light-primary"
        }}).then((result)=>{
            if(result.isConfirmed){
                $('#checkOutForm').submit(); // Submit the form
            }
        })
    });
</script>
<script src="{{asset('/modules/fieldservice/js/vision/camera.js')}}"></script>
{{-- alpine --}}
<script>
    function AlpineData(){
        return {
            currentTag:'geo',
            isCaptured:false,
            isReCapture:false,
            exact:'user',
            async turnCamera(){
                this.exact= this.exact=='user' ? 'environment' :'user';
                if(this.exact =='user'){
                    console.log('here');
                    $('.video').css('transform',"scaleX(-1)")
                }else{
                    $('.video').css('transform',"none")
                }
                modeChange(this.exact);
            },
            screenshot(){
                doScreenshot();
                this.isCaptured=true;
                this.isReCapture=false;
            },
            toCapture(){
                this.isReCapture=true;
                this.isCaptured=false;
                this.currentTag= 'camera';

                openCamera();
            },
            confirmCapture(){
                this.currentTag= 'geo';
                closeCamera();
                $('#previewImg').attr("src", imgSrc);
                $('#previewImg').removeClass('d-none');
                $('#previewText').addClass('d-none');
                console.log(imgSrc,'==');


            },
            reCapture(){
                this.isReCapture=true;
                this.isCaptured=false;
                $('#previewText').removeClass('d-none');
                $('#previewImg').addClass('d-none');
                $('#previewImg').attr("src", '');
                openCamera();
            },
        }
    }
</script>
<script>
    $("#flatPicker").flatpickr();
    getLocation();
    let geolocation={ lat: 14805.39908239538, lng: 96.10852422222902 };
    document.querySelector('#btn').addEventListener('click',()=>{
        getLocation();
    })
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
    }

    function showPosition(position) {
        geolocation={lat: position.coords.latitude, lng: position.coords.longitude};
        $('#currentLocationGeolocation').val(geolocation.lat+' - '+geolocation.lng)
        initMap();
    }
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
                $('.currentLocationName').text(address);
                $('.currentLocationName').val(address);

                console.log("Address:", address);
            } else {
                console.error("Geocoding failed:", status);
            }
        });
    }

    initMap();
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB6y-549HrO6No2H4yELrxw-phFYRHo5I0&callback=initMap&v=weekly"></script>

@endpush
