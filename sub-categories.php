<?php
session_start();
require_once('header.php');

$slug = $_GET['name'];
$slug = str_replace('-', ' ', $slug);
$slug = ucwords($slug);
?>

<!-- Breadcrumb Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30">
                <a class="breadcrumb-item text-dark" href="index">Home</a>
                <a class="breadcrumb-item text-dark" href="#">Sub-Category</a>
                <span class="breadcrumb-item active"><?php echo $slug ?></span>
            </nav>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Shop Start -->
<div class="container-fluid">
    <!-- Grid View Section (Default) -->
    <div id="grid-view" class="row">
        <?php
        for($i = 0; $i < $subcategories['count']; $i++) {
                if($subcategories['statusval'][$i] == 1 && $subcategories['category_id'][$i] == $_GET['id']){

                    $slug = $subcategories['name'][$i];
                    $slug = strtolower($slug);
                    $slug = str_replace(' ', '-', $slug);
                    $slug = preg_replace('/[^a-z0-9-]/', '', $slug);
                    $slug = trim($slug, '-');

                ?>
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1" >
                    <div class="product-item bg-light mb-4">
                        <a href="./product-listing?id=<?php echo $subcategories['id'][$i]; ?>&name=<?php echo $slug; ?>">
                            <div class="product-img position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="./panels/admin/subcategory/<?php echo $subcategories['image'][$i]; ?>" alt="" style="width: 100%; height: 300px;">
                            </div>
                            <div class="text-center py-4">
                                <a class="h3 text-decoration-none text-truncate" href=""><?php echo $subcategories['name'][$i]; ?></a>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <b><?php echo $subcategories['product_count'][$i]; ?> </b>&nbsp; Products
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <?php
                }
        }       
        ?>
    </div>
</div> 
<!-- Shop End -->

<script>
    // Toggle Grid View and List View
    document.getElementById('grid-view-btn').addEventListener('click', function() {
        document.getElementById('grid-view').style.display = 'block';
        document.getElementById('list-view').style.display = 'none';
    });

    document.getElementById('list-view-btn').addEventListener('click', function() {
        document.getElementById('grid-view').style.display = 'none';
        document.getElementById('list-view').style.display = 'block';
    });
</script>

<?php
require_once('footer.php');
?>
