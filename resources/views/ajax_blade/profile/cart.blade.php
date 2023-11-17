@if ($cart_count == 0)
    <h3>Ваша корзина пуста. <a href="/">Перейти в каталог</a></h3>
@else
<h3>Ваша корзина ({{ $cart_count}})</h3>
@foreach ($carts as $cart)
@csrf
    <div class="card">
        <h1>{{ $cart->name }}</h1>
        <p class="price">$ {{ $cart->price }}</p>
        <p>{{ $cart->quantity }} шт</p>
        <p><button onclick="addOrder({{ $cart->cart_id }})">Buy</button></p>
        <p><button class="delete" onclick="deleteCart({{ $cart->cart_id }})">Delete</button></p>
    </div>
@endforeach
@endif
<br><br>
<h4>Итого: $ {{ $sum_price }}</h4>