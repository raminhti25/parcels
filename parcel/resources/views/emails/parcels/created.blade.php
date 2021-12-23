@component('mail::message')
Dear {{$sender['full_name']}}

Your parcel with code "{{$parcel['code']}}" created.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
