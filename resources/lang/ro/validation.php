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

    'accepted' => 'Atributul :attribute trebuie acceptat.',
    'active_url' => 'Atributul :attribute nu este un URL valid.',
    'after' => 'Atributul :attribute trebuie să fie o dată după :date.',
    'after_or_equal' => 'Atributul :attribute trebuie să fie o dată după sau egală cu :date.',
    'alpha' => 'Atributul :attribute poate conține doar litere.',
    'alpha_dash' => 'Atributul :attribute poate conține doar litere, cifre, puncte și liniuțe de subliniere.',
    'alpha_num' => 'Atributul :attribute poate conține doar litere și cifre.',
    'alpha_space' => 'Atributul :attribute poate conține doar litere, spații sau liniuțe.',
    'array' => 'Atributul :attribute trebuie să fie un array.',
    'before' => 'Atributul :attribute trebuie să fie o dată înainte de :date.',
    'before_or_equal' => 'Atributul :attribute trebuie să fie o dată anterioară sau egală cu :date.',
    'between' => [
        'numeric' => 'Atributul :attribute trebuie să fie între: min și: max.',
        'file' => 'Atributul :attribute trebuie să fie între: min și: max kilobytes.',
        'string' => 'Atributul :attribute trebuie să fie între :min și :max caractere.',
        'array' => 'Atributul :attribute trebuie să aibă între :min și :max elemente.',
    ],
    'boolean' => 'Câmpul :attribute trebuie să fie adevărat sau fals.',
    'confirmed' => 'Confirmarea :attribute nu se potrivește.',
    'date' => 'Elementul :attribute nu este o dată validă.',
    'date_equals' => 'Elementul :attribute trebuie să fie o dată egală cu :date.',
    'date_format' => 'Elementul :attribute nu se potrivește cu formatul :format.',
    'different' => 'Elementele :attribute și :other trebuie să fie diferite.',
    'digits' => 'Elementul :attribute trebuie să fie :digits cifre.',
    'digits_between' => 'Elementul :attribute trebuie să fie între :min și :max cifre.',
    'dimensions' => 'Elementul :attribute nu are dimensiuni valide ale imaginii.',
    'distinct' => 'Câmpul :attribute are o valoare duplicat.',
    'email' => 'Elementul :attribute trebuie să fie o adresă de e-mail validă.',
    'ends_with' => 'Elementul :attribute trebuie să se încheie cu unul dintre următoarele: :values.',
    'exists' => 'Elementul :attribute selectat nu este valid.',
    'file' => 'Elementul :attribute trebuie să fie un fișier.',
    'filled' => 'Câmpul :attribute trebuie să aibă o valoare.',
    'gt' => [
        'numeric' => 'Elementul :attribute trebuie să fie mai mare decât :value.',
        'file' => 'Elementul :attribute trebuie să fie mai mare de :value kilobiți (kb).',
        'string' => 'Elementul :attribute trebuie să fie mai mare decât :value caractere.',
        'array' => 'Elementul :attribute trebuie să aibă mai mult de :value elemente.',
    ],
    'gte' => [
        'numeric' => 'Elementul :attribute trebuie să fie mai mare sau egal cu :value.',
        'file' => 'Elementul :attribute trebuie să fie mai mare sau egal cu :value kilobiți (kb).',
        'string' => 'Elementul :attribute trebuie să fie mai mare sau egal cu :value caractere.',
        'array' => 'Elementul :attribute trebuie să aibă :value elemente sau mai multe.',
    ],
    'image' => 'Elementul :attribute trebuie să fie o imagine.',
    'in' => 'Elementul :attribute selectat nu este valid.',
    'in_array' => 'Câmpul :attribute nu există în :other.',
    'integer' => 'Elementul :attribute trebuie să fie un număr întreg.',
    'ip' => 'Elementul :attribute trebuie să fie o adresă IP validă.',
    'ipv4' => 'Elementul :attribute trebuie să fie o adresă IPv4 validă.',
    'ipv6' => 'Elementul :attribute trebuie să fie o adresă IPv6 validă.',
    'json' => 'Elementul :attribute trebuie să fie un șir JSON valid.',
    'lt' => [
        'numeric' => 'Elementul :attribute trebuie să fie mai mic decât :value.',
        'file' => 'Elementul :attribute trebuie să fie mai mic de :value kilobiți(kb).',
        'string' => 'Elementul :attribute trebuie să fie mai mic decât :value caractere.',
        'array' => 'Elementul :attribute trebuie să aibă mai puțin de :value elemente.',
    ],
    'lte' => [
        'numeric' => 'Elementul :attribute trebuie să fie mai mic sau egal cu :value.',
        'file' => 'Elementul :attribute trebuie să fie mai mic sau egal cu :value kilobiți(kb).',
        'string' => 'Elementul :attribute trebuie să fie mai mic sau egal cu :value caractere.',
        'array' => 'Elementul :attribute nu trebuie să aibă mai mult de :value elemente.',
    ],
    'max' => [
        'numeric' => 'Elementul :attribute nu poate fi mai mare de :max.',
        'file' => 'Elementul :attribute nu poate fi mai mare de :max kilobiți(kb).',
        'string' => 'Elementul :attribute nu poate fi mai mare de :max caractere.',
        'array' => 'Elementul :attribute nu poate avea mai mult de :max articole.',
    ],
    'mimes' => 'Elementul :attribute trebuie să fie un fișier de tip: :values.',
    'mimetypes' => 'Elementul :attribute trebuie să fie un fișier de tip: :values.',
    'min' => [
        'numeric' => 'Elementul :attribute trebuie să fie cel puțin: min.',
        'file' => 'Elementul :attribute trebuie să fie cel puțin: min kiloocteți.',
        'string' => 'Elementul :attribute trebuie să aibă cel puțin: min caractere.',
        'array' => ':attribute trebuie să aibă cel puțin :min elemente.',
    ],
    'not_in' => 'Elementul :attribute selectat nu este valid.',
    'not_regex' => 'Formatul :attribute nu este valid.',
    'numeric' => 'Elementul :attribute trebuie să fie un număr.',
    'password' => 'Parola este incorectă.',
    'present' => 'Câmpul :attribute trebuie să fie prezent.',
    'regex' => 'Formatul :attribute nu este valid.',
    'required' => 'Câmpul :attribute este obligatoriu.',
    'required_if' => 'Câmpul :attribute este necesar atunci când :other este :value.',
    'required_unless' => 'Câmpul :attribute este obligatoriu, cu excepția cazului în care :other este în :values.',
    'required_with' => 'Câmpul :attribute este necesar atunci când :values este prezent.',
    'required_with_all' => 'Câmpul :attribute este obligatoriu atunci când :values sunt prezente.',
    'required_without' => 'Câmpul :attribute este obligatoriu când :values nu sunt prezente.',
    'required_without_all' => 'Câmpul :attribute este obligatoriu atunci când niciuna dintre :values nu este prezentă.',
    'same' => 'Elementul :attribute și :other trebuie să se potrivească.',
    'size' => [
        'numeric' => 'Elementul :attribute trebuie să fie :size.',
        'file' => 'Elementul :attribute trebuie să fie :size kilobiți(kb).',
        'string' => 'Elementul :attribute trebuie să fie :size caractere.',
        'array' => 'Elementul :attribute trebuie să conțină elemente de mărime.',
    ],
    'starts_with' => 'Elementul :attribute trebuie să înceapă cu unul dintre următoarele: :values.',
    'string' => 'Elementul :attribute trebuie să fie un șir de caractere.',
    'timezone' => 'Elementul :attribute trebuie să fie o zonă validă.',
    'unique' => 'Elementul :attribute a fost deja luat.',
    'uploaded' => 'Elementul :attribute a eșuat la încărcare.',
    'url' => 'Formatul :attribute nu este valid.',
    'uuid' => 'Elementul :attribute trebuie să fie un UUID valid.',

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
