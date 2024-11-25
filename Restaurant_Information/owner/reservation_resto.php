<?php

include '../components/connect.php';

session_start();

$owner_id = $_SESSION['restaurant_id'];

if (!isset($owner_id)) {
    header('location:owner_login.php');
    exit();
}

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete_message = $conn->prepare("DELETE FROM `reservation` WHERE id = ?");
    $delete_message->execute([$delete_id]);
    header('location:reservation_resto.php');
 }

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>messages</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/owner_header.php' ?>

<!-- messages section starts  -->

<section class="messages">

   <h1 class="heading">Reservation</h1>

   <div class="box-container">

   <?php
      $select_reservation = $conn->prepare("SELECT * FROM `reservation` WHERE resto_id = :restaurant_id");
      $select_reservation->execute([':restaurant_id' => $owner_id]);
      if($select_reservation->rowCount() > 0){
         while($fetch_reservation = $select_reservation->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p> name : <span><?= $fetch_reservation['name']; ?></span> </p>
      <p> number : <span><?= $fetch_reservation['number']; ?></span> </p>
      <p> date : <span><?= $fetch_reservation['date']; ?></span> </p>
      <p> guest : <span><?= $fetch_reservation['guest']; ?></span> </p>
      <a href="reservation_resto.php?delete=<?= $fetch_reservation['id']; ?>" class="delete-btn" onclick="return confirm('delete this reservation?');">delete</a>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">restaurant have no reservation</p>';
      }
   ?>

   </div>

</section>

<!-- messages section ends -->









<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>