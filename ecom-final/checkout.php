<?php
session_start();
include 'db.php';

if (empty($_SESSION['cart'])) {
    die("Your cart is empty.");
}

// Fetch cart products
$cart_products = [];
$total_amount = 0;
foreach ($_SESSION['cart'] as $product_id => $quantity) {
    $sql = "SELECT * FROM products WHERE id = $product_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $row['quantity'] = $quantity; // Add quantity to product data
        $cart_products[] = $row;
        $total_amount += $row['price'] * $quantity; // Calculate total amount
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <style type="text/css">
        a{
            text-decoration: none;
        }
        .container{
            width:100%;
            min-height:80vh;
            padding:20px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;

        }

        .heading{
            min-height:10vh;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            background-color: whitesmoke;
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="heading">
    <h1>Checkout</h1>
    <h2>Your Cart</h2>
</div>
    <ul>
        <?php foreach ($cart_products as $product): ?>
            <div class="Item">
                <div class="cart-img">
                    <img src="images/<?php echo $product['image']; ?>" alt="img1" width="100%" height="190px">
                   

                 </div>
            <li>
                <h3><?php echo $product['name']; ?></h3>
                <p>Price: $<?php echo $product['price']; ?></p>
                <p>Quantity: <?php echo $product['quantity']; ?></p>
                <p>Total: $<?php echo $product['price'] * $product['quantity']; ?></p>
            </li>

        </div>
        <?php endforeach; ?>
    </ul>

    <h2>Total Amount: $<?php echo $total_amount; ?></h2>

    <h2>Customer Details</h2>
    <form action="place_order.php" method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" required><br><br>
        <label for="email">Email:</label>
        <input type="email" name="email" required><br><br>
        <label for="address">Address:</label>
        <textarea name="address" required></textarea><br><br>
        <input type="submit" value="Place Order (COD)">
    </form>

</div>
</body>
</html>