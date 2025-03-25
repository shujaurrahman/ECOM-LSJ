<?php
session_start();
if(!empty($_GET['id']) && !empty($_GET['status'])){
    require_once('./logics.class.php');
    $obj = new logics();
    $verification= $obj->RegStatusUpdate($_GET['id'],$_GET['status']);
    if(!empty($verification['status']) && $verification['status']==1){
        $_SESSION['succ']="Success";
        header('location:registrations.php');
    }else{
        $_SESSION['fail']="Failure";
        header('location:registrations.php');
    }
}


?>