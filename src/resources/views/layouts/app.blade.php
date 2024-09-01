<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rese</title>
    <script src="https://kit.fontawesome.com/88521f16f4.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/common.css')}}">
    @yield('css')
    @livewireStyles
</head>

<body>
    <header class="header">
        <div class="header__inner">
            @livewire('menu')
            <h1 class="header__logo">Rese</h1>
            @yield('search')
        </div>
    </header>
    <main class="content">
        @yield('content')
    </main>
    @livewireScripts
</body>

</html>