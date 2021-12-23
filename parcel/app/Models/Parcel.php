<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Parcel extends Model
{
    use HasFactory;

    const PENDING = 0;
    const PROCESSING = 1;
    const DELIVERED = 2;
    const CANCELED = 3;

    protected $fillable = [
        'pick_up_address',
        'drop_off_address',
        'status',
        'biker_id',
        'sender_id',
        'code',
        'price',
        'pick_up_date',
        'delivery_date',
        'recipient_mobile',
        'details'
    ];

    protected $dates = ['pick_up_date', 'delivery_date'];

    protected $appends = ['status_name'];

    protected $casts = ['details' => 'array'];

    public function scopeCanBePickedUp($query, int $biker_id)
    {
        return $query->whereIn('biker_id', [0, $biker_id]);
    }

    public function scopeSenderIs($query, int $sender_id)
    {
        return $query->where('sender_id', $sender_id);
    }

    public function getStatusNameAttribute()
    {
        $status = $this->attributes['status'] ?? 0;

        if ($status == self::PENDING) {
            return trans('messages.parcel_statuses.pending');
        }

        if ($status == self::PROCESSING) {
            return trans('messages.parcel_statuses.processing');
        }

        if ($status == self::DELIVERED) {
            return trans('messages.parcel_statuses.delivered');
        }

        if ($status == self::CANCELED) {
            return trans('messages.parcel_statuses.canceled');
        }
    }

    public function sender()
    {
        return $this->belongsTo(Sender::class, 'sender_id');
    }

    public function biker()
    {
        return $this->belongsTo(Biker::class, 'biker_id');
    }
}
