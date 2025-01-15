<div class="content flex flex-col flex-grow" id="kt_content">
    <div class="container mx-auto px-4" id="location" x-data="AlpineData()">
        <div class="card bg-white shadow rounded-lg">
            <div class="card-header flex justify-center items-center py-4">
                <div class="text-center">
                    <h2 class="text-xl font-semibold">Check In</h2>
                </div>
            </div>
            <div class="card-body user-select-none p-6">
                <form wire:submit.prevent="save">
                    <div class="mb-4">
                        <div id="map" wire:ignore class="w-3/4 hidden h-64"></div>
                        <div class="w-full mt-5 md:w-1/4 flex justify-center items-center">
                            <input type="hidden" wire:model="attendanceForm.checkInLocation">
                            <button type="button" class="btn mt-5 mx-auto bg-blue-500 text-white px-4 py-2 rounded shadow" @click="getLocation()">Get Location</button>
                        </div>
                    </div>

                    <div class="w-full md:w-1/2 px-2 mb-4">
                        <label class="form-label block text-sm font-medium text-gray-700">Location</label>
                        <input type="text" wire:model="attendanceForm.checkInLocation" class="form-control mt-1 block w-full text-sm border-gray-300 rounded shadow-sm" placeholder="Location" disabled>
                    </div>

                    <div class="mb-4">
                        <div class="relative display-cover w-full md:w-1/2">
                            <video x-show="showVideo" class="w-full bg-gray-300" autoplay x-ref="video"></video>
                            <canvas class="hidden" x-ref="canvas"></canvas>
                            <img x-show="!showVideo" class="w-full bg-gray-300" alt="" x-ref="screenshotImage" wire:ignore >
                            <div class="controls absolute flex right-4 top-4 space-x-2">
                                <button type="button" class="btn bg-red-500 text-white px-4 py-2 rounded shadow" @click="openCamera()">Play</button>
                                <button type="button" class="btn bg-blue-500 text-white px-4 py-2 rounded shadow" @click="pauseStream()">Pause</button>
                                <button type="button" class="btn bg-green-500 text-white px-4 py-2 rounded shadow" @click="doScreenshot()">Screenshot</button>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden input to hold the screenshot -->
                    <input type="file" wire:model="screenshot"  class=" hidden"  x-ref="screenshotInput">

                    <div class="mt-5 mx-auto text-center">
                        <button type="submit" class="btn bg-green-500 text-white px-4 py-2 rounded shadow">Confirm Check-In</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function AlpineData() {
        return {
            // areaCenter: new google.maps.LatLng(16.774422, 96.158756),
            areaCenter: new google.maps.LatLng(50.1005233, 8.6544487), //staticaa

            
        areaRadius: 1000, // Ar

            streamStarted: false,
            showVideo: true,
            video: null,
            canvas: null,
            screenshotImage: null,

            init() {
                this.video = this.$refs.video;
                this.canvas = this.$refs.canvas;
                this.screenshotImage = this.$refs.screenshotImage;
            },

            openCamera() {
                if (this.streamStarted) {
                    this.showVideo = true;
                    this.video.play();
                    return;
                }
                if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                    navigator.mediaDevices.getUserMedia({ video: true })
                        .then(stream => {
                            this.video.srcObject = stream;
                            this.video.play();
                            this.streamStarted = true;
                            this.showVideo = true;
                        });
                }
            },

            pauseStream() {
                this.video.pause();
            },

            doScreenshot() {
                this.canvas.width = this.video.videoWidth;
                this.canvas.height = this.video.videoHeight;
                this.canvas.getContext('2d').drawImage(this.video, 0, 0);
                const dataUrl = this.canvas.toDataURL('image/png');
                this.screenshotImage.src = dataUrl;
                this.showVideo = false;

                // Convert the data URL to a blob and append to the hidden file input
                this.convertToBlobAndSetInput(dataUrl);
            },

            convertToBlobAndSetInput(dataUrl) {
                const blob = this.dataURLToBlob(dataUrl);
                const file = new File([blob], 'screenshot.png', { type: 'image/png' });
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                    
                this.$refs.screenshotInput.files = dataTransfer.files;

                setTimeout(() => {
                    this.$refs.screenshotInput.dispatchEvent(new Event('change', { bubbles: false }));
                }, 500);
            },

            dataURLToBlob(dataURL) {
                const parts = dataURL.split(';base64,');
                const byteString = atob(parts[1]);
                const mimeString = parts[0].split(':')[1];
                const arrayBuffer = new ArrayBuffer(byteString.length);
                const intArray = new Uint8Array(arrayBuffer);
                for (let i = 0; i < byteString.length; i++) {
                    intArray[i] = byteString.charCodeAt(i);
                }
                return new Blob([arrayBuffer], { type: mimeString });
            },
            getLocation() {
            navigator.geolocation.getCurrentPosition((position) => {
                const geolocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };

                // Check if the location is within the predefined area
                const userLocation = new google.maps.LatLng(geolocation.lat, geolocation.lng);
                console.log(userLocation);
                const distance = google.maps.geometry.spherical.computeDistanceBetween(userLocation, this.areaCenter);
                // console.log( distance);
                if (distance <= this.areaRadius) {
                    alert("You are within the designated area.");
                } else {
                    alert("You are outside the designated area.");
                }

                const geocoder = new google.maps.Geocoder();
                geocoder.geocode({ location: geolocation }, (results, status) => {
                    if (status === google.maps.GeocoderStatus.OK) {
                        @this.set('checkInLocation', results[0].formatted_address);
                    }
                });

                const map = new google.maps.Map(document.getElementById('map'), {
                    center: geolocation,
                    zoom: 8
                });

                

                geocoder.geocode({ location: geolocation }, (results, status) => {
                        if (status === google.maps.GeocoderStatus.OK) {
                            @this.set('attendanceForm.checkInLocation', results[0].formatted_address);
                        }
                    });


            });
        }
        };
    }

document.addEventListener('livewire:initialized', function () {
    const map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: 16.774422, lng: 96.158756 },
        zoom: 8
    });

   
});

window.initMap = function () {};

window.addEventListener('checkInSuccess', () => {
        Swal.fire({
            title: 'Success!',
            text: 'Check-In was successful.',
            icon: 'success',
            confirmButtonText: 'OK'
        });


    });
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB6y-549HrO6No2H4yELrxw-phFYRHo5I0&libraries=geometry&callback=initMap" async defer></script>
