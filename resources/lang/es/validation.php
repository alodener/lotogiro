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

    'accepted'             => 'El campo :attribute debe ser aceptado.',
    'active_url'           => 'El campo :attribute no es una URL válida.',
    'after'                => 'El campo :attribute debe ser una fecha posterior a :date.',
    'after_or_equal'       => 'El campo :attribute debe ser una fecha posterior o igual a :date.',
    'alpha'                => 'El campo :attribute sólo puede contener letras.',
    'alpha_dash'           => 'El campo :attribute solo puede contener letras, números y guiones.',
    'alpha_num'            => 'El campo :attribute solo puede contener letras y números.',
    'array'                => 'El campo :attribute debe ser una matriz.',
    'before'               => 'El campo :attribute debe ser una fecha anterior :date.',
    'before_or_equal'      => 'El campo :attribute debe ser una fecha anterior o igual a :date.',
    'between'              => [
        'numeric' => 'El campo :attribute debe estar entre :min y :max.',
        'file'    => 'El campo :attribute debe estar entre :min y :max kilobytes.',
        'string'  => 'El campo :attribute debe estar entre :min y :max caracteres.',
        'array'   => 'El campo :attribute debe estar entre :min y :max itens.',
    ],
    'boolean'              => 'El campo :attribute debe ser verdadero o falso.',
    'confirmed'            => 'El campo :attribute la confirmación no coincide.',
    'date'                 => 'El campo :attribute no es una fecha válida.',
    'date_equals'          => 'El campo :attribute debe ser una fecha igual a :date.',
    'date_format'          => 'El campo :attribute no coincide con el formato :format.',
    'different'            => 'Los campos :attribute y :other deben ser diferente.',
    'digits'               => 'El campo :attribute debe tener :digits dígitos.',
    'digits_between'       => 'El campo :attribute debe tener entre :min y :max dígitos.',
    'dimensions'           => 'El campo :attribute tiene dimensiones de imagen no válidas.',
    'distinct'             => 'El campo :attribute campo tiene un valor duplicado.',
    'email'                => 'El campo :attribute debe ser una dirección de correo electrónico válida.',
    'ends_with'            => 'El campo :attribute debe terminar con uno de los siguientes: :values',
    'exists'               => 'El campo :attribute seleccionado no es válido.',
    'file'                 => 'El campo :attribute debe ser un archivo.',
    'filled'               => 'El campo :attribute debe tener un valor.',
    'gt' => [
        'numeric' => 'El campo :attribute debe ser mayor que :value.',
        'file'    => 'El campo :attribute debe ser mayor que :value kilobytes.',
        'string'  => 'El campo :attribute debe ser mayor que :value caracteres.',
        'array'   => 'El campo :attribute debe contener más de :value itens.',
    ],
    'gte' => [
        'numeric' => 'El campo :attribute debe ser mayor o igual que :value.',
        'file'    => 'El campo :attribute debe ser mayor o igual que :value kilobytes.',
        'string'  => 'El campo :attribute debe ser mayor o igual que :value caracteres.',
        'array'   => 'El campo :attribute debe contener :value artículos o más.',
    ],
    'image'                => 'El campo :attribute debe ser una imagen.',
    'in'                   => 'El campo :attribute seleccionado no es válido.',
    'in_array'             => 'El campo :attribute no existe en :other.',
    'integer'              => 'El campo :attribute debe ser un numero entero.',
    'ip'                   => 'El campo :attribute debe ser una dirección IP válida.',
    'ipv4'                 => 'El campo :attribute debe ser una dirección IPv4 válida.',
    'ipv6'                 => 'El campo :attribute debe ser una dirección IPv6 válida.',
    'json'                 => 'El campo :attribute debe ser una cadena JSON válida.',
    'lt' => [
        'numeric' => 'El campo :attribute debe ser menor que :value.',
        'file'    => 'El campo :attribute debe ser menor que :value kilobytes.',
        'string'  => 'El campo :attribute debe ser menor que :value caracteres.',
        'array'   => 'El campo :attribute debe contener menos de :value itens.',
    ],
    'lte' => [
        'numeric' => 'El campo :attribute debe ser menor o igual que :value.',
        'file'    => 'El campo :attribute debe ser menor o igual que :value kilobytes.',
        'string'  => 'El campo :attribute debe ser menor o igual que :value caracteres.',
        'array'   => 'El campo :attribute no debe contener más de :value itens.',
    ],
    'max' => [
        'numeric' => 'El campo :attribute no puede ser superior a :max.',
        'file'    => 'El campo :attribute no puede ser superior a :max kilobytes.',
        'string'  => 'El campo :attribute no puede ser superior a :max caracteres.',
        'array'   => 'El campo :attribute no puede tener más de :max itens.',
    ],
    'mimes'                => 'El campo :attribute debe ser un archivo como: :values.',
    'mimetypes'            => 'El campo :attribute debe ser un archivo como: :values.',
    'min' => [
        'numeric' => 'El campo :attribute al menos debe ser :min.',
        'file'    => 'El campo :attribute al menos debe ser :min kilobytes.',
        'string'  => 'El campo :attribute al menos debe ser :min caracteres.',
        'array'   => 'El campo :attribute al menos debe ser :min itens.',
    ],
    'not_in'               => 'El campo :attribute seleccionado no es válido.',
    'not_regex'            => 'El campo :attribute tiene un formato inválido.',
    'numeric'              => 'El campo :attribute tiene que ser un número.',
    'password'             => 'La contraseña es incorrecta.',
    'present'              => 'El campo :attribute debe estar presente.',
    'regex'                => 'El campo :attribute tiene un formato inválido.',
    'required'             => 'El campo :attribute es obligatorio.',
    'required_if'          => 'El campo :attribute es obligatorio cuando :other for :value.',
    'required_unless'      => 'El campo :attribute es obligatorio excepto cuando :other for :values.',
    'required_with'        => 'El campo :attribute es obligatorio cuando :values está presente.',
    'required_with_all'    => 'El campo :attribute es obligatorio cuando :values está presente.',
    'required_without'     => 'El campo :attribute es obligatorio cuando :values no está presente.',
    'required_without_all' => 'El campo :attribute es obligatorio cuando ninguno de los :values están presentes.',
    'same'                 => 'Los campos :attribute y :other deben corresponder.',
    'size'                 => [
        'numeric' => 'El campo :attribute debe ser :size.',
        'file'    => 'El campo :attribute debe ser :size kilobytes.',
        'string'  => 'El campo :attribute debe ser :size caracteres.',
        'array'   => 'El campo :attribute debe contener :size itens.',
    ],
    'starts_with'          => 'El campo :attribute debe comenzar con uno de los siguientes valores: :values',
    'string'               => 'El campo :attribute debe ser una cadena.',
    'timezone'             => 'El campo :attribute debe ser una zona válida.',
    'unique'               => 'El campo :attribute ya ha sido registrado.',
    'uploaded'             => 'Carga de campo fallida :attribute.',
    'url'                  => 'El campo :attribute tiene un formato inválido.',
    'uuid' => 'El campo :attribute debe ser un UUID válido.',

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

    'attributes' => [
        'account'   => 'cuenta',
        'address'   => 'dirección',
        'age'       => 'edad',
        'agency'    => 'agencia',
        'alias'     => 'nombre visible',
        'amount'    => 'valor',
        'bank'      => 'banco',
        'balance'   => 'balance',
        'body'      => 'contenido',
        'cell'      => 'teléfono móvil',
        'city'      => 'ciudad',
        'country'   => 'país',
        'columns'   => 'columnas',
        'commission'   => 'comisión',
        'competition'   => 'concurso',
        'client'    => 'cliente',
        'date'      => 'fecha',
        'day'       => 'día',
        'dozens'    => 'docenas',
        'excerpt'   => 'resumen',
        'first_name'=> 'primer nombre',
        'gender'    => 'género',
        'hour'      => 'hora',
        'last_name' => 'apellido',
        'message'   => 'mensaje',
        'minute'    => 'minuto',
        'mobile'    => 'teléfono móvil',
        'month'     => 'mes',
        'name'      => 'nombre',
        'neighborhood' => 'vecindario',
        'number'    => 'número',
        'numbers'    => 'números',
        'password'  => 'contraseña',
        'phone'     => 'teléfono',
        'prize'     => 'otorgar',
        'second'    => 'segundo',
        'sex'       => 'sexo',
        'sort_date' => 'fecha del sorteo',
        'state'     => 'estado',
        'street'    => 'camino',
        'subject'   => 'sujeto',
        'text'      => 'texto',
        'time'      => 'hora',
        'type_account'  => 'tipo de cuenta',
        'typeGame'  => 'tipo de juego',
        'type_game'  => 'tipo de juego',
        'title'     => 'título',
        'username'  => 'usuario',
        'year'      => 'año',
        'description' => 'descripción',
        'password_confirmation' => 'confirmación de contraseña',
    ],

];
