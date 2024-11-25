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
   <title>search page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<!-- search form section starts  -->

<section class="search-form">
   <form method="post" action="">
      <input type="text" name="search_box" placeholder="search here..." class="box">
      <button type="submit" name="search_btn" class="fas fa-search"></button>
   </form>
</section>
<br>

<!-- search form section ends -->


<section class="category" style="min-height: 100vh; padding-top:0;">

<div class="box-container">

      <?php
         if(isset($_POST['search_box']) OR isset($_POST['search_btn'])){
         $search_box = $_POST['search_box'];
         $select_products = $conn->prepare("SELECT * FROM `restaurant` WHERE title LIKE '%{$search_box}%'");
         $select_products->execute();
         if($select_products->rowCount() > 0){
            while($fetch_restaurant = $select_products->fetch(PDO::FETCH_ASSOC)){
      ?>
      <div class="box">
         <img src="uploaded_img_resto/<?= $fetch_restaurant['images_resto']; ?>" alt="">
         <h3 class="name">
         <a href="restaurant_view.php?id=<?= $fetch_restaurant['id']; ?>" >
                    <?= $fetch_restaurant['title']; ?>
                </a>
         </h3>
      </div>
      <?php
            }
         }else{
            echo '<p class="empty">no restaurant added yet!</p>';
         }
        }
         
      ?>

   </div>
   <br><br>
   <center><a href="index.php" class="btn">Back to Home</a></center>

</section>











<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->







<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>