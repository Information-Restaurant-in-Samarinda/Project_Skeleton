<?php

include '../components/connect.php';

session_start();

// Mendapatkan restaurant_id dari session
$owner_id = $_SESSION['restaurant_id'];

if (!isset($owner_id)) {
    header('location:owner_login.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/owner_header.php'; ?>

<!-- show products section starts  -->

<section class="show-products">
   <div class="box-container">

   <?php
      // Query untuk menampilkan restoran berdasarkan restaurant_id
      $show_restaurant = $conn->prepare("SELECT * FROM `restaurant` WHERE `id` = :restaurant_id");
      $show_restaurant->bindParam(':restaurant_id', $owner_id, PDO::PARAM_INT);
      $show_restaurant->execute();

      if ($show_restaurant->rowCount() > 0) {
         while ($fetch_restaurant = $show_restaurant->fetch(PDO::FETCH_ASSOC)) {
   ?>
   <div class="box">
      <img src="../uploaded_img_resto/<?= $fetch_restaurant['images_resto']; ?>" alt="">

      <div class="name"><?= $fetch_restaurant['title']; ?></div>
      <p class="description"><?= $fetch_restaurant['description']; ?></p>
   </div>

   <?php

         }
      } else {
         echo '<p class="empty">No restaurant found!</p>';
      }
   ?>

   </div>
</section>

<!-- show products section ends -->

<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>
