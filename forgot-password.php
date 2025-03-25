<?php 
session_start();
require_once('./header.php');




if(!empty($_POST['email']) && !empty($_POST['send-otp'])   ){
    $otp = rand('1000','9999');
    require_once('./logics.class.php');
    $adminObj = new logics();

    $to = $_POST['email'];
    $subject = "OTP to reset Password";

    $message = "
    <html>
    <head>
    <title>Lakshmi Sreenivasa Jewellery</title>
    </head>
    <body>
    <p>To Reset your Password, Please use the below OTP.</p>
    <br>
    <span>OTP : <span style='font-weight: bold;color:red;font-size:30px'>".$otp."</span></span>
    <br>
    Regards,
    Lakshmi Sreenivasa Jewellery

    <i>This is Auto Generated Email - ".date('Y-m-d H:i:s')." </i>

    </body>
    </html>
    ";


    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: <info@lsjcollections.com>' . "\r\n";

    require_once('./logics.class.php');
    $Obj = new logics;

    $verification = $Obj->checkEmailExists($_POST['email']);
    if(!empty($verification['status']) && $verification['status']==1){

        $mail = mail($to,$subject,$message,$headers);

        if(1){
            $_SESSION['forgot-password-otp'] = $otp;
            $_SESSION['email'] = $_POST['email'];
            echo '<script src="panels/js/sweetalert.js"></script>';
            echo '<script>';
            echo 'Swal.fire({
                    icon: "success",
                    title: "OTP Sent, Please check Mail",
                    showConfirmButton: true,
                }).then(function() {
                    window.location.href = "forgot-password";
                });';
            echo '</script>';
        }else{
            echo '<script src="panels/js/sweetalert.js"></script>';
            echo '<script>';
            echo 'Swal.fire({
                    icon: "error",
                    title: "Failed to send OTP!",
                    text: "Please try again"
                }).then(function() {
                    window.location.href = "forgot-password";
                });';
            echo '</script>';
        }
    }else{
        echo '<script src="panels/js/sweetalert.js"></script>';
        echo '<script>';
        echo 'Swal.fire({
                icon: "error",
                title: "Email Not Registered with Us!",
                text: "Please try again"
            }).then(function() {
                window.location.href = "forgot-password";
            });';
        echo '</script>';
    }

}



if(!empty($_POST['email']) && !empty($_POST['otp']) ){
    if($_POST['otp'] == $_SESSION['forgot-password-otp']){
        $_SESSION['verified-otp'] = $_POST['otp'];
        $_SESSION['email'] = $_POST['email'];
        unset($_SESSION['forgot-password-otp']);
        
        echo '<script src="panels/js/sweetalert.js"></script>';
        echo '<script>';
        echo 'Swal.fire({
                icon: "success",
                title: "OTP Verified, Please create new Password",
                showConfirmButton: true,
            }).then(function() {
                window.location.href = "forgot-password";
            });';
        echo '</script>';



    }else{
        echo '<script src="panels/js/sweetalert.js"></script>';
        echo '<script>';
        echo 'Swal.fire({
                icon: "error",
                title: "Invalid OTP!",
                text: "Please try again"
            }).then(function() {
                window.location.href = "forgot-password";
            });';
        echo '</script>';
    }
}


if(!empty($_POST['recovery-email']) && !empty($_POST['password']) && !empty($_POST['password1'])  ){
    if($_POST['password'] == $_POST['password1']){
        unset($_SESSION['verified-otp']);

        require_once('./logics.class.php');
        $Obj = new logics;

        $verification = $Obj->ResetPassword($_POST['recovery-email'],$_POST['password']);
        if(!empty($verification['status']) && $verification['status']==1){
            echo '<script src="panels/js/sweetalert.js"></script>';
            echo '<script>';
            echo 'Swal.fire({
                    icon: "success",
                    title: "Password Reset Successful, Please Login",
                    showConfirmButton: true,
                }).then(function() {
                    window.location.href = "account";
                });';
            echo '</script>';
        }else{
            echo '<script src="panels/js/sweetalert.js"></script>';
            echo '<script>';
            echo 'Swal.fire({
                    icon: "error",
                    title: "Failed to Reset Password!",
                    text: "Please try again"
                }).then(function() {
                    window.location.href = "forgot-password";
                });';
            echo '</script>';
        }
    }else{
        echo '<script src="panels/js/sweetalert.js"></script>';
        echo '<script>';
        echo 'Swal.fire({
                icon: "error",
                title: "Password & Confirm Password Mismatched!",
                text: "Please try again"
            }).then(function() {
                window.location.href = "forgot-password";
            });';
        echo '</script>';
    }
}
?>


    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="#">Home</a>
                    <!-- <a class="breadcrumb-item text-dark" href="#">Shop</a> -->
                    <span class="breadcrumb-item active">Forgot Password</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Checkout Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-6 mx-auto">
                <div class="card">
                    
                    <div class="card-body">
                    <h4 class="text-center">Reset Password <?php echo !empty($_SESSION['forgot-password-otp']) ? $_SESSION['forgot-password-otp'] : ''; ?>
                    </h4>
                        
                        <form action="./forgot-password" method="post">
                            <!-- <label for="">Enter Registered E-mail Address</label> -->
                            
                            <?php
                            if(!empty($_SESSION['forgot-password-otp'])){
                                ?>
                                <input type="email" name="email" class="form-control" placeholder="Please Enter your Email Address" <?php if(!empty($_SESSION['email']) && $_SESSION['forgot-password-otp']){ echo 'value="'.$_SESSION['email'].'" readonly'; } ?> required id="">
                                <br>
                                    <input type="number" name="otp" class="form-control" placeholder="Please Enter OTP" id="" maxlength="4">
                                    <small class="text-danger"><?php echo !empty($msg) ? $msg : ""; ?></small>
                                    <br>
                                <?php
                            }elseif(!empty($_SESSION['verified-otp'])){
                                ?>
                                <input type="hidden" name="recovery-email" value="<?php echo $_SESSION['email'] ?>" id="">
                                <input type="password" name="password" class="form-control" placeholder="Create New Password" required id="">
                                <br>
                                <input type="password" name="password1" class="form-control" placeholder="Confirm Password" required id="">
                                <br>
                                <?php

                            }else{
                                ?>
                                <input type="email" name="email" class="form-control" placeholder="Please Enter your Email Address" required id="">
                                <br>
                                    <input type="hidden" name="send-otp" value="1" class="form-control" placeholder="Please Enter OTP" id="">
                                    
                                    <br>
                                <?php
                            }
                            ?>
                            <input type="submit" value="<?php if(!empty($_SESSION['forgot-password-otp'])){ echo 'Validate OTP'; }elseif(!empty($_SESSION['verified-otp'])){ echo 'Reset Password'; }else{ echo 'Send OTP'; } ?>" class="btn btn-primary" name="" id="">
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Checkout End -->

    <?php 
require_once('./footer.php');
?>