<?php
session_start();
if (!empty($_SESSION['role'])) {
    require_once('./logics.class.php');
    $adminObj = new logics();

    // Handle view_on update for ratings
      $verification = $adminObj->DeleteCategory($_GET['delete_category']);
      
      if(!empty($verification['status']) && $verification['status']==1){
        echo "Success";
          echo '<script src="../js/sweetalert.js"></script>';
          echo '<script>';
          echo 'Swal.fire({
                  icon: "success",
                  title: "Category Successfully Deleted!",
                  showConfirmButton: true,
              }).then(function() {
                  window.location.href = "getCategories";
              });';
          echo '</script>';
      }else{
        echo "Failed";
          echo '<script src="../js/sweetalert.js"></script>';
          echo '<script>';
          echo 'Swal.fire({
                  icon: "error",
                  title: "Data not Submitted!",
                  text: "Please try again"
              }).then(function() {
                  window.location.href = "getCategories1";
              });';
          echo '</script>';
      }
  }

  if(!empty($_GET['delete_subcategory'])  ){
      require_once('./logics.class.php');
      $adminObj = new logics();

      $verification = $adminObj->DeleteSubCategory($_GET['delete_subcategory']);
      
      if(!empty($verification['status']) && $verification['status']==1){
        echo "Success";
          echo '<script src="../js/sweetalert.js"></script>';
          echo '<script>';
          echo 'Swal.fire({
                  icon: "success",
                  title: "Sub Category Successfully Deleted!",
                  showConfirmButton: true,
              }).then(function() {
                  window.location.href = "getSubCategories";
              });';
          echo '</script>';
      }else{
        echo "Failed";
          echo '<script src="../js/sweetalert.js"></script>';
          echo '<script>';
          echo 'Swal.fire({
                  icon: "error",
                  title: "Data not Submitted!",
                  text: "Please try again"
              }).then(function() {
                  window.location.href = "getSubCategories";
              });';
          echo '</script>';
      }
  }

//   Delete record
if(!empty($_GET['delete_record_id']) && !empty($_GET['delete_table_name']) && !empty($_GET['url'])) {
    require_once('./logics.class.php');
    $adminObj = new logics();
    
    $verification = $adminObj->deleteRecord($_GET['delete_table_name'], $_GET['delete_record_id']);
    
    if(!empty($verification['status']) && $verification['status']==1) {
        $message = '';
        switch($_GET['delete_table_name']) {
            case 'ratings':
                $message = 'Review deleted successfully!';
                break;
            case 'categories':
                $message = 'Category deleted successfully!';
                break;
            default:
                $message = 'Record deleted successfully!';
        }
        
        echo '<script src="../js/sweetalert.js"></script>';
        echo '<script>';
        echo 'Swal.fire({
                icon: "success",
                title: "' . $message . '",
                showConfirmButton: true,
            }).then(function() {
                window.location.href = "' . $_GET['url'] . '";
            });';
        echo '</script>';
    } else {
        echo '<script src="../js/sweetalert.js"></script>';
        echo '<script>';
        echo 'Swal.fire({
                icon: "error",
                title: "Delete failed!",
                text: "Please try again"
            }).then(function() {
                window.location.href = "' . $_GET['url'] . '";
            });';
        echo '</script>';
    }
}

//   Update Status
if(!empty($_GET['update_record_id']) && !empty($_GET['update_table_name']) && !empty($_GET['statusval']) && !empty($_GET['url'])) {
    require_once('./logics.class.php');
    $adminObj = new logics();
    
    $verification = $adminObj->UpdateStatus($_GET['update_table_name'], $_GET['update_record_id'], $_GET['statusval']);
    
    if(!empty($verification['status']) && $verification['status']==1) {
        $message = '';
        switch($_GET['update_table_name']) {
            case 'ratings':
                $statusText = $_GET['statusval'] == 1 ? 'activated' : 'deactivated';
                $message = "Review successfully {$statusText}!";
                break;
            case 'categories':
                $statusText = $_GET['statusval'] == 1 ? 'activated' : 'deactivated';
                $message = "Category successfully {$statusText}!";
                break;
            default:
                $statusText = $_GET['statusval'] == 1 ? 'activated' : 'deactivated';
                $message = "Record successfully {$statusText}!";
        }
        
        echo '<script src="../js/sweetalert.js"></script>';
        echo '<script>';
        echo 'Swal.fire({
                icon: "success",
                title: "' . $message . '",
                showConfirmButton: true,
            }).then(function() {
                window.location.href = "' . $_GET['url'] . '.php";
            });';
        echo '</script>';
    } else {
        echo '<script src="../js/sweetalert.js"></script>';
        echo '<script>';
        echo 'Swal.fire({
                icon: "error",
                title: "Status update failed!",
                text: "Please try again"
            }).then(function() {
                window.location.href = "' . $_GET['url'] . '.php";
            });';
        echo '</script>';
    }
}


if (!empty($_SESSION['role'])) {
    require_once('./logics.class.php');
    $adminObj = new logics();

    // Handle view_on update for ratings
    if (!empty($_GET['update_record_id']) && !empty($_GET['update_table_name']) && isset($_GET['view_on'])) {
        $verification = $adminObj->UpdateStatus($_GET['update_table_name'], $_GET['update_record_id'], $_GET['view_on'], 'view_on');
        
        if (!empty($verification['status']) && $verification['status'] == 1) {
            echo '<script src="../js/sweetalert.js"></script>';
            echo '<script>';
            echo 'Swal.fire({
                    icon: "success",
                    title: "Review status updated successfully!",
                    showConfirmButton: true,
                }).then(function() {
                    window.location.href = "' . $_GET['url'] . '.php";
                });';
            echo '</script>';
        } else {
            echo '<script src="../js/sweetalert.js"></script>';
            echo '<script>';
            echo 'Swal.fire({
                    icon: "error",
                    title: "Failed to update review status!",
                    text: "Please try again"
                }).then(function() {
                    window.location.href = "' . $_GET['url'] . '.php";
                });';
            echo '</script>';
        }
    }

// Update Lakshmi Kubera Status
if (!empty($_GET['update_lakshmi_kubera_id']) && isset($_GET['status']) && !empty($_GET['url'])) {
    require_once('./logics.class.php');
    $adminObj = new logics();

    $status = $_GET['status'] == 1 ? 1 : 0; // Ensure status is either 0 or 1

    $verification = $adminObj->UpdateLakshmiKuberaStatus($_GET['update_lakshmi_kubera_id'], $status);

    if (!empty($verification['status']) && $verification['status'] == 1) {
        echo '<script src="../js/sweetalert.js"></script>';
        echo '<script>';
        echo 'Swal.fire({
                icon: "success",
                title: "Added to Best selling product!",
                showConfirmButton: true,
            }).then(function() {
                window.location.href = "' . $_GET['url'] . '";
            });';
        echo '</script>';
    } else {
        echo '<script src="../js/sweetalert.js"></script>';
        echo '<script>';
        echo 'Swal.fire({
                icon: "error",
                title: "Failed to add to best selling product!",
                text: "Please try again"
            }).then(function() {
                window.location.href = "' . $_GET['url'] . '";
            });';
        echo '</script>';
    }
}
  
}



?>