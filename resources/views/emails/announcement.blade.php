@component('mail::message')
    # Annoucement

    @php
    strip_tags(htmlspecialchars_decode($description));
    @endphp

    @component('mail::button', ['url' => url('/announcements')])
        View More Announcements
    @endcomponent

    Thanks, <br>
    {{-- {{ config('app.name') }} --}}
    School
@endcomponent
