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

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<!--restaurant section start -->

<div class="heading">
   <h3>restaurant In Samarinda</h3>
   <p><a href="index.php">home</a> <span> / Restaurant</span></p>
</div>

<section class="category2">

   <div class="box-container">


      <?php
         $show_restaurant = $conn->prepare("SELECT * FROM `restaurant`");
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

</section>

<br><br>

<!--restaurant section  end -->





<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->

<script src="js/script.js"></script>

</body>
</html>