<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!empty($_SESSION['role'])) {
    $title = "Subscribers";
    require_once('header.php');
    require_once('./logics.class.php');

    $getContacts = new logics();  
    $verification = $getContacts->getSubscribers();

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
                            <h5 class="card-title text-primary">View All Subscribers</h5>
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
                                                <td>Email</td>
                                                <td>Submitted At</td>
                                                <td>Action</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        for ($i = 0; $i < $verification['count']; $i++) {
                                            ?>
                                            <tr>
                                                <td><?php echo $i + 1; ?></td>
                                                <td><?php echo $verification['email'][$i]; ?></td>
                                                <td><?php echo $verification['subscribed_at'][$i]; ?></td>
                                                <td>
                                                    <a href="manage-status?delete_record_id=<?php echo $verification['id'][$i]; ?>&delete_table_name=subscriptions&url=getSubscribers" onclick="return confirm('Are you sure to Delete?')"><i class="menu-icon tf-icons bx bx-trash text-danger mx-2"></i></a>
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