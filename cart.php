<?php 
session_start();
if(!empty($_SESSION['username'])){
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


    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="#">Home</a>
                    <a class="breadcrumb-item text-dark" href="#">Shop</a>
                    <span class="breadcrumb-item active">Shopping Cart</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <?php
                if($cart['count']>0){
                ?>
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                    <?php 
                    
                    for($i=0;$i<$cart['count'];$i++){ 
                        
                        ?>
                        <tr>
                            <td class="text-left">
                                <img src="./panels/admin/product/<?php echo $cart['featured_image'][$i] ?>" alt="" style="width: 50px;"> 
                                <?php echo $cart['product_name'][$i] ?>
                            </td>
                            <td class="align-middle">₹<?php echo round($cart['discounted_price'][$i]) ?></td>
                            <td class="align-middle">
                                <div class="input-group quantity mx-auto" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-minus quantity" data-cart-id="<?php echo $cart['id'][$i]; ?>">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text" name="quantity" class="form-control form-control-sm bg-secondary border-0 text-center quantity-input" 
                                        value="<?php echo $cart['quantity'][$i] ?>" 
                                        data-cart-id="<?php echo $cart['id'][$i]; ?>">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-plus quantity" data-cart-id="<?php echo $cart['id'][$i]; ?>">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">₹<?php echo round($cart['discounted_price'][$i]*$cart['quantity'][$i]) ?></td>
                            <td class="align-middle "><button class="btn btn-sm btn-danger delete-cart"  data-cart-id="<?php echo $cart['id'][$i]; ?>" ><i class="fa fa-times"></i></button></td>
                    <?php } ?>

                    </tbody>
                </table>
                <?php
                }else{
                ?>
                <div class="text-center">
                    <br><br>
                    <img src="./images/empty-cart.png" style="width: 150px;" alt="">
                    <h3>Your Cart is Empty!</h3>
                    <a href="index" class="btn btn-primary">Continue Shopping</a>
                </div>
                <?php
                }
                ?>
            </div>
            <div class="col-lg-4">
                
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart Summary</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-2">
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
                            <h5>₹<?php echo $formattedGrandTotal ?></h5>
                        </div>
                        <a href="<?php if($cart['count']>0){ echo "checkout"; } ?>" class="btn btn-block btn-primary font-weight-bold my-3 py-3" >Proceed To Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->

    <?php 
require_once('./footer.php');
} else {
    // Set a flag to trigger the modal
    $_SESSION['show_signin_modal'] = true;

    // Redirect to home page
    header('Location: index');
    exit(); // Always exit after a redirect to prevent further code execution
}
?>

<script>
    $(".btn-plus,.btn-minus").on('click', function() {
        
        var $input = $(this).closest('.input-group').find('input[name="quantity"]');
        var currentValue = parseInt($input.val());
        var cartId = $(this).data('cart-id');

        $input.val(currentValue);
        
        // AJAX request
        $.ajax({
            url: "open-logics.php",
            type: "POST",
            data: {
                quantity_update: currentValue,
                cart_id: cartId
            },
            beforeSend: function() {
                $(".quantity-input").html("<span>Working...</span>");
            },
            success: function(data) {
                $(".quantity-input").html(data);
                location.reload();
            },
            error: function() {
                alert("An error occurred while updating the quantity.");
            }
        });
    });

    // Delete From Cart
    $(".delete-cart").on('click', function() {
        if(confirm('Are you Sure to delete')){
        var cartId = $(this).data('cart-id');
        
        // AJAX request
        $.ajax({
            url: "open-logics.php",
            type: "POST",
            data: {
                cart_delete: 'delete',
                cart_id: cartId
            },
            beforeSend: function() {
                $(".quantity-input").html("<span>Working...</span>");
            },
            success: function(data) {
                $(".quantity-input").html(data);
                location.reload();
            },
            error: function() {
                alert("An error occurred while updating the quantity.");
            }
        });
    }
    });
</script>


<!-- <script>
    $(".quantity").on('change',function(){
        var value = $(this).val();
        alert(value);
        $.ajax({
            url:"student-fetch.php",
            type:"POST",
            data:'request='+value,
            beforeSend:function(){
                $(".dynamic_data").html("<span>Working...</span>");
            },
            success:function(data){
                $(".dynamic_data").html(data);
            }
        });
    });
</script> -->