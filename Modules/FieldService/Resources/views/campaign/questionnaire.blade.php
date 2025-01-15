@extends('App.main.navBar')

@section('campaign_icon', 'active')
@section('campaign_show', 'active show')
@section('campaign_list_active', 'active')

@section('styles')
<link href="{{asset('customCss/businessSetting.css')}}" rel="stylesheet" type="text/css" />
<style>
    iframe{
        width: 100% !important;
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
        <div class="card h-auto">
            <div class="card-header justify-content-center align-items-center min-h-unset h-auto">
                <div class="text-center  p-3">
                    <h2 class="">December Promotion questionnaire</h2>
                </div>
            </div>
            <div class="col-md-5 col-12 my-5 m-auto">
                <a href="javascript:history.back()" class="btn btn-secondary btn-sm">{{__('fieldservice::actions.back')}}</a>
                <a href="{{route('campaign.questionnaire',$questionnaires->id)}}" class="btn btn-primary btn-sm">{{__('fieldservice::actions.resubmit_question_form')}}</a>
            </div>
            <div class="card-body user-select-none text-center h-auto w-100">
                {!! $questionnaires->url ?? 'url not found' !!}
            </div>
        </div>
    </div>
    <!--end::Container-->
</div>

@endsection

@push('scripts')
<script>
    // Get the iframe element
    var iframe = document.getElementById('myIframe');

    // Listen for the 'load' event on the iframe
    iframe.onload = function() {
        // Access the contentWindow property to get the window object of the iframe
        var iframeWindow = iframe.contentWindow;

        // Add an event listener for form submission inside the iframe
        iframeWindow.document.querySelector('form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            // Handle the form submission here
            alert('Form submitted from iframe!');
        });
    };
</script>
@endpush
