<?php
session_start();
include 'db.php';

if (empty($_SESSION['cart'])) {
    die("Your cart is empty.");
}

// Calculate total amount
$total_amount = 0;
foreach ($_SESSION['cart'] as $product_id => $quantity) {
    $sql = "SELECT price FROM products WHERE id = $product_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $total_amount += $row['price'] * $quantity;
    }
}

// Insert order
$name = $_POST['name'];
$email = $_POST['email'];
$address = $_POST['address'];

$sql = "INSERT INTO orders (customer_name, customer_email, customer_address, total_amount) 
        VALUES ('$name', '$email', '$address', $total_amount)";
if ($conn->query($sql) === TRUE) {
    $order_id = $conn->insert_id;

    // Insert order items
    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        $sql = "SELECT price FROM products WHERE id = $product_id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $price = $row['price'];
            $sql = "INSERT INTO order_items (order_id, product_id, quantity, price) 
                    VALUES ($order_id, $product_id, $quantity, $price)";
            $conn->query($sql);
        }
    }

    // Clear cart
    unset($_SESSION['cart']);

    echo "<h1 style='color:red;text-align='center'>Order placed successfully!</h1>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>