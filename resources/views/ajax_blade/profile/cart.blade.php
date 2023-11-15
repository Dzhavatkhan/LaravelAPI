<h3>Ваша корзина ({{ $cart_count}})</h3>

@foreach ($carts as $cart)
    <div class="card">
        <img src="/w3images/jeans3.jpg" alt="Denim Jeans" style="width:100%">
        <h1>{{ $cart->name }}</h1>
        <p class="price">$ {{ $cart->price }}</p>
        <p>Some text about the jeans. Super slim and comfy lorem ipsum lorem jeansum. Lorem jeamsun denim lorem jeansum.</p>
        <p><button>Buy</button></p>
        <p><button>Delete</button></p>
    </div>            
@endforeach