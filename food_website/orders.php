<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:home.php');
};

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
   <link rel="stylesheet" href="css/style.css">

   <style>
      table {
         width: 100%;
         border-collapse: collapse;
         margin: 20px 0;
      }
      th, td {
         border: 1px solid #ddd;
         padding: 12px;
         text-align: left;
         font-size: 16px;
      }
      th {
         background-color: #f2f2f2;
      }
      tr:nth-child(even) {
         background-color: #f9f9f9;
      }
      tr:hover {
         background-color: #f1f1f1;
      }
      .heading {
         text-align: center;
         margin-bottom: 20px;
      }
      .cancel-btn {
         background-color: red;
         color: white;
         padding: 8px 16px;
         border: none;
         border-radius: 4px;
         cursor: pointer;
         font-size: 14px;
      }
      .cancel-btn:hover {
         background-color: darkred;
      }
   </style>
</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<div class="heading">
   <h3>Đơn hàng</h3>
   <p><a href="html.php">Trang chủ</a> <span> / Đơn hàng</span></p>
</div>

<section class="orders">

   <h1 class="title">Đơn hàng của bạn</h1>

   <div class="box-container">

   <?php
      if($user_id == ''){
         echo '<p class="empty">Đăng nhập để xem đơn hàng</p>';
      }else{
         $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ? ORDER BY placed_on DESC");
         $select_orders->execute([$user_id]);
         if($select_orders->rowCount() > 0){
            echo '<table>';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Thời gian đặt</th>';
            echo '<th>Tên</th>';
            echo '<th>Email</th>';
            echo '<th>Điện thoại</th>';
            echo '<th>Địa chỉ</th>';
            echo '<th>Phương thức thanh toán</th>';
            echo '<th>Đơn hàng</th>';
            echo '<th>Thanh toán</th>';
            echo '<th>Trạng thái</th>';
            echo '<th>Hành động</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
   ?>
   <tr>
      <td><?= $fetch_orders['placed_on']; ?></td>
      <td><?= $fetch_orders['name']; ?></td>
      <td><?= $fetch_orders['email']; ?></td>
      <td><?= $fetch_orders['number']; ?></td>
      <td><?= $fetch_orders['address']; ?></td>
      <td><?= $fetch_orders['method']; ?></td>
      <td><?= $fetch_orders['total_products']; ?></td>
      <td><?= number_format($fetch_orders['total_price']); ?> VNĐ</td>
      <td style="color:<?php 
         if($fetch_orders['payment_status'] == 'Đang chờ'){ 
            echo 'orange'; 
         } elseif($fetch_orders['payment_status'] == 'Hủy'){ 
            echo 'red'; 
         } else { 
            echo 'green'; 
         }; 
      ?>"><?= $fetch_orders['payment_status']; ?></td>
      <td>           
            <?php if($fetch_orders['payment_status'] == 'Đang chờ'): ?>
               <button class="cancel-btn" onclick="confirmCancel(<?= $fetch_orders['id']; ?>)">Hủy đơn</button>
            <?php endif; ?>
      </td>
   </tr>
   <?php
      }
      echo '</tbody>';
      echo '</table>';
      }else{
         echo '<p class="empty">Chưa có đơn hàng!</p>';
      }
      }
   ?>

   </div>

</section>

<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->

<!-- custom js file link  -->
<script src="js/script.js"></script>

<script>
function confirmCancel(orderId) {
    if (confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?')) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                console.log('Response:', xhr.responseText); // Kiểm tra phản hồi từ server
                if (xhr.responseText.trim() === 'success') {
                    alert('Đơn hàng đã được hủy thành công!');
                    window.location.reload();
                } else {
                    alert('Đã xảy ra lỗi. Vui lòng thử lại sau!');
                }
            }
        };
        xhr.open('POST', 'cancel_order.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.send('order_id=' + orderId);
    }
}

</script>
</body>
</html>