<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Home</title>
    @vite('resources/css/app.css')
</head>
<body>
    <header>
        <nav>
            <ul>
                <li>

                    @guest
                        <a href="{{ route('login-view')}}">Войти</a>
                    @endguest
                    @auth
                        <a href="{{ route('profile', Auth::user()->email) }}">Войти</a>
                    @endauth
                </li>
                <li>

                </li>
                <li>

                </li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="products">
            @foreach ($products as $product)
            <div class="card">
                
                <a style="text-decoration: none" href="{{ route('product', $product->id) }}"><h1>{{ $product->name }}</h1><a style="text-decoration: none" href="{{ route('product', $product->id) }}">
                <p class="price">$ {{ $product->price }}</p>
                <p>{{$product->category}}</p>
                @guest
                <p><button onclick="window.location.replace('/auth/login');">Добавить</button></p>
                @endguest
                @auth
                <p><button onclick="addCart({{ $product->id }})">Добавить</button></p>
                @endauth
            </div>
            @endforeach
        </section>
    </main>
    <footer>

    </footer>



</body>
</html>
