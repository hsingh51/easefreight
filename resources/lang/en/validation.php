<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'The :attribute must be accepted.',
    'active_url'           => 'The :attribute is not a valid URL.',
    'after'                => 'The :attribute must be a date after :date.',
    'alpha'                => 'The :attribute may only contain letters.',
    'alpha_dash'           => 'The :attribute may only contain letters, numbers, and dashes.',
    'alpha_num'            => 'The :attribute may only contain letters and numbers.',
    'array'                => 'The :attribute must be an array.',
    'before'               => 'The :attribute must be a date before :date.',
    'between'              => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => 'The :attribute confirmation does not match.',
    'date'                 => 'The :attribute is not a valid date.',
    'date_format'          => 'The :attribute does not match the format :format.',
    'different'            => 'The :attribute and :other must be different.',
    'digits'               => 'The :attribute must be :digits digits.',
    'digits_between'       => 'The :attribute must be between :min and :max digits.',
    'email'                => 'The :attribute must be a valid email address.',
    'exists'               => 'The selected :attribute is invalid.',
    'filled'               => 'The :attribute field is required.',
    'image'                => 'The :attribute must be an image.',
    'in'                   => 'The selected :attribute is invalid.',
    'integer'              => 'The :attribute must be an integer.',
    'ip'                   => 'The :attribute must be a valid IP address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file'    => 'The :attribute may not be greater than :max kilobytes.',
        'string'  => 'The :attribute may not be greater than :max characters.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'The :attribute must be at least :min.',
        'file'    => 'The :attribute must be at least :min kilobytes.',
        'string'  => 'The :attribute must be at least :min characters.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'numeric'              => 'The :attribute must be a number.',
    'regex'                => 'The :attribute format is invalid.',
    'required'             => 'The :attribute field is required.',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'The :attribute has already been taken.',
    'url'                  => 'The :attribute format is invalid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'air' => [
            'required' => 'The IATA Airport CODE field is required',
        ],
        'des_air' => [
            'required' => 'The IATA Airport CODE field is required',
        ],
        'des_city_id' => [
            'required' => 'The City field is required',
        ],
        'des_country_id' => [
            'required' => 'The Country field is required',
        ],
        'city_id' => [
            'required' => 'The City field is required',
        ],
        'country_id' => [
            'required' => 'The Country field is required',
        ],
        'destination_terminal_id' => [
            'required' => 'The Terminal field is required',
        ],
        'destination_ocean_port_id' => [
            'required' => 'The Port field is required',
        ],
        'origin_terminal_id' => [
            'required' => 'The Terminal field is required',
        ],
        'origin_ocean_port_id' => [
            'required' => 'The Port field is required',
        ],
        'dest_col_department_id' => [
            'required' => 'The Department field is required',
        ],
        'dest_city_id' => [
            'required' => 'The City field is required',
        ],
        'org_col_department_id' => [
            'required' => 'The Department field is required',
        ],
        'org_city_id' => [
            'required' => 'The City field is required',
        ],
        'c_1TON' => [
            'required' => 'C-100 field is required',
            'numeric' => 'C-100 must be number',
        ],
        'c_1TON_stand_hours' => [
            'required' => 'StandBy/Hour Required',
            'numeric' => 'StandBy/Hour must be number',
        ],
        'c_4TON' => [
            'required' => 'C-300 field is required',
            'numeric' => 'C-300 must be number',
        ],
        'c_4TON_stand_hours' => [
            'required' => 'StandBy/Hour Required',
            'numeric' => 'StandBy/Hour must be number',
        ],
        'c_8TON' => [
            'required' => 'C-600 field is required',
            'numeric' => 'C-600 must be number',
        ],
        'c_8TON_stand_hours' => [
            'required' => 'StandBy/Hour Required',
            'numeric' => 'StandBy/Hour must be number',
        ],
        'c_16TON' => [
            'required' => 'DOBLETROQUE field is required',
            'numeric' => 'DOBLETROQUE must be number',
        ],
        'c_16TON_stand_hours' => [
            'required' => 'StandBy/Hour Required',
            'numeric' => 'StandBy/Hour must be number',
        ],
        'c_25TON' => [
            'required' => 'TRACTOR field is required',
            'numeric' => 'TRACTOR must be number',
        ],
        'c_25TON_stand_hours' => [
            'required' => 'StandBy/Hour required',
            'numeric' => 'StandBy/Hour must be number',

        ],
        'origin_terminal_id' => [
            'required' => "You didn't select terminal, if no terminal available pls create one",
            

        ],
        'destination_terminal_id' => [
            'required' => "You didn't select terminal, if no terminal available pls create one",
        ],
        'rate_20_ofc' => [
            'required' => "OFC field is required",
        ],
        'rate_20_baf' => [
            'required' => "BAF field is required",
        ],
        'rate_20_pss' => [
            'required' => "PSS field is required",
        ],
        'rate_40_ofc' => [
            'required' => "OFC field is required",
        ],
        'rate_40_baf' => [
            'required' => "BAF field is required",
        ],
        'rate_40_pss' => [
            'required' => "PSS field is required",
        ],
        'rate_40hc_ofc' => [
            'required' => "OFC field is required",
        ],
        'rate_40hc_baf' => [
            'required' => "BAF field is required",
        ],
        'rate_40hc_pss' => [
            'required' => "PSS field is required",
        ],
        'terminal_security_charges' => [
            'required' => "Security Charges field is required",
        ],
        'load_charges_20' => [
            'required' => "Load/Discharge 20 field is required",
        ],
        'load_charges_40' => [
            'required' => "Load/Discharge 40 field is required",
        ],
        'load_charges_40hc' => [
            'required' => "Load/Discharge 40hc field is required",
        ],
        'handling_charges_20' => [
            'required' => "Handling Charges 20 field is required",
        ],
        'handling_charges_40' => [
            'required' => "Handling Charges 40 field is required",
        ],
        'handling_charges_40hc' => [
            'required' => "Handling Charges  40hc field is required",
        ],
        'wharfage_20' => [
            'required' => "Wharfage 20 field is required",
        ],
        'wharfage_40' => [
            'required' => "Wharfage 40 field is required",
        ],
        'wharfage_40hc' => [
            'required' => "Wharfage  40hc field is required",
        ],
        'org_doc_fee_origin' => [
            'required' => "B/L DOC FEE ORIGIN field is required",
        ],
        'org_doc_fee_dest' => [
            'required' => "B/L DOC FEE DEST field is required",
        ],
        'org_doc_emssion_fee_dest' => [
            'required' => "B/L EMISSION DEST field is required",
        ],
        'CBM' => [
            'required' => "CBM field is required",
        ],
        'MTON' => [
            'required' => "MTON field is required",
        ],
        'rate_OFR' => [
            'required' => "OFR field is required",
        ],
        'rate_BAF' => [
            'required' => "BAF field is required",
        ],
        'estimated_transit' => [
            'required' => "Estimated Transit Time field is required",
        ],
        'carrier' => [
            'required' => "Carrier field is required",
        ],
        'org_doc_carrier_key' => [
            'required' => "Carrier field is required",
        ],
        'wharfage_lcl' => [
            'required' => "Wharfage lcl field is required",
        ],
        'wharfage_lcl_min' => [
            'required' => "Wharfage minimum LCL MIN field is required",
        ],
        'handling_charges_lcl' => [
            'required' => "Handling Charges field is required",
        ],
        'handling_charges_lcl_min' => [
            'required' => "Handling Charges minimum LCL MIN field is required",
        ],
        'load_charges_lcl' => [
            'required' => "Load/Discharge Charges field is required",
        ],
        'load_charges_lcl_min' => [
            'required' => "Load/Discharge Charges minimum LCL MIN field is required",
        ],
        'minium_rate' => [
            'required' => "Minium Rate field is required",
        ],        
        'less_100kg' => [
            'required' => "Less 100kg field is required",
        ],
        'more_500kg' => [
            'required' => "More 500kg field is required",
        ],
        'more_100kg' => [
            'required' => "More 100kg field is required",
        ],
        'more_300kg' => [
            'required' => "More 300kg is required",
        ], 
        'validity' => [
            'required' => "Validity field is required",
        ],
        'due_agent' => [
            'required' => "Due Agent field is required",
        ],
        'transit_time' => [
            'required' => "Transit Time field is required",
        ],
        'due_carrier' => [
            'required' => "Due Carrier field is required",
        ],
        'awb' => [
            'required' => "AWB field is required",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
