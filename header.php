
<?php
require_once('./logics.class.php');
$Obj = new logics;
 
$todayPriceList = $Obj->getOrnaments();
$categories = $Obj->getCategories();
$subcategories = $Obj->getSubCategories();
$products = $Obj->getProducts();
$advertisements = $Obj->getAdvertisements();
 
if(!empty($_SESSION['user_id'])){
    $cart = $Obj->getCartById($_SESSION['user_id']);
    $wishlist = $Obj->getWishlistById($_SESSION['user_id']);
    $getOrders = $Obj->getOrders();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>lsj Jewelley</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="lsj Jewelley" name="keywords">
    <meta content="lsj Jewelley" name="description">

    <!-- Favicon -->
    <link rel="shortcut icon" href="./images/logo_lsj.png" type="image/x-icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">  

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

    <!-- Add these styles to your existing CSS in header.php -->
    <style>
/* Modal Styles */
.modal.right .modal-dialog {
    position: fixed;
    margin: auto;
    width: 100%;
    height: 100%;
    transform: translateX(100%);
}

.modal.right .modal-content {
    height: 100%;
    overflow-y: auto;
    background-color: #f8f9fa;
}

.modal.right.fade .modal-dialog {
    right: 0;
    transition: transform .3s cubic-bezier(0.4, 0, 0.2, 1);
}

.modal.right.fade.show .modal-dialog {
    transform: translateX(0);
}

/* Search Input Styles */
.search-input-wrapper {
    position: relative;
    margin: 10px 0;
}

.search-input-wrapper input {
    padding: 20px 60px 20px 25px;
    font-size: 16px;
    background-color: white;
    transition: all 0.3s ease;
}

.search-input-wrapper input:focus {
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    border: none;
    outline: none;
}

/* Button Styles */
.search-btn {
    position: absolute;
    right: 5px;
    top: 50%;
    transform: translateY(-50%);
    width: 45px;
    height: 45px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.close-btn {
    background: none;
    border: none;
    font-size: 24px;
    color: #666;
    padding: 10px;
    transition: all 0.3s ease;
    border-radius: 50%;
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.close-btn:hover {
    background-color: rgba(0,0,0,0.05);
    color: #333;
}

/* Product Card Styles */
.product-card {
    background: white;
    border-radius: 10px;
    overflow: hidden;
    transition: all 0.3s ease;
    margin-bottom: 20px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.product-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.product-card .card-body {
    padding: 15px;
}

/* Search Results Styles */
.search-results-box {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    border: 1px solid #ddd;
    border-radius: 4px;
    margin-top: 5px;
    max-height: 300px;
    overflow-y: auto;
    z-index: 1000;
    display: none;
}

.search-item {
    padding: 10px 15px;
    border-bottom: 1px solid #eee;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 10px;
}

.search-item:hover {
    background-color: #f8f9fa;
    text-decoration: none;
}

.search-item img {
    width: 40px;
    height: 40px;
    object-fit: cover;
    border-radius: 4px;
}

.search-item-details {
    flex-grow: 1;
}

.search-item-name {
    margin: 0;
    color: #333;
    font-size: 14px;
}

.search-item-price {
    margin: 0;
    color: #666;
    font-size: 12px;
}

/* Search Modal Specific Styles */
.search-result-card {
    border: 1px solid #eee;
    border-radius: 8px;
    transition: all 0.3s ease;
    animation: fadeIn 0.3s ease forwards;
}

.search-result-card:hover {
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}

.modal-search-input-wrapper {
    position: relative;
}

.search-loading {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
}

#searchModal .custom-position-search {
    position: absolute;
    right: 5px;
    top: 50%;
    transform: translateY(-50%);
}

#searchModal .modal-header {
    align-items: center;
}

#searchModal .close {
    font-size: 2rem;
    padding: 0;
    margin: 0;
}

/* Animation */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Responsive Styles */
@media (max-width: 768px) {
    .modal.right .modal-dialog {
        width: 100%;
        margin: 0;
    }

    .search-input-wrapper input {
        padding: 15px 50px 15px 20px;
        font-size: 14px;
    }

    .search-btn {
        width: 35px;
        height: 35px;
    }

    .product-card img {
        height: 150px;
    }
}
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row bg-secondary py-1 px-xl-5">
            <div class="col-lg-6 d-none d-lg-block">
                <div class="d-inline-flex align-items-center h-100">
                    <a class="text-body mr-3" href="privacy-policy">Privacy Policy</a>
                    <a class="text-body mr-3" href="terms-conditions">Terms & Conditions</a>
                    <a class="text-body mr-3" href="contact">Help</a>
                    <a class="text-body mr-3" href="faqs">FAQs</a>
                </div>
            </div>
            <div class="col-lg-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">

                <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">Today's Updated Price</button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <?php
                            for($pricelist=0;$pricelist<$todayPriceList['count'];$pricelist++){
                                ?>
                                <button class="dropdown-item text-dark" type="button" disabled><?php echo $todayPriceList['name'][$pricelist]; ?> - 1G - Rs.<?php echo $todayPriceList['price'][$pricelist]; ?></button>
                                <?php
                            }
                            ?>
                        </div>
                    </div>

                    <!-- <div class="btn-group mx-2">
                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">USD</button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <button class="dropdown-item" type="button">EUR</button>
                            <button class="dropdown-item" type="button">GBP</button>
                            <button class="dropdown-item" type="button">CAD</button>
                        </div>
                    </div> -->
                    <!-- <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">EN</button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <button class="dropdown-item" type="button">FR</button>
                            <button class="dropdown-item" type="button">AR</button>
                            <button class="dropdown-item" type="button">RU</button>
                        </div>
                    </div> -->
                </div>
                <div class="d-inline-flex align-items-center d-block d-lg-none">
                    <a href="wishlist" class="btn px-0 ml-2">
                        <i class="fas fa-heart text-dark"></i>
                        <span class="badge text-dark border border-dark rounded-circle" style="padding-bottom: 2px;"><?php echo !empty($wishlist['count']) ? $wishlist['count'] : '0'; ?></span>
                    </a>
                    <a href="cart" class="btn px-0 ml-2">
                        <i class="fas fa-shopping-cart text-dark"></i>
                        <span class="badge text-dark border border-dark rounded-circle" style="padding-bottom: 2px;"><?php echo !empty($cart['count']) ? $cart['count'] : '0'; ?></span>
                    </a>
                    <a href="account" class="btn px-0 ml-2">
                        <i class="fas fa-user text-dark"></i>
                        <!-- <span class="badge text-dark border border-dark rounded-circle" style="padding-bottom: 2px;">0</span> -->
                    </a>
                </div>
            </div>
        </div>
        <div class="row align-items-center bg-light py-3 px-xl-5 d-none d-lg-flex" >
            <div class="col-lg-4">
                <a href="./index" class="text-decoration-none">
                    <img src="./images/logo-no-bg.png" style="width: 170px;" alt="logo">
                </a>
            </div>
            <div class="col-lg-4 col-6 text-left d-none">
                <form action="">
                    <div class="input-group custom-input-group">
                        <input type="text" class="form-control rounded-pill custom-search-input p-4" placeholder="Search for products1">
                        <div class="custom-input-append">
                            <span class="custom-input-icon">
                                <i class="fa fa-search custom-search-icon"></i>
                            </span>
                        </div>
                    </div>
                    
                </form>
            </div>
            <div class="col-lg-4 col-6 text-left">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <form action="" method="get" class="position-relative">
                                <input 
                                    type="search" 
                                    name="search" 
                                    placeholder="Please Search for 'Gold Jewellery'" 
                                    id="search-bar" 
                                    autocomplete="off"
                                    class="form-control w-100 rounded-pill p-3 border-primary">
                                <button 
                                    type="submit" 
                                    class="btn btn-primary btn-sm rounded-pill custom-position-search">
                                    <i class="fa fa-search"></i>&nbsp;Search
                                </button>
                                <div id="search-results" class="search-results-box"></div>
                            </form>
                        </div>
                        <?php echo !empty($_GET['search']) ? '<a href="index" class="text-center"><u><i class="fa fa-refresh"></i> Reset Search</u></a>' : '' ?>
                        
                    </div>
                </div>
            </div>
            


            <div class="col-lg-4 col-6 text-right">
                <p class="m-0"><i class="fab fa-whatsapp mx-2 text-success"></i> Contact Us</p>
                <h5 class="m-0">+91 9175128432 </h5>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <div class="container-fluid theme-bg mb-30">
        <div class="row px-xl-5 " >
            <div class="col-lg-3 d-none d-lg-block " >
                <a class="btn d-flex align-items-center justify-content-between bg-primary w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 100%; padding: 0 30px;">
                    <h6 class="text-light m-0"><i class="fa fa-bars mr-2"></i>Categories</h6>
                    <i class="fa fa-angle-down text-light"></i>
                </a>
                <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 bg-light" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 999;">


                    <div class="navbar-nav w-100">
                        <?php
                        for ($cat = 0; $cat < $categories['count']; $cat++) {
                            if($categories['statusval'][$cat]==1){
                            $category_id = $categories['id'][$cat];
                            $category_name = $categories['name'][$cat];
                            $hasSubcategories = false;

                            // Check if the category has subcategories
                            foreach ($subcategories['category_id'] as $subcategory_index => $subcategory_category_id) {
                                if ($subcategory_category_id == $category_id) {
                                    $hasSubcategories = true;
                                    break;
                                }
                            }

                            if ($hasSubcategories) {
                                // If the category has subcategories, display it as a dropdown
                                ?>
                                <div class="nav-item dropdown dropright">
                                    <a href="sub-categories?id=<?php echo $category_id ?>&name=<?php echo $category_name ?>" class="nav-link dropdown-toggle" data-toggle="dropdown">
                                    <img src="./panels/admin/category/<?php echo $categories['image'][$cat]; ?>" style="width: 35px;height:35px;border-radius:50%;margin-right:10px" alt="sdf"><?php echo htmlspecialchars($category_name); ?> <i class="fa fa-angle-right float-right mt-1"></i>
                                </a>
                                    <div class="dropdown-menu position-absolute rounded-0 border-0 m-0">
                                        <?php
                                        // Loop through subcategories to display those under the current category
                                        foreach ($subcategories['category_id'] as $subcategory_index => $subcategory_category_id) {
                                            if ($subcategory_category_id == $category_id) {
                                                $subcategory_name = $subcategories['name'][$subcategory_index];
                                                echo '<a href="product-listing?id='.$subcategories['id'][$subcategory_index].'&name='.$subcategories['name'][$subcategory_index].'" class="dropdown-item">' . htmlspecialchars($subcategory_name) . '</a>';
                                            }
                                        }
                                        ?>
                                    </div>
                     
                                </div>
                                <?php
                            } else {
                                // If no subcategories, display as a regular nav item
                                echo '<a href="sub-categories?id=' . $category_id . '&name=' . $category_name . '" class="nav-item nav-link">
                                    <img src="./panels/admin/category/' . $categories['image'][$cat] . '" style="width: 35px; height: 35px; border-radius: 50%; margin-right: 10px;" alt="">
                                    ' . htmlspecialchars($category_name) . '
                                </a>';

                            }
                        }
                        }
                        ?>
                    </div>


                </nav>

            </div>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg theme-bg navbar-dark py-3 py-lg-0 px-0">
                    <a href="index" class="text-decoration-none d-block d-lg-none">
                        <img src="./images/lsj-logo.jpg" style="width: 60px;" alt="logo">
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav  py-0">
                            <a href="index" class="nav-item nav-link  ">Home</a>
                            <a href="popular-products.php" class="nav-item nav-link">Popular Collections</a>
                            <a href="recent-products" class=" nav-item nav-link">New Arrivals</a>
                            <a href="lakshmi-kubera" class="nav-item nav-link">Lakshmi Kubera Schema
                                <sup><img src="./images/newGif1.gif" width="40px" alt=""></sup>
                            </a>
                            <!-- <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Pages <i class="fa fa-angle-down mt-1"></i></a>
                                <div class="dropdown-menu bg-primary rounded-0 border-0 m-0">
                                    <a href="cart.html" class="dropdown-item">Shopping Cart</a>
                                    <a href="checkout.html" class="dropdown-item">Checkout</a>
                                </div>
                            </div> -->
                            <!-- <a href="contact.html" class="nav-item nav-link">Read To Ship</a> -->
                            <!-- <a href="product-listing?id=9&name=rtvcxsfdr" class=" nav-item nav-link">Ready to Ship
                                <sup><img src="./images/newGif1.gif" width="40px" alt=""></sup>
                            </a> -->
                            <a href="contact" class=" nav-item nav-link">Contact Us</a>
                            <!-- <a href="contact.html" class="nav-item nav-link">Contact</a> -->
                        </div>
                        <div class="navbar-nav ml-auto py-0 d-none d-lg-block">
                            <a href="wishlist" class="btn px-0">
                                <i class="fas fa-heart text-primary"></i>
                                <sup class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;"><?php echo !empty($wishlist['count']) ? $wishlist['count'] : '0'; ?></sup>
                            </a>
                            <a href="cart" class="btn px-0 ml-3">
                                <i class="fas fa-shopping-cart text-primary"></i>
                                <span class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;"><?php echo !empty($cart['count']) ? $cart['count'] : '0'; ?></span>
                            </a>
                            <a href="account" class="btn px-0 ml-3">
                                <i class="fas fa-user text-primary"></i>
                                <!-- <span class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;">0</span> -->
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- Navbar End -->



<!-- Login Popup -->   
<div class="modal fade" id="SigninModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Login</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="./open-logics.php" method="POST">
            <input type="hidden" name="login" value="login" id="">
            <label for="mobile">Mobile Number <sup class="text-danger">*</sup></label>
            <input type="tel" id="mobile" name="mobile" pattern="[6-9][0-9]{9}" placeholder="Enter 10-digit mobile number" required class="form-control">
            <label for="password">Password <sup class="text-danger">*</sup></label>
            <input type="password" id="password" name="password"  placeholder="Enter password" required class="form-control">
            <div class="d-flex justify-content-between">
                <a href="" data-toggle="modal" data-target="#SignupModal" data-dismiss="modal">New User?</a>
                <a href="forgot-password" >Forgot Password?</a>
            </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Login</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- SignUp Popup -->   
<div class="modal fade" id="SignupModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Registration</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="./open-logics.php" method="POST">
            <input type="hidden" name="register" value="register" id="">
            <label for="name">Full Name <sup class="text-danger">*</sup></label>
            <input type="text" id="name" name="name"  placeholder="Enter Your Name" required class="form-control">
            <label for="email">Email Address <sup class="text-danger">*</sup></label>
            <input type="email" id="email" name="email"  placeholder="Enter Your Email" required class="form-control">
            <label for="mobile">Mobile Number <sup class="text-danger">*</sup></label>
            <input type="tel" id="mobile" name="mobile" pattern="[6-9][0-9]{9}" placeholder="Enter 10-digit mobile number" required class="form-control">
            <label for="password">Password <sup class="text-danger">*</sup></label>
            <input type="password" id="password" name="password"  placeholder="Enter password" required class="form-control">
            <label for="password1">Confirm Password <sup class="text-danger">*</sup></label>
            <input type="password" id="password1" name="password1"  placeholder="Re-Enter password" required class="form-control">
            <label for="address">Address <sup class="text-danger">*</sup></label>
            <input type="text" id="address" name="address"  placeholder="Enter address" required class="form-control">

            <div class="d-flex justify-content-between">
                <a href="" data-toggle="modal" data-target="#SigninModal" data-dismiss="modal">Already Registered?</a>
                <a href="forgot-password">Forgot Password?</a>
            </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Register</button>
      </div>
      </form>
    </div>
  </div>
</div>


<!-- Payment Details Popup -->   
<!-- <div class="modal fade" id="PaymentDetailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Payment Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-lg-6 text-center">
                <img src="./images/scanner.webp" class="w-50" alt="">
                <p>Scan QR to pay</p>
            </div>
            <div class="col-lg-6">
                <p><img src="./images/upi.webp" style="width: 50px;" alt=""><span style="font-size: 20px;" class="font-weight-bold mx-2">UPI ID : </span>9985951017@ybl</p>
                <p><img src="./images/phonepe.png" style="width: 30px;border-radius:50%" alt=""><span style="font-size: 20px;" class="font-weight-bold mx-2">PhonePe : </span>9985951017</p>
                <p><img src="./images/paytm.png" style="width: 30px;border-radius:50%" alt=""><span style="font-size: 20px;" class="font-weight-bold mx-2">PayTM : </span>9985951017</p>
                <p><img src="./images/gpay.png" style="width: 30px;border-radius:50%" alt=""><span style="font-size: 20px;" class="font-weight-bold mx-2">GooglePay : </span>9985951017</p>
            </div>
        </div>
        <h5><u>Bank Details:</u></h5>
        <p><span style="font-size: 20px;" class="font-weight-bold mx-2">Bank Name : </span>Union Bank of India</p>
        <p><span style="font-size: 20px;" class="font-weight-bold mx-2">Accountant Name : </span>lsj Collections Pvt Ltd.</p>
        <p><span style="font-size: 20px;" class="font-weight-bold mx-2">AccountNo. : </span>09911001422144563</p>
        <p><span style="font-size: 20px;" class="font-weight-bold mx-2">IFSC Code : </span>UBIN05802214</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="OrderProductsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Order Products</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div style="overflow-y:scroll">
            <table class="table table-bordered">
            <thead>
                <tr>
                <th>Sno</th>
                <th>Image</th>
                <th>Name</th>
                <th>Type</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Weight</th>
                <th>GrandTotal</th>
                </tr>
            </thead>
            <tbody>
    
            </tbody>
            </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div> -->


<!-- SignUp Popup -->   
<div class="modal fade" id="PartialPurchaseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">About Partial Purchase</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul>
            <li><strong>What is Partial Purchase?</strong> - It allows you to pay a minimal amount (10% of the product price) to lock your favorite item.</li>
            <li><strong>Lock Your Product:</strong> - Secure the product and prevent it from being sold to someone else during the locking period.</li>
            <li><strong>Minimal Payment:</strong> - Pay just 10% of the total price upfront to reserve the product.</li>
            <li><strong>Flexible Time Frame:</strong> - Complete your payment and purchase the product within 15 days of the initial lock-in.</li>
            <li><strong>No Price Change:</strong> - The product price will remain locked and won't increase during the 15-day period.</li>
            <li><strong>Exclusive Reservation:</strong> - The product will be reserved exclusively for you during the locking period.</li>
            <li><strong>Hassle-Free Shopping:</strong> - Take your time to arrange the full payment while ensuring your favorite product isn’t sold out.</li>
            <li><strong>Refund Policy:</strong> - The initial 10% payment is non-refundable if the purchase is not completed within 15 days.</li>
            <li><strong>Secure Checkout:</strong> - Use secure online payment methods to lock your product with ease.</li>
            <li><strong>How to Use:</strong> - Select Partial Purchase at checkout, pay 10% upfront, and complete the remaining payment within 15 days to finalize your purchase.</li>
        </ul>

        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>

<!-- Search Modal -->
<div class="modal fade right" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-full-height modal-right modal-xl" role="document">
        <div class="modal-content border-0">
            <div class="modal-header border-0 bg-light">
                <div class="col-11">
                    <form action="" method="get" class="position-relative">
                        <div class="search-input-wrapper">
                            <input type="search" name="search" placeholder="Search..." 
                                id="modal-search-input" autocomplete="off"
                                class="form-control form-control-lg rounded-pill shadow-sm border-0">
                            <button type="button" class="btn btn-primary rounded-circle search-btn">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <button type="button" class="close-btn" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <!-- Search Results Section -->
                <div id="modal-search-results" style="display: none;">
                    <h4 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
                        <span class="bg-secondary pr-3">Search Results</span>
                    </h4>
                    <div class="row px-xl-5" id="search-results-container"></div>
                </div>

                <!-- Popular Products Section -->
                <div id="popular-products-section">
                    <h4 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
                        <span class="bg-secondary pr-3">Popular Products</span>
                    </h4>
                    <div class="row px-xl-5" id="popular-products-container"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

document.addEventListener('DOMContentLoaded', function() {
    // Get elements
    const searchBar = document.getElementById('search-bar');
    const modalSearchInput = document.getElementById('modal-search-input');
    const modalSearchResults = document.getElementById('modal-search-results');
    const popularProductsSection = document.getElementById('popular-products-section');
    const popularProductsContainer = document.getElementById('popular-products-container');
    let searchTimeout;

    // Add this event listener for the search form
    document.querySelector('.search-input-wrapper').closest('form').addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent form submission
        const query = modalSearchInput.value.trim();
        if (query.length > 0) {
            performSearch(query);
        }
    });

    // Update the main search bar form as well
    document.getElementById('search-bar').closest('form').addEventListener('submit', function(e) {
        e.preventDefault();
        $('#searchModal').modal('show');
        modalSearchInput.value = searchBar.value;
        if (modalSearchInput.value) {
            performSearch(modalSearchInput.value);
        }
    });

    function createProductCard(product, averageRating = 0) {
        return `
            <div class="col-lg-4 col-md-4 col-sm-6 mb-4">
                <div class="product-item bg-light mb-4 h-100">
                    <div class="product-img position-relative overflow-hidden">
                        <img class="img-fluid w-100" 
                             src="./panels/admin/product/${product.featured_image}"
                             alt="${product.product_name}"
                             style="object-fit: cover;">
                        <div class="product-action">
                            <a class="btn btn-outline-dark btn-square" href="./open-logics.php?type=addToCart&product_id=${product.id}">
                                <i class="fa fa-shopping-cart"></i>
                            </a>
                            <a class="btn btn-outline-dark btn-square" href="./open-logics.php?type=addToWishlist&product_id=${product.id}">
                                <i class="far fa-heart"></i>
                            </a>
                            <a class="btn btn-outline-dark btn-square" href="./product-view?slug=${product.slug}">
                                <i class="fa fa-eye"></i>
                            </a>
                        </div>
                    </div>
                    <div class="text-center py-4">
                        <a class="h6 text-decoration-none text-truncate product-name" 
                           style="max-width: 100%;" 
                           href="./product-view?slug=${product.slug}">
                            ${product.product_name}
                        </a>
                        <div class="d-flex align-items-center justify-content-center mt-2">
                            <h5 class="font-weight-bold mr-2">₹${product.discounted_price}</h5>
  
                        </div>
                        <span class="badge badge-success">${product.discount_percentage}% OFF</span>
                        ${averageRating ? `
                            <div class="d-flex align-items-center justify-content-center mb-1">
                                ${generateRatingStars(averageRating)}
                                <small>(${averageRating})</small>
                            </div>
                        ` : ''}
                    </div>
                </div>
            </div>
        `;
    }

    function generateRatingStars(rating) {
        let stars = '';
        for (let i = 0; i < Math.floor(rating); i++) {
            stars += '<small class="fa fa-star text-primary mr-1"></small>';
        }
        if (rating - Math.floor(rating) >= 0.5) {
            stars += '<small class="fa fa-star-half-alt text-primary mr-1"></small>';
        }
        for (let i = Math.ceil(rating); i < 5; i++) {
            stars += '<small class="far fa-star text-primary mr-1"></small>';
        }
        return stars;
    }

    function performSearch(query) {
        modalSearchResults.innerHTML = `
            <h4 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
                <span class="bg-secondary pr-3">Searching for "${query}"...</span>
            </h4>
            <div class="text-center py-4"><div class="spinner-border text-primary" role="status"></div></div>
        `;
        modalSearchResults.style.display = 'block';
        popularProductsSection.style.display = 'none';

        fetch(`./search.php?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                modalSearchResults.innerHTML = `
                    <h4 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
                        <span class="bg-secondary pr-3">Search Results for "${query}"</span>
                    </h4>
                    <div class="row px-xl-5">
                        ${data.length > 0 ? 
                            data.map(product => createProductCard(product)).join('') : 
                            `<div class="col-12 text-center py-5">
                                <h5>No products found for "${query}"</h5>
                                <button class="btn btn-primary mt-3" onclick="showPopularProducts()">
                                    Show Popular Products
                                </button>
                            </div>`
                        }
                    </div>`;
            })
            .catch(error => {
                console.error('Search error:', error);
                modalSearchResults.innerHTML = `
                    <div class="text-center py-4">
                        <div class="text-danger mb-3">Error searching products</div>
                        <button class="btn btn-primary" onclick="showPopularProducts()">
                            Show Popular Products
                        </button>
                    </div>`;
            });
    }

    function loadPopularProducts() {
        fetch('./get_popular_products.php')
            .then(response => response.json())
            .then(data => {
                popularProductsContainer.innerHTML = data.length > 0 ? 
                    data.map(product => createProductCard(product)).join('') :
                    '<div class="col-12 text-center">No popular products found</div>';
            })
            .catch(error => {
                console.error('Error loading popular products: ', error);
                popularProductsContainer.innerHTML = 
                    '<div class="col-12 text-center text-danger">Error loading popular products</div>';
            });
    }

    function showPopularProducts() {
        modalSearchResults.style.display = 'none';
        popularProductsSection.style.display = 'block';
        loadPopularProducts();
    }

    // Event Listeners
    modalSearchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const query = this.value.trim();

        if (query.length > 0) {
            searchTimeout = setTimeout(() => performSearch(query), 300);
        } else {
            showPopularProducts();
        }
    });

    $('#searchModal').on('shown.bs.modal', function () {
        modalSearchInput.value = searchBar.value;
        if (modalSearchInput.value.trim()) {
            performSearch(modalSearchInput.value.trim());
        } else {
            loadPopularProducts();
        }
    });

    // Handle search button click
    document.querySelector('.custom-position-search').addEventListener('click', function(e) {
        e.preventDefault();
        $('#searchModal').modal('show');
        modalSearchInput.value = searchBar.value;
        if (modalSearchInput.value) {
            performSearch(modalSearchInput.value);
        }
    });

    // Make showPopularProducts available globally
    window.showPopularProducts = showPopularProducts;

    // Add this new event listener for the search input
    document.getElementById('search-bar').addEventListener('click', function(e) {
        e.preventDefault();
        $('#searchModal').modal('show');
        modalSearchInput.value = searchBar.value;
        if (modalSearchInput.value.trim()) {
            performSearch(modalSearchInput.value.trim());
        } else {
            loadPopularProducts();
        }
    });

    // Make the search input readonly to prevent keyboard input
    document.getElementById('search-bar').setAttribute('readonly', 'readonly');
});
</script>


