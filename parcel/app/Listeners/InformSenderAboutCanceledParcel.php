<?php

namespace App\Listeners;

use App\Models\Sender;
use App\Events\ParcelCanceled;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;

class InformSenderAboutCanceledParcel implements ShouldQueue
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
     * @param  ParcelCanceled  $event
     * @return void
     */
    public function handle(ParcelCanceled $event)
    {
        $sender = Sender::find($event->parcel['sender_id'] ?? 0);

        if (!$sender) {
            return null;
        }

        Mail::to($sender->email)->send(new \App\Mail\ParcelCanceled($event->parcel, $sender->toArray()));
    }
}
