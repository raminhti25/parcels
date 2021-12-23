<?php

namespace App\Policies;

use App\Models\Parcel;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class ParcelPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can pickup the parcel.
     *
     * @param  $user
     * @param  \App\Models\Parcel  $parcel
     * @return mixed
     */
    public function pickup($user, Parcel $parcel)
    {
        if ($parcel->status != Parcel::PENDING) {
            return Response::deny(trans('errors.pickup_parcel.parcel_not_pending'));
        }

        return Response::allow();
    }

    /**
     * Determine whether the user can deliver the parcel.
     *
     * @param  $user
     * @param  \App\Models\Parcel  $parcel
     * @return mixed
     */
    public function deliver($user, Parcel $parcel)
    {
        if ($parcel->status != Parcel::PROCESSING) {
            return Response::deny(trans('errors.deliver_parcel.not_in_progress'));
        }

        if ($parcel->biker_id != $user->id) {
            return Response::deny(trans('errors.deliver_parcel.not_belong'));
        }

        return Response::allow();
    }

    /**
     * Determine whether the user can cancel the parcel.
     *
     * @param  $user
     * @param  \App\Models\Parcel  $parcel
     * @return mixed
     */
    public function cancel($user, Parcel $parcel)
    {
        if ($parcel->status == Parcel::DELIVERED) {
            return Response::deny(trans('errors.cancel_parcel.already_delivered'));
        }

        if ($parcel->sender_id != $user->id) {
            return Response::deny(trans('errors.cancel_parcel.not_belong'));
        }

        return Response::allow();
    }
}
