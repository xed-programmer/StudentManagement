@component('mail::message')
    # Annoucement

    {{-- The body of your message. --}}
    {{-- Body --}}
    {!! $body !!}

    @component('mail::button', ['url' => url('/announcements')])
        View More Announcements
    @endcomponent

    Thanks, <br>
    {{ config('app.name') }}
@endcomponent
