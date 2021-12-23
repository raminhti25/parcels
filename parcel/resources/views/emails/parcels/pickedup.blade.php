@component('mail::message')
Dear {{$sender['full_name'] ?? ''}}

Your parcel {{$parcel['code'] ?? ''}} was picked up at {{$parcel['pick_up_date']}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
