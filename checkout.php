<?php 
session_start();

require_once('./header.php');



// Calculate Subtotal (Total of all discounted prices * quantities)
$subtotal = 0;
for($i = 0; $i < $cart['count']; $i++) {
    $subtotal += round($cart['discounted_price'][$i] * $cart['quantity'][$i]);
}

// Format subtotal with commas
$formattedSubtotal = number_format($subtotal, 0, '.', ',');

// Calculate GST (18%)
$gstRate = 0.18;
$gstAmount = round($subtotal * $gstRate);

// Format GST amount with commas
$formattedGstAmount = number_format($gstAmount, 0, '.', ',');

// Calculate Grand Total
$grandTotal = $subtotal + $gstAmount;

// Format grand total with commas
$formattedGrandTotal = number_format($grandTotal, 0, '.', ',');

?>

<!-- Add this in the head section -->
<style>
.fa-spinner {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
<!-- Add this before closing </head> tag -->
<script src="https://mercury-uat.phonepe.com/web/bundle/checkout.js"></script>

    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="#">Home</a>
                    <a class="breadcrumb-item text-dark" href="#">Shop</a>
                    <span class="breadcrumb-item active">Checkout</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Checkout Start -->
    <div class="container-fluid">
        <form id="checkoutForm"  method="post" enctype="multipart/form-data">
        <div class="row px-xl-5">
            <div class="col-lg-8">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Billing Address</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Full Name <sup class="text-danger">*</sup></label>
                            <input class="form-control" type="text" placeholder="Enter Full Name" name="name" id="billing_name" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>E-mail <sup class="text-danger">*</sup></label>
                            <input class="form-control" type="email" placeholder="Enter Email Address" name="email" id="billing_email" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Mobile No <sup class="text-danger">*</sup></label>
                            <input class="form-control" type="tel" pattern="[6-9][0-9]{9}" placeholder="Enter 10 Digit Mobile number Without +91" name="mobile" id="billing_mobile"required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Address Line 1 <sup class="text-danger">*</sup></label>
                            <input class="form-control" type="text" placeholder="Enter Street Address" name="address1" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Address Line 2</label>
                            <input class="form-control" type="text" placeholder="Enter Door no., Area ..etc" name="address2" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>City <sup class="text-danger">*</sup></label>
                            <input class="form-control" type="text" placeholder="Enter City Name" name="city" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>State <sup class="text-danger">*</sup></label>
                            <select class="custom-select" name="state">
                                <!-- <option value="" disabled selected>Select State</option> -->
                                <!-- South Indian States -->
                                <option value="Andhra Pradesh" selected>Andhra Pradesh</option>
                                <option value="Telangana">Telangana</option>
                                <option value="Karnataka">Karnataka</option>
                                <option value="Kerala">Kerala</option>
                                <option value="Tamil Nadu">Tamil Nadu</option>
                                <!-- Other Indian States -->
                                <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                <option value="Assam">Assam</option>
                                <option value="Bihar">Bihar</option>
                                <option value="Chhattisgarh">Chhattisgarh</option>
                                <option value="Goa">Goa</option>
                                <option value="Gujarat">Gujarat</option>
                                <option value="Haryana">Haryana</option>
                                <option value="Himachal Pradesh">Himachal Pradesh</option>
                                <option value="Jharkhand">Jharkhand</option>
                                <option value="Madhya Pradesh">Madhya Pradesh</option>
                                <option value="Maharashtra">Maharashtra</option>
                                <option value="Manipur">Manipur</option>
                                <option value="Meghalaya">Meghalaya</option>
                                <option value="Mizoram">Mizoram</option>
                                <option value="Nagaland">Nagaland</option>
                                <option value="Odisha">Odisha</option>
                                <option value="Punjab">Punjab</option>
                                <option value="Rajasthan">Rajasthan</option>
                                <option value="Sikkim">Sikkim</option>
                                <option value="Tripura">Tripura</option>
                                <option value="Uttar Pradesh">Uttar Pradesh</option>
                                <option value="Uttarakhand">Uttarakhand</option>
                                <option value="West Bengal">West Bengal</option>
                                <!-- Union Territories -->
                                <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                                <option value="Chandigarh">Chandigarh</option>
                                <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
                                <option value="Delhi">Delhi</option>
                                <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                <option value="Ladakh">Ladakh</option>
                                <option value="Lakshadweep">Lakshadweep</option>
                                <option value="Puducherry">Puducherry</option>
                            </select>

                        </div>
                        <div class="col-md-6 form-group">
                            <label>ZIP Code <sup class="text-danger">*</sup></label>
                            <input class="form-control" type="text" placeholder="517551" maxlength="6" id="zipCode" oninput="this.value = this.value.replace(/[^0-9]/g, '')" name="pincode" required>
                        </div>
                        <div class="col-md-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="shipto">
                            <label class="custom-control-label" for="shipto"  data-toggle="collapse" data-target="#shipping-address">Ship to different address</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="collapse mb-5" id="shipping-address">
                    <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Shipping Address</span></h5>
                    <div class="bg-light p-30">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Full Name </label>
                                <input class="form-control" type="text" placeholder="Enter Full Name" name="shipping_name" id="billing_name" >
                            </div>
                            <div class="col-md-6 form-group">
                                <label>E-mail </label>
                                <input class="form-control" type="email" placeholder="Enter Email Address" name="shipping_email" id="billing_email">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Mobile No </label>
                                <input class="form-control" type="tel" pattern="[6-9][0-9]{9}" placeholder="Enter 10 Digit Mobile number Without +91" name="shipping_mobile" id="billing_mobile" >
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Address Line 1 </label>
                                <input class="form-control" type="text" placeholder="Enter Street Address" name="shipping_address1" >
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Address Line 2</label>
                                <input class="form-control" type="text" placeholder="Enter Door no., Area ..etc" name="shipping_address2" >
                            </div>
                            <div class="col-md-6 form-group">
                                <label>City </label>
                                <input class="form-control" type="text" placeholder="Enter City Name" name="shipping_city" >
                            </div>
                            <div class="col-md-6 form-group">
                                <label>State </label>
                                <select class="custom-select" name="shipping_state">
                                    <option value="" selected>Select State</option>
                                    <!-- South Indian States -->
                                    <option value="Andhra Pradesh">Andhra Pradesh</option>
                                    <option value="Telangana">Telangana</option>
                                    <option value="Karnataka">Karnataka</option>
                                    <option value="Kerala">Kerala</option>
                                    <option value="Tamil Nadu">Tamil Nadu</option>
                                    <!-- Other Indian States -->
                                    <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                    <option value="Assam">Assam</option>
                                    <option value="Bihar">Bihar</option>
                                    <option value="Chhattisgarh">Chhattisgarh</option>
                                    <option value="Goa">Goa</option>
                                    <option value="Gujarat">Gujarat</option>
                                    <option value="Haryana">Haryana</option>
                                    <option value="Himachal Pradesh">Himachal Pradesh</option>
                                    <option value="Jharkhand">Jharkhand</option>
                                    <option value="Madhya Pradesh">Madhya Pradesh</option>
                                    <option value="Maharashtra">Maharashtra</option>
                                    <option value="Manipur">Manipur</option>
                                    <option value="Meghalaya">Meghalaya</option>
                                    <option value="Mizoram">Mizoram</option>
                                    <option value="Nagaland">Nagaland</option>
                                    <option value="Odisha">Odisha</option>
                                    <option value="Punjab">Punjab</option>
                                    <option value="Rajasthan">Rajasthan</option>
                                    <option value="Sikkim">Sikkim</option>
                                    <option value="Tripura">Tripura</option>
                                    <option value="Uttar Pradesh">Uttar Pradesh</option>
                                    <option value="Uttarakhand">Uttarakhand</option>
                                    <option value="West Bengal">West Bengal</option>
                                    <!-- Union Territories -->
                                    <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                                    <option value="Chandigarh">Chandigarh</option>
                                    <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
                                    <option value="Delhi">Delhi</option>
                                    <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                    <option value="Ladakh">Ladakh</option>
                                    <option value="Lakshadweep">Lakshadweep</option>
                                    <option value="Puducherry">Puducherry</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>ZIP Code </label>
                                <input class="form-control" type="text" placeholder="517551" maxlength="6" id="zipCode" oninput="this.value = this.value.replace(/[^0-9]/g, '')" name="shipping_pincode" >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Order Total</span></h5>
                <div class="bg-light p-30 mb-3">
                <div class="border-bottom">
    <h6 class="mb-3">Products (Total: <?php echo $cart['count'] ?>)</h6>
    <?php 
    for($i = 0; $i < $cart['count']; $i++) {
        ?>
        <div class="d-flex justify-content-between">
            <p>
                <img src="./panels/admin/product/<?php echo $cart['featured_image'][$i] ?>" style="width: 40px;height:40px;border-radius:50%;border:1px solid grey" alt=""> 
                <span class="product-name"><?php echo $cart['product_name'][$i] ?></span>
                (<b>x<?php echo $cart['quantity'][$i] ?></b>)
            </p>
            <p>₹<?php echo round($cart['discounted_price'][$i] * $cart['quantity'][$i]) ?></p>
        </div>
        <input type="hidden" name="quantity[]" value="<?php echo $cart['quantity'][$i] ?>">
        <?php
    }
    ?>
</div>


                    <input type="hidden" name="total_products" value="<?php echo $cart['count'] ?>" id="">
                    <input type="hidden" name="gst" value="<?php echo $formattedGstAmount ?>" id="">
                    <input type="hidden" name="subtotal" value="<?php echo $formattedSubtotal ?>" id="">
                    <input type="hidden" name="total" value="<?php echo $formattedGrandTotal ?>" id="payAmount">
                    <input type="hidden" name="grandTotal_hidden"  id="grandTotal_hidden">
                    <input type="hidden" name="coupon_hidden"  id="coupon_hidden">
                    <input type="hidden" name="discount_hidden"  id="discount_hidden">
                    <input type="hidden" name="couponType_hidden"  id="couponType_hidden">

                    <!-- <p id="grandTotal_hidden">grandTotal_hidden: </p>
                    <p id="coupon_hidden">coupon_hidden: </p>
                    <p id="discount_hidden">discount_hidden: </p>
                    <p id="couponType_hidden">couponType_hidden: </p> -->

                    <div class="border-bottom pt-3 pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Subtotal</h6>
                            <h6>₹<?php echo $formattedSubtotal ?></h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">GST(18%)</h6>
                            <h6 class="font-weight-medium">₹<?php echo $formattedGstAmount ?></h6>
                        </div>
                    </div>
                    <div class="pt-2">  
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Grand Total</h5>
                            <h5>₹<span id="grandTotal"><?php echo $formattedGrandTotal ?></span></h5>
                        </div>
                    </div>

                </div>
                <div class="input-group mb-30">
                    <input type="text" class="form-control border-0 p-4" id="couponCode" placeholder="Coupon Code">
                    <div class="input-group-append">
                        <button class="btn btn-primary" id="applyCouponBtn" data-grandtotal="<?php echo $grandTotal ?>">Apply Coupon</button>
                    </div>
                </div>

                <div class="mb-5">
                    <h5 class="section-title position-relative text-uppercase mb-3">
                        <span class="bg-secondary pr-3">Payment</span>
                    </h5>
                    <div class="bg-light p-30">
                        <!-- Remove the form action since we'll handle it via AJAX -->
                        <button type="button" name="submit" id="PayNow" 
                            class="btn btn-block btn-primary font-weight-bold py-3">
                            Place Order
                        </button>
                    </div>
                </div>

            </div>
        </div>
        </form>
    </div>
    <!-- Checkout End -->

    <?php 
require_once('./footer.php');
?>

<!-- Add these scripts before closing body tag -->
<script src="./js/checkout.js"></script>

<script>
    // Apply Coupon AJAX with event delegation
    $(document).on('click', '#applyCouponBtn', function() {
        var couponCode = $("#couponCode").val(); // Get coupon code from input field
        var grandTotal = $(this).data('grandtotal'); // Retrieve the grand total data attribute

        if (couponCode === "") {
            alert("Please enter a coupon code.");
            return;
        }

        // AJAX request to validate the coupon
        $.ajax({
            url: "open-logics.php", // URL where the coupon is validated
            type: "POST",
            data: {
                coupon: couponCode, // Send coupon code
                grandTotal: grandTotal // Send grandTotal
            },
            beforeSend: function() {
                $(".input-group-append").html("<span>Validating...</span>"); // Show loading message
            },
            success: function(response) {
                $(".input-group-append").html('<button class="btn btn-primary" id="applyCouponBtn" data-grandtotal="' + grandTotal + '">Apply Coupon</button>'); // Reset button

                // Parse the JSON response if it is a string
                if (typeof response === "string") {
                    response = JSON.parse(response);
                }

                // Clear previous messages
                $(".pt-2 .coupon-message").remove();

                // Check the response
                if (response.status == '1') {
                    // Coupon applied successfully
                    alert("Coupon applied successfully! Discount: " + response.discount + " " + response.type);

                    $("#grandTotal").html(response.new_total);
                    
                    // $("#grandTotal_hidden").html(response.new_total);
                    // $("#coupon_hidden").html(couponCode);
                    // $("#discount_hidden").html(response.discount);
                    // $("#couponType_hidden").html(response.type);

                    $("#grandTotal_hidden").val(response.new_total);
                    $("#coupon_hidden").val(couponCode);
                    $("#discount_hidden").val(response.discount);
                    $("#couponType_hidden").val(response.type);



                    // Update the grand total on the page
                    $(".pt-2 .d-flex .mt-2 h5:last-child").text("₹" + parseFloat(response.new_total).toFixed(2));

                    // Show the applied coupon message in green
                    $(".pt-2").append('<div class="coupon-message" style="color: green;">Coupon applied: ' + couponCode + ' with ' + response.discount + ' ' + response.type + ' OFF </div>');
                } else {
                    // Invalid or expired coupon
                    alert(response.error || "Invalid or expired coupon.");

                    // Show the invalid coupon message in red
                    $(".pt-2").append('<div class="coupon-message" style="color: red;">' + response.error + '</div>');
                }
            },
            error: function() {
                alert("An error occurred while validating the coupon.");
                $(".input-group-append").html('<button class="btn btn-primary" id="applyCouponBtn" data-grandtotal="' + grandTotal + '">Apply Coupon</button>'); // Reset button

                // Clear previous messages
                $(".pt-2 .coupon-message").remove();
            }
        });
    });

</script>


