@extends('App.main.navBar')

@section('campaign_icon', 'active')
@section('campaign_show', 'active show')
@section('campaign_list_active', 'active')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/spinwheel/css/reset.css') }}">
<link rel="stylesheet" href="{{ asset('assets/spinwheel/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/spinwheel/css/superwheel.min.css') }}">
@endsection
@section('title')
<!--begin::Heading-->
<h1 class="text-dark fw-bold my-0 fs-2">Campaign</h1>
<!--end::Heading-->
<!--begin::Breadcrumb-->
<ul class="breadcrumb fw-semibold fs-base my-1">
    <li class="breadcrumb-item text-muted">Game</li>
    {{-- <li class="breadcrumb-item text-muted">
        <a href="" class="text-muted text-hover-primary">Crate</a>
    </li> --}}
    <li class="breadcrumb-item text-dark">Spin & Wheel </li>
</ul>
<!--end::Breadcrumb-->
@endsection

@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Container-->
    <div class="container-xxl" id="location">

        <!--begin::Modals-->
        <div class="card">
            <div class="card-header justify-content-center align-items-center min-h-unset h-auto">
                <div class="text-center  p-3">
                    <span class="fs-2 fw-bold">December Promotion Spin & Wheel</span>
                </div>
            </div>
            <div class="card-body user-select-none text-center h-auto">
               <main class="cd-main-content text-center">

                    <div class="wheel-standard"></div>
                    <button type="button" class="btn btn-primary wheel-standard-spin-button">Spin</button>

                </main>
            </div>
        </div>
    </div>
    <!--end::Container-->
</div>

@endsection

@push('scripts')
<script src="{{asset('assets/spinwheel/js/jquery.superwheel.min.js')}}"></script>
<script src="{{asset('assets/spinwheel/js/main.js')}}"></script>
@endpush
