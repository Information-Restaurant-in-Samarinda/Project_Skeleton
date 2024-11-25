<?php

include '../components/connect.php';

session_start();

// Pastikan owner_id tersedia di session
$owner_id = $_SESSION['restaurant_id'];  // Misalnya session menyimpan restaurant_id sebagai owner_id

// Cek apakah owner_id ada dalam sesi
if(!isset($owner_id)){
   header('location:owner_login.php');
   exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dashboard</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/owner_header.php'; ?>

<!-- admin dashboard section starts  -->

<section class="dashboard">
   <h1 class="heading">Dashboard</h1>

   <div class="box-container">

      <div class="box">
         <?php
            // Query untuk mendapatkan restoran berdasarkan owner_id atau restaurant_id
            $select_restaurant = $conn->prepare("SELECT * FROM `restaurant` WHERE id = :restaurant_id");
            $select_restaurant->bindParam(':restaurant_id', $owner_id, PDO::PARAM_INT);
            $select_restaurant->execute();

            if ($select_restaurant->rowCount() > 0) {
               $fetch_restaurant = $select_restaurant->fetch(PDO::FETCH_ASSOC);
         ?>
         <h3>Manage Resto</h3>
         <p><?= $fetch_restaurant['title']; ?></p>
         <a href="restaurant_owner.php" class="btn">See Restaurant</a>
         <?php } else { ?>
            <p>No restaurant found!</p>
         <?php } ?>
      </div>

      <div class="box">
         <?php
            $select_reservation = $conn->prepare("SELECT * FROM `reservation` WHERE resto_id = :restaurant_id");
            $select_reservation->execute([':restaurant_id' => $owner_id]);
            $numbers_of_reservation = $select_reservation->rowCount();
         ?>
         <h3><?= $numbers_of_reservation; ?></h3>
         <p>Reservations</p>
         <a href="reservation_resto.php" class="btn">See Reservations</a>
      </div>


      <div class="box">
         <?php
            $select_messages = $conn->prepare("SELECT * FROM `message_restaurant` WHERE resto_id = :restaurant_id");
            $select_messages->execute([':restaurant_id' => $owner_id]);
            $numbers_of_messages = $select_messages->rowCount();
         ?>
         <h3><?= $numbers_of_messages; ?></h3>
         <p>new messages</p>
         <a href="messages_resto.php" class="btn">see messages</a>
      </div>

   </div>

</section>


<!-- admin dashboard section ends -->

<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>
