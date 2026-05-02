@extends('layouts.app')

@section('app_css')
@stop

@section('title_postfix')
Offer Details
@stop

@section('page_title')
Offer Details
@stop

@section('page_title_subtext')
<a class="ms-1" href="{{ route('sb.offers.index') }}">
    <i class="bx bx-chevron-left"></i> Back to Offer Dashboard
</a>
@stop

@section('page_title_buttons')
    <a data-toggle="tooltip" 
        title="New" 
        data-val='{{$id}}' 
        class="btn btn-primary btn-new-mdl-offer-modal" href="#">
        <i class="fa fa-plus text-white" style="opacity:80%"></i>
    </a>

    <a data-toggle="tooltip" 
        title="Edit" 
        data-val='{{$id}}' 
        class="btn btn-primary btn-edit-mdl-offer-modal" href="#">
        <i class="fa fa-pencil-square-o text-white" style="opacity:80%"></i>
    </a>

    @if (Auth()->user()->hasAnyRole(['','admin']))
        @include('dmo-savings-bond-module::pages.offers.bulk-upload-modal')
    @endif
@stop

@section('content')
    {{-- Offer Details Card --}}
    <div class="card border-top border-0 border-4 border-primary mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bx bx-detail me-2"></i>Offer Information</h5>
        </div>
        <div class="card-body">
            @include('dmo-savings-bond-module::pages.offers.show_fields')
        </div>
    </div>

    {{-- Related Subscriptions --}}
    <div class="card border-top border-0 border-4 border-info mb-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0"><i class="bx bx-list-ul me-2"></i>Related Subscriptions ({{ $offer->subscriptions->count() }})</h5>
        </div>
        <div class="card-body">
            @if($offer->subscriptions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Investor Name</th>
                                <th>Email</th>
                                <th>Units Requested</th>
                                <th>Price Per Unit</th>
                                <th>Total Price</th>
                                <th>Status</th>
                                <th>Broker</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($offer->subscriptions as $subscription)
                                <tr>
                                    <td>{{ $subscription->first_name }} {{ $subscription->last_name }}</td>
                                    <td>{{ $subscription->investor_email }}</td>
                                    <td>{{ number_format($subscription->units_requested) }}</td>
                                    <td>{{ number_format($subscription->price_per_unit, 2) }}</td>
                                    <td>{{ number_format($subscription->total_price, 2) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $subscription->status == 'active' ? 'success' : ($subscription->status == 'pending' ? 'warning' : 'secondary') }}">
                                            {{ $subscription->status }}
                                        </span>
                                    </td>
                                    <td>{{ $subscription->broker_name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info">
                    <i class="bx bx-info-circle me-2"></i>No subscriptions found for this offer.
                </div>
            @endif
        </div>
    </div>

    {{-- Related Bids --}}
    <div class="card border-top border-0 border-4 border-success">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="bx bx-gavel me-2"></i>Related Bids ({{ $offer->bids->count() }})</h5>
        </div>
        <div class="card-body">
            @if($offer->bids->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Units Requested</th>
                                <th>Price Per Unit</th>
                                <th>Total Price</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($offer->bids as $bid)
                                <tr>
                                    <td>{{ number_format($bid->units_requested) }}</td>
                                    <td>{{ number_format($bid->price_per_unit, 2) }}</td>
                                    <td>{{ number_format($bid->total_price, 2) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $bid->status == 'active' ? 'success' : ($bid->status == 'pending' ? 'warning' : 'secondary') }}">
                                            {{ $bid->status }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info">
                    <i class="bx bx-info-circle me-2"></i>No bids found for this offer.
                </div>
            @endif
        </div>
    </div>
@stop

@section('side-panel')
<div class="card radius-5 border-top border-0 border-4 border-primary">
    <div class="card-body">
        <div><h5 class="card-title">More Information</h5></div>
        <p class="small">
            This page displays the complete details of the bond offer including all related subscriptions and bids.
        </p>
    </div>
</div>
@stop

@push('page_scripts')
@endpush
