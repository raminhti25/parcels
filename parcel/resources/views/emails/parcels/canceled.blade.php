@component('mail::message')
Dear {{$sender['full_name']}}

Your parcel {{$parcel['code']}} has been canceled

Thanks,<br>
{{ config('app.name') }}
@endcomponent
