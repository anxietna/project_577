<?php
session_start();
include "db.php";

$username = $_POST['username'];
$password = $_POST['password'];

/* Check user */
$sql = "SELECT * FROM user 
        WHERE username='$username' 
        AND password='$password'";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {

    $row = mysqli_fetch_assoc($result);

    $_SESSION['userID'] = $row['idUser'];
    $_SESSION['username'] = $row['username'];

    echo "<script>
        alert('Login successful!');
        window.location='main.php';
    </script>";

} else {
    echo "<script>
        alert('Invalid username or password!');
        window.location='login.php';
    </script>";
}
?>
