<?php
session_start();
if (!empty($_SESSION['role'])) {
    $title = "pastregistrations";
    require_once('header.php');
    require_once('./logics.class.php');

    $getUsers = new logics();
    $verification = $getUsers->getInactiveRegistrations();

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
                                    <h5 class="card-title text-primary">View All the InActive Past Registrations</h5>
                                    <br>
                                    <table id="example" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <td>Action</td>
                                                <td>ID</td>
                                                <td>Name</td>
                                                <td>Mobile</td>
                                                <td>email</td>
                                                <td>College</td>
                                                <td>Location</td>
                                                <td>Dept</td>
                                                <td>YOP</td>
                                                <td>Created At</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        for ($i = 0; $i < $verification['count']; $i++) {
                                            ?>
                                            <tr>
                                                
                                                <td><?php echo $i + 1; ?></td>
                                                <td><a href="reg_status.php?id=<?php echo $verification['sno'][$i]; ?>&status=active" class="btn btn-sm btn-outline-danger">In-Active</a></td>
                                                <td><?php echo $verification['name'][$i]; ?></td>
                                                <td><?php echo $verification['mobile'][$i]; ?></td>
                                                <td><?php echo $verification['email'][$i]; ?></td>
                                                <td><?php echo $verification['college_name'][$i]; ?></td>
                                                <td><?php echo $verification['college_location'][$i]; ?></td>
                                                <td><?php echo $verification['dept'][$i]; ?></td>
                                                <td><?php echo $verification['yop'][$i]; ?></td>
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