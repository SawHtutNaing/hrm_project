<div class="content    flex flex-col flex-grow" id="kt_content">
    <div class="container mx-auto px-4" id="location" x-data="AlpineData()">
        <div class="card bg-white shadow rounded-lg">
            <div class="card-header flex justify-center items-center py-4">
                <div class="text-center">
                    <h2 class="text-xl font-semibold">Check Out</h2>
                </div>
            </div>
            <div class="card-body user-select-none p-6">
                <form wire:submit.prevent="update">
                    <div class=" mb-4">
                        <div id="map" wire:ignore  class="w-3/4 h-64 hidden "></div>
                        <div class="w-full mt-5  md:w-1/4 flex justify-center items-center   ">
                            <input type="hidden" wire:model="attendanceForm.checkOutLocation">
                            <button type="button" class="btn mt-5 mx-auto bg-blue-500 text-white px-4 py-2 rounded shadow" @click="getLocation()">Get Location</button>
                        </div>
                    </div>
                    
                        <div class="w-full md:w-1/2 px-2 mb-4">
                            <label class="form-label block text-sm font-medium text-gray-700">Location</label>
                            <input type="text" wire:model="attendanceForm.checkOutLocation" class="form-control mt-1 block w-full text-sm border-gray-300 rounded shadow-sm" placeholder="Location" disabled>
                        </div>
                        
                      
                       
                    
                    <div class="mb-5  mx-auto text-center">
                        <button type="submit"
                        
                        class="btn bg-green-500 text-white px-4 py-2 rounded shadow">Confirm Check-Out</button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>

{{-- <script>
    function AlpineData() {
        return {
            getLocation() {
                
                
                navigator.geolocation.getCurrentPosition((position) => {
                     const geolocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    const geocoder = new google.maps.Geocoder();
                    geocoder.geocode({ location: geolocation }, (results, status) => {
                        if (status === google.maps.GeocoderStatus.OK) {
                            @this.set('checkInLocation', results[0].formatted_address);
                        }
                    });

                    // const map = new google.maps.Map(document.getElementById('map'));
                console.log(geolocation)
        // map.setCenter(geolocation);

        const map = new google.maps.Map(document.getElementById('map'), {
            center: geolocation,
            zoom: 8
        });

                });
                
              

            }
        }
    }

    document.addEventListener('livewire:initialized', function () {
        const map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: 16.774422, lng: 96.158756 },
            zoom: 8
        });
    });

    window.initMap = function () {};
</script> --}}


<script>


function AlpineData() {
    return {
        // Define the center of the area (Sule Pagoda) and radius (in meters)
        areaCenter: new google.maps.LatLng(16.774422, 96.158756),
        areaRadius: 1000, // Area radius in meters

        getLocation() {
            navigator.geolocation.getCurrentPosition((position) => {
                const geolocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };

                // Check if the location is within the predefined area
                const userLocation = new google.maps.LatLng(geolocation.lat, geolocation.lng);
                const distance = google.maps.geometry.spherical.computeDistanceBetween(userLocation, this.areaCenter);
                // console.log( distance);
                if (distance <= this.areaRadius) {
                    // alert("You are within the designated area.");
                } else {
                    // alert("You are outside the designated area.");
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
                            @this.set('attendanceForm.checkOutLocation', results[0].formatted_address);
                        }
                    });
            });
        }
    }
}

document.addEventListener('livewire:initialized', function () {
    const map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: 16.774422, lng: 96.158756 },
        zoom: 8
    });

   
});

window.initMap = function () {};

window.addEventListener('checkOutSuccess', () => {
        Swal.fire({
            title: 'Success!',
            text: 'Check-Out was successful.',
            icon: 'success',
            confirmButtonText: 'OK'
        });


    });
</script>


{{-- <script src="https://maps.googleapis.com/maps/api/js?key=callback=initMap&v=weekly"></script> --}}
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB6y-549HrO6No2H4yELrxw-phFYRHo5I0&libraries=geometry&callback=initMap" async defer></script>

