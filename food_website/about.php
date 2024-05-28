<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Thông tin</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<div class="heading">
   <h3>Về chúng tôi</h3>
   <p><a href="home.php">Trang chủ</a> <span> / Thông tin</span></p>
</div>

<!-- about section starts  -->

<section class="about">

   <div class="row">

      <div class="image">
         <img src="images/about-img.svg" alt="">
      </div>

      <div class="content">
         <h3>Tại sao nên chọn yum-yum?</h3>
         <p>Tận hưởng hành trình ẩm thực với cửa hàng đồ ăn trực tuyến của chúng tôi, nơi mọi món ngon đều có mặt để làm hài lòng vị giác của bạn. Được cung cấp từ những nguồn nguyên liệu tươi ngon nhất và chế biến bởi các đầu bếp tài năng, mỗi món ăn không chỉ là một trải nghiệm ẩm thực mà còn là một hành trình khám phá vị ngon. Đặt hàng ngay hôm nay và khám phá một thế giới đa dạng của hương vị tuyệt vời và sự tiện lợi mua sắm trực tuyến!</p>
         <a href="menu.php" class="btn">Khám phá</a>
      </div>

   </div>

</section>

<!-- about section ends -->

<!-- steps section starts  -->

<section class="steps">

   <h1 class="title">3 bước đơn giản</h1>

   <div class="box-container">

      <div class="box">
         <img src="images/step-1.png" alt="">
         <h3>Đặt đơn</h3>
         <p>Đặt hàng dễ dàng, xác nhận nhanh chóng. </p>
      </div>

      <div class="box">
         <img src="images/step-2.png" alt="">
         <h3>Vận chuyển nhanh</h3>
         <p>Giao hàng trong vòng 1h kể từ lúc xác nhận đơn. </p>
      </div>

      <div class="box">
         <img src="images/step-3.png" alt="">
         <h3>Tận hưởng món ăn</h3>
         <p>Tận hưởng món ăn khi vẫn còn nóng hổi.</p>
      </div>

   </div>

</section>

<!-- steps section ends -->



<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->=






<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".reviews-slider", {
   loop:true,
   grabCursor: true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      0: {
      slidesPerView: 1,
      },
      700: {
      slidesPerView: 2,
      },
      1024: {
      slidesPerView: 3,
      },
   },
});

</script>

</body>
</html>