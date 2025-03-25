<?php

require_once('./logics.class.php');

$Obj = new logics();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['email'])) {
        $email = $_POST['email'];

        $result = $Obj->AddSubscription($email);

        if ($result['status'] == 1) {
            echo '<script src="./panels/js/sweetalert.js"></script>';
            echo '<script>';
            echo 'Swal.fire({
                    icon: "success",
                    title: "Subscribed successfully!",
                    showConfirmButton: true,
                }).then(function() {
                    window.location.href = window.location.href;
                });';
            echo '</script>';
        } else {
            echo '<script src="./panels/js/sweetalert.js"></script>';
            echo '<script>';
            echo 'Swal.fire({
                    icon: "error",
                    title: "Subscription failed!",
                    text: "Please try again"
                }).then(function() {
                    window.location.href = window.location.href;
                });';
            echo '</script>';
        }
    }
}
 
 ?>
 <!-- Footer Start -->
 <div class="container-fluid bg-dark text-secondary mt-5 pt-5">
        <div class="row px-xl-5 pt-5">
            <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
                <h5 class="text-secondary text-uppercase mb-4">Get In Touch</h5>
                <p class="mb-4">lsj offers premium beauty products, elegant jewelry, and stylish fancy items, combining quality, luxury, and affordability.</p>
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>OXFORD TOWERS 139 UNIT 101 HAL OLD AIRPORT ROAD KODIHALLI , Bengaluru, Kranataka, 560008</p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>cornerstraight@gmail.com</p>
                <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>+91 9175128432</p>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="row">
                    <div class="col-md-4 mb-5">
                        <h5 class="text-secondary text-uppercase mb-4">Quick Shop</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Home</a>
                            <a class="text-secondary mb-2" href="popular-products.php"><i class="fa fa-angle-right mr-2"></i>Popular Collections</a>
                            <a class="text-secondary mb-2" href="recent-products"><i class="fa fa-angle-right mr-2"></i>New Arrivals</a>
                            <a class="text-secondary mb-2" href="contact"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                            <a class="text-secondary" href="./panels/admin/"><i class="fa fa-angle-right mr-2"></i>Admin</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="text-secondary text-uppercase mb-4">Useful Links</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-secondary mb-2" href="./privacy-policy"><i class="fa fa-angle-right mr-2"></i>Privacy Policy</a>
                            <a class="text-secondary mb-2" href="./replacement-policy"><i class="fa fa-angle-right mr-2"></i>Replacement Policy</a>
                            <a class="text-secondary mb-2" href="./terms-conditions"><i class="fa fa-angle-right mr-2"></i>Terms & Conditions</a>
                            <a class="text-secondary mb-2" href="./shipping-policy"><i class="fa fa-angle-right mr-2"></i>Shipping Policy</a>
                            <a class="text-secondary mb-2" href="./faqs"><i class="fa fa-angle-right mr-2"></i>FAQs</a>
                            
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="text-secondary text-uppercase mb-4">Subscribe</h5>
                        <p>Subscribe to our newsletter to get the latest updates about any discounts,offers,Deals..etc</p>
                        <form action="" method="post">
                        <div class="input-group">
                            <input type="text" name="email" class="form-control" placeholder="Your Email Address">
                            <div class="input-group-append">
                                <button class="btn btn-primary">Sign Up</button>
                            </div>
                        </div>
                    </form>
                        <h6 class="text-secondary text-uppercase mt-4 mb-3">Follow Us</h6>
                        <div class="d-flex">
                            <a class="btn btn-primary btn-square mr-2" href="#"><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-primary btn-square mr-2" href="#"><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-primary btn-square mr-2" href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a class="btn btn-primary btn-square" href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row border-top mx-xl-5 py-4" style="border-color: rgba(256, 256, 256, .1) !important;">
            <div class="col-md-6 px-xl-0">
                <p class="mb-md-0 text-center text-md-left text-secondary">
                    &copy; 2024. All Rights Reserved. 
                    <!-- <a class="text-primary" href="https://protechelevate.in">protechelevate</a> -->
                </p>
            </div>
            <div class="col-md-6 px-xl-0 text-center text-md-right">
                <img class="img-fluid" src="img/payments.png" alt="">
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>

    <script src="panels/js/datatable1.js"></script>
    <script src="panels/js/datatable2.js"></script>

    <script>
        $(document).ready(function () {
            // Check if the modal has already been shown
            if (!localStorage.getItem('modalShown')) {
                // Set the flag in localStorage
                localStorage.setItem('modalShown', 'true');
                
                // Delay opening the modal by 10 seconds
                setTimeout(function () {
                    $('#SigninModal').modal('show');
                }, 5000); // 10 seconds
            }
        });
    </script>
</body>

</html>