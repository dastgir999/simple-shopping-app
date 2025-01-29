<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$product_id = $_POST['product_id'];
if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id] += 1; // Increase quantity
} else {
    $_SESSION['cart'][$product_id] = 1; // Add new product
}

echo "Product added to cart!";
?>