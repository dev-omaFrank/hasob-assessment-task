<?php

namespace DMO\SavingsBond\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Hasob\FoundationCore\Requests\AppBaseFormRequest;

class UpdateOfferRequest extends AppBaseFormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'organization_id' => 'required',
            'display_ordinal' => 'nullable|min:0|max:365',
            'wf_status' => 'max:100',
            'wf_meta_data' => 'max:1000',
            'offer_title' => 'required|string|max:255',
            'price_per_unit' => 'required|numeric|min:0',
            'max_units_per_investor' => 'required|integer|min:1',
            'interest_rate_pct' => 'required|numeric|min:0|max:100',
            'offer_start_date' => ['required', 'date'],
            'offer_end_date' => ['required', 'date', 'after_or_equal:offer_start_date'],
            'offer_settlement_date' => ['required', 'date', 'after_or_equal:offer_end_date'],
            'offer_maturity_date' => ['required', 'date', 'after_or_equal:offer_settlement_date'],
            'tenor_years' => 'required|integer|min:1|max:50',
        ];
    }

   protected function prepareForValidation(): void
    {
        $input = $this->all();

        $dateFields = [
            'offer_start_date',
            'offer_end_date',
            'offer_settlement_date',
            'offer_maturity_date'
        ];

        foreach ($dateFields as $field) {
            if (!empty($input[$field])) {
                $input[$field] = str_replace('T', ' ', $input[$field]);
            }
        }

        $this->replace($input);
    }

    public function messages(): array
    {
        return [
            'offer_end_date.after_or_equal' => 'The offer end date must be on or after the start date.',
            'offer_settlement_date.after_or_equal' => 'The settlement date must be on or after the end date.',
            'offer_maturity_date.after_or_equal' => 'The maturity date must be on or after the settlement date.',
        ];
    }
}
