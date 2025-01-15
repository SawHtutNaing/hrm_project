@extends('App.main.navBar')

@section('campaign_icon', 'active')
@section('campaign_show', 'active show')
@section('campaign_list_v2_active', 'active')

@section('styles')
@endsection
@section('title')
<!--begin::Heading-->
<h1 class="text-dark fw-bold my-0 fs-2">View Campaign</h1>
<!--end::Heading-->
<!--begin::Breadcrumb-->
<ul class="breadcrumb fw-semibold fs-base my-1">
    <li class="breadcrumb-item text-muted">Camgpaign</li>
    {{-- <li class="breadcrumb-item text-muted">
        <a href="" class="text-muted text-hover-primary">Crate</a>
    </li> --}}
    <li class="breadcrumb-item text-dark">View </li>
</ul>
<!--end::Breadcrumb-->
@endsection

@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="">
    <!--begin::Container-->
    <div class="container-xxl" id="">
        <!--begin::Modals-->
        <div class="text-end col-12">
            <a href="{{route('campaign.create')}}" class="btn btn-sm btn-primary py-2">Create</a>
        </div>
        <div class="d-flex justify-content-center align-items-center mt-3 mb-5">
            <div class="col-6 col-md-2 fs-7  fw-semibold  text-primary">
               Current Campaigns
            </div>
            <div class="separator   border-primary-subtle col-md-10 col-6"></div>
        </div>
        <div class="row">
            @foreach ($CurrentCampaigns as $campaign)
            <div class="col-lg-4 col-md-5 col-12 mb-3">
                <div class="card">
                    <div class="card-header min-h-unset ">
                        <div class="card-title col-12">
                            <div class="d-flex justify-content-between align-items-center col-12">
                                <div class="">
                                    <i class="fa-solid fa-circle text-success fs-9  animation-blink end-100"></i>
                                    <span class="fs-8">Now</span>
                                </div>
                                <div class="fs-8 fw-bold">
                                    <div class="dropdown ">
                                        <button class="btn btn-secondary btn-sm py-1 fs-8  dropdown-toggle " type="button" id="purchaseDropDown" data-bs-toggle="dropdown" aria-expanded="false">
                                            Actions
                                        </button>
                                        <div class="z-3">
                                            <ul class="dropdown-menu z-10 p-2" aria-labelledby="purchaseDropDown" role="menu">
                                                <a href="{{route('campaign.edit',$campaign->id)}}" class="dropdown-item fw-semibold">Edit</a>
                                                <a href="{{route('campaign.edit',$campaign->id)}}" class="dropdown-item fw-semibold text-danger">Delete</a>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card-body mt-0 pt-0 pb-4">
                        <div class="mt-5 d-flex justify-content-between">
                            <div class="text-start">
                                <a href="{{route('campaign.show',$campaign->id)}}" class="fw-bold fs-7 text-decoration-underline">{{$campaign->name}}</a>
                            </div>
                            <div class="text-start">
                                <i class="fa-solid fa-location-pin me-3"></i><span
                                    class="fw-bold fs-7 text-gray-800">{{$campaign->location_name}}</span>
                            </div>
                        </div>
                        <div class="mt-5 d-flex justify-content-between">
                            <div class="text-start">
                                <span class="fw-bold fs-7 text-gray-800">{{fdate($campaign->campaign_start_date,false,false)}} to {{fdate($campaign->campaign_end_date,false,false)}}</span>
                            </div>
                            <div class="text-start">
                                <span class="fw-bold fs-7 text-gray-800">{{optional(App\Models\BusinessUser::where('id',$campaign->campaign_leader)->first())->username}}</span>
                            </div>
                        </div>
                        <div class="separator my-3"></div>
                        <div class="mt-3  justify-content-start">
                            @if ($campaign->status!='start' && $campaign->campaign_leader==Auth::user()->id)
                                <button href="#" class="btn btn-sm btn-success fs-8 py-2 start_campaign" data-id="{{$campaign->id}}">
                                    Start
                                </button>

                            @elseif ($campaign->status!='start' && $campaign->campaign_leader!=Auth::user()->id)
                                <a href="#"  class="btn btn-sm  btn-outline btn-primary fs-8 py-2 disabled">
                                    Activity
                                </a>
                                <a href="#" class="btn btn-sm  btn-outline btn-danger fs-8 py-2 d-none disabled">
                                    Close
                                </a>
                                {{-- @if ($i==3 || $i==1) --}}
                                <a href="#" class="btn btn-sm btn-outline btn-outline-primary fs-8 py-2 disabled">
                                    Check In
                                </a>
                                {{-- @else --}}
                                <a href="#" class="btn btn-sm  btn-outline btn-outline-danger fs-8 py-2 disabled">
                                    Check Out
                                </a>
                                {{-- @endif --}}
                            @else
                                @if (getStatus($campaign->id,Auth::user()->id)=='checkIn')
                                    <a href="{{route('campaign.ptx',$campaign->id)}}" class="btn btn-sm  btn-outline btn-primary fs-8 py-2">
                                        Activity
                                    </a>
                                {{-- @elseif(isCheckOut($campaign->id,Auth::user()->id))
                                    <button class="btn btn-sm btn-secondary fs-8 py-2 " disabled>
                                        You Already Checkout
                                    </button> --}}
                                @endif
                                <a href="{{route('campaign.checkOutForm',3)}}" class="btn btn-sm  btn-outline btn-danger fs-8 py-2 d-none">
                                    Close
                                </a>
                                @if (getStatus($campaign->id,Auth::user()->id)=='checkOut' || getStatus($campaign->id,Auth::user()->id)==null)
                                    <a href="{{route('campaign.checkInForm',$campaign->id)}}"  class="btn btn-sm btn-outline btn-outline-primary fs-8 py-2">
                                        Check In
                                    </a>
                                @elseif(getStatus($campaign->id,Auth::user()->id)=='checkIn')
                                    <a href="{{route('campaign.checkOutForm',$campaign->id)}}" class="btn btn-sm  btn-outline btn-outline-danger fs-8 py-2">
                                        Check Out
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center align-items-center mt-5 mb-10">
            <div class="col-6 col-md-2 fs-7  fw-semibold  text-primary">
                 Campaigns
            </div>
            <div class="separator   border-primary-subtle col-md-10 col-6"></div>
        </div>
        <div class="row">
            @foreach ($AllCampaigns as $AllCampaign)
                <div class="col-lg-4 col-md-5 col-12 mb-3">
                    <div class="card">
                        <div class="card-header min-h-unset ">
                            <div class="card-title col-12">
                                <div class="d-flex justify-content-between align-items-center col-12">
                                    <div class="">
                                        <i class="fa-solid fa-circle text-success fs-9  animation-blink end-100"></i>
                                        <span class="fs-8">Now</span>
                                    </div>
                                    <div class="fs-8 fw-bold">
                                        <div class="dropdown ">
                                            <button class="btn btn-secondary btn-sm py-1 fs-8  dropdown-toggle " type="button" id="purchaseDropDown" data-bs-toggle="dropdown" aria-expanded="false">
                                                Actions
                                            </button>
                                            <div class="z-3">
                                                <ul class="dropdown-menu z-10 p-2" aria-labelledby="purchaseDropDown" role="menu">
                                                    <a href="{{route('campaign.edit',$AllCampaign->id)}}" class="dropdown-item fw-semibold">Edit</a>
                                                    <a href="{{route('campaign.edit',$AllCampaign->id)}}" class="dropdown-item fw-semibold text-danger">Delete</a>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card-body mt-0 pt-0 pb-4">
                            <div class="mt-5 row justify-content-between">
                                <div class="text-start">
                                    <a href="{{route('campaign.show',$AllCampaign->id)}}" class="fw-bold fs-7 text-decoration-underline">{{$AllCampaign->name}}</a>
                                </div>
                                <div class="text-start">
                                    <i class="fa-solid fa-location-pin me-3"></i><span
                                        class="fw-bold fs-7 text-gray-800">{{$AllCampaign->location_name}}</span>
                                </div>
                            </div>
                            <div class="mt-5 d-flex justify-content-between">
                                <div class="text-start">
                                    <span class="fw-bold fs-7 text-gray-800">{{fdate($AllCampaign->campaign_start_date,false,false)}} to {{fdate($AllCampaign->campaign_end_date,false,false)}}</span>
                                </div>
                                <div class="text-start">
                                    <span class="fw-bold fs-7 text-gray-800">{{optional(App\Models\BusinessUser::where('id',$AllCampaign->campaign_leader)->first())->username}}</span>
                                </div>
                            </div>
                            <div class="separator my-3"></div>
                            <div class="mt-3  justify-content-start">
                                @if ($AllCampaign->status!='start' && $AllCampaign->campaign_leader==Auth::user()->id)
                                    <button href="#" class="btn btn-sm btn-success fs-8 py-2 start_campaign" data-id="{{$AllCampaign->id}}">
                                        Start
                                    </button>
                                @elseif ($AllCampaign->status!='start' && $AllCampaign->campaign_leader!=Auth::user()->id)
                                    <a href="#"  class="btn btn-sm  btn-outline btn-primary fs-8 py-2 disabled">
                                        Activity
                                    </a>
                                    <a href="#" class="btn btn-sm  btn-outline btn-danger fs-8 py-2 d-none disabled">
                                        Close
                                    </a>
                                    {{-- @if ($i==3 || $i==1) --}}
                                    <a href="#" class="btn btn-sm btn-outline btn-outline-primary fs-8 py-2 disabled">
                                        Check In
                                    </a>
                                    {{-- @else --}}
                                    <a href="#" class="btn btn-sm  btn-outline btn-outline-danger fs-8 py-2 disabled">
                                        Check Out
                                    </a>
                                    {{-- @endif --}}
                                @else
                                    @if (getStatus($AllCampaign->id,Auth::user()->id)=='checkIn')
                                        <a href="{{route('campaign.ptx',$campaign->id)}}" class="btn btn-sm  btn-outline btn-primary fs-8 py-2">
                                            Activity
                                        </a>
                                    {{-- @elseif(isCheckOut($AllCampaign->id,Auth::user()->id))
                                        <button class="btn btn-sm btn-secondary fs-8 py-2 " disabled>
                                            You Already Checkout
                                        </button> --}}
                                    @endif
                                    <a href="{{route('campaign.checkOutForm',3)}}" class="btn btn-sm  btn-outline btn-danger fs-8 py-2 d-none">
                                        Close
                                    </a>
                                    @if (getStatus($AllCampaign->id,Auth::user()->id)=='checkOut' || getStatus($AllCampaign->id,Auth::user()->id)==null)
                                        <a href="{{route('campaign.checkInForm',$AllCampaign->id)}}"  class="btn btn-sm btn-outline btn-outline-primary fs-8 py-2">
                                            Check In
                                        </a>
                                    @elseif(getStatus($AllCampaign->id,Auth::user()->id)=='checkIn')
                                        <a href="{{route('campaign.checkOutForm',$AllCampaign->id)}}" class="btn btn-sm  btn-outline btn-outline-danger fs-8 py-2">
                                            Check Out
                                        </a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!--end::Container-->
</div>

@endsection

@push('scripts')
<script>
    $("#kt_daterangepicker_1").daterangepicker();
        $('.start_campaign').click(function(){
        Swal.fire({
            title:"Are you sure to Start Campaign.",
            text:"Start Date : 10.1.2023",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes, Start!",
            cancelButtonText: "No, cancel",
            customClass: {
            confirmButton: "btn btn-sm btn-success",
            cancelButton: "btn btn-sm btn-secondary"
            }
        }).then((result)=>{
            if(result.isConfirmed){
                let cId=$(this).data('id');
                $.ajax({
                    url: `/campaign/${cId}/start`,
                    type: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    delay: 150,
                    error:function(e){
                        status=e.status;
                        if(status==405){
                            warning('Method Not Allow!');
                        }else if(status==419){
                            error('Session Expired')
                        }else if(status==403){
                            error('403 Forbidden')
                        }else{
                            console.log(' Something Went Wrong! Error Status: '+status )
                        };
                    },
                    success:function(){
                        Swal.fire({
                            title:"Successfully Start Campaign",
                            icon: "success",
                            customClass: {
                                confirmButton: "btn btn-sm btn-primary",
                            }
                        })
                        location.reload();

                    }
                });
            }
        })
    })
</script>
@endpush
