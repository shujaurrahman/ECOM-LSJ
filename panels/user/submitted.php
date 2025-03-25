<?php
session_start();
if (!empty($_SESSION['username'])) {
    $title = "submitted";
    require_once('header.php');
    require_once('./logics.class.php');

    $getTasks = new logics();
    $verification = $getTasks->SubmittedTasks($_SESSION['id']);

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
                                    <h5 class="card-title text-primary">View All your Submitted Tasks</h5>
                                    <br>
                                    <table id="example" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <td>ID</td>
                                                <td>Task</td>
                                                <td>Task URL</td>
                                                <td>Doubts</td>
                                                <td>Submitted At</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if($verification['count']>0){
                                        for ($i = 1; $i < $verification['count']; $i++) {
                                            ?>
                                            <tr>
                                                <td><?php echo $i ; ?></td>
                                                <td><?php echo $verification['task'][$i]; ?></td>
                                                <td><?php echo $verification['url'][$i]; ?></td>
                                                <td><?php echo $verification['doubts'][$i]; ?></td>
                                                <td><?php echo $verification['created_at'][$i]; ?></td>
                                            </tr>
                                            <?php
                                        }
                                    }else{
                                        ?>
                                        <tr>
                                            <td>No Tasks Submitted Yet</td>
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