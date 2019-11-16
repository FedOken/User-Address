<?php
return [
    'admin' => [
        'type' => 1,
        'ruleName' => 'userRole',
        'children' => [
            'user',
        ],
    ],
    'user' => [
        'type' => 1,
        'ruleName' => 'userRole',
    ],
];
