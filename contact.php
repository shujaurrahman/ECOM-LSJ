<?php 
session_start();
require_once('header.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['namecontact']) && !empty($_POST['emailcontact']) && !empty($_POST['subjectcontact']) && !empty($_POST['messagecontact'])) {
        require_once('./logics.class.php');
        $Obj = new logics();

        $verification = $Obj->AddContact($_POST['namecontact'], $_POST['emailcontact'], $_POST['subjectcontact'], $_POST['messagecontact']);
        if (!empty($verification['status']) && $verification['status'] == 1) {
            echo '<script src="./panels/js/sweetalert.js"></script>';
            echo '<script>';
            echo 'Swal.fire({
                    icon: "success",
                    title: "Message sent successfully!",
                    showConfirmButton: true,
                }).then(function() {
                    window.location.href = "contact.php";
                });';
            echo '</script>';
        } else {
            echo '<script src="./panels/js/sweetalert.js"></script>';
            echo '<script>';
            echo 'Swal.fire({
                    icon: "error",
                    title: "Data not Submitted!",
                    text: "Please try again"
                }).then(function() {
                    window.location.href = "contact.php";
                });';
            echo '</script>';
        }
    }
}



?>

<!-- Breadcrumb Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30">
                <a class="breadcrumb-item text-dark" href="#">Home</a>
                <span class="breadcrumb-item active">Testimonial</span>
            </nav>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Contact Start -->
<div class="container-fluid">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Contact Us</span></h2>
    <div class="row px-xl-5">
        <div class="col-lg-7 mb-5">
            <div class="contact-form bg-light p-30">
                <form action="./contact.php" method="post">
                    <div class="control-group">
                        <input type="text" class="form-control" id="name" name="namecontact" placeholder="Your Name"
                            required="required" data-validation-required-message="Please enter your name" />
                        <p class="help-block text-danger"></p>
                    </div>
                    <div class="control-group">
                        <input type="email" class="form-control" id="email" name="emailcontact" placeholder="Your Email"
                            required="required" data-validation-required-message="Please enter your email" />
                        <p class="help-block text-danger"></p>
                    </div>
                    <div class="control-group">
                        <input type="text" class="form-control" id="subject" name="subjectcontact" placeholder="Subject"
                            required="required" data-validation-required-message="Please enter a subject" />
                        <p class="help-block text-danger"></p>
                    </div>
                    <div class="control-group">
                        <textarea class="form-control" rows="8" id="message" name="messagecontact" placeholder="Message"
                            required="required" data-validation-required-message="Please enter your message"></textarea>
                        <p class="help-block text-danger"></p>
                    </div>
                    <div>
                        <button class="btn btn-primary py-2 px-4" type="submit" id="sendMessageButton">Send
                            Message</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-5 mb-5">
            <div class="bg-light p-30 mb-30">
                <iframe style="width: 100%; height: 250px;"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3888.1478675831087!2d77.64429881482942!3d12.959050390866396!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bae1405f1eedf7d%3A0x76ea2e92cd2a3593!2s139%2C%20HAL%20Old%20Airport%20Rd%2C%20Kodihalli%2C%20Bengaluru%2C%20Karnataka%20560008!5e0!3m2!1sen!2sin!4v1707901234567!5m2!1sen!2sin"
                frameborder="0" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="bg-light p-30 mb-3">
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>OXFORD TOWERS 139 UNIT 101 HAL OLD AIRPORT ROAD KODIHALLI , Bengaluru, Kranataka, 560008</p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>cornerstraight@gmail.com</p>
                <p class="mb-2"><i class="fa fa-phone-alt text-primary mr-3"></i>+91 9175128432</p>
            </div>
        </div>
    </div>
</div>
<!-- Contact End -->

<?php
require_once('footer.php');
?>