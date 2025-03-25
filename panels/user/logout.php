<?php
session_start();
if(!empty($_SESSION['username'])){
    unset($_SESSION['username']);
    header('location: login.php');
}
unset($_SESSION['username']);
    header('location: login.php');

?>