<?php
/**
 * Cart Update Handler
 */
require_once __DIR__ . '/session.php';

requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('cart.php');
}

$action = $_POST['action'] ?? '';
$cartId = (int)($_POST['cart_id'] ?? 0);
$userId = getCurrentUserId();
$conn = getDB();

switch ($action) {
    case 'increase':
        if ($cartId) {
            $stmt = $conn->prepare("UPDATE cart SET qty = qty + 1 WHERE id = ? AND user_id = ?");
            $stmt->bind_param("ii", $cartId, $userId);
            $stmt->execute();
            $stmt->close();
        }
        break;
        
    case 'decrease':
        if ($cartId) {
            $stmt = $conn->prepare("SELECT qty FROM cart WHERE id = ? AND user_id = ?");
            $stmt->bind_param("ii", $cartId, $userId);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            
            if ($result && $result['qty'] > 1) {
                $stmt = $conn->prepare("UPDATE cart SET qty = qty - 1 WHERE id = ? AND user_id = ?");
                $stmt->bind_param("ii", $cartId, $userId);
                $stmt->execute();
                $stmt->close();
            } else {
                $stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
                $stmt->bind_param("ii", $cartId, $userId);
                $stmt->execute();
                $stmt->close();
                setFlash('success', 'Item removed from cart.');
            }
        }
        break;
        
    case 'remove':
        if ($cartId) {
            $stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
            $stmt->bind_param("ii", $cartId, $userId);
            $stmt->execute();
            $stmt->close();
            setFlash('success', 'Item removed from cart.');
        }
        break;
        
    case 'clear':
        $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->close();
        setFlash('success', 'Cart cleared.');
        break;
}

redirect('cart.php');
?>
