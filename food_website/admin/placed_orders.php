<?php
include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}

if (isset($_POST['update_payment'])) {
    $order_id = $_POST['order_id'];
    $payment_status = $_POST['payment_status'];
    $update_status = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
    $update_status->execute([$payment_status, $order_id]);
    $message[] = 'Cập nhật trạng thái thành công!';
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
    $delete_order->execute([$delete_id]);
    header('location:placed_orders.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Đơn hàng</title>
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">
   <style>
      .table-container {
         display: flex;
         justify-content: center;
      }

      table {
         width: 100%;
         max-width: 90%;
         border-collapse: collapse;
         margin: 0 auto;
         background-color: var(--white);
         box-shadow: var(--box-shadow);
         border: 1px solid black;
      }

      th, td {
         padding: 1rem;
         text-align: left;
         font-size: 1.2rem;
         color: var(--black);
         border: 1px solid black;
         font-weight: bold;
      }

      th {
         background-color: var(--main-color);
         color: var(--white);
         white-space: nowrap;
      }


      td form {
         display: flex;
         flex-direction: column;
         gap: 0.5rem;
      }

      .drop-down {
         width: 100%;
         background-color: var(--light-bg);
         padding: 0.5rem;
         font-size: 1.6rem;
         color: var(--black);
         border: 1px solid var(--black);
         margin-bottom: 1rem;
      }

      .btn, .delete-btn {
         display: inline-block;
         padding: 0.5rem 1rem;
         background-color: var(--main-color);
         color: var(--white);
         text-align: center;
         cursor: pointer;
         font-size: 1.2rem;
         border-radius: 0.5rem;
         transition: background-color 0.3s ease;
         text-decoration: none;
      }

      .btn:hover, .delete-btn:hover {
         background-color: var(--hover-color);
      }

      .delete-btn {
         background-color: red;
      }

      .delete-btn:hover {
         background-color: darkred;
      }
   </style>
</head>
<body>
<?php include '../components/admin_header.php'; ?>

<section class="placed-orders">

   <h1 class="heading">Đơn hàng</h1>

   <div class="table-container">
      <table>
         <thead>
         <tr>
            <th>ID người dùng</th>
            <th>Thời gian đặt</th>
            <th>Tên</th>
            <th>Điện thoại</th>
            <th>Địa chỉ</th>
            <th>Tổng sản phẩm</th>
            <th>Tổng giá</th>
            <th>Phương thức</th>
            <th>Trạng thái thanh toán</th>
            <th>Cập nhật</th>
         </tr>
         </thead>
         <tbody>
         <?php
         $select_orders = $conn->prepare("SELECT * FROM `orders` ORDER BY placed_on DESC");
         $select_orders->execute();
         if ($select_orders->rowCount() > 0) {
            while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
               ?>
               <tr style="background-color: <?php echo ($fetch_orders['payment_status'] == 'Hủy') ? '#ffcccc' : 'transparent'; ?>">
                  <td><?= $fetch_orders['user_id']; ?></td>
                  <td><?= $fetch_orders['placed_on']; ?></td>
                  <td><?= $fetch_orders['name']; ?></td>
                  <td><?= $fetch_orders['number']; ?></td>
                  <td><?= $fetch_orders['address']; ?></td>
                  <td><?= $fetch_orders['total_products']; ?></td>
                  <td><?= number_format($fetch_orders['total_price']); ?> VNĐ</td>
                  <td><?= $fetch_orders['method']; ?></td>
                  <td>
                     <form action="" method="POST">
                        <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
                        <select name="payment_status" class="drop-down">
                           <option value="" selected disabled><?= $fetch_orders['payment_status']; ?></option>
                           <option value="Đang chờ">Đang chờ</option>
                           <option value="Thành công">Thành công</option>
                           <option value="Hủy">Hủy</option>
                        </select>
                  </td>
                  <td>
                        <input type="submit" value="Cập nhật" class="btn" name="update_payment">
                        <?php if ($fetch_orders['payment_status'] == 'Hủy'): ?>
                           <a href="placed_orders.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('Xóa đơn?');">Xóa</a>
                        <?php endif; ?>
                     </form>
                  </td>
               </tr>
               <?php
            }
         } else {
            echo '<tr><td colspan="12" class="empty">Chưa có đơn hàng nào</td></tr>';
         }
         ?>
         </tbody>
      </table>
   </div>
</section>

<script src="../js/admin_script.js"></script>
</body>
</html>
