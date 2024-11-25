<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>dashboard</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- admin dashboard section starts  -->

<section class="dashboard">

   <h1 class="heading">dashboard</h1>

   <div class="box-container">

   <!-- Update Profile Start -->

   <div class="box">
      <h3>welcome!</h3>
      <p><?= $fetch_profile['name']; ?></p>
      <a href="update_profile.php" class="btn">update profile</a>
   </div>

   <!-- Update Profile End -->
   
   <!-- Restaurant Start -->
   <div class="box">
      <?php
         $select_restaurant = $conn->prepare("SELECT * FROM `restaurant`");
         $select_restaurant->execute();
         $numbers_of_restaurant = $select_restaurant->rowCount();
      ?>
      <h3><?= $numbers_of_restaurant; ?></h3>
      <p>Restaurant Added</p>
      <a href="resto.php" class="btn">see resto</a>
   </div>
   <!-- Restaurant End -->

   <!-- Accounts Start -->
   <div class="box">
      <?php
         $select_users = $conn->prepare("SELECT * FROM `users`");
         $select_users->execute();
         $numbers_of_users = $select_users->rowCount();
      ?>
      <h3><?= $numbers_of_users; ?></h3>
      <p>All Accounts</p>
      <a href="account.php" class="btn">see account</a>
   </div>
   <!-- Accounts End -->

   <div class="box">
      <?php
         $select_messages = $conn->prepare("SELECT * FROM `message_admin`");
         $select_messages->execute();
         $numbers_of_messages = $select_messages->rowCount();
      ?>
      <h3><?= $numbers_of_messages; ?></h3>
      <p>new messages</p>
      <a href="messages_admin.php" class="btn">see messages</a>
   </div>

   </div>

</section>

<!-- admin dashboard section ends -->









<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>