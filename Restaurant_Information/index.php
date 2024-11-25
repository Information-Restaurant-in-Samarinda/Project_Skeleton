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
   <title>home</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>



<section class="hero">

   <div class="swiper hero-slider">

      <div class="swiper-wrapper">

         <div class="swiper-slide slide">
            <div class="content">
               <span>reservation online</span>
               <h3>Mie Gacoan</h3>
               <a href="restaurant.php" class="btn">see resto</a>
            </div>
            <div class="image">
               <img src="images/gacoan_image.jpeg" alt="">
            </div>
         </div>

         <div class="swiper-slide slide">
            <div class="content">
               <span>reservation online</span>
               <h3>KFC</h3>
               <a href="restaurant.php" class="btn">see resto</a>
            </div>
            <div class="image">
               <img src="images/kfc_image.jpeg" alt="">
            </div>
         </div>

         <div class="swiper-slide slide">
            <div class="content">
               <span>reservation online</span>
               <h3>Solaria</h3>
               <a href="restaurant.php" class="btn">see resto</a>
            </div>
            <div class="image">
               <img src="images/solaria_image.jpeg" alt="">
            </div>
         </div>

      </div>

      <div class="swiper-pagination"></div>

   </div>

</section>

<section class="category">

   <h1 class="title">Restaurant in Samarinda</h1>

   <div class="box-container">


      <?php
         $show_restaurant = $conn->prepare("SELECT * FROM `restaurant` LIMIT 3");
         $show_restaurant->execute();
         if($show_restaurant->rowCount() > 0){
            while($fetch_restaurant = $show_restaurant->fetch(PDO::FETCH_ASSOC)){ 
      ?>
      <div class="box">
         <a href="restaurant_view.php?id=<?= $fetch_restaurant['id']; ?>" >
            <img src="uploaded_img_resto/<?= $fetch_restaurant['images_resto']; ?>" alt="">
            <h3 class="name">
               <a href="restaurant_view.php?id=<?= $fetch_restaurant['id']; ?>" >
                        <?= $fetch_restaurant['title']; ?>
               </a>
            </h3>
         </a>
      </div>
      <?php
            }
         }else{
            echo '<p class="empty">no restaurant added yet!</p>';
         }
      ?>

      
   </div>
   <br><br>
   <center><a href="restaurant.php" class="btn">See More</a></center>
   <br>

</section>























<?php include 'components/footer.php'; ?>


<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<script>
    var swiper = new Swiper(".hero-slider", {
      spaceBetween: 30,
      centeredSlides: true,
      autoplay: {
        delay: 3000,
        disableOnInteraction: false,
      },
      speed: 1500, // Memperlambat Perpindahan
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
    });
  </script>

</body>
</html>