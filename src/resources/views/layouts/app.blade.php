<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/sanitize.css')}}" />
    <link rel="stylesheet" href="{{asset('css/common.css')}}" />
    @yield('css')
    <title>FashionablyLate</title>
</head>
<body>
    <header>
            <div class="header_logo">FashionablyLate</div>
            @hasSection('header-button')
            <div class="header_button">
                @yield('header-button')
            </div>
            @endif
    </header>

    <main>
    @yield('content')
    </main>
</body>
</html>