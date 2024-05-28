<?php

include 'components/connect.php';

$user_logged_in = isset($_SESSION['user_id']);
if ($user_logged_in) {
    $user_id = $_SESSION['user_id'];
}

if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <section class="flex">

      <a href="home.php" class="logo">Yum Yum</a>

      <nav class="navbar">
         <a href="home.php">Trang chủ</a>
         <a href="about.php">Thông tin</a>
         <a href="menu.php">Thực đơn</a>
         <a href="orders.php">Đơn hàng</a>
         <a href="contact.php">Liên hệ</a>
         <a href="contact.php">humhg</a>
      </nav>

      <div class="icons">
         <?php
            if ($user_logged_in) {
                $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                $count_cart_items->execute([$user_id]);
                $total_cart_items = $count_cart_items->rowCount();
            } else {
                $total_cart_items = 0;
            }
         ?>
         <a href="search.php"><i class="fas fa-search"></i></a>
         <a href="cart.php" id="cart-link"><i class="fas fa-shopping-cart"></i><span>(<?= $total_cart_items; ?>)</span></a>
         <div id="user-btn" class="fas fa-user"></div>
         <div id="menu-btn" class="fas fa-bars"></div>
      </div>

      <div class="profile">
         <?php
            if ($user_logged_in) {
                $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                $select_profile->execute([$user_id]);
                if($select_profile->rowCount() > 0){
                   $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p class="name"><?= $fetch_profile['name']; ?></p>
         <div class="flex">
            <a href="profile.php" class="btn">Hồ sơ</a>
            <a href="components/user_logout.php" onclick="return confirm('Bạn có muốn đăng xuất khỏi trang?');" class="delete-btn">Đăng xuất</a>
         </div>
         <p class="account">
            <a href="login.php">Đăng nhập</a> /
            <a href="register.php">Đăng ký</a>
         </p> 
         <?php
                }
            } else {
         ?>
            <p class="name">Vui lòng đăng nhập trước!</p>
            <a href="login.php" class="btn">Đăng nhập</a>
         <?php
            }
         ?>
      </div>

   </section>

</header>

<script>
    // Biến JavaScript để kiểm tra trạng thái đăng nhập
    var userLoggedIn = <?= json_encode($user_logged_in) ?>;

    // Kiểm tra khi người dùng nhấp vào giỏ hàng
    document.getElementById('cart-link').addEventListener('click', function(event) {
        if (!userLoggedIn) {
            event.preventDefault();
            alert("Vui lòng đăng nhập để truy cập giỏ hàng!");
            window.location.href = "login.php";
        }
    });
</script>
