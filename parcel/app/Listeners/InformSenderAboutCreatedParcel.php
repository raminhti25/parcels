<?php

namespace App\Listeners;

use App\Models\Sender;
use App\Events\ParcelCreated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;

class InformSenderAboutCreatedParcel implements ShouldQueue
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
     * @param  ParcelCreated  $event
     * @return void
     */
    public function handle(ParcelCreated $event)
    {
        $sender_id = $event->parcel['sender_id'] ?? 0;

        $sender = Sender::find($sender_id);

        if (!$sender) {
            return null;
        }

        Mail::to($sender->email)->send(new \App\Mail\ParcelCreated($event->parcel, $sender->toArray()));
    }
}
