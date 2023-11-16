<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>{{ $user->name }}</title>
</head>
<style>
    * {box-sizing: border-box}

    /* Set height of body and the document to 100% */
    body, html {
      height: 100%;
      margin: 0;
      font-family: Arial;
    }
    .card {
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
      max-width: 300px;
      margin: auto;
      text-align: center;
      font-family: arial;
}

.price {
  color: grey;
  font-size: 22px;
}

.card button {
  border: none;
  outline: 0;
  padding: 12px;
  color: white;
  background-color: #000;
  text-align: center;
  cursor: pointer;
  width: 100%;
  font-size: 18px;
}
.card .delete{
  background-color: red;
}

.card button:hover {
  opacity: 0.7;
}
    /* Style tab links */
    .tablink {
      background-color: #555;
      color: white;
      float: left;
      border: none;
      outline: none;
      cursor: pointer;
      padding: 14px 16px;
      font-size: 17px;
      width: 25%;
    }

    .tablink:hover {
      background-color: #777;
    }

    /* Style the tab content (and add height:100% for full page content) */
    .tabcontent {
      color: black;
      display: none;
      padding: 100px 20px;
      height: 100%;
    }

    #Cart{
        background-color: whitesmoke;
        padding-left: 150px;
        padding-right: 50px;
    }
    #Cart div:first{
        margin-left: 0px;
    }
    #Cart div{
        display: inline-block;
        margin-left: 30px;
        margin-top: 10px;
    }
    #Order {background-color: whitesmoke;}
    #Contact {background-color: whitesmoke;}
    #About {background-color: whitesmoke;}
    </style>
    </head>
    <body>

    <button class="tablink" onclick="openPage('Cart', this, 'red')" id="defaultOpen">Cart</button>
    <button class="tablink" onclick="openPage('Order', this, 'green')">Order</button>
    <button class="tablink" onclick="openPage('Contact', this, 'blue')">Contact</button>
    <button class="tablink" onclick="openPage('About', this, 'orange')">About</button>

    <div id="Cart" class="tabcontent">

    </div>

    <div id="Order" class="tabcontent">
      <h3>{{ $user->name }}</h3>
      <p>Some news this fine day!</p>
    </div>

    <div id="Contact" class="tabcontent">
      <h3>Contact</h3>
      <p>Get in touch, or swing by for a cup of coffee.</p>
    </div>

    <div id="About" class="tabcontent">
      <h3>About</h3>
      <p>Who we are and what we do.</p>
    </div>

    <script>
    function openPage(pageName,elmnt,color) {
      var i, tabcontent, tablinks;
      tabcontent = document.getElementsByClassName("tabcontent");
      for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
      }
      tablinks = document.getElementsByClassName("tablink");
      for (i = 0; i < tablinks.length; i++) {
        tablinks[i].style.backgroundColor = "";
      }
      document.getElementById(pageName).style.display = "block";
      elmnt.style.backgroundColor = color;
    }

    // Get the element with id="defaultOpen" and clickCart on it
    document.getElementById("defaultOpen").click();
     $(document).ready(function () {
       getCart();
       getOrders();
     });
     function getCart(){
         let cart = "cart"
         let product_id = {{ Auth::user()->id }}
     $.ajax({
         type: "GET",
         url: "{{ route('cart', Auth::user()->email) }}",
         data:  { cart:cart, product_id:product_id },
         contentType: false,
         processData: false,
         success: function (data) {
            $.getJSON("{{route('json-request-cart')}}",
                function (response, textStatus, jqXHR) {
                    console.log(response);
                }
            );
             $('#Cart').html(data);
         },
         error: function (data){
             console.log(data);
           }
     });
    }
    function deleteCart(id){
      $.ajax({
        type: "GET",
        url: "{{ route('deleteCart', Auth::user()->email) }}",
        data: {id:id},
        success: function (response) {
            console.log(response);
            getCart();
        },
        error: function (response){

        }
      });
    }
    function addOrder(id){
      $.ajax({
        type: "GET",
        url: "{{ route('addOrder', Auth::user()->email) }}",
        data: {id:id},
        cache:false,
        success: function (response) {
          console.log(response);
          getOrders();
        }
      });
    }

    function getOrders(){
         let cart = "cart"
         let product_id = {{ Auth::user()->id }}
     $.ajax({
         type: "GET",
         url: "{{ route('orders', Auth::user()->email) }}",
         data:  { cart:cart, product_id:product_id },
         contentType: false,
         processData: false,
         success: function (data) {
            // $.getJSON("{{route('json-request-cart')}}",
            //     function (response, textStatus, jqXHR) {
            //         console.log(response);
            //     }

             $('#Order').html(data);
         },
         error: function (data){
             console.log(data);
           }
     });
    }
    </script>
</html>
