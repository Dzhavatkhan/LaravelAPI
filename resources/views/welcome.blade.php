<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
</head>
<body>
    <header>

    </header>
    <main>
        <section class="products">
            @foreach ($products as $product)
                <div class="product-card">
                    <h4>{{ $product->name }}</h4>
                    <p>{{ $product->category }}</p>
                    <p>{{ $product->price }} ₽</p>
                    <button class="add_cart">Добавить в корзину</button>
                </div>
            @endforeach
        </section>
    </main>
    <footer>

    </footer>
</body>
</html>