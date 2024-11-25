<?php

include '../components/connect.php';

session_start();

if (isset($_POST['login_owner'])) {
   $owner_password = $_POST['password']; // Password yang dimasukkan oleh owner
   $title = $_POST['title']; // Nama restoran

   // Menemukan restoran berdasarkan nama restoran dan password owner
   $select_owner = $conn->prepare("SELECT * FROM `restaurant` WHERE `title` = ?");
   $select_owner->execute([$title]);

   if ($select_owner->rowCount() > 0) {
       $fetch_owner = $select_owner->fetch(PDO::FETCH_ASSOC);
       
       // Verifikasi password owner menggunakan password_hash() atau password_verify()
       if (sha1($owner_password) === $fetch_owner['password']) {
         // Jika password valid, simpan session owner
         $_SESSION['password'] = $owner_password;
         $_SESSION['restaurant_id'] = $fetch_owner['id'];
         header('location:dashboard_owner.php');
       } else {
           $message[] = 'Incorrect password!';
       }
   } else {
       $message[] = 'Restaurant not found!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

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

<!-- admin login form section starts  -->

<section class="form-container">

   <form action="" method="POST">
      <h3>Owner Login</h3>
      <input type="text" name="title" placeholder="Enter restaurant name" required class="box">
      <input type="password" name="password" placeholder="Enter your password" required class="box">
      <input type="submit" name="login_owner" value="Login" class="btn">
   </form>

</section>

<!-- admin login form section ends -->











</body>
</html>