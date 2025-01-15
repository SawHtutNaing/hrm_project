@extends('App.main.navBar')

@section('campaign_icon', 'active')
@section('campaign_show', 'active show')
@section('campaign_list_active', 'active')

@section('styles')
<style>
    .z-index-custom-5{
        z-index: 50 !important;
    }
    .bottomDiv{
        height: 200px;
    }
    .loaded {
        transition: background-image 0.3s ease-in-out;
    }
    .lazy-bg {
    width: 100%;
    height: 300px; /* Set a height for the container */
    background-size: cover;
    background-position: center;
    /* Optionally, add a placeholder background while the image is loading */
    background-color: #f0f0f0;
    }

</style>

@livewireStyles
{{-- <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}
@endsection
@section('title')
<!--begin::Heading-->
<h1 class="text-dark fw-bold my-0 fs-2">View Campaign</h1>
<!--end::Heading-->
<!--begin::Breadcrumb-->
<ul class="breadcrumb fw-semibold fs-base my-1">
    <li class="breadcrumb-item text-muted">Campaign</li>
    {{-- <li class="breadcrumb-item text-muted">
        <a href="" class="text-muted text-hover-primary">Crate</a>
    </li> --}}
    <li class="breadcrumb-item text-dark">View </li>
</ul>
<!--end::Breadcrumb-->
@endsection

@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Container-->
    <div class="container-xxl" id="">


        <livewire:CampaignInfo :id="$campaign->id" />

        <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6">
            <li class="nav-item">
                <a class="nav-link  text-active-gray-700 fw-semibold " href="{{route('campaign.showOar',$campaign->id)}}" >Campaign
                    Report</a>
            </li>
            @if (hasView('attendance'))
                <li class="nav-item">
                    <a class="nav-link  text-active-gray-700 fw-semibold active" data-bs-toggle="tab" href="#">Attendance</a>
                </li>
            @endif
            <li class="nav-item">

                <a class="nav-link text-active-gray-700 fw-semibold" href="{{route('campaign.showGallery',$campaign->id)}}">Photo Gallery</a>
                {{-- <a class="nav-link text-active-gray-700 fw-semibold {{!hasView('campaign report') && !hasView('attendance')? 'active' :'' }}" data-bs-toggle="tab" href="#kt_tab_pane_5">Photo Gallery</a> --}}
            </li>

            @if (hasView('campaign report'))
            <li class="nav-item">

                <a class="nav-link text-active-gray-700 fw-semibold"  href="{{route('campaign.showPs',$campaign->id)}}">Product Summary Report</a>
            </li>
            @endif
        </ul>
            <livewire:fieldservice.AttendanceList :campaign_id="$campaign->id" />


    </div>
    <!--end::Container-->
</div>

<div class="modal fade editmodal" tabindex="-1" id="editt">
</div>



@endsection

@push('scripts')


@livewireScripts
<script src="{{asset('assets/plugins/custom/fslightbox/fslightbox.bundle.js')}}"></script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
    var lazyBg = document.getElementsByClassName("lazy-bg");

    function lazyLoad() {
    for (var i = 0; i < lazyBg.length; i++) { if (elementInViewport(lazyBg[i]) && !lazyBg[i].classList.contains("loaded")) {
        lazyBg[i].style.backgroundImage="url("+ lazyBg[i].getAttribute("data-src") + ")" ;
        lazyBg[i].classList.add("loaded"); } } } function elementInViewport(el) { var rect=el.getBoundingClientRect();
        return ( rect.top>= 0 &&
        rect.left >= 0 &&
        rect.top <= (window.innerHeight || document.documentElement.clientHeight) ); } // Initial load lazyLoad(); // Lazy
            // load on scroll (you might want to debounce/throttle this in a production environment)
            window.addEventListener("scroll", lazyLoad); });
</script>
@endpush
