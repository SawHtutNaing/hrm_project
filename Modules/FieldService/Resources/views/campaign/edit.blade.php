@extends('App.main.navBar')

@section('campaign_icon', 'active')
@section('campaign_show', 'active show')
@section('campaign_list_active', 'active')

@section('styles')
@endsection
@section('title')
<!--begin::Heading-->
<h1 class="text-dark fw-bold my-0 fs-2">Edit Campaign</h1>
<!--end::Heading-->
<!--begin::Breadcrumb-->
<ul class="breadcrumb fw-semibold fs-base my-1">
    <li class="breadcrumb-item text-muted">Campaign</li>
    {{-- <li class="breadcrumb-item text-muted">
        <a href="" class="text-muted text-hover-primary">Crate</a>
    </li> --}}
    <li class="breadcrumb-item text-dark">Edit </li>
</ul>
<!--end::Breadcrumb-->
@endsection

@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Container-->
    <div class="container-xxl" id="location">

        <!--begin::Modals-->
        <div class="card">
            <div class="card-body user-select-none">
                <!--begin::Form-->
                <form action="{{route('campaign.update',$campaign->id)}}" method="POST" id="form" >
                    @csrf
                    @method('PUT')
                    <div class="row flex-row">
                        {{-- <div class="row"> --}}
                            <div class="col-12 col-md-6 mb-5 fv-row">
                                <div class="col-12">
                                    <label class="form-label required">Outlet Name</label>
                                    <select name="business_location_id" id="business_location_id" class="form-select form-select-sm fw-bold " data-kt-select2="true" data-hide-search="false" data-placeholder="Select Outlet" data-allow-clear="true" data-kt-user-table-filter="role" data-hide-search="true" >
                                        <option></option>
                                            @foreach ($locations as $l)
                                                <option value="{{$l->id}}" @selected($l->id == $campaign->business_location_id)>{{businessLocationName($l)}}</option>
                                            @endforeach
                                    </select>
                                </div>
                                @if(isset($campaign->location->locationAddress))
                                    <div class="fw-semibold text-gray-700 col-12 border border-dashed p-2 rounded border-1  my-3 d-flex align-items-center" id="locationAddress">
                                        <div class="text-start col-12 p-3">{!! businessaddress($campaign->location->locationAddress) !!}</div>
                                    </div>
                                @else
                                    <div class="fw-semibold text-gray-700 col-12 border border-dashed p-2 rounded border-1  my-3 d-flex align-items-center" id="locationAddress">
                                        <div class="text-center col-12 p-3">Address</div>
                                    </div>
                                @endif
                            </div>
                            <div class="col-12 col-md-6 mb-5 fv-row">
                                <label class="form-label required">Campaign Name</label>
                                <input type="text" name="name" class="form-control form-control-sm " id="" value="{{$campaign->name}}">
                            </div>
                            <div class="mb-5 col-12 col-md-6">
                                <label class="form-label">Select Game Template</label>
                                <select name="game_id" id="" class="form-select form-select-sm" data-kt-select2="true" data-placeholder="Select Game Template" placeholder="select game template">
                                    @foreach ($games as $game)
                                        <option value="{{$game->id}}" @selected($campaign->game_id ==$game->id)>{{$game->name !='' ?$game->name : 'game-'.$game->id}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-5 col-12 col-md-6">
                                <label class="form-label">Select Questionnaires</label>
                                <select name="questionnaire_id" id="" class="form-select form-select-sm" data-kt-select2="true" data-placeholder="Select Questionnaire" placeholder="select game template">
                                    @foreach ($questionnaires as $q)
                                        <option value="{{$q->id}}" @selected($campaign->questionnaire_id==$q->id)>{{$q->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-5 fv-row col-12 col-md-6">
                                <label class="form-label required">Date</label>
                                <label class="form-label">Date</label>
                                <input class="form-control form-control-sm" name="campaign_datetime"
                                    placeholder="Pick date rage" id="kt_daterangepicker_1" value="{{date_format(date_create($campaign->campaign_start_date),'d/M/Y')}} - {{date_format(date_create($campaign->campaign_end_date),'d/M/Y')}}" />
                            </div>
                            <div class="mb-5 fv-row col-12 col-md-6">
                                <label class="form-label required">Campaign Leader</label>
                                <select name="campaign_leader" id="userSelect" class="form-select form-select-sm fw-bold userSelect"
                                    data-hide-search="false" data-placeholder="Select Campaign Leader" data-allow-clear="true"
                                    data-kt-user-table-filter="role" data-hide-search="true">
                                    <option value="{{$campaign->campaign_leader}}" selected>{{$campaign->leader->username ?? ''}}</option>

                                </select>
                            </div>
                            <div class="mb-5 fv-row col-12 col-md-6">
                                <label class="form-label required">Campaign Member</label>
                                <input class="form-control form-control-sm" name="campaign_member"
                                    id="campaignMemberTagify" value="{{$campaignUsernames}}" />
                            </div>
                            <div class="mb-5 col-12 col-md-6">
                                <label class="form-label required">Description</label>
                                <textarea class="form-control" name="description" data-kt-autosize="true"></textarea>
                            </div>
                            <div class="mb-5 text-center">
                                <button class="btn btn-sm btn-primary" type="submit" data-kt-action="submit">
                                    Update
                                </button>
                            </div>
                    </div>
                </form>




            </div>
        </div>
    </div>
    <!--end::Container-->
</div>

@endsection

@push('scripts')
<script>
    let geoLocation=@json($campaign->gps_location);
    let location_name="{{$campaign->location_name}}";
    let businessLoations=@json($locations ?? []);
    $('#business_location_id').on('select2:unselecting', function (e) {
            $('#locationAddress').html('<div class="text-center col-12 p-3">Address</div>');
    });
    $('#business_location_id').change(function(){
       let locationdata= businessLoations.find((l)=>$(this).val()==l.id);

        if(locationdata){
            let locationAddress=locationdata.location_address ?? {};
            let address= locationAddress.address;
            let city=locationAddress.city;
            let state=locationAddress.state;
            let country=locationAddress.country;
            let zipCode=locationAddress.zip_postal_code;
            let mobile=locationAddress.mobile;
            let email=locationAddress.email;
            let alternateNumber=locationAddress.alternate_number;
            if( address || city || state || country || zipCode || mobile || email || alternateNumber){
                let html=`${address ? address+', ':''} ${city ? city+',':''} ${state ? state+',':''}  ${country ? country+'.':''}<br/>
                    ${zipCode ? zipCode+'.<br>':''}
                    ${mobile ? mobile +',':''} ${alternateNumber ? alternateNumber +'.':''} ${mobile || alternateNumber? '<br>':''}
                    ${email ? email +'.':''}`;
                $('#locationAddress').html(html);
            }else{
                $('#locationAddress').html('<div class="text-center col-12 p-3">Address</div>');
            }
        }
    });
    // geoSpllit=geoLocation.split('-');
    let users=@json($campaignUsers).map(d => ({
        id: d.id,
        value: d.username
    }));
    $("#kt_daterangepicker_1").daterangepicker({
        locale: {
        format: "DD/MMM/YYYY"
        }
    });


    const getUsers=(e,tagify,count=100)=>{
        const query = e.detail.value;
        $.ajax({
        url: `/campaign/user/data`,
        method: 'GET',
        data:{
            query,
            count
        },
        success: function(response,params,sth) {
            let data = response.data;
            // update Tagify's whitelist with the fetched suggestions
            let whitelistData = data.map(d => ({
                    id: d.id,
                    value: d.username
            }));
            whitelistData=[{'id':'all','value':'All'},...whitelistData];
            tagify.settings.whitelist = whitelistData;
            tagify.dropdown.show.call(tagify)
        },
            error: function(xhr, status, error) {
                console.error('Error fetching suggestions:', error);
            }
        });
    }
    var cmt = document.querySelector('#campaignMemberTagify');
    var tagify = new Tagify(cmt, {
        enforceWhitelist: true,
        dropdown: {
            enabled: 0,
            searchKeys: ['value'],
            closeOnSelect: false,
            scrollDuration: 10, // Set scroll duration in milliseconds
        },
        whitelist: [ {'id':'all','value':'All'},...users], // an empty whitelist to allow suggestions to populate dynamically
        callbacks: {
            focus:function(e){
                getUsers(e,tagify,100);
            },
            input:function(e){
                getUsers(e,tagify);
            },
        },
    });

    $('#campaignMemberTagify').change(function(c){
        let val=$(this).val();
        console.log(val);
        if(val){
            let jsonValue=JSON.parse(val);
            let checkAll=jsonValue.find(j=>j.id=='all');
            if(checkAll && checkAll.id=='all'){
                $(this).val('All');
                tagify.removeAllTags();
                tagify.addTags(['All']);
            }
        }

    })
    // Init Tagify script on the above inputs
    // tagify = new Tagify(cmt, {
    //     enforceWhitelist: true,
    //     whitelist: [],
    //     maxTags: 5, // Set the maximum number of tags allowed
    //     dropdown: {
    //         enabled: 1,
    //         maxItems: 5,
    //         closeOnSelect: true
    //     },
    //     callbacks: {
    //         input: function(e) {
    //             const value = e.detail.value.toLowerCase();

    //             $.ajax({
    //                 url: `/campaign/user/data`,
    //                 method: 'GET',
    //                 dataType: 'json',
    //                 success: function(data) {
    //                     console.log();
    //                     const whitelistData = data.map(d => ({
    //                         value: d.id,
    //                         label: d.username
    //                     }));
    //                     // Update Tagify whitelist with fetched data
    //                     $('.userTagify')[0].tagify.settings.whitelist = whitelistData;
    //                 },
    //                 error: function(error) {
    //                     console.error('Error fetching data:', error);
    //                 }
    //             });
    //         }
    //     }
    // });


    $('.userSelect').select2({
        ajax: {
            url: '/campaign/user/data',
            dataType: 'json',
            delay: 250,
            processResults: function(results, params) {
                params.page = params.page || 1;
                resultsForSelect=[];
                let data=results.data;
                data.map(function(d) {
                    resultsForSelect.push({
                        id: d.id,
                        text: `${d.username}`
                    });
                })
                return {
                    results:resultsForSelect,
                    pagination: {
                        more: (params.page * 20) < results.total
                    }
                };
            },
            cache: true
        },
        placeholder: 'Search for an item',
        minimumInputLength: 0,
    })
</script>


{{-- map --}}
{{-- <script>
    function initMap() {
        let lat=Number(geoSpllit[0]);
        let lng=Number(geoSpllit[1]);
        const myLatlng = { lat, lng };
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 10,
            center: myLatlng,
        });
        // Create the initial InfoWindow.
        let infoWindow = new google.maps.InfoWindow({
            content: location_name ?? "Click the map to get Lat/Lng!",
            position: myLatlng,
        });

        infoWindow.open(map);
        // Configure the click listener.
        let geolocation=[];
        const geocoder = new google.maps.Geocoder();
        map.addListener("click", (mapsMouseEvent) => {
            // Close the current InfoWindow.
            infoWindow.close();
            // Create a new InfoWindow.
            infoWindow = new google.maps.InfoWindow({
                position: mapsMouseEvent.latLng,
            });
            infoWindow.setContent(
                JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2),
            );
            infoWindow.open(map);
            geolocation=mapsMouseEvent.latLng.toJSON();

            $('.gps_location').val(geolocation.lat+'-'+geolocation.lng);
            const geocoderRequest = { location: geolocation };
            geocoder.geocode(geocoderRequest, (results, status) => {
                if (status === google.maps.GeocoderStatus.OK) {
                    const address = results[2].formatted_address;
                    $('.currentLocationName').val(address);
                } else {
                    console.error("Geocoding failed:", status);
                }
            });
        });


    }

</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB6y-549HrO6No2H4yELrxw-phFYRHo5I0&callback=initMap&v=weekly"></script> --}}
@endpush
