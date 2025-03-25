<?php
session_start();
if(!empty($_SESSION['username']) || !empty($_SESSION['user_id'])){
    unset($_SESSION['username']);
    unset($_SESSION['user_id']);
    header('location: index');
}
unset($_SESSION['username']);
unset($_SESSION['user_id']);
    header('location: index');

?>