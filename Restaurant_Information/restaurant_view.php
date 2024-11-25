<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
 }else{
    $user_id = '';
};

if (!isset($user_id)) {
    header('location:login.php');
    exit;
}

if(isset($_GET['id'])) {
    $resto_id = $_GET['id'];

    $get_restaurant = $conn->prepare("SELECT * FROM `restaurant` WHERE id = ?");
    $get_restaurant->execute([$resto_id]);
    
    if($get_restaurant->rowCount() > 0){
        $restaurant = $get_restaurant->fetch(PDO::FETCH_ASSOC);
}}else{
    echo '<p class="empty">no restaurant added yet!</p>';
 }

if(isset($_POST['send'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $msg = $_POST['message'];
    $msg = filter_var($msg, FILTER_SANITIZE_STRING);
 
    $select_message = $conn->prepare("SELECT * FROM `message_restaurant` WHERE name = ? AND email = ? AND number = ? AND message = ?");
    $select_message->execute([$name, $email, $number, $msg]);
 
    if($select_message->rowCount() > 0){
       $message[] = 'already sent message!';
    }else{
 
       $insert_message = $conn->prepare("INSERT INTO `message_restaurant`(user_id, resto_id, name, email, number, message) VALUES(?,?,?,?,?,?)");
       $insert_message->execute([$user_id, $resto_id, $name, $email, $number, $msg]);
 
       $message[] = 'sent message successfully!';
 
    }
 
 }

 if (isset($_GET['id']) && !empty($_GET['id'])) {
    $resto_id = $_GET['id'];
    
    // Query untuk mengambil data restoran berdasarkan ID
    $get_restaurant = $conn->prepare("SELECT * FROM `restaurant` WHERE id = ?");
    $get_restaurant->execute([$resto_id]);

    if ($get_restaurant->rowCount() > 0) {
        $restaurant = $get_restaurant->fetch(PDO::FETCH_ASSOC);
    } else {
        echo "<script>alert('Restoran tidak ditemukan!'); window.history.back();</script>";
        exit;
    }
} else {
    echo "<script>alert('ID restoran tidak valid!'); window.history.back();</script>";
    exit;
}

if (isset($_POST['like'])) {
    // Cek apakah user sudah login
    if (!isset($_SESSION['user_id'])) {
        $message[] = 'You must log in to like a restaurant!';
    } else {
        $resto_id = $_POST['resto_id']; // ID restoran dari form
        $user_id = $_SESSION['user_id']; // Ambil ID user dari session

        // Cek apakah user sudah menyukai restoran ini
        $check_like = $conn->prepare("SELECT * FROM `likes` WHERE resto_id = ? AND user_id = ?");
        $check_like->execute([$resto_id, $user_id]);

        if ($check_like->rowCount() > 0) {
            // Jika sudah menyukai, beri pesan
            $message[] = 'You already liked this restaurant!';
        } else {
            // Jika belum, tambahkan data ke tabel likes
            $insert_like = $conn->prepare("INSERT INTO `likes` (user_id, resto_id) VALUES (?, ?)");
            $insert_like->execute([$user_id, $resto_id]);

            $message[] = 'Restaurant liked successfully!';
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
   <title>about</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

   <style>
    .btn-like {
        margin-top: 1rem;
        display: inline-block;
        border-radius: 10px;
        font-size: 1rem;
        padding:1rem 1rem;
        cursor: pointer;
        text-transform: capitalize;
        transition: .2s linear;
        background-color: #fed330;
        color: #222;
    }
    .btn-like:hover {
        letter-spacing: .2rem;
    }
    .restaurant-detail {
        display: flex;
        flex-wrap: wrap;
        gap: 2rem;
        margin-bottom: 2rem;
    }
    .resto-main {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .resto-content {
        display: flex;
        flex-wrap: wrap;
        justify-content: left;
        gap: 1rem;
    }
    .resto-content img {
        width: 180px;
        height: auto;
        object-fit: cover;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s;
    }
    .resto-content img:hover {
        transform: scale(1.05);
    }
    .restaurant-detail .resto-description,
    .restaurant-detail .reservation-section {
        padding: 1rem;
        flex: 1;
        min-width: 300px;
        align-items: auto;
        justify-content: auto; 
    }
    .reservation-section {
        margin: 2rem;
    }
    .location-contact {
        display: flex;
        gap: 2rem; /* Jarak antar elemen */
        background-color: #fff;
        margin: 2rem;
        padding: 2rem;
        border: #000;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.54);
        height: 400px;
        width: 120%;
    }
    .reservation-section .contact-info {
        flex: 2;
        display: flex;
        flex-direction: column;
        gap: 1rem;
        justify-content: center;
        height: 350px;
    }
    .reservation-section .contact-info .contact-form form {
        display: flex;
        flex-direction: column;
        width: 300px;
    }
    .contact-form input,
    .contact-form textarea {
        width: 103%;
        padding: 0.5rem;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 1rem;
    }
    .contact-form .form-btn {
        width: 50%;
        background-color: #fdd130;
        color: #000;
        border: none;
        padding: 1rem;
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
    }
    .contact-form .form-btn:hover {
        letter-spacing: .2rem;
    }
    .like-section {
        display: block;
    }
   </style>

</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<!-- Informasi Utama Restoran -->
    <div class="heading">
        <h3><?= $restaurant['title']; ?></h3>
        <p><a href="index.php">home</a> <span> / Restaurant</span></p>
    </div>

<!--restaurant section start -->
<section class="restaurant-detail">
    <!-- Header/Banner Restoran -->
    <!-- <div class="resto-header">
        <img src="uploaded_img_resto/<?= $restaurant['images_resto']; ?>" alt="<?= $restaurant['title']; ?>">
    </div> -->

    <!-- Informasi Deskripsi Restoran -->
    <div class="resto-description">
        <br><br>
        <div class="like-section">
            <?php
                $select_likes = $conn->prepare("SELECT COUNT(*) AS total_likes FROM `likes` WHERE resto_id = ?");
                $select_likes->execute([$resto_id]);
                $likes_data = $select_likes->fetch(PDO::FETCH_ASSOC);
                $total_likes = $likes_data['total_likes'];
            ?>
            
            <form method="post">
                <input type="hidden" name="resto_id" value="<?= htmlspecialchars($resto_id); ?>"> <!-- ID Restoran -->
                <input type="hidden" name="user_id" value="<?= htmlspecialchars($user_id); ?>"> <!-- ID User -->
                <button type="submit" name="like" class="btn-like">Like</button>
            </form>
        </div>

        <br><br>

        <p style="font-size: large;"><?= $restaurant['description']; ?></p>

        <br>

        <p><?= $total_likes; ?> likes</p>

        <br>

        <div class="resto-content">
            <div class="content-images">
                <img src="uploaded_img_content/<?= $restaurant['images_content']; ?>" alt="Menu">
            </div>
        </div>
    </div>

    <!-- Tombol Reservasi -->
    <div class="reservation-section">
        <a href="reservation.php?id=<?= $restaurant['id']; ?>" class="btn">
            Reservation Now
        </a>

        <div class="location-contact">
            <div class="map-container">
                <iframe 
                    src="<?= $restaurant['map']; ?>"
                    width="100%" 
                    height="450" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>

            <div class="contact-info">
                <h2>Contact Us</h2>
                
                <!-- Form Contact -->
                <form action="" method="post" class="contact-form">
                    <div class="input-group">
                        <input type="text" name="name" maxlength="50" class="box" placeholder="enter your name" required>
                    </div>
                    
                    <div class="input-group">
                        <input type="email" name="email" maxlength="50" class="box" placeholder="enter your email" required>
                    </div>
                    
                    <div class="input-group">
                        <input type="number" name="number" min="0" max="9999999999" class="box" placeholder="enter your number" required maxlength="10">
                    </div>
                    
                    <div class="input-group">
                        <textarea name="message" class="box" required placeholder="enter your message" maxlength="500" cols="30" rows="10"></textarea>
                    </div>
                    
                    <center><button type="submit" name="send" class="form-btn">Send Message</button></center>
                </form>
            </div>
        </div>
    </div>

    <!-- Lokasi dan Kontak -->
    
</section>
<!--restaurant section  end -->







<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->

<script src="js/script.js"></script>

</body>
</html>