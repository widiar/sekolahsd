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

    'accepted'             => 'Isian <strong>:attribute</strong> harus diterima.',
    'active_url'           => 'Isian <strong>:attribute</strong> bukan URL yang sah.',
    'after'                => 'Isian <strong>:attribute</strong> harus tanggal setelah :date.',
    'after_or_equal' => 'Isian <strong>:attribute</strong> harus berupa tanggal setelah atau sama dengan tanggal :date.',
    'alpha'                => 'Isian <strong>:attribute</strong> hanya boleh berisi huruf.',
    'alpha_dash'           => 'Isian <strong>:attribute</strong> hanya boleh berisi huruf, angka, dan strip.',
    'alpha_num'            => 'Isian <strong>:attribute</strong> hanya boleh berisi huruf dan angka.',
    'array'                => 'Isian <strong>:attribute</strong> harus berupa sebuah array.',
    'before'               => 'Isian <strong>:attribute</strong> harus tanggal sebelum :date.',
    'before_or_equal' => 'Isian <strong>:attribute</strong> harus berupa tanggal sebelum atau sama dengan tanggal :date.',
    'between'              => [
        'numeric' => 'Isian <strong>:attribute</strong> harus antara :min dan :max.',
        'file'    => 'Isian <strong>:attribute</strong> harus antara :min dan :max kilobytes.',
        'string'  => 'Isian <strong>:attribute</strong> harus antara :min dan :max karakter.',
        'array'   => 'Isian <strong>:attribute</strong> harus antara :min dan :max item.',
    ],
    'boolean'              => 'Isian <strong>:attribute</strong> harus berupa true atau false',
    'confirmed'            => 'Konfirmasi <strong>:attribute</strong> tidak cocok.',
    'date'                 => 'Isian <strong>:attribute</strong> bukan tanggal yang valid.',
    'date_equals' => 'The <strong>:attribute</strong> must be a date equal to :date.',
    'date_format' => 'The <strong>:attribute</strong> does not match the format :format.',
    'different'            => 'Isian <strong>:attribute</strong> dan :other harus berbeda.',
    'digits'               => 'Isian <strong>:attribute</strong> harus berupa angka :digits.',
    'digits_between' => 'Isian <strong>:attribute</strong> harus antara angka :min dan :max.',
    'dimensions'           => 'Isian <strong>:attribute</strong> harus merupakan dimensi gambar yang sah.',
    'distinct'             => 'Isian <strong>:attribute</strong> memiliki nilai yang duplikat.',
    'email'                => 'Isian <strong>:attribute</strong> harus berupa alamat surel yang valid.',
    'exists'               => 'Isian <strong>:attribute</strong> yang dipilih tidak valid.',
    'file' => 'Bidang <strong>:attribute</strong> harus berupa sebuah berkas.',
    'filled'               => 'Isian <strong>:attribute</strong> wajib diisi.',
    'gt' => [
        'numeric' => 'The <strong>:attribute</strong> must be greater than :value.',
        'file' => 'The <strong>:attribute</strong> must be greater than :value kilobytes.',
        'string' => 'The <strong>:attribute</strong> must be greater than :value characters.',
        'array' => 'The <strong>:attribute</strong> must have more than :value items.',
    ],
    'gte' => [
        'numeric' => 'The <strong>:attribute</strong> must be greater than or equal :value.',
        'file' => 'The <strong>:attribute</strong> must be greater than or equal :value kilobytes.',
        'string' => 'The <strong>:attribute</strong> must be greater than or equal :value characters.',
        'array' => 'The <strong>:attribute</strong> must have :value items or more.',
    ],
    'image'                => 'Isian <strong>:attribute</strong> harus berupa gambar.',
    'in'                   => 'Isian <strong>:attribute</strong> yang dipilih tidak valid.',
    'in_array'             => 'Isian <strong>:attribute</strong> tidak terdapat dalam :other.',
    'integer'              => 'Isian <strong>:attribute</strong> harus merupakan bilangan bulat.',
    'ip'                   => 'Isian <strong>:attribute</strong> harus berupa alamat IP yang valid.',
    'ipv4' => 'Isian <strong>:attribute</strong> harus berupa alamat IPv4 yang valid.',
    'ipv6' => 'Isian <strong>:attribute</strong> harus berupa alamat IPv6 yang valid.',
    'json'                 => 'Isian <strong>:attribute</strong> harus berupa JSON string yang valid.',
    'lt' => [
        'numeric' => 'The <strong>:attribute</strong> must be less than :value.',
        'file' => 'The <strong>:attribute</strong> must be less than :value kilobytes.',
        'string' => 'The <strong>:attribute</strong> must be less than :value characters.',
        'array' => 'The <strong>:attribute</strong> must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'The <strong>:attribute</strong> must be less than or equal :value.',
        'file' => 'The <strong>:attribute</strong> must be less than or equal :value kilobytes.',
        'string' => 'The <strong>:attribute</strong> must be less than or equal :value characters.',
        'array' => 'The <strong>:attribute</strong> must not have more than :value items.',
    ],
    'max'                  => [
        'numeric' => 'Isian <strong>:attribute</strong> seharusnya tidak lebih dari <strong>:max</strong>.',
        'file'    => 'Isian <strong>:attribute</strong> seharusnya tidak lebih dari :max kilobytes.',
        'string'  => 'Isian <strong>:attribute</strong> seharusnya tidak lebih dari :max karakter.',
        'array'   => 'Isian <strong>:attribute</strong> seharusnya tidak lebih dari :max item.',
    ],
    'mimes'                => 'Isian <strong>:attribute</strong> harus dokumen berjenis : :values.',
    'mimetypes' => 'The <strong>:attribute</strong> must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'Isian <strong>:attribute</strong> harus minimal :min.',
        'file'    => 'Isian <strong>:attribute</strong> harus minimal :min kilobytes.',
        'string'  => 'Isian <strong>:attribute</strong> harus minimal :min karakter.',
        'array'   => 'Isian <strong>:attribute</strong> harus minimal :min item.',
    ],
    'not_in'               => 'Isian <strong>:attribute</strong> yang dipilih tidak valid.',
    'not_regex' => 'The <strong>:attribute</strong> format is invalid.',
    'numeric'              => 'Isian <strong>:attribute</strong> harus berupa angka.',
    'present'              => 'Isian <strong>:attribute</strong> wajib ada.',
    'regex'                => 'Format isian <strong>:attribute</strong> tidak valid.',
    'required'             => 'Isian <strong>:attribute</strong> wajib diisi.',
    'required_if'          => 'Isian <strong>:attribute</strong> wajib diisi bila :other adalah :value.',
    'required_unless'      => 'Isian <strong>:attribute</strong> wajib diisi kecuali :other memiliki nilai :values.',
    'required_with'        => 'Isian <strong>:attribute</strong> wajib diisi bila terdapat :values.',
    'required_with_all'    => 'Isian <strong>:attribute</strong> wajib diisi bila terdapat :values.',
    'required_without'     => 'Isian <strong>:attribute</strong> wajib diisi bila tidak terdapat :values.',
    'required_without_all' => 'Isian <strong>:attribute</strong> wajib diisi bila tidak terdapat ada :values.',
    'same'                 => 'Isian <strong>:attribute</strong> dan :other harus sama.',
    'size'                 => [
        'numeric' => 'Isian <strong>:attribute</strong> harus berukuran :size.',
        'file'    => 'Isian <strong>:attribute</strong> harus berukuran :size kilobyte.',
        'string'  => 'Isian <strong>:attribute</strong> harus berukuran :size karakter.',
        'array'   => 'Isian <strong>:attribute</strong> harus mengandung :size item.',
    ],
    'starts_with' => 'The <strong>:attribute</strong> must start with one of the following: :values',
    'string'               => 'Isian <strong>:attribute</strong> harus berupa string.',
    'timezone'             => 'Isian <strong>:attribute</strong> harus berupa zona waktu yang valid.',
    'unique'               => 'Isian <strong>:attribute</strong> sudah ada sebelumnya.',
    'uploaded' => 'The <strong>:attribute</strong> failed to upload.',
    'url'                  => 'Format isian <strong>:attribute</strong> tidak valid.',
    'uuid' => 'The <strong>:attribute</strong> must be a valid UUID.',

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
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
