<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>uVote</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    </head>
    <body class="antialiased">
        <h1>Homepage</h1>
        <p>This is page is intended for student</p>

        @auth
            <h2>Hi, {{auth()->user()->name}}</h2>
        @endauth

        @guest
            <a href="{{ route('google.signin') }}">Login as MyCSPC to cast vote</a>
        @endguest
    </body>
</html>
