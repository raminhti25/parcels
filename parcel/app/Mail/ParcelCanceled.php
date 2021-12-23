<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ParcelCanceled extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $parcel;
    private $sender;

    /**
     * Create a new message instance.
     *
     * @param array $parcel
     * @param array $sender
     */
    public function __construct(array $parcel, array $sender)
    {
        $this->parcel = $parcel;
        $this->sender = $sender;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Parcel canceled')
            ->markdown('emails.parcels.canceled', ['parcel' => $this->parcel, 'sender' => $this->sender]);
    }
}
