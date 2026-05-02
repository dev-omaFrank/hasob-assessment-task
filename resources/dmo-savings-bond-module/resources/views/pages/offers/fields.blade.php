<!-- Status Field -->
<div id="div-status" class="form-group mb-3">
    <label for="status" class="col-lg-3 col-form-label">Status</label>
    <div class="col-lg-9">
        {!! Form::text('status', null, ['id'=>'status', 'class' => 'form-control']) !!}
    </div>
</div>

<!-- Offer Title Field -->
<div id="div-offer_title" class="form-group mb-3">
    <label for="offer_title" class="col-lg-3 col-form-label">Offer Title</label>
    <div class="col-lg-9">
        {!! Form::text('offer_title', null, ['id'=>'offer_title', 'class' => 'form-control']) !!}
    </div>
</div>

<!-- Price Per Unit Field -->
<div id="div-price_per_unit" class="row mb-3">
    <label for="price_per_unit" class="col-lg-3 col-form-label">Price Per Unit</label>
    <div class="col-sm-9">
        {!! Form::number('price_per_unit', null, ['id'=>'price_per_unit', 'class' => 'form-control','min' => 0,'max' => 100000000, 'step' => '0.01']) !!}
    </div>
</div>

<!-- Max Units Per Investor Field -->
<div id="div-max_units_per_investor" class="row mb-3">
    <label for="max_units_per_investor" class="col-lg-3 col-form-label">Max Units Per Investor</label>
    <div class="col-sm-9">
        {!! Form::number('max_units_per_investor', null, ['id'=>'max_units_per_investor', 'class' => 'form-control','min' => 1,'max' => 1000000000]) !!}
    </div>
</div>

<!-- Interest Rate Pct Field -->
<div id="div-interest_rate_pct" class="row mb-3">
    <label for="interest_rate_pct" class="col-lg-3 col-form-label">Interest Rate (%)</label>
    <div class="col-sm-9">
        {!! Form::number('interest_rate_pct', null, ['id'=>'interest_rate_pct', 'class' => 'form-control','min' => 0,'max' => 100, 'step' => '0.01']) !!}
    </div>
</div>

<!-- Offer Start Date Field -->
<div id="div-offer_start_date" class="form-group mb-3">
    <label for="offer_start_date" class="col-lg-3 col-form-label">Offer Start Date</label>
    <div class="col-lg-9">
        <input type="text" id="offer_start_date" name="offer_start_date"
            class="form-control"
            placeholder="YYYY-MM-DD"
            value="{{ isset($offer) && $offer->offer_start_date ? \Carbon\Carbon::parse($offer->offer_start_date)->format('Y-m-d') : '' }}"
            required>
    </div>
</div>

<!-- Offer End Date Field -->
<div id="div-offer_end_date" class="form-group mb-3">
    <label for="offer_end_date" class="col-lg-3 col-form-label">Offer End Date</label>
    <div class="col-lg-9">
        <input type="text" id="offer_end_date" name="offer_end_date"
            class="form-control"
            placeholder="YYYY-MM-DD"
            value="{{ isset($offer) && $offer->offer_end_date ? \Carbon\Carbon::parse($offer->offer_end_date)->format('Y-m-d') : '' }}"
            required>
    </div>
</div>

<!-- Offer Settlement Date Field -->
<div id="div-offer_settlement_date" class="form-group mb-3">
    <label for="offer_settlement_date" class="col-lg-3 col-form-label">Offer Settlement Date</label>
    <div class="col-lg-9">
        <input type="text" id="offer_settlement_date" name="offer_settlement_date"
            class="form-control"
            placeholder="YYYY-MM-DD"
            value="{{ isset($offer) && $offer->offer_settlement_date ? \Carbon\Carbon::parse($offer->offer_settlement_date)->format('Y-m-d') : '' }}"
            required>
    </div>
</div>

<!-- Offer Maturity Date Field -->
<div id="div-offer_maturity_date" class="form-group mb-3">
    <label for="offer_maturity_date" class="col-lg-3 col-form-label">Offer Maturity Date</label>
    <div class="col-lg-9">
        <input type="text" id="offer_maturity_date" name="offer_maturity_date"
            class="form-control"
            placeholder="YYYY-MM-DD"
            value="{{ isset($offer) && $offer->offer_maturity_date ? \Carbon\Carbon::parse($offer->offer_maturity_date)->format('Y-m-d') : '' }}"
            required>
    </div>
</div>

<!-- Tenor Years Field -->
<div id="div-tenor_years" class="form-group mb-3">
    <label for="tenor_years" class="col-lg-3 col-form-label">Tenor (Years)</label>
    <div class="col-lg-9">
        {!! Form::number('tenor_years', null, ['id'=>'tenor_years', 'class' => 'form-control', 'min' => 1, 'max' => 50]) !!}
    </div>
</div>
