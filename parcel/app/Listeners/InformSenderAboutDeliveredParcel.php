<?php

namespace App\Listeners;

use App\Models\Sender;
use App\Events\ParcelDelivered;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;

class InformSenderAboutDeliveredParcel implements ShouldQueue
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
     * @param  ParcelDelivered  $event
     * @return void
     */
    public function handle(ParcelDelivered $event)
    {
        $sender_id = $event->parcel['sender_id'] ?? 0;

        $sender = Sender::find($sender_id);

        if (!$sender) {
            return null;
        }

        Mail::to($sender->email)->send(new \App\Mail\ParcelDelivered($event->parcel, $sender->toArray()));
    }
}
