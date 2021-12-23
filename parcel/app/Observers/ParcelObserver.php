<?php

namespace App\Observers;

use App\Models\Parcel;

class ParcelObserver
{
    public function creating(Parcel $parcel)
    {
        $parcel->code = substr(md5($parcel->sender_id . time() . rand(1,1000)), 0, 8);
    }
}
