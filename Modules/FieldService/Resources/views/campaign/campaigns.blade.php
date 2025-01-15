@extends('App.main.navBar')

@section('campaign_icon', 'active')
@section('campaign_show', 'active show')
@section('campaign_list_active', 'active')

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
        @if(hasCreate('campaign'))
        <div class="text-end col-12">
            <a href="{{route('campaign.create')}}" class="btn btn-sm btn-primary py-2">Create</a>
        </div>
        @endif

        <div class="d-flex justify-content-center align-items-center mt-5 mb-10">
            <div class="col-6 col-md-2 fs-7  fw-semibold  text-primary">
                 Campaigns
            </div>
            <div class="separator   border-primary-subtle col-md-10 col-6"></div>
        </div>
        <livewire:fieldservice.CampaignComponent />
    </div>
    <!--end::Container-->
</div>

@endsection

@push('scripts')
<script>
    $("#kt_daterangepicker_1").daterangepicker();
    $('.start_campaign').click(function(){
         let   currentdate=new Date();
        Swal.fire({
            title:"Are you sure to Start Campaign.",
            text:"Start Date :"+currentdate.getDate() + "-"
                + (currentdate.getMonth()+1)  + "-"
                + currentdate.getFullYear() + "  "
                + currentdate.getHours() + ":"
                + currentdate.getMinutes(),
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
        $('.close_campaign').click(function(){
         let   currentdate=new Date();
        Swal.fire({
            title:"Are you sure to Close Campaign.",
            // text:"Start Date :"+currentdate.getDate() + "-"
            //     + (currentdate.getMonth()+1)  + "-"
            //     + currentdate.getFullYear() + "  "
            //     + currentdate.getHours() + ":"
            //     + currentdate.getMinutes(),
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes, Close!",
            cancelButtonText: "No, cancel",
            customClass: {
            confirmButton: "btn btn-sm btn-danger",
            cancelButton: "btn btn-sm btn-secondary"
            }
        }).then((result)=>{
            if(result.isConfirmed){
                let cId=$(this).data('id');
                $.ajax({
                    url: `/campaign/${cId}/close`,
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
                            title:"Successfully Closed Campaign",
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
