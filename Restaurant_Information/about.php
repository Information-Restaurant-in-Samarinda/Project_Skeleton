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
   <title>about</title>

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
   <h3>about us</h3>
   <p><a href="index.php">home</a> <span> / about</span></p>
</div>

<!-- about section starts  -->

<section class="about">

   <div class="row">

      <div class="image">
         <img src="images/about-img.svg" alt="">
      </div>

      <div class="content">
         <h3>why choose us?</h3>
         <p>Restoku Samarinda is a restaurant information system platform in Samarinda, designed to make it easy for you to find and reserve the best restaurants in the city. With a mission to provide a seamless dining experience, we offer complete information about various restaurants, including menus, locations, and customer reviews. We are dedicated to supporting local culinary businesses while giving the people of Samarinda a convenient way to enjoy memorable dining experiences.</p>
         <a href="index.php" class="btn">our website</a>
      </div>

   </div>

</section>

<!-- about section ends -->

<!-- steps section starts  -->

<section class="steps">

   <h1 class="title">simple steps</h1>

   <div class="box-container">

      <div class="box">
         <img src="images/step-1.png" alt="">
         <h3>choose restaurant</h3>
         <p>Choose restaurant and reservation restaurant do you want</p>
      </div>

      <div class="box">
         <img src="images/step-2.png" alt="">
         <h3>to the restaurant</h3>
         <p>Go to restaurant do you want and order some food or drink</p>
      </div>

      <div class="box">
         <img src="images/step-3.png" alt="">
         <h3>enjoy food</h3>
         <p>Enjoy your food with your family or people you love </p>
      </div>

   </div>

</section>

<!-- steps section ends -->

<section class="reviews">

   <h1 class="title">Website Makers</h1>

   <div class="swiper reviews-slider">

      <div class="swiper-wrapper">

      <div class="swiper-slide slide">
            <img src="images/foto_robby.jpeg" alt="">
            <p>Mahasiswa Informatika angkatan 2023 Fakultas Teknik, Universitas Mulawarman</p>
            <h3>Robby Pratama</h3>
         </div>

         <div class="swiper-slide slide">
            <img src="images/foto_iqbal.jpeg" alt="">
            <p>Mahasiswa Informatika angkatan 2023 Fakultas Teknik, Universitas Mulawarman</p>
            <h3>Maulana Iqbal Hidayah</h3>
         </div>

         <div class="swiper-slide slide">
            <img src="images/foto_luthfi.jpeg" alt="">
            <p>Mahasiswa Informatika angkatan 2023 Fakultas Teknik, Universitas Mulawarman</p>
            <h3>Luthfiah Nur Alifah</h3>
         </div>

         <div class="swiper-slide slide">
            <img src="images/pic-4.png" alt="">
            <p>Mahasiswa Informatika Fakultas Teknik, Universitas Mulawarman</p>
            <h3>Aji Pangestu</h3>
         </div>

      </div>

      <div class="swiper-pagination"></div>

   </div>

</section>









<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->






<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".reviews-slider", {
   loop:true,
   grabCursor: true,
   spaceBetween: 20,
   autoplay: {
      delay: 3000,
      disableOnInteraction: false,
   },
   speed: 1500,
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