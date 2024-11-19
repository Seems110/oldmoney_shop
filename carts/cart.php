<?php
session_start();
require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $cartItemId = $_POST['cart_item_id'] ?? null;
    $quantity = $_POST['quantity'] ?? null;

    if ($action === 'update' && $cartItemId && $quantity) {
        // Логика обновления количества товара
        echo json_encode(['message' => 'Количество товара обновлено!']);
    } elseif ($action === 'remove' && $cartItemId) {
        // Логика удаления товара
        echo json_encode(['message' => 'Товар удален из корзины!']);
    } else {
        echo json_encode(['error' => 'Некорректные данные!']);
    }
}
?>

