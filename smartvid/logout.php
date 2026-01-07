<?php
session_start();
session_destroy();
header("Location: logindb.php");
exit();
?>