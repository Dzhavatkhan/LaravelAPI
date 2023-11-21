<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite("resources/css/app.css")
    <title>{{ $product->name }}</title>
</head>
<body>
    <div class="card">
                
        <h1>{{ $product->name }}</h1>
        <p class="price">$ {{ $product->price }}</p>
        <p>{{$product->category}}</p>
        @guest
        <p><button onclick="window.location.replace('/auth/login');">Добавить</button></p>
        @endguest
        @auth
        <p><button onclick="addCart({{ $product->id }})">Добавить</button></p>
        @endauth
    </div>
    @auth
        <script>
            function addCart(id){
                $.ajax({
                    type: "GET",
                    url: "{{ route('addCart', Auth::user()->email) }}",
                    data: {id:id},
                    success: function (response) {
                        console.log(response, id);
                        alert("Product already in your cart!")
                    },
                    error: function(response){
                        console.log(response, id);
                    }
                });
            }

        </script>
    @endauth
</body>
</html>