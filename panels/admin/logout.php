<?php
session_start();
session_destroy();
session_unset();
unset($_SESSION['role']);
unset($_SESSION['username']);
header('Location: ./login.php');
exit();
?>