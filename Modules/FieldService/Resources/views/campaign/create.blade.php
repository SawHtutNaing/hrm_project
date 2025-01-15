@extends('App.main.navBar')

@section('campaign_icon', 'active')
@section('campaign_show', 'active show')
@section('campaign_list_active', 'active')

@section('styles')

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
{{-- <link rel="stylesheet" href="{{asset('assets/tech/alpine.min.js')}}"> --}}
@endsection
@section('title')
<!--begin::Heading-->
<h1 class="text-dark fw-bold my-0 fs-2">Create Campaign</h1>
<!--end::Heading-->
<!--begin::Breadcrumb-->
<ul class="breadcrumb fw-semibold fs-base my-1">
    <li class="breadcrumb-item text-muted">Campaign</li>
    {{-- <li class="breadcrumb-item text-muted">
        <a href="" class="text-muted text-hover-primary">Crate</a>
    </li> --}}
    <li class="breadcrumb-item text-dark">Create </li>
</ul>
<!--end::Breadcrumb-->
@endsection

@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Container-->
    <div class="container-xxl" id="location">

        <!--begin::Modals-->
        <div class="card">
            <div class="card-body user-select-none" id="formDiv" >
                <!--begin::Form-->
                <form action="{{route('campaign.store')}}" method="POST" id="form" >
                    @csrf
                    <div class="row flex-row">
                        {{-- <div class="row"> --}}
                            <div class="col-12 col-md-6 mb-5 fv-row">
                                <div class="col-12">
                                    <label class="form-label required">Outlet Name</label>
                                    <div class="input-group">
                                        <div class="input-group col-12">
                                            <div class="overflow-hidden  flex-grow-1">
                                                @php
                                                    $locationOptions='';
                                                    foreach ($locations as $l){
                                                        $locationOptions.='<option value="'.$l->id.'">'.businessLocationName($l).'</option>';
                                                    }
                                                @endphp
                                                <select name="business_location_id" id="business_location_id" class="form-select form-select-sm fw-bold rounded-end-0" data-kt-select2="true" data-hide-search="false" data-placeholder="Select Outlet" data-allow-clear="true" data-kt-user-table-filter="role" data-hide-search="true" >
                                                    <option></option>
                                                    {!! $locationOptions !!}
                                                </select>
                                            </div>
                                            <button type="button" class="input-group-text bg-primary rounded-end-1" data-bs-toggle="modal" data-bs-target="#outlet_add_modal">
                                                <i class="fa-solid fa-plus text-white"></i>
                                            </button>
                                        </div>
                                        {{-- <div class="input-group-text">
                                            <i class="fa-solid fa-plus"></i>
                                        </div> --}}
                                    </div>
                                </div>
                                <div class="fw-semibold text-gray-700 col-12 border border-dashed p-2 rounded border-1  my-3 d-flex align-items-center" id="locationAddress">
                                    <div class="text-center col-12 p-3">Address</div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-5 fv-row">
                                <label class="form-label required">Campaign Name</label>
                                <input type="text" name="name" class="form-control form-control-sm " id="">
                            </div>
                            <div class="mb-5 col-12 col-md-6">
                                <label class="form-label">Select Game Template</label>
                                <select name="game_id" id="" class="form-select form-select-sm" data-kt-select2="true" data-placeholder="Select Game Template" placeholder="select game template">
                                    @foreach ($games as $game)
                                        <option value="{{$game->id}}">{{$game->name !='' ?$game->name : 'game-'.$game->id}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-5 col-12 col-md-6">
                                <label class="form-label">Select Questionnaires</label>
                                <select name="questionnaire_id" id="" class="form-select form-select-sm" data-kt-select2="true" data-placeholder="Select Questionnaire" placeholder="select game template">
                                    @foreach ($questionnaires as $q)
                                        <option value="{{$q->id}}">{{$q->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-5 fv-row col-12 col-md-6">
                                <label class="form-label required">Date</label>
                                <input class="form-control form-control-sm" name="campaign_datetime" placeholder="Pick date rage"
                                    id="kt_daterangepicker_1" />
                            </div>
                            <div class="mb-5 fv-row col-12 col-md-6">
                                <label class="form-label required">Campaign Leader</label>
                                <select name="campaign_leader" id="userSelect" class="form-select form-select-sm fw-bold userSelect"
                                    data-hide-search="false" data-placeholder="Select Campaign Leader" data-allow-clear="true"
                                    data-kt-user-table-filter="role" data-hide-search="true">

                                </select>
                            </div>
                            <div class="mb-5 fv-row col-12 col-md-6">
                                <label class="form-label required">Campaign Member</label>
                                <input class="form-control form-control-sm" name="campaign_member" id="campaignMemberTagify" />
                            </div>
                            <div class="mb-5 col-12 col-md-6">
                                <label class="form-label required">Description</label>
                                <textarea class="form-control" name="description" data-kt-autosize="true"></textarea>
                            </div>
                            <div class="mb-5 text-center">
                                <button class="btn btn-sm btn-primary" type="submit" data-kt-action="submit">
                                    Create
                                </button>
                            </div>
                    </div>
                </form>
                <!--end::Form-->
            </div>
        </div>
    </div>
    <!--end::Container-->
    <div class="modal fade" tabindex="-1" id="outlet_add_modal">
        <div class="modal-dialog modal-dialog-scrollable w-md-500px" x-data="outletFormData">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Outlet</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <div class="fv-row">
                        <label for="" class="form-label" >
                            Outlet Name
                        </label>
                        <input type="text" class="form-control form-control-sm" x-model="data.name" placeholder="Outlet Name">
                    </div>

                    <div class="fv-row mt-3">
                        <label for="" class="form-label">
                            Outlet Type
                        </label>
                        <select name="outlet_type" id="outlet_type" x-ref="outletTypeSelect"
                        x-init="
                            $nextTick(() => {
                                initOTSelect2();
                            });
                            $watch('data.outlet_type',()=>{
                                $($el).trigger('change');
                            })
                        "
                        data-kt-select2="true" class="form-select form-select-sm">
                           <option value="on">On</option>
                           <option value="off">Off</option>
                        </select>
                    </div>
                    <div class="fv-row mt-3">
                        <label for="" class="form-label">
                            Parent Location
                        </label>
                        <select name="parent_outlet" id="pOutlet" x-ref="parentOutletSelect"
                        x-init="
                            $nextTick(() => {
                                initSelect2();
                            });
                            $watch('data.parentOutletId',()=>{
                                $($el).trigger('change');
                            })
                        "
                        data-kt-select2="true" class="form-select form-select-sm">
                            {!! $locationOptions !!}
                        </select>
                    </div>

                    <div class="fv-row mt-3">
                        <label for="" class="form-label">
                            Mobile
                        </label>
                        <input type="text" class="form-control form-control-sm"  x-model="data.mobile" placeholder="mobile number">
                    </div>
                    <div class="fv-row mt-3">
                        <label for="" class="form-label">
                            Address
                        </label>
                        <input type="text" class="form-control form-control-sm"  x-model="data.address" placeholder="Address">
                    </div>

                    <div class="fv-row mt-3">
                        <label for="" class="form-label">
                            City
                        </label>
                        <input type="text" class="form-control form-control-sm"  x-model="data.city" placeholder="City">
                    </div>


                    <div class="fv-row mt-3">
                        <label for="" class="form-label">
                            State
                        </label>
                        <input type="text" class="form-control form-control-sm"  x-model="data.state" placeholder="State">
                    </div>
                    <div class="fv-row mt-3">
                        <label for="" class="form-label">
                            Zip Code
                        </label>
                        <input type="text" class="form-control form-control-sm"  x-model="data.zip_code" placeholder="State">
                    </div>
                    <div class="fv-row mt-3">
                        <label for="" class="form-label">
                            Country
                        </label>
                        <input type="text" class="form-control form-control-sm"  x-model="data.country" placeholder="State">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-sm" :disabled="isCreating" @click="create" x-text="isCreating ? 'Creating...' :'Create' ">Create</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>

    // $outletModal=document.getElementById('#outlet_add_modal');

    var outletModal = new bootstrap.Modal($('#outlet_add_modal'));
    function outletFormData(){
        return {
            isCreating:false,
            data:{
                name:'',
                parentOutletId:'',
                mobile:'',
                address:'',
                city:'',
                state:'',
                zipCode:'',
                country:'',
                outlet_type:'on',
            },
            initSelect2() {
                const selectElement = $(this.$refs.parentOutletSelect); // Use this.$refs.uomSelect
                selectElement.select2().on('change', (e) => {
                    this.data.parentOutletId=e.target.value;
                });
            },
            initOTSelect2(){
                const outletTypeEl = $(this.$refs.outletTypeSelect); // Use this.$refs.uomSelect
                outletTypeEl.select2().on('change', (e) => {
                    this.data.outlet_type=e.target.value;
                });
            },
            async create(){
                this.isCreating=true;
                let responseData=await this.requestCreate();
                this.isCreating=false;
                $('#outlet_add_modal').modal('hide');

                let mainOutlet = document.getElementById("business_location_id");
                let optionOutlet = document.getElementById("pOutlet");
                let option1 = document.createElement("option");
                option1.text =responseData.lname;
                option1.value =responseData.id;
                mainOutlet.appendChild(option1);
                option1.selected = true;


                let option2 = document.createElement("option");
                option2.text =responseData.lname;
                option2.value =responseData.id;
                optionOutlet.appendChild(option2);

                Swal.fire({
                    title:"Succesfully Created.",
                    icon: "success",
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok',
                    customClass: {
                        confirmButton: "btn btn-sm btn-primary",
                    }
                });
            },
            requestCreate(){
                return new Promise((resolve,reject)=>{
                    $.ajax({
                        url: `/outlet/create`,
                        type: 'POST',
                        data: this.data,
                        headers:{
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        error:function(response){
                            reject(response);
                            if(response.status=='401'){
                                error('Permission Denined');
                            }else if(response.status !=200){
                                console.log(response,'sdf');
                                error(response)
                            }
                        },
                        success: (response)=>{
                            resolve(response);
                            this.isCreating=false;
                            data=this.data;
                            for (let key in data) {
                                if (data.hasOwnProperty(key)) {
                                    data[key] = '';
                                }
                            }
                        }
                    })
                })
            }



        }
    }
</script>
<script>
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

    })
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
        whitelist: [], // an empty whitelist to allow suggestions to populate dynamically
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
{{-- validation --}}
<script>
        // user update validation
        var inputValidator = function () {
        // Shared variables

        const element = document.getElementById("formDiv");
        const form = element.querySelector("#form");
        // Init add schedule modal
        var initValidator = () => {
            var validationFields = {
                        business_location_id: {
                            validators: {
                                notEmpty: { message: "* Outlet is required" },
                            },
                        },
                        campaign_member: {
                            validators: {
                                notEmpty: { message: "* Campaign Member is required" },
                            },
                        },

                        campaign_leader: {
                            validators: {
                                notEmpty: { message: "* Campaign Leader is required" },
                            },
                        },
                        // location_name: {
                        //     validators: {
                        //         notEmpty: { message: "*Location Name is required" },
                        //     },
                        // },
                        campaign_datetime: {
                            validators: {
                                notEmpty: { message: "* Date is required" },
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

{{-- map --}}
{{-- <script>
    function initMap() {
        const myLatlng = { lat: 21.9588282, lng: 96.0891032 };
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 8.5,
            center: myLatlng,
        });
        // Create the initial InfoWindow.
        let infoWindow = new google.maps.InfoWindow({
            content: "Click the map to get Lat/Lng!",
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
                    console.log(results);
                    const address = results[2].formatted_address;
                    $('.currentLocationName').val(address);
                } else {
                    console.error("Geocoding failed:", status);
                }
            });
        });


    }

</script> --}}

{{-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB6y-549HrO6No2H4yELrxw-phFYRHo5I0&callback=initMap&v=weekly"></script> --}}
@endpush
