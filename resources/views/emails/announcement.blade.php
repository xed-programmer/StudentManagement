@component('mail::message')
    # Annoucement

    @{{ $body }}

    @component('mail::button', ['url' => url('/announcements')])
        View More Announcements
    @endcomponent

    Thanks, <br>
    {{-- {{ config('app.name') }} --}}
    School
@endcomponent
