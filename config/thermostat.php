<?php
/**
 * Created by PhpStorm.
 * User: matsui
 * Date: 2017/09/26
 * Time: 22:17
 */

return [
    'thermostat1' => [
        'accessory' => 'aircon',
        'command' => [
            'cooling' => collect(range(18, 32))->map(function ($t) {
                return ['temperature' => $t, 'command' => 'c'.$t ];
            }),
            'heating' => collect(range(14, 30))->map(function ($t) {
                return ['temperature' => $t, 'command' => 'h'.$t ];
            }),
            'off' => 'off',
        ]
    ],
];