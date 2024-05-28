<?php
include 'components/connect.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['order_id'])) {
        $order_id = $_POST['order_id'];
        error_log("Received order_id: $order_id"); // Debugging

        $update_order_status = $conn->prepare("UPDATE `orders` SET payment_status = 'Hủy' WHERE id = ?");
        if ($update_order_status->execute([$order_id])) {
            error_log("Đơn hàng $order_id hủy thành công."); // Debugging
            echo 'success';
        } else {
            error_log("Không thể cập nhật trạng thái đơn hàng $order_id."); // Debugging
            echo 'error';
        }
    } else {
        error_log("No order_id received."); // Debugging
        echo 'error';
    }
} else {
    error_log("Lỗi."); // Debugging
    echo 'error';
}
?>
