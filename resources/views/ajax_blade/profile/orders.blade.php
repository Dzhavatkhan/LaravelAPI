@if ($order_count == 0)
    <h3>У вас нет заказов. <a href="/">Перейти в каталог</a></h3>
@else
<h3>Ваши заказы ({{ $order_count}})</h3>
@foreach ($orders as $order)
@csrf
    <div class="card">
        <h1>{{ $order->name }}</h1>
        <p class="price">$ {{ $price->SUM}}</p>
        <p>{{ $order->quantity }} шт</p>
        <p><button onclick="addOrder({{ $order->id }})">Buy</button></p>
        <p><button class="delete" onclick="deleteCart({{ $order->id }})">Delete</button></p>
    </div>            
@endforeach 
@endif