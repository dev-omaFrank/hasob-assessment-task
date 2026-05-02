@php
    $store_route = route('sb.offers.store');
    $update_route = route('sb.offers.update', '');
    $show_route = route('sb.offers.show', '');
    $destroy_route = route('sb.offers.destroy', '');
@endphp

<div class="modal fade" id="mdl-offer-modal" tabindex="-1" role="dialog" aria-modal="true" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 id="lbl-offer-modal-title" class="modal-title">Offer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="div-offer-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-offer-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-12 ma-10">

                            @csrf

                            <div class="offline-flag"><span class="offline-offers">You are currently offline</span></div>

                            <div id="spinner-offers" class="spinner-border text-primary" role="status"> 
                                <span class="visually-hidden">Loading...</span>
                            </div>

                            <input type="hidden" id="txt-offer-primary-id" value="0" />
                            <div id="div-show-txt-offer-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">                            
                                    @include('dmo-savings-bond-module::pages.offers.show_fields')
                                    </div>
                                </div>
                            </div>
                            <div id="div-edit-txt-offer-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">
                                    @include('dmo-savings-bond-module::pages.offers.fields')
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>


            <div class="modal-footer" id="div-save-mdl-offer-modal">
                <button type="button" class="btn btn-primary" id="btn-save-mdl-offer-modal" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@push('page_scripts')
<script type="text/javascript">
$(document).ready(function() {

    $('.offline-offers').hide();

    //Show Modal for New Entry
    $(document).on('click', ".btn-new-mdl-offer-modal", function(e) {
        $('#div-offer-modal-error').hide();
        $('#mdl-offer-modal').modal('show');
        $('#frm-offer-modal').trigger("reset");
        $('#txt-offer-primary-id').val(0);

        // Clear date inputs
        $('#offer_start_date').val('');
        $('#offer_end_date').val('');
        $('#offer_settlement_date').val('');
        $('#offer_maturity_date').val('');

        $('#div-show-txt-offer-primary-id').hide();
        $('#div-edit-txt-offer-primary-id').show();

        $("#spinner-offers").hide();
        $("#div-save-mdl-offer-modal").attr('disabled', false);
    });

    //Show Modal for View
    $(document).on('click', ".btn-show-mdl-offer-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        if (!window.navigator.onLine) {
            $('.offline-offers').fadeIn(300);
            return;
        }else{
            $('.offline-offers').fadeOut(300);
        }

        $('#div-offer-modal-error').hide();
        $('#mdl-offer-modal').modal('show');
        $('#frm-offer-modal').trigger("reset");

        $("#spinner-offers").show();
        $("#div-save-mdl-offer-modal").attr('disabled', true);

        $('#div-show-txt-offer-primary-id').show();
        $('#div-edit-txt-offer-primary-id').hide();
        let itemId = $(this).attr('data-val');

        $.get("{{ $show_route }}/" + itemId).done(function(response) {
            $('#txt-offer-primary-id').val(response.id);
            $('#spn_offer_status').html(response.status || 'N/A');
            $('#spn_offer_offer_title').html(response.offer_title || 'N/A');
            $('#spn_offer_price_per_unit').html(response.price_per_unit || 'N/A');
            $('#spn_offer_max_units_per_investor').html(response.max_units_per_investor || 'N/A');
            $('#spn_offer_interest_rate_pct').html(response.interest_rate_pct || 'N/A');
            $('#spn_offer_offer_start_date').html(response.offer_start_date || 'N/A');
            $('#spn_offer_offer_end_date').html(response.offer_end_date || 'N/A');
            $('#spn_offer_offer_settlement_date').html(response.offer_settlement_date || 'N/A');
            $('#spn_offer_offer_maturity_date').html(response.offer_maturity_date || 'N/A');
            $('#spn_offer_tenor_years').html(response.tenor_years || 'N/A');

            $("#spinner-offers").hide();
            $("#div-save-mdl-offer-modal").attr('disabled', false);
        }).fail(function(xhr) {
            console.error('Error loading offer:', xhr);
            $("#spinner-offers").hide();
            $("#div-save-mdl-offer-modal").attr('disabled', false);
        });
    });

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-mdl-offer-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        $('#div-offer-modal-error').hide();
        $('#mdl-offer-modal').modal('show');
        $('#frm-offer-modal').trigger("reset");

        $("#spinner-offers").show();
        $("#div-save-mdl-offer-modal").attr('disabled', true);

        $('#div-show-txt-offer-primary-id').hide();
        $('#div-edit-txt-offer-primary-id').show();
        let itemId = $(this).attr('data-val');

        $.get("{{ $show_route }}/" + itemId).done(function(response) {     
            $('#txt-offer-primary-id').val(response.id);
            $('#status').val(response.status);
            $('#offer_title').val(response.offer_title);
            $('#price_per_unit').val(response.price_per_unit);
            $('#max_units_per_investor').val(response.max_units_per_investor);
            $('#interest_rate_pct').val(response.interest_rate_pct);

            // Format dates for DD-MM-YYYY display
            $('#offer_start_date').val(formatDateForDisplay(response.offer_start_date));
            $('#offer_end_date').val(formatDateForDisplay(response.offer_end_date));
            $('#offer_settlement_date').val(formatDateForDisplay(response.offer_settlement_date));
            $('#offer_maturity_date').val(formatDateForDisplay(response.offer_maturity_date));

            $('#tenor_years').val(response.tenor_years);

            $("#spinner-offers").hide();
            $("#div-save-mdl-offer-modal").attr('disabled', false);
        }).fail(function(xhr) {
            console.error('Error loading offer for edit:', xhr);
            $("#spinner-offers").hide();
            $("#div-save-mdl-offer-modal").attr('disabled', false);
        });
    });

    //Delete action
    $(document).on('click', ".btn-delete-mdl-offer-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        if (!window.navigator.onLine) {
            $('.offline-offers').fadeIn(300);
            return;
        }else{
            $('.offline-offers').fadeOut(300);
        }

        let itemId = $(this).attr('data-val');
        swal({
                title: "Are you sure you want to delete this Offer?",
                text: "You will not be able to recover this Offer if deleted.",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: false,
                closeOnCancel: true
            }, function(isConfirm) {
                if (isConfirm) {

                    let endPointUrl = "{{ $destroy_route }}/" + itemId;

                    let formData = new FormData();
                    formData.append('_token', $('input[name="_token"]').val());
                    formData.append('_method', 'DELETE');

                    $.ajax({
                        url:endPointUrl,
                        type: "POST",
                        data: formData,
                        cache: false,
                        processData:false,
                        contentType: false,
                        dataType: 'json',
                        success: function(result){
                            if(result.errors){
                                console.log(result.errors)
                                swal("Error", "Oops an error occurred. Please try again.", "error");
                            }else{
                                swal({
                                        title: "Deleted",
                                        text: "Offer deleted successfully",
                                        type: "success",
                                        confirmButtonClass: "btn-success",
                                        confirmButtonText: "OK",
                                        closeOnConfirm: false
                                    },function(){
                                        location.reload(true);
                                });
                            }
                        },
                    });
                }
            });

    });

    //Save details
    $('#btn-save-mdl-offer-modal').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        if (!window.navigator.onLine) {
            $('.offline-offers').fadeIn(300);
            return;
        }else{
            $('.offline-offers').fadeOut(300);
        }

        // Validate date format before sending
        var dateFields = ['offer_start_date', 'offer_end_date', 'offer_settlement_date', 'offer_maturity_date'];
        var dateRegex = /^\d{4}-\d{2}-\d{2}$/;
        var dateErrors = [];

        for (var i = 0; i < dateFields.length; i++) {
            var fieldName = dateFields[i];
            var fieldValue = document.getElementById(fieldName).value.trim();

            if (!fieldValue) {
                dateErrors.push(fieldName.replace(/_/g, ' ').replace(/\b\w/g, function(l){ return l.toUpperCase() }) + ' is required');
            } else if (!dateRegex.test(fieldValue)) {
                dateErrors.push(fieldName.replace(/_/g, ' ').replace(/\b\w/g, function(l){ return l.toUpperCase() }) + ' must be in YYYY-MM-DD format');
            }
        }

        if (dateErrors.length > 0) {
            $('#div-offer-modal-error').html('');
            $('#div-offer-modal-error').show();
            dateErrors.forEach(function(err) {
                $('#div-offer-modal-error').append('<li>' + err + '</li>');
            });
            return;
        }

        $("#spinner-offers").show();
        $("#div-save-mdl-offer-modal").attr('disabled', true);

        let actionType = "POST";
        let endPointUrl = "{{ $store_route }}";
        let primaryId = $('#txt-offer-primary-id').val();

        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());

        if (primaryId != "0"){
            actionType = "PUT";
            endPointUrl = "{{ $update_route }}/" + primaryId;
            formData.append('id', primaryId);
        }

        formData.append('_method', actionType);
        @if (isset($organization) && $organization!=null)
            formData.append('organization_id', '{{$organization->id}}');
        @endif
        formData.append('status', $('#status').val());
        formData.append('offer_title', $('#offer_title').val());
        formData.append('price_per_unit', $('#price_per_unit').val());
        formData.append('max_units_per_investor', $('#max_units_per_investor').val());
        formData.append('interest_rate_pct', $('#interest_rate_pct').val());
        formData.append('offer_start_date', document.getElementById('offer_start_date').value);
        formData.append('offer_end_date', document.getElementById('offer_end_date').value);
        formData.append('offer_settlement_date', document.getElementById('offer_settlement_date').value);
        formData.append('offer_maturity_date', document.getElementById('offer_maturity_date').value);
        formData.append('tenor_years', $('#tenor_years').val());

        $.ajax({
            url:endPointUrl,
            type: "POST",
            data: formData,
            cache: false,
            processData:false,
            contentType: false,
            dataType: 'json',
            success: function(result){
                if(result.errors){
                    $('#div-offer-modal-error').html('');
                    $('#div-offer-modal-error').show();

                    $.each(result.errors, function(key, value){
                        $('#div-offer-modal-error').append('<li class="">'+value+'</li>');
                    });
                }else{
                    $('#div-offer-modal-error').hide();
                    window.setTimeout( function(){

                        $('#div-offer-modal-error').hide();

                        swal({
                                title: "Saved",
                                text: "Offer saved successfully",
                                type: "success",
                                showCancelButton: false,
                                closeOnConfirm: false,
                                confirmButtonClass: "btn-success",
                                confirmButtonText: "OK",
                                closeOnConfirm: false
                            },function(){
                                location.reload(true);
                        });

                    },20);
                }

                $("#spinner-offers").hide();
                $("#div-save-mdl-offer-modal").attr('disabled', false);

            }, error: function(data){
                console.log(data);
                swal("Error", "Oops an error occurred. Please try again.", "error");

                $("#spinner-offers").hide();
                $("#div-save-mdl-offer-modal").attr('disabled', false);

            }
        });
    });

});

function formatDateForDisplay(dateString) {
    if (!dateString) return '';
    let date = dateString.split(' ')[0];
    let parts = date.split('-');
    if (parts.length !== 3) return '';
    let [year, month, day] = parts;
    return `${year}-${month}-${day}`;
}
</script>
@endpush
