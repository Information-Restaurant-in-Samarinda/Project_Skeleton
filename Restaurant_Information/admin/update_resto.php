<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['update'])){

   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);
   $title = $_POST['title'];
   $title = filter_var($title, FILTER_SANITIZE_STRING);
   $description = $_POST['description'];
   $description = filter_var($description, FILTER_SANITIZE_STRING);

   $reservation = $_POST['reservation'];
   $reservation = filter_var($reservation, FILTER_SANITIZE_STRING);
   $map = $_POST['map'];
   $map = filter_var($map, FILTER_SANITIZE_STRING);

   $update_restaurant = $conn->prepare("UPDATE `restaurant` SET title = ?, description = ?, reservation = ?, map = ? WHERE id = ?");
   $update_restaurant->execute([$title, $description, $reservation, $map, $pid]);

   $message[] = 'restaurant updated!';

   // Data untuk gambar restoran
    $old_image_resto = $_POST['old_image_resto'];
    $images_resto = filter_var($_FILES['images_resto']['name'], FILTER_SANITIZE_STRING);
    $image_size_resto = $_FILES['images_resto']['size'];
    $image_tmp_name_resto = $_FILES['images_resto']['tmp_name'];
    $image_folder_resto = '../uploaded_img_resto/' . $images_resto;

    if (!empty($images_resto)) {
        if ($image_size_resto > 2000000) {
            $message[] = 'Image size is too large!';
        } else {
            $update_image = $conn->prepare("UPDATE `restaurant` SET images_resto = ? WHERE id = ?");
            $update_image->execute([$images_resto, $pid]);
            move_uploaded_file($image_tmp_name_resto, $image_folder_resto);
            if (!empty($old_image_resto)) {
                unlink('../uploaded_img_resto/' . $old_image_resto);
            }
            $message[] = 'Restaurant image updated!';
        }
    }

    // Data untuk gambar konten
    $old_image_content = $_POST['old_image_content'];
    $images_content = filter_var($_FILES['images_content']['name'], FILTER_SANITIZE_STRING);
    $image_size_content = $_FILES['images_content']['size'];
    $image_tmp_name_content = $_FILES['images_content']['tmp_name'];
    $image_folder_content = '../uploaded_img_content/' . $images_content;

    if (!empty($images_content)) {
        if ($image_size_content > 2000000) {
            $message[] = 'Image size is too large!';
        } else {
            $update_image = $conn->prepare("UPDATE `restaurant` SET images_content = ? WHERE id = ?");
            $update_image->execute([$images_content, $pid]);
            move_uploaded_file($image_tmp_name_content, $image_folder_content);
            if (!empty($old_image_content)) {
                unlink('../uploaded_img_content/' . $old_image_content);
            }
            $message[] = 'Content image updated!';
        }
    }


}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update product</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- update product section starts  -->

<section class="update-product">

   <h1 class="heading">update product</h1>

   <?php
      $update_id = $_GET['update'];
      $show_restaurant = $conn->prepare("SELECT * FROM `restaurant` WHERE id = ?");
      $show_restaurant->execute([$update_id]);
      if($show_restaurant->rowCount() > 0){
         while($fetch_restaurant = $show_restaurant->fetch(PDO::FETCH_ASSOC)){  
   ?>

   <form action="" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="pid" value="<?= $fetch_restaurant['id']; ?>">
      <input type="hidden" name="old_image_resto" value="<?= $fetch_restaurant['images_resto']; ?>">
      <img src="../uploaded_img_resto/<?= $fetch_restaurant['images_resto']; ?>" alt="">
      <input type="hidden" name="old_image_content" value="<?= $fetch_restaurant['images_content']?>">
      <img src="../uploaded_img_content/<?= $fetch_restaurant['images_content']; ?>" alt="">
      <span>Update Restaurant Name</span>
      <input type="text" required placeholder="enter restaurant name" name="title" maxlength="100" class="box" value="<?= $fetch_restaurant['title']; ?>">
      <span>Update Description Restaurant</span>
      <input type="text" required placeholder="enter restaurant description" name="description" maxlength="255" class="box" value="<?= $fetch_restaurant['description']; ?>">
      <span>Update Image Restaurant</span>
      <input type="file" name="images_resto" class="box" accept="image/jpg, image/jpeg, image/png, image/webp" required>
      <span>Update Image Description</span>
      <input type="file" name="images_content" class="box" accept="image/jpg, image/jpeg, image/png, image/webp" required>
      <span>Update Reservation</span>
      <input type="number" required placeholder="masukkan jumlah reservasi" name="reservation" class="box" value="<?= $fetch_restaurant['reservation']; ?>">
      <span>Update Map</span>
      <input type="text" required placeholder="enter link map restaurant" name="map" class="box">
      <div class="flex-btn">
        <input type="submit" value="update" class="btn" name="update">
        <a href="resto.php" class="option-btn">go back</a>
      </div>
   </form>
   <?php
         }
      }else{
         echo '<p class="empty">no restaurant added yet!</p>';
      }
   ?>

</section>

<!-- update product section ends -->










<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>