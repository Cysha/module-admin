<?php

return [
    [
        'name' => 'Text',
        'view' => 'admin::fields.input',
        'type' => 'text',
        'options' => [
            'class' => 'form-control',
            'placeholder' => 'textbox',
        ],
    ],
    [
        'name' => 'Color',
        'view' => 'admin::fields.input',
        'type' => 'color',
        'value' => '#00ffff',
        'options' => [
            'class' => null,
        ],
    ],
    [
        'name' => 'Radio',
        'view' => 'admin::fields.radio',
        'value' => 2,
        'options' => [
            'options' => [
                'Radio 1' => ['value' => 1, 'name' => 'radio'],
                'Radio 2' => ['value' => 2, 'name' => 'radio'],
                'Radio 3' => ['value' => 3, 'name' => 'radio'],
                'Radio 4' => ['value' => 4, 'name' => 'radio'],
            ]
        ],
    ],
    [
        'name' => 'Select Box',
        'view' => 'admin::fields.select',
        'value' => 2,
        'options' => [
            'options' => [
                'option 1' => ['value' => 1],
                'option 2' => ['value' => 2],
                'option 3' => ['value' => 3],
                'option 4' => ['value' => 4],
            ]
        ],
    ],
    [
        'name' => 'Multi Select Box',
        'view' => 'admin::fields.select',
        'options' => [
            'multiple' => true,
            'selected' => 2,
            'options' => [
                'option 1' => ['value' => 1],
                'option 2' => ['value' => 2],
                'option 3' => ['value' => 3],
                'option 4' => ['value' => 4],
            ]
        ],
    ]
];
