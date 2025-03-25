<?php
session_start();

  if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['mobile']) && !empty($_POST['password']) && !empty($_POST['password1']) && !empty($_POST['address']) && !empty($_POST['register'])  ){
    if($_POST['password'] === $_POST['password1']){

      require_once('./logics.class.php');
      $adminObj = new logics();

      $verification = $adminObj->userRegistration($_POST['name'],$_POST['email'],$_POST['mobile'],$_POST['password'],$_POST['address']);
      
      if(!empty($verification['status'])){
        if($verification['status']==1){
            $_SESSION['user_id']= $verification['user_id'];
            $_SESSION['username']= $_POST['name'];
            echo "Success";
            echo '<script src="panels/js/sweetalert.js"></script>';
            echo '<script>';
            echo 'Swal.fire({
                    icon: "success",
                    title: "Registration Successful!",
                    showConfirmButton: true,
                }).then(function() {
                    window.location.href = "account";
                });';
            echo '</script>';
        }elseif($verification['status']==3){
            echo "Failed";
          echo '<script src="panels/js/sweetalert.js"></script>';
          echo '<script>';
          echo 'Swal.fire({
                  icon: "error",
                  title: "Data not Submitted!",
                  text: "Duplicate Email,Please try again"
              }).then(function() {
                  window.location.href = "index";
              });';
          echo '</script>';
        }elseif($verification['status']==4){
            echo "Failed";
          echo '<script src="panels/js/sweetalert.js"></script>';
          echo '<script>';
          echo 'Swal.fire({
                  icon: "error",
                  title: "Data not Submitted!",
                  text: "Duplicate Mobile Number,Please try again"
              }).then(function() {
                  window.location.href = "index";
              });';
          echo '</script>';
        }
      }else{
        echo "Failed";
          echo '<script src="panels/js/sweetalert.js"></script>';
          echo '<script>';
          echo 'Swal.fire({
                  icon: "error",
                  title: "Data not Submitted!",
                  text: "Please try again"
              }).then(function() {
                  window.location.href = "index";
              });';
          echo '</script>';
      }
    }else{
        echo "Failed";
          echo '<script src="panels/js/sweetalert.js"></script>';
          echo '<script>';
          echo 'Swal.fire({
                  icon: "error",
                  title: "Data not Submitted!",
                  text: "Password and Confirm Password not Matched"
              }).then(function() {
                  window.location.href = "index";
              });';
          echo '</script>';
    }
  }

  if( !empty($_POST['mobile']) && !empty($_POST['password']) && !empty($_POST['login'])  ){

      require_once('./logics.class.php');
      $adminObj = new logics();

      $verification = $adminObj->userLogin($_POST['mobile'],$_POST['password']);
      
      if(!empty($verification['status']) && $verification['status']==1){
        $_SESSION['user_id']= $verification['user_id'];
        $_SESSION['username']= $verification['name'];
        echo "Success";
          echo '<script src="panels/js/sweetalert.js"></script>';
          echo '<script>';
          echo 'Swal.fire({
                  icon: "success",
                  title: "Login Successful!",
                  showConfirmButton: true,
              }).then(function() {
                  window.location.href = "account";
              });';
          echo '</script>';
      }else{
        echo "Failed";
          echo '<script src="panels/js/sweetalert.js"></script>';
          echo '<script>';
          echo 'Swal.fire({
                  icon: "error",
                  title: "Data not Submitted!",
                  text: "Failed,Invalid Credentials!"
              }).then(function() {
                  window.location.href = "index";
              });';
          echo '</script>';
      }
  }

// Add to Cart
  if(!empty($_GET['product_id']) && !empty($_GET['type']) && $_GET['type']=="addToCart" ){
    if(!empty($_SESSION['user_id'])){
    
      require_once('./logics.class.php'); 
      $adminObj = new logics();
      if(!empty($_GET['quantity'])){
        $quantity = $_GET['quantity']; 
      }else{
        $quantity = 1;
      }

      $verification = $adminObj->addToCart($_SESSION['user_id'],$_GET['product_id'],$quantity);
      
      if(!empty($verification['status'])){
        if($verification['status']==1){
            
            echo "Success";
            echo '<script src="panels/js/sweetalert.js"></script>';
            echo '<script>';
            echo 'Swal.fire({
                    icon: "success",
                    title: "Added to     Cart!",
                    showCancelButton: true,
                    confirmButtonText: "Cart",
                    cancelButtonText: "Continue",
                }).then(function(result) {
                    if (result.isConfirmed) {
                        // Redirect to cart if "Cart" is clicked
                        window.location.href = "cart";
                    } else {
                        window.history.back();
                    }
                });';
            echo '</script>';


        }elseif($verification['status']==2){
            echo "Success";
            echo '<script src="panels/js/sweetalert.js"></script>';
            echo '<script>';
            echo 'Swal.fire({
                    icon: "success",
                    title: "Product Already in Cart, Quantity Increased!",
                    showCancelButton: true,
                    confirmButtonText: "Cart",
                    cancelButtonText: "Continue",
                }).then(function(result) {
                    if (result.isConfirmed) {
                        // Redirect to cart if "Cart" is clicked
                        window.location.href = "cart";
                    } else {
                        // Redirect to the previous page if "Continue" is clicked
                        window.history.back();
                    }
                });';
            echo '</script>';

        }
      }else{
        echo "Failed";
          echo '<script src="panels/js/sweetalert.js"></script>';
          echo '<script>';
          echo 'Swal.fire({
                  icon: "error",
                  title: "Data not Submitted!",
                  text: "Please try again"
              }).then(function() {
                  window.location.href = "index";
              });';
          echo '</script>';
      }
    }else{
        header('location:account');
    }
  }

// Add to Wishlist
  if(!empty($_GET['product_id']) && !empty($_GET['type']) && $_GET['type']=="addToWishlist" ){
    if(!empty($_SESSION['user_id'])){
    
      require_once('./logics.class.php');
      $adminObj = new logics();

      $verification = $adminObj->addToWishlist($_SESSION['user_id'],$_GET['product_id']);
      
      if(!empty($verification['status'])){
        if($verification['status']==1){
            
            echo "Success";
            echo '<script src="panels/js/sweetalert.js"></script>';
            echo '<script>';
            echo 'Swal.fire({
                    icon: "success",
                    title: "Added to Wishlist!",
                    showCancelButton: true,
                    confirmButtonText: "Wishlist", 
                    cancelButtonText: "Continue",
                }).then(function(result) {
                    if (result.isConfirmed) {
                        // Redirect to cart if "Cart" is clicked
                        window.location.href = "wishlist";
                    } else {
                        window.history.back();
                    }
                });';
            echo '</script>';


        }elseif($verification['status']==2){
            echo "Failed";
            echo '<script src="panels/js/sweetalert.js"></script>';
            echo '<script>';
            echo 'Swal.fire({
                    icon: "error",
                    title: "Product already added to Wishlist!",
                    text: "Please try again"
                }).then(function() {
                    window.history.back();
                });';
            echo '</script>';

        }
      }else{
        echo "Failed";
          echo '<script src="panels/js/sweetalert.js"></script>';
          echo '<script>';
          echo 'Swal.fire({
                  icon: "error",
                  title: "Data not Submitted!",
                  text: "Please try again"
              }).then(function() {
                  window.location.href = "index";
              });';
          echo '</script>';
      }
    }else{
        header('location:account');
    }
  }


// Update Cart Quantity
  if(!empty($_POST['cart_id']) && !empty($_POST['quantity_update'])  ){
    
      require_once('./logics.class.php');
      $adminObj = new logics();

      $verification = $adminObj->UpdateCartQuantity($_POST['cart_id'],$_POST['quantity_update']);
      
      if(!empty($verification['status']) && $verification['status']==1){
            
        echo "Success";

      }else{
        echo "failed";
      }
  }

// Delete From Cart
  if(!empty($_POST['cart_id']) && !empty($_POST['cart_delete'])  ){
    
      require_once('./logics.class.php');
      $adminObj = new logics();

      $verification = $adminObj->DeleteCartItem($_POST['cart_id']);
      
      if(!empty($verification['status']) && $verification['status']==1){
            
        echo "Success";

      }else{
        echo "failed";
      }
  }

// Delete From wishlist
  if(!empty($_POST['wishlist_id']) && !empty($_POST['wishlist_delete'])  ){
    
      require_once('./logics.class.php');
      $adminObj = new logics();

      $verification = $adminObj->DeleteWishlistItem($_POST['wishlist_id']);
      
      if(!empty($verification['status']) && $verification['status']==1){
            
        echo "Success";

      }else{
        echo "failed";
      }
  }


  if(!empty($_POST['coupon']) && !empty($_POST['grandTotal']) ){
    require_once('./logics.class.php');
    $adminObj = new logics();

    $verification = $adminObj->ApplyCoupon($_POST['coupon'], $_POST['grandTotal']);
    
    if(!empty($verification['status']) && $verification['status'] == 1){
     
        // Return JSON response with new total price
        echo json_encode([
            'status' => 1,
            'discount' => $verification['discount'],
            'type' => $verification['type'],
            'new_total' => $verification['new_total']
        ]);
    } else {
        // Return error response
        echo json_encode([
            'status' => 0,
            'error' => $verification['error']
        ]);
    }   
}




  if(!empty($_POST['order_id']) && !empty($_POST['getOrderProducts']) ){
    require_once('./logics.class.php');
    $adminObj = new logics();

    $verification = $adminObj->getOrderProducts($_POST['order_id']);
    
    if(!empty($verification['status']) && $verification['status'] == 1){
     
        // Return JSON response with new total price
        echo json_encode([
            'status' => 1,
            'count' => $verification['count'],
            'order_id' => $verification['order_id'],
            'user_id' => $verification['user_id'],
            'product_id' => $verification['product_id'],
            'product_name' => $verification['product_name'],
            'product_image' => $verification['product_image'],
            'quantity' => $verification['quantity'],
            'product_actual_price' => $verification['product_actual_price'],
            'product_price' => $verification['product_price'],
            'product_type' => $verification['product_type'],
            'product_weight' => $verification['product_weight'],
            'product_slug' => $verification['product_slug'],
            'price_per_gram' => $verification['price_per_gram'],
        ]);
    } else {
        // Return error response
        echo json_encode([
            'status' => 0,
            'error' => $verification['error']
        ]);
    }   
}



// Upload Customization Image
if(!empty($_POST['user_id']) &&  !empty($_FILES['customization_image']) && !empty($_POST['slug']) ){
  if(!empty($_SESSION['user_id'])){

    
    if (!empty($_FILES['customization_image']['name'])) {
      $customization_imageName = $_FILES['customization_image']['name'];
      $customization_imageTempLocal = $_FILES['customization_image']['tmp_name'];
      
      // Append current date and time to the customization_image name to make it unique
      $timestamp = date("YmdHis");
      $extension = pathinfo($customization_imageName, PATHINFO_EXTENSION);
      $customization_imageName = pathinfo($customization_imageName, PATHINFO_FILENAME) . '_' . $timestamp . '.' . $extension;

      $customization_imageStore = "panels/admin/customizations/" . $customization_imageName;

      // Move uploaded customization_image photo to desired directory
      move_uploaded_file($customization_imageTempLocal, $customization_imageStore);

      // Store customization_image photo name
      $customization_imagePhoto = $customization_imageName;
    }
  
    require_once('./logics.class.php'); 
    $adminObj = new logics();
    

    $verification = $adminObj->addCustomizations($_SESSION['user_id'],$customization_imagePhoto,$_POST['slug']);
    
    if(!empty($verification['status'])){
      if($verification['status']==1){
          
        echo "Success";
        echo '<script src="panels/js/sweetalert.js"></script>';
        echo '<script>';
        echo 'Swal.fire({
                icon: "success",
                title: "Request Submitted, we will get back soon with Expected Price!",
                confirmButtonText: "Continue",
            }).then(function(result) {
                if (result.isConfirmed) {
                    // Redirect to the previous page if "Continue" is clicked
                    window.history.back();
                }
            });';
        echo '</script>';

      }elseif($verification['status']==2){
          echo "Success";
          echo '<script src="panels/js/sweetalert.js"></script>';
          echo '<script>';
          echo 'Swal.fire({
                  icon: "success",
                  title: "Product Already in Cart, Quantity Increased!",
                  showCancelButton: true,
                  confirmButtonText: "Cart",
                  cancelButtonText: "Continue",
              }).then(function(result) {
                  if (result.isConfirmed) {
                      // Redirect to cart if "Cart" is clicked
                      window.location.href = "cart";
                  } else {
                      // Redirect to the previous page if "Continue" is clicked
                      window.history.back();
                  }
              });';
          echo '</script>';

      }
    }else{
      echo "Failed";
        echo '<script src="panels/js/sweetalert.js"></script>';
        echo '<script>';
        echo 'Swal.fire({
                icon: "error",
                title: "Data not Submitted!",
                text: "Please try again"
            }).then(function() {
                window.location.href = "index";
            });';
        echo '</script>';
    }
  }else{
      header('location:account');
  }
}



// Review Submission
if(!empty($_POST['product_id']) && !empty($_POST['rating']) &&  !empty($_POST['review']) ){
  if(!empty($_SESSION['user_id'])){
  
    require_once('./logics.class.php'); 
    $adminObj = new logics();
    
    $verification = $adminObj->addReview($_SESSION['user_id'],$_POST['product_id'],$_POST['rating'],$_POST['review']);
    
    if(!empty($verification['status'])){
      if($verification['status']==1){
          
        echo "Success";
        echo '<script src="panels/js/sweetalert.js"></script>';
        echo '<script>';
        echo 'Swal.fire({
                icon: "success",
                title: "Thank you your Review!",
                confirmButtonText: "Continue",
            }).then(function(result) {
                if (result.isConfirmed) {
                    // Redirect to the previous page if "Continue" is clicked
                    window.history.back();
                }
            });';
        echo '</script>';

      }elseif($verification['status']==2){
          echo "Success";
          echo '<script src="panels/js/sweetalert.js"></script>';
          echo '<script>';
          echo 'Swal.fire({
                  icon: "success",
                  title: "Product Already in Cart, Quantity Increased!",
                  showCancelButton: true,
                  confirmButtonText: "Cart",
                  cancelButtonText: "Continue",
              }).then(function(result) {
                  if (result.isConfirmed) {
                      // Redirect to cart if "Cart" is clicked
                      window.location.href = "cart";
                  } else {
                      // Redirect to the previous page if "Continue" is clicked
                      window.history.back();
                  }
              });';
          echo '</script>';

      }
    }else{
      echo "Failed";
        echo '<script src="panels/js/sweetalert.js"></script>';
        echo '<script>';
        echo 'Swal.fire({
                icon: "error",
                title: "Data not Submitted!",
                text: "Please try again"
            }).then(function() {
                window.location.href = "index";
            });';
        echo '</script>';
    }
  }else{
      header('location:account');
  }
}






  

?>