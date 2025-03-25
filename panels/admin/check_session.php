<?php
function checkAdminSession() {
    // session_start();
    if(empty($_SESSION['role'])) {
        header('Location: ./login.php');
        exit();
    }
}