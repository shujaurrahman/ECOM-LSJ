<?php
session_start();
if (!empty($_SESSION['username'])) {
    $title = "view-task";
    require_once('header.php');
    require_once('./logics.class.php');

    $getTasks = new logics();
    $verification = $getTasks->getTodayTask($_SESSION['domain']);

    if (!empty($verification['status']) && $verification['status'] == 1) {
        ?>
        <!--  Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-lg-12 mb-4 order-0">
                    <div class="card">
                        <div class="card-header">
                            <h5><u>Today's Task (<?php echo $verification['task_date'] ?>)</u></h5>
                        </div>
                        <div class="card-body">
                            <h3><?php  echo $verification['task_name'] ?></h3>
                            <br>
                            <?php  echo $verification['task_description'] ?>
                            <br><br>
                            <h5><u>Tasks:</u></h5>
                            <?php  echo $verification['tasks'] ?>
                            <br><br>
                            <a href="./submission.php" class="btn btn-sm btn-primary">Click to Submit Task</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Content -->

        <?php
    } else {
        echo "No Task Todaty!";
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