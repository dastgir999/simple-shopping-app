<?php
session_start();

if (!isset($_SESSION['cart'])) {
    die("Your cart is empty.");
}

foreach ($_POST['quantity'] as $product_id => $quantity) {
    if ($quantity > 0) {
        $_SESSION['cart'][$product_id] = $quantity; // Update quantity
    } else {
        unset($_SESSION['cart'][$product_id]); // Remove product if quantity is 0
    }
}

echo "Cart updated successfully!";
?>