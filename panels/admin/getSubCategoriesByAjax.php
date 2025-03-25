<?php
require_once('./logics.class.php');
$Obj = new logics();

if (isset($_POST['category_id_ajax'])) {
    $category_id_ajax = $_POST['category_id_ajax'];
  
    // Call the method to get subcategories filtered by category_id
    $subcategories = $Obj->getSubCategoriesAjax($category_id_ajax);

    // Return the subcategories as a JSON response
    echo json_encode($subcategories);
    exit; // Prevent further output
}

// The rest of your PHP page logic...
?>
