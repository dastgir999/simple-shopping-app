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
    <title>View Cart</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style type="text/css">
         a{
            text-decoration: none;
            
         }

        
        #cart-form{
               display: flex;
               justify-content: center;
               align-items: center;
               padding:20px;
               flex-direction: column;
        }
        #cart-form table{
             border-collapse: collapse;
             width: 50%;
        }

        .po{
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

         button{
            padding:5px;
            background-color: red;
            color: white;
            font-weight: bold;
            border: none;
         }
    </style>
</head>
<body>
    <h1>Your Cart</h1>
    <form id="cart-form" action="update_cart.php" method="POST">
        <table border="1">
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
            <?php foreach ($cart_products as $product): ?>
                <tr>
                    <td><?php echo $product['name']; ?></td>
                    <td>$<?php echo $product['price']; ?></td>
                    <td>
                        <input type="number" name="quantity[<?php echo $product['id']; ?>]" value="<?php echo $product['quantity']; ?>" min="1">
                    </td>
                    <td>$<?php echo $product['price'] * $product['quantity']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <br>
        <button type="submit">Update Cart</button>
    </form>
    <br>
    <div class="po">
    <a href="checkout.php">Proceed to Checkout</a>
    <br>
    <a href="index.php">Continue Shopping</a>

   </div>

    <script>
        // Update cart form submission
        $('#cart-form').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: 'update_cart.php',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    alert('Cart updated successfully!');
                    location.reload(); // Refresh the page
                }
            });
        });
    </script>
</body>
</html>