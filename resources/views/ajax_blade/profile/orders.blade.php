@if ($order_count == 0)
    <h3>У вас нет заказов. <a href="/">Перейти в каталог</a></h3>
@else
<h3>Ваши заказы ({{ $order_count}})</h3>
@foreach ($orders as $order)
@csrf
    <div class="card">
        <h1>{{ $order->name }}</h1>
        <p class="price">$ {{ $order->order_price}}</p>
        <p>{{ $order->quantity }} шт</p>
        <p>Дни ожидания: {{$days}}</p>
    </div>
@endforeach
@endif
