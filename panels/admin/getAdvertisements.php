<?php
session_start();
if (!empty($_SESSION['role'])) {
    $title = "added-advertisements";
    require_once('header.php');
    require_once('./logics.class.php');

    $getUsers = new logics();
    $verification = $getUsers->getAdvertisements();

    if (!empty($verification['status']) && $verification['status'] == 1) {
        ?>

        <!--  Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-lg-12 mb-4 order-0">
                    <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-12">
                        <div class="card-body d-flex justify-content-between">
                            <h5 class="card-title text-primary">View All Advertisements</h5>
                            <a href="./addbannerads" class="btn btn-sm btn-primary">Add Banner Advertisement</a>
                            
                        </div>
                        </div>
                    
                    </div>
                    </div>
                </div>
                </div>



            <div class="row">
                <div class="col-lg-12 mb-4 order-0">
                    <div class="card">
                        <div class="d-flex align-items-end row">
                            <div class="col-sm-12">
                                <div class="card-body" style="overflow-x: scroll;">
                                    
                                    <br>
                                    <table id="example" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <td>ID</td>
                                                <td>Advertisement Name</td>
                                                <td>Featured Image</td>
                                                <td>Advertisement Theme</td>
                                                <td>Advertisement URL</td>
                                                <td>Advertisement Location</td>
                                                <td>Created At</td>
                                                <td>Status</td>
                                                <td>Action</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        for ($i = 0; $i < $verification['count']; $i++) {
                                            ?>
                                            <tr>
                                                
                                                <td><?php echo $i + 1; ?></td>
                                                <td><?php echo $verification['name'][$i]; ?></td>
                                                <td><img src="./advertisements/<?php echo $verification['image'][$i]; ?>" width="100px" alt=""></td>
                                                
                                                <td><?php echo $verification['description'][$i]; ?></td>
                                                <td><?php echo $verification['url'][$i]; ?></td>
                                                <td><?php echo $verification['location'][$i]; ?></td>
                                                <td><?php echo $verification['created_at'][$i]; ?></td>
                                                <td>
                                                    <a href="manage-status?update_record_id=<?php echo $verification['id'][$i]; ?>&update_table_name=advertisements&statusval=<?php if($verification['statusval'][$i]==1){ echo "2"; }else{ echo "1"; } ?>&url=getAdvertisements" onclick="return confirm('Are you sure to Update?')" class="btn btn-sm btn-outline-<?php if($verification['statusval'][$i]==1){ echo "success"; }else{ echo "danger"; } ?> rounded-pill"> <?php if($verification['statusval'][$i]==1){ echo "Active"; }else{ echo "InActive"; } ?></a>
                                                </td>
                                                <td>
                                                <a href="editAdvertisement?id=<?php echo $verification['id'][$i]; ?>"><i class="menu-icon tf-icons mx-2 bx bx-edit"></i></a>
                                                <a href="manage-status?delete_record_id=<?php echo $verification['id'][$i]; ?>&delete_table_name=advertisements&url=getAdvertisements" onclick="return confirm('Are you sure to Delete?')"><i class="menu-icon tf-icons bx bx-trash text-danger mx-2"></i></a>
                                                </td>
                                                
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
<script>
    new DataTable('#example');
</script>