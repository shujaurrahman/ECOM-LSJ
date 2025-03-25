<?php 
session_start();
if(!empty($_SESSION['username'])){
require_once('./header.php');

?>


    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="#">Home</a>
                    <a class="breadcrumb-item text-dark" href="#">Shop</a>
                    <span class="breadcrumb-item active">Wishlist</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-12 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Add To cart</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                    <?php for($i=0;$i<$wishlist['count'];$i++){ ?>
                        <tr>
                            <td class="text-left">
                                <img src="./panels/admin/product/<?php echo $wishlist['featured_image'][$i] ?>" alt="" style="width: 50px;"> 
                                <?php echo $wishlist['product_name'][$i] ?>
                            </td>
                            <td class="align-middle">₹<?php echo round($wishlist['discounted_price'][$i]) ?></td>
                            <td class="align-middle"><a href="./open-logics.php?type=addToCart&product_id=<?php echo $wishlist['product_id'][$i] ?>" class="btn btn-outline-primary rounded-pill">Add To Cart</a></td>

                            <td class="align-middle "><button class="btn btn-sm btn-danger delete-cart"  data-cart-id="<?php echo $wishlist['id'][$i]; ?>" ><i class="fa fa-times"></i></button></td>
                    <?php } ?>

                    </tbody>
                </table>
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

    // Delete From Wishlist
    $(".delete-cart").on('click', function() {
        if(confirm('Are you Sure to delete')){
        var cartId = $(this).data('cart-id');
        
        // AJAX request
        $.ajax({
            url: "open-logics.php",
            type: "POST",
            data: {
                wishlist_delete: 'delete',
                wishlist_id: cartId
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
