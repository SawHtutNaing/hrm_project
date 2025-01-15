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

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB6y-549HrO6No2H4yELrxw-phFYRHo5I0&callback=initMap&v=weekly"></script>

