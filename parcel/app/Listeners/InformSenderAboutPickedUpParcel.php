<?php

namespace App\Listeners;

use App\Models\Sender;
use App\Events\ParcelPickedUp;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;

class InformSenderAboutPickedUpParcel implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ParcelPickedUp  $event
     * @return void
     */
    public function handle(ParcelPickedUp $event)
    {
        $sender_id = $event->parcel['sender_id'] ?? 0;

        $sender = Sender::find($sender_id);

        if (!$sender) {
            return null;
        }

        Mail::to($sender->email)->send(new \App\Mail\ParcelPickedUp($event->parcel, $sender->toArray()));
    }
}
