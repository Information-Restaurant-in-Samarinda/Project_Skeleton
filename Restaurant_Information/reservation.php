<?php 
include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

if (!isset($user_id)) {
    header('location:login.php');
    exit;
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

// Cek jumlah reservasi yang sudah ada untuk restoran ini
$check_reservations = $conn->prepare("SELECT * FROM `reservation` WHERE resto_id = ?");
$check_reservations->execute([$resto_id]);

// Cek apakah sudah mencapai 10 reservasi
$is_limit_reached = $check_reservations->rowCount() >= $restaurant['reservation'];

if ($is_limit_reached) {
    $message[] = 'Reservation limit reached! Only ' . $restaurant['reservation'] . ' reservations are allowed.';
}

if (isset($_POST['send']) && !$is_limit_reached) {

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $date = $_POST['date'];
    $date = filter_var($date, FILTER_SANITIZE_STRING);
    $guest = $_POST['guest'];
    $guest = filter_var($guest, FILTER_SANITIZE_STRING);

    // Cek apakah reservasi sudah ada
    $select_reservation = $conn->prepare("SELECT * FROM `reservation` WHERE name = ? AND number = ? AND date = ? AND guest = ?");
    $select_reservation->execute([$name, $number, $date, $guest]);

    if ($select_reservation->rowCount() > 0) {
        $message[] = 'Already sent reservation!';
    } else {
        // Insert reservasi baru
        $insert_reservation = $conn->prepare("INSERT INTO `reservation`(resto_id, user_id, name, number, date, guest) VALUES(?,?,?,?,?,?)");
        $insert_reservation->execute([$resto_id, $user_id, $name, $number, $date, $guest]);

        if ($insert_reservation->rowCount() > 0) {
            $message[] = 'Sent reservation successfully!';
        } else {
            $message[] = 'Failed to send reservation!';
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
   <title>Reservation</title>
   <link rel="stylesheet" href="css/style.css">
   <style>
       /* Menambahkan gaya untuk form yang disable */
       .disabled-form input, .disabled-form button {
           background-color: #f0f0f0;
           color: #ccc;
           cursor: not-allowed;
       }
   </style>
</head>
<body>
   <?php include 'components/user_header.php'; ?>
   
   <section class="form-container">
       <form action="" method="POST" class="<?= $is_limit_reached ? 'disabled-form' : '' ?>">
           <h3>Reservation <? $restaurant['title']; ?></h3>
           <input type="text" name="name" maxlength="20" placeholder="Enter your name" class="box" <?= $is_limit_reached ? 'disabled' : '' ?> required>
           <input type="number" name="number" maxlength="20" placeholder="Enter your number" class="box" <?= $is_limit_reached ? 'disabled' : '' ?> required>
           <input type="date" name="date" maxlength="20" placeholder="Enter reservation date" class="box" <?= $is_limit_reached ? 'disabled' : '' ?> required>
           <input type="number" name="guest" maxlength="20" placeholder="Enter guest count" class="box" <?= $is_limit_reached ? 'disabled' : '' ?> required>
           <input type="submit" value="Reserve Now" name="send" class="btn" <?= $is_limit_reached ? 'disabled' : '' ?>>
       </form>
   </section>

   <center><a href="restaurant.php" class="btn">Back to Restaurant</a></center>

   <div class="sticky"></div>

   <?php include 'components/footer.php'; ?>
   <script src="js/script.js"></script>
</body>
</html>
