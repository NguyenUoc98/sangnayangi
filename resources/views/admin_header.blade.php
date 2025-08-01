@push('head')
    <meta name="robots" content="noindex" />
    <link
        href="{{ asset('/vendor/orchid/favicon.svg') }}"
        sizes="any"
        type="image/svg+xml"
        id="favicon"
        rel="icon"
    >

    <!-- For Safari on iOS -->
    <meta name="theme-color" content="#21252a">
@endpush

<div class="d-flex align-items-center">
    <img class="w-xxs" src="{{ asset('images/logo.png') }}">

    <div class="ms-3 my-0 d-none d-sm-block">
        <p class="h3">123doc</p>
        <small class="align-top opacity">Sáng nay ăn gì?</small>
    </div>
</div>
