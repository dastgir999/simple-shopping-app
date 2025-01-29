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
            
        }


        .container{
            width:100%;
            background-color: whitesmoke;
            display: grid;
            grid-template-columns: repeat(auto-fit,minmax(250px,1fr));
            padding:20px;
        }

        .Items{
            display: flex;
            flex-direction: column;
            height:300px;
        }
        
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    
</head>
<body>
    <h1>Products</h1>
    <div id="cart-message"></div>
    <p>Cart Items: <span id="cart-count"><?php echo isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0; ?></span></p>
    <a href="view_cart.php">View Cart</a>
    <div class="container">
       <div class="Items"> 

    <ul class="Item">
        <?php foreach ($products as $product): ?>
            <li>
                <h3><?php echo $product['name']; ?></h3>
                <p><?php echo $product['description']; ?></p>
                <p>Price: $<?php echo $product['price']; ?></p>
                <button onclick="addToCart(<?php echo $product['id']; ?>)">Add to Cart</button>
            </li>
        <?php endforeach; ?>
    </ul>

    <a href="checkout.php">Proceed to Checkout</a>
</div>
</div>

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