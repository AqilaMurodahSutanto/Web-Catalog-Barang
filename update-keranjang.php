<?php
include 'config.php';
session_start();

$id_user = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : null;
if (!$id_user) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $product_id = (int) $_POST['product_id'];
    $quantity = (int) $_POST['quantity'];

    // Pastikan jumlah lebih dari 0
    if ($quantity >= 1) {
        // Update jumlah barang di keranjang
        $query = "UPDATE keranjang SET Jumlah = $quantity WHERE id_user = $id_user AND ID_Barang = $product_id";
        if (mysqli_query($conn, $query)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update cart']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Quantity must be greater than 0']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
}
?>