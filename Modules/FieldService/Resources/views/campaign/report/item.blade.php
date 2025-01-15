@extends('App.main.navBar')

@section('campaign_icon', 'active')
@section('campaign_show', 'active show')
@section('campaign_item_report_active', 'active')

@section('styles')
@endsection
@section('title')
<!--begin::Heading-->
<h1 class="text-dark fw-bold my-0 fs-2">Item Report For All Campaign</h1>
<!--end::Heading-->
<!--begin::Breadcrumb-->
<ul class="breadcrumb fw-semibold fs-base my-1">
    <li class="breadcrumb-item text-muted">Camgpaign</li>
    {{-- <li class="breadcrumb-item text-muted">
        <a href="" class="text-muted text-hover-primary">Crate</a>
    </li> --}}
    <li class="breadcrumb-item text-dark">Item Report </li>
</ul>
<!--end::Breadcrumb-->
@livewireStyles
@endsection

@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="">
    <!--begin::Container-->
    <div class="container-xxl" id="">
        <livewire:fieldservice.campaignProductSummeryReport  />

    </div>
    <!--end::Container-->
</div>

@endsection

@push('scripts')
@livewireScripts

@endpush
