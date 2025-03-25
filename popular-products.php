<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('./header.php');


// Initialize the Product class
$Obj = new logics();



// Set page title
$pageTitle = "Popular Collection";
?>

<style>
    .product-item {
  height: 400px; 
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}
</style>
<!-- Breadcrumb Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30">
                <a class="breadcrumb-item text-dark" href="./">Home</a>
                <span class="breadcrumb-item active">Popular Collection</span>
            </nav>
        </div>
    </div>
</div>
<div class="container-fluid pt-5 pb-3">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Popular Products</span></h2>
    <div class="row px-xl-5">
    <?php
        for ($i = 0; $i < min($products['count'], 10); $i++) {
            if ($products['statusval'][$i] == 1 && $products['is_popular_collection'][$i] == 1) {
                $averageRating = $Obj->getAverageRating($products['id'][$i]);
                $averageRatingValue = $averageRating['status'] == 1 ? $averageRating['average_rating'] : 0;
                ?>
                <div class="col-lg-3 col-md-4 col-6 pb-1">
                    <div class="product-item bg-light mb-4">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100 mobile-small-image" src="./panels/admin/product/<?php echo $products['featured_image'][$i]; ?>"  alt="">
                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" href="./open-logics.php?type=addToCart&product_id=<?php echo $products['id'][$i] ?>"><i class="fa fa-shopping-cart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href="./open-logics.php?type=addToWishlist&product_id=<?php echo $products['id'][$i] ?>"><i class="far fa-heart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href="./product-view?slug=<?php echo $products['slug'][$i] ?>"><i class="fa fa-eye"></i></a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none mobile-small-font text-truncate product-name" style="max-width: 100%;" href="./product-view?slug=<?php echo $products['slug'][$i] ?>"><?php echo $products['product_name'][$i]; ?></a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5 class="font-weight-bold mr-2">
                                    ₹<?php echo number_format(floor($products['discounted_price'][$i])); ?>
                                </h5>
                                <small class="text-muted ml-2">
                                    <del>₹<?php echo number_format(floor($products['actual_price'][$i])); ?></del>
                                </small>
                            </div>
                            <span class="font-weight-bold"><small class="text-danger">Save <?php echo $products['discount_percentage'][$i]; ?>% </small> </span>

                            <div class="d-flex align-items-center justify-content-center mb-1">
                                <?php
                                // Display filled stars based on average rating
                                for ($j = 0; $j < floor($averageRatingValue); $j++) {
                                    echo '<small class="fa fa-star text-primary mr-1"></small>';
                                }
                                // Display half star if average rating is not an integer
                                if ($averageRatingValue - floor($averageRatingValue) >= 0.5) {
                                    echo '<small class="fa fa-star-half-alt text-primary mr-1"></small>';
                                }
                                // Display empty stars
                                for ($j = ceil($averageRatingValue); $j < 5; $j++) {
                                    echo '<small class="far fa-star text-primary mr-1"></small>';
                                }
                                ?>
                                <small>(<?php echo $averageRatingValue; ?>)</small>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
    ?>
    </div>
</div>
<?php
require_once('./footer.php');
?>

