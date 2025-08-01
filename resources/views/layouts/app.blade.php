<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.29/sweetalert2.min.css"/>
    @stack('css')

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

</head>
<body class="font-sans antialiased bg-[url('/images/bg.png')] bg-primary bg-opacity-25">
<div class="min-h-screen">
    @include('layouts.navigation')

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>
</div>
@livewireScripts
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.29/sweetalert2.min.js"></script>
@auth()
    <script type="module">
        Echo.private('App.Models.User.{{ auth()->id() }}')
            .notification((notification) => {
                Swal.fire({
                    html: '<p class="text-xl text-center">Người được chọn</p>' + '<p class="font-bold text-2xl text-center">' + notification.user_name + '</p>',
                    width: 600,
                    padding: '3em',
                    color: '#00a888',
                    background: '#fff url(/images/bg.png)',
                    backdrop: `
                                rgb(0, 168, 136, 0.4)
                                url("/images/nyan-cat.gif")
                                left bottom
                                no-repeat
                              `,
                    showConfirmButton: false
                });
            });
    </script>
@endauth
</body>
@stack('script')
</html>
