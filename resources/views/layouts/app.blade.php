<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Page Analyzer</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    </head>
    <body class="d-flex flex-column">
        <header style="background-color: #e3f2fd;">
            <nav class="navbar navbar-expand-lg mb-3 navbar-light">
                <div class="container">
                    <a class="navbar-brand" href="{{ route('root') }}">Анализатор страниц</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                      </button>
                    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                        <ul class="navbar-nav">
                            <li class="nav-item active">
                                <a class="nav-link" href="{{ route('root') }}">Главная</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('urls.index') }}">Сайты</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="container">
                @include('flash::message')
            </div>
        </header>
        <main role="main">
            @yield('content')
        </main>
        <footer class="text-muted">
            <div class="container">
                <p class="float-right">
                    <a href="#">Back to top</a>
                </p>
                <p>
                    Made by <a href="https://github.com/shapurid">Ivan Korney</a>
                </p>
            </div>
          </footer>
    </body>
</html>