<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['add_restaurant'])){

   $title = $_POST['title'];
   $title = filter_var($title, FILTER_SANITIZE_STRING);
   $description = $_POST['description'];
   $description = filter_var($description, FILTER_SANITIZE_STRING);

   $images_resto = $_FILES['images_resto']['name'];
   $images_resto = filter_var($images_resto, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['images_resto']['size'];
   $image_tmp_name = $_FILES['images_resto']['tmp_name'];
   $image_folder = '../uploaded_img_resto/'.$images_resto;

   $images_content = $_FILES['images_content']['name'];
   $images_content = filter_var($images_content, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['images_content']['size'];
   $image_tmp_name = $_FILES['images_content']['tmp_name'];
   $image_folder = '../uploaded_img_content/'.$images_content;

   $reservation = $_POST['reservation'];
   $reservation = filter_var($reservation, FILTER_SANITIZE_STRING);
   $map = $_POST['map'];
   $map = filter_var($map, FILTER_SANITIZE_STRING);
   $password = sha1($_POST['password']);
   $password = filter_var($password, FILTER_SANITIZE_STRING);

   $select_restaurant = $conn->prepare("SELECT * FROM `restaurant` WHERE title = ?");
   $select_restaurant->execute([$title]);

   if($select_restaurant->rowCount() > 0){
      $message[] = 'restaurant name already exists!';
   }else{
      if($image_size > 2000000){
         $message[] = 'image size is too large';
      }else{
         move_uploaded_file($image_tmp_name, $image_folder);

         $insert_restaurant = $conn->prepare("INSERT INTO `restaurant`(title, description, images_resto, images_content, reservation, map, password) VALUES(?,?,?,?,?,?,?)");
         $insert_restaurant->execute([$title, $description, $images_resto, $images_content, $reservation, $map, $password]);

         $message[] = 'new restaurant added!';
      }

   }

}

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_restaurant_image = $conn->prepare("SELECT * FROM `restaurant` WHERE id = ?");
   $delete_restaurant_image->execute([$delete_id]);
   $fetch_delete_image = $delete_restaurant_image->fetch(PDO::FETCH_ASSOC);
   unlink('../uploaded_img_resto/'.$fetch_delete_image['images_resto']);
   unlink('../uploaded_img_content/'.$fetch_delete_image['images_content']);
   $delete_restaurant = $conn->prepare("DELETE FROM `restaurant` WHERE id = ?");
   $delete_restaurant->execute([$delete_id]);
   header('location:resto.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- add restaurant section starts  -->

<section class="add-restaurant">

   <form action="" method="POST" enctype="multipart/form-data">

      <h3>Add Restaurant</h3>
      <input type="text" required placeholder="enter restaurant name" name="title" maxlength="100" class="box">
      <input type="text" required placeholder="enter restaurant description" name="description" maxlength="255" class="box">
      <input type="number" required placeholder="masukkan jumlah reservasi" name="reservation" class="box">
      <input type="text" required placeholder="enter link map restaurant" name="map" class="box">
      <input type="text" required placeholder="enter restaurant password" name="password" class="box">
      <input type="file" name="images_resto" class="box" accept="image/jpg, image/jpeg, image/png, image/webp" required value="image restaurant">
      <input type="file" name="images_content" class="box" accept="image/jpg, image/jpeg, image/png, image/webp" required value="image description">
      <input type="submit" value="add restaurant" name="add_restaurant" class="btn">
   </form>

</section>

<!-- add restaurant section ends -->

<!-- show products section starts  -->

<section class="show-products" style="padding-top: 0;">

   <div class="box-container">

   <?php
      $show_restaurant = $conn->prepare("SELECT * FROM `restaurant`");
      $show_restaurant->execute();
      if($show_restaurant->rowCount() > 0){
         while($fetch_restaurant = $show_restaurant->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <div class="box">
      <img src="../uploaded_img_resto/<?= $fetch_restaurant['images_resto']; ?>" alt="">
      <img src="../uploaded_img_content/<?= $fetch_restaurant['images_content']; ?>" alt="">

      <!-- <div class="flex">
         <div class="price"><span>$</span><?= $fetch_restaurant['price']; ?><span>/-</span></div>
         <div class="category"><?= $fetch_restaurant['category']; ?></div>
      </div> -->
      
      <div class="name"><?= $fetch_restaurant['title']; ?></div>
      <div class="flex-btn">
         <a href="update_resto.php?update=<?= $fetch_restaurant['id']; ?>" class="option-btn">update</a>
         <a href="resto.php?delete=<?= $fetch_restaurant['id']; ?>" class="delete-btn" onclick="return confirm('delete this restaurant?');">delete</a>
      </div>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">no restaurant added yet!</p>';
      }
   ?>

   </div>

</section>

<!-- show products section ends -->










<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>