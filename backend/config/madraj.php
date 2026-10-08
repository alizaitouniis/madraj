<?php

return [

    // Times are stored in UTC and shown to people in Lebanon time.
    'timezone' => 'Asia/Beirut',

    'currency' => 'USD',

    // Group booking: 1 to 6 tickets per order, each with its own name and mobile.
    'max_tickets_per_order' => 6,

    // Stadium builder canvas and the fixed pitch, in canvas units (zones use the same units).
    'stadium_canvas' => [
        'width' => 580,
        'height' => 640,
        'pitch' => ['x' => 142, 'y' => 221, 'width' => 296, 'height' => 186],
    ],

];
