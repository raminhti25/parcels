<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ParcelDelivered extends Mailable implements ShouldQueue
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
        $parcel_code = $this->parcel['code'] ?? '';

        return $this
            ->subject("Parcel $parcel_code delivered")
            ->markdown('emails.parcels.delivered', ['parcel' => $this->parcel, 'sender' => $this->sender]);
    }
}
