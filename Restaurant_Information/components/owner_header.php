<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <section class="flex">

      <a href="dashboard_owner.php" class="logo">Owner<span>Panel</span></a>

      <nav class="navbar">
         <a href="dashboard_owner.php">Home</a>
         <a href="restaurant_owner.php">Restaurant</a>
         <a href="reservation_resto.php">Reservation</a>
         <a href="messages_resto.php">Messages</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `owner` WHERE id = ?");
            $select_profile->execute([$owner_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <div class="flex-btn">
            <a href="admin_login.php" class="option-btn">login</a>
         </div>
         <a href="../components/owner_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn">logout</a>
      </div>

   </section>

</header>