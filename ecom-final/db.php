<?php
$conn = new mysqli('localhost', 'root', '', 'shopping_cart');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>