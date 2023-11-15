<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    @vite('resources/css/app.css')
</head>
<body>
    <header>

    </header>
    <main>
        <section class="products">
            @foreach ($products as $product)
            <div class="card">
                <img src="/w3images/jeans3.jpg" alt="Denim Jeans" style="width:100%">
                <h1>{{ $product->name }}</h1>
                <p class="price">$ {{ $product->price }}</p>
                <p>{{$product->category}}</p>
                <p><button>Buy</button></p>
            </div>
            @endforeach
        </section>
    </main>
    <footer>

    </footer>
</body>
</html>
