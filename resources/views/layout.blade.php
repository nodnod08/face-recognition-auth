<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Face Auth | User Management</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
        
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <script src="{{ asset('js/face-api.min.js?v=' . \Carbon\Carbon::now()->timestamp) }}"></script>
    </head>
    <body>
    
        @section('app')
            <div id='app'>
                <v-app>
                    @yield('app-content')
                    <snack-bar/>
                </v-app>
            </div>
        @show

        <script src="{{ asset('js/app.js?v=' . \Carbon\Carbon::now()->timestamp) }}"></script>

    </body>
</html>
