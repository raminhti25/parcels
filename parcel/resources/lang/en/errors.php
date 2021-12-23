<?php

return [
    'wrong_credentials' => 'Credentials not match',
    'pickup_parcel' => [
        'parcel_not_pending' => 'The status of Parcel is not pending.'
    ],
    'deliver_parcel' => [
        'already_delivered' => 'The parcel has been already delivered.',
        'not_in_progress'   => 'The parcel must be in progress.',
        'not_belong'        => 'The parcel has been picked up by another biker.'
    ],
    'cancel_parcel' => [
        'already_delivered' => 'The parcel has been already delivered.',
        'not_belong'        => 'The parcel has been picked up by another biker.'
    ]
];