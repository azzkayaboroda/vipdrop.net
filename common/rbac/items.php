<?php
return [
    'superuser' => [
        'type' => 1,
        'ruleName' => 'userRole',
        'children' => [
            'registered',
        ],
    ],
    'registered' => [
        'type' => 1,
        'ruleName' => 'userRole',
        'children' => [
            'guest',
        ],
    ],
    'guest' => [
        'type' => 1,
        'ruleName' => 'userRole',
    ],
];
