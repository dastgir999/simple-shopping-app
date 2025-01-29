<?php
session_start();
include 'db.php';

// Fetch products
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <style type="text/css">
        *{
            margin:0;
            padding: 0;
            box-sizing: border-box;
            font-family: sans-serif;
            
        }

          a{
            text-decoration: none;
          }

        .cart-item{
              display: flex;
              
              align-content: center;
              align-items: center;
               width:50px;
               height:50px;
               border-radius:50%;
               background-color:red;
               color: white;
               font-weight: bold;
               text-align: center;
        }


        .container{
            width:100%;
            background-color: whitesmoke;
            display: grid;
            grid-template-columns: repeat(auto-fit,minmax(250px,1fr));
            padding:20px;
            gap: 1rem;
            height:80vh;
        }

        .Items{
            display: flex;
            flex-direction: column;
            height:300px;
/*            border: 1px solid red;*/
            background-color: white;
            padding:1rem;
            justify-content: center;
            align-items: center;
            box-shadow:3px 3px 3px grey;
        }

        .Items button{
               padding:10px;
               background-color:green;
               color: white;
               font-weight: bold;
               border: none;
        }

        .ch{
            text-align: center;
        }

        .Item {
            list-style-type:none;
            padding:5PX;

        }

        .Item li{
             padding:5px;
        }
        
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    
</head>
<body>
    <h1>MyShop</h1>
    <div id="cart-message"></div>
    <div class="cart-item">
    <p>Cart: <span id="cart-count"><?php echo isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0; ?></span></p></div>
    <a href="view_cart.php">View Cart</a>
    <div class="container">
        

    
        <?php foreach ($products as $product): ?>
            <div class="Items">
                <div class="cart-img">
                    <img src="images/<?php echo $product['image']; ?>" alt="img1" width="100%" height="190px">
                   

                 </div>
            <ul class="Item">
            <li>
                <h3><?php echo $product['name']; ?></h3>
                <p><?php echo $product['description']; ?></p>
                <p>Price: $<?php echo $product['price']; ?></p>
                <button onclick="addToCart(<?php echo $product['id']; ?>)">Add to Cart</button>
            </li>
            </ul>
            </div>

        <?php endforeach; ?>
    
   

</div>
 <h1 class="ch"><a href="checkout.php">Proceed to Checkout</a></h1>

    <script>
        function addToCart(productId) {
            $.ajax({
                url: 'add_to_cart.php',
                type: 'POST',
                data: { product_id: productId },
                success: function(response) {
                    $('#cart-message').html(response);
                    // Update cart count
                    $.ajax({
                        url: 'get_cart_count.php',
                        type: 'GET',
                        success: function(count) {
                            $('#cart-count').text(count);
                        }
                    });
                }
            });
        }
    </script>
</body>
</html>