@extends('App.main.navBar')

@section('setting_active','active')
@section('setting_active_show','active show')
@section('location_here_show','here show')
@section('location_add_nav','active')

@section('styles')
<link href="{{asset('customCss/businessSetting.css')}}" rel="stylesheet" type="text/css" />
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>


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
    <li class="breadcrumb-item text-dark">Check In </li>
</ul>
<!--end::Breadcrumb-->
@endsection

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Container-->
    <div class="container-xxl" id="location">

        <!--begin::Modals-->
        <div class="card ">
            <div class="card-header justify-content-center align-items-center min-h-unset h-auto">
                <div class="text-center  p-3">
                    <h2 class="">December Promotion (1/12/2020 - 1/1/2024)</h2>
                </div>
            </div>
            <div class="card-body user-select-none">
                <!--begin::Form-->
                <form action="{{route('campaign.checkIn',$campaign->id)}}" method="POST">
                    @csrf
                    <div class="row justify-content-center">
                        <div class="col-12 mb-10">

                            <div id="map" style="width: 100%; height: 250px;"></div>
                            <div class="mt-3 text-center">
                                <button class="btn btn-sm btn-primary" type="button" id="btn">
                                  <i class="fa-solid fa-location-crosshairs"></i>  Check In Arrive Location
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-8 col-12">
                            <div class="mb-5">
                                <label class="form-label required">Current Location</label>
                                <div class="input-group">
                                    <input type="text" name="" value="Mandalay (41.2999392 - 20.2302)"
                                        class="form-control form-control-sm form-group currentLocationName text-dark" disabled id="">

                                        <input type="hidden" name="location_name" value="Mandalay (41.2999392 - 20.2302)"
                                            class="form-control form-control-sm form-group currentLocationName"  id="">
                                        <input type="hidden" name="gps_location" value="12.222 - 34.434"
                                            class="form-control form-control-sm form-group "  id="currentLocationGeolocation">
                                </div>
                            </div>
                            <div class="mb-5">
                                <label class="form-label required">Employee Name</label>
                                <div class="input-group">
                                    <input type="text" name="" value="{{Auth::user()->username}}"
                                        class="form-control form-control-sm form-group text-dark" disabled id="">

                                </div>
                            </div>
                            <div class="mb-5">
                                <label class="form-label">Date</label>
                                <input class="form-control form-control-sm" name="checkin_datetime" value="{{now()}}" placeholder="Pick date"
                                    id="flatPicker" />
                            </div>
                            {{-- <div class="mb-5">
                                <label class="form-label required">Note</label>
                                <textarea class="form-control" data-kt-autosize="true" cols="10" rows="5"></textarea>
                            </div> --}}
                            <div class="mb-5 text-center">
                                <button type="submit" class="btn btn-sm btn-success">
                                    Confirm
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <!--end::Form-->
            </div>
        </div>

        {{-- <div class="card">
            <video autoplay></video>
            <canvas class="d-none"></canvas>

            <div class="video-options">
                <select name="" id="" class="changeCamera">
                    <option value="">Select camera</option>
                </select>
            </div>

            <img class="screenshot-image d-none" alt="">

            <div class="controls">
                <button class="btn btn-danger play" title="Play"><i data-feather="play-circle"></i></button>
                <button class="btn btn-info pause d-none" title="Pause"><i data-feather="pause"></i></button>
                <button class="btn btn-outline-success screenshot d-none" title="ScreenShot"><i data-feather="image"></i></button>
            </div>
        </div>

        <form action="{{route('campaign.checkIn',$campaign->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="ffd" id="ffd" multiple>
            <button type="submit" class="btn btn-success">Submit</button>
        </form> --}}
    </div>
    <!--end::Container-->
</div>

@endsection

@push('scripts')


{{-- script capture--}}
<script>

const controls = document.querySelector('.controls');
const cameraOptions = document.querySelector('.changeCamera')[0];
const video = document.querySelector('video');
const canvas = document.querySelector('canvas');
const screenshotImage = document.querySelector('img');
const buttons = [...controls.querySelectorAll('button')];
let streamStarted = false;

const [play, pause, screenshot] = buttons;

const constraints = {
  video: {
    facingMode: {
        exact: 'user',
      },
    width: {
      min: 1280,
      ideal: 1920,
      max: 2560,
    },
    height: {
      min: 720,
      ideal: 1080,
      max: 1440
    },
  }
};

const getCameraSelection = async () => {
  const devices = await navigator.mediaDevices.enumerateDevices();
  const videoDevices = devices.filter(device => device.kind === 'videoinput');
  const options = videoDevices.map(videoDevice => {
    return `<option value="${videoDevice.deviceId}">${videoDevice.label}</option>`;
  });
  cameraOptions.innerHTML = options.join('');
};

play.onclick = openCamera;
function openCamera(){
    if (streamStarted) {
        video.play();
        play.classList.add('d-none');
        pause.classList.remove('d-none');
        return;
    }

    if ('mediaDevices' in navigator && navigator.mediaDevices.getUserMedia) {
        // Request access to the camera
        const updatedConstraints = {
        ...constraints,
        deviceId: {
            exact: cameraOptions.value
        }
        };
        startStream(updatedConstraints);
    }
}
const startStream = async (constraints) => {
  const stream = await navigator.mediaDevices.getUserMedia(constraints);
  handleStream(stream);
};

const handleStream = (stream) => {
  video.srcObject = stream;
  play.classList.add('d-none');
  pause.classList.remove('d-none');
  screenshot.classList.remove('d-none');
  streamStarted = true;
};

getCameraSelection();


cameraOptions.onchange = () => {
    console.log(cameraOptions.value);
  const updatedConstraints = {
    ...constraints,
    deviceId: {
      exact: cameraOptions.value
    }
  };
  startStream(updatedConstraints);
};

const pauseStream = () => {
  video.pause();
  play.classList.remove('d-none');
  pause.classList.add('d-none');
};

const doScreenshot = () => {
  canvas.width = video.videoWidth;
  canvas.height = video.videoHeight;
  canvas.getContext('2d').drawImage(video, 0, 0);
  screenshotImage.src = canvas.toDataURL('image/jpb');
  screenshotImage.classList.remove('d-none');
  let file=dataURLtoFile(canvas.toDataURL('image/jpb'),'hello_world.jpb');
  console.log(file,'sfsd');


  const fileList = new DataTransfer();
    fileList.items.add(file);
    $('#ffd')[0].files = fileList.files;
};


function dataURLtoFile(dataurl, filename) {
    var arr = dataurl.split(','),
      mime = arr[0].match(/:(.*?);/)[1],
      bstr = atob(arr[1]),
      n = bstr.length,
      u8arr = new Uint8Array(n);
    while (n--) {
      u8arr[n] = bstr.charCodeAt(n);
    }
    return new File([u8arr], filename, { type: 'image/jpb' });
  }








function downloadImage(url) {
    // Create a new anchor element
    var anchor = document.createElement('a');

    // Set the href attribute to the image URL
    anchor.href = url;

    // Set the download attribute to prompt the browser to download the image
    anchor.download = 'image.jpg'; // You can set the desired filename here

    // Simulate a click on the anchor element
    document.body.appendChild(anchor);
    anchor.click();

    // Clean up by removing the anchor element
    document.body.removeChild(anchor);
  }
pause.onclick = pauseStream;
screenshot.onclick = doScreenshot;
openCamera();
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
