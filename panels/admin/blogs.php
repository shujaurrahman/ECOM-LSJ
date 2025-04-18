<?php
session_start();
if (!empty($_SESSION['role'])) {
    $title = "blogs";
    require_once('header.php');
    require_once('./logics.class.php');

    $getUsers = new logics();
    $verification = $getUsers->getBlogs();

    if (!empty($verification['status']) && $verification['status'] == 1) {
        ?>
        <head>
            <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
        </head>

        <!--  Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-lg-12 mb-4 order-0">
                    <div class="card">
                        <div class="d-flex align-items-end row">
                            <div class="col-sm-12">
                                <div class="card-body" style="overflow-x: scroll;">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="card-title text-primary">View All Blogs</h5>
                                        <a href="./addblogs.php" class="btn btn-sm btn-primary">Add Blogs</a>
                                    </div>
                                    <br>
                                    <table id="example" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <td>ID</td>
                                                <td>Image</td>
                                                <td>Username</td>
                                                <td>Blog Heading</td>
                                                <td>Description</td>
                                                <td>Category</td>
                                                <td>Meta Keywords</td>
                                                <td>Meta Desc</td>
                                                <td>Created At</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        for ($i = 0; $i < $verification['count']; $i++) {
                                            ?>
                                            <tr>
                                                <td><?php echo $i + 1; ?></td>
                                                <td><img src="./Blogimages/<?php echo $verification['featured_image'][$i]; ?>" width="100px" height="100px" alt=""></td>
                                                
                                                <td><?php echo $verification['username'][$i]; ?></td>
                                                <td><a href="<?php echo $verification['slug_url'][$i]; ?>" target="_blank"><?php echo $verification['blog_heading'][$i]; ?></a></td>
                                                <td><?php echo $verification['description'][$i]; ?></td>
                                                <td><?php echo $verification['category'][$i]; ?></td>
                                                <td><?php echo $verification['meta_keywords'][$i]; ?></td>
                                                <td><?php echo $verification['meta_description'][$i]; ?></td>
                                                
                                                <td><?php echo $verification['created_at'][$i]; ?></td>
                                                
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Content -->

        <?php
    } else {
        echo "Data not fetched";
    }

    require_once('footer.php');
} else {
    header('location:login.php');
}
?>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
<script>
    new DataTable('#example');
</script>