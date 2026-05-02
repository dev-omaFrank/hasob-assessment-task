@php
    $detail_page_url = route('sb.offers.show', $data_item->id);
@endphp

<div class="card border-top border-0 border-4 border-primary">
    <div class="card-body">
        <div class="d-flex align-items-center mb-3">
            <div class="flex-grow-1">
                <h5 class="card-title mb-1">
                    <a href='{{$detail_page_url}}' class="text-primary">{{$data_item->offer_title}}</a>
                </h5>
                <span class="badge bg-{{ $data_item->status == 'active' ? 'success' : ($data_item->status == 'pending' ? 'warning' : 'secondary') }}">
                    {{ $data_item->status }}
                </span>
            </div>
            <div class="ms-auto"> 
                <a href="{{$detail_page_url}}" 
                    data-toggle="tooltip" 
                    title="View Details" 
                    class="btn btn-sm btn-outline-primary me-2">
                    <i class="bx bx-show"></i>
                </a>
                <a data-toggle="tooltip" 
                    title="Edit" 
                    data-val='{{$data_item->id}}' 
                    class="btn-edit-mdl-offer-modal btn btn-sm btn-outline-warning me-2" href="#">
                    <i class="bx bxs-edit"></i>
                </a>
                <a data-toggle="tooltip" 
                    title="Delete" 
                    data-val='{{$data_item->id}}' 
                    class="btn-delete-mdl-offer-modal btn btn-sm btn-outline-danger" href="#">
                    <i class="bx bxs-trash-alt"></i>
                </a>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <p class="mb-1"><strong>Price Per Unit:</strong> {{ number_format($data_item->price_per_unit, 2) }}</p>
                <p class="mb-1"><strong>Interest Rate:</strong> {{ $data_item->interest_rate_pct }}%</p>
                <p class="mb-1"><strong>Tenor:</strong> {{ $data_item->tenor_years }} years</p>
            </div>
            <div class="col-md-6">
                <p class="mb-1"><strong>Max Units:</strong> {{ number_format($data_item->max_units_per_investor) }}</p>
                <p class="mb-1"><strong>Start Date:</strong> {{ $data_item->offer_start_date ? \Carbon\Carbon::parse($data_item->offer_start_date)->format('M d, Y') : 'N/A' }}</p>
                <p class="mb-1"><strong>End Date:</strong> {{ $data_item->offer_end_date ? \Carbon\Carbon::parse($data_item->offer_end_date)->format('M d, Y') : 'N/A' }}</p>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <small class="text-muted">
                <i class="bx bx-calendar me-1"></i>Created {{ \Carbon\Carbon::parse($data_item->created_at)->diffForHumans() }}
            </small>
            <a href="{{$detail_page_url}}" class="btn btn-sm btn-primary">
                View Details <i class="bx bx-chevron-right"></i>
            </a>
        </div>
    </div>
</div>
