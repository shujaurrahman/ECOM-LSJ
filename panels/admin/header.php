<?php
require_once('check_session.php');
checkAdminSession();
?>
<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="Protechelevate Software solutions pvt. ltd."
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>lsj - Admin</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../images/logo_lsj.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <link rel="stylesheet" href="../assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->

    <link rel="stylesheet" href="../js/datatable.css">

    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>

    <script src="../assets/js/config.js"></script>


  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="index" class="app-brand-link">
              
            <img src="../../images/logo-no-bg.png" style="width: 170px;" alt="logo">
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Main Menu</span>
            </li>
            
            <li class="menu-item <?php if(!empty($title) && $title=='home'){ echo 'active'; } ?>">
              <a href="index.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
              </a>
            </li>

            <li class="menu-item <?php if(!empty($title) && $title=='orders'){ echo 'active'; } ?>">
              <a href="./getOrders" class="menu-link">
                <i class="menu-icon tf-icons bx bx-cart"></i>
                <div data-i18n="Analytics">Orders</div>
              </a>
            </li>

            <!-- <li class="menu-item <?php if(!empty($title) && $title=='Payments'){ echo 'active'; } ?>">
              <a href="./getOrdersPayments" class="menu-link">
                <i class="menu-icon tf-icons bx bx-cart"></i>
                <div data-i18n="Analytics">Payments</div>
              </a>
            </li> -->


            <li class="menu-item <?php if(!empty($title) && $title=='users'){ echo 'active'; } ?>">
              <a href="./getUsers" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Analytics">Resgistered Users</div>
              </a>
            </li>

<!-- 
            <li class="menu-item <?php if(!empty($title) && $title=='customizations'){ echo 'active'; } ?>">
              <a href="./getCustomizations" class="menu-link">
                <i class="menu-icon tf-icons bx bx-refresh"></i>
                <div data-i18n="Analytics">Customizations</div>
              </a>
            </li> -->

            
            <li class="menu-item <?php if(!empty($title) && $title=='ornament'){ echo 'active'; } ?>">
              <a href="./addOrnament" class="menu-link">
                <i class="menu-icon tf-icons bx bx-plus-circle"></i>
                <div data-i18n="Analytics">Add Ornaments</div>
              </a>
            </li>

            <li class="menu-item <?php if(!empty($title) && $title=='added-ornaments'){ echo 'active'; } ?>">
              <a href="./getOrnaments" class="menu-link">
                <i class="menu-icon tf-icons bx bx-check-circle"></i>
                <div data-i18n="Analytics">View Ornaments</div>
              </a>
            </li>

            
            <li class="menu-item <?php if(!empty($title) && $title=='product'){ echo 'active'; } ?>">
              <a href="./addProduct" class="menu-link">
                <i class="menu-icon tf-icons bx bx-plus-circle"></i>
                <div data-i18n="Analytics">Add Products</div>
              </a>
            </li>
            
            <li class="menu-item <?php if(!empty($title) && $title=='added-products'){ echo 'active'; } ?>">
              <a href="./getProducts" class="menu-link">
                <i class="menu-icon tf-icons bx bx-check-circle"></i>
                <div data-i18n="Analytics">View Products</div>
              </a>
            </li>

            <li class="menu-item <?php if(!empty($title) && $title=='added-advertisements'){ echo 'active'; } ?>">
              <a href="./getAdvertisements" class="menu-link">
                <i class="menu-icon tf-icons bx bx-check-circle"></i>
                <div data-i18n="Analytics">Advertisements</div>
              </a>
            </li>







            <li class="menu-item <?php if(!empty($title) && $title=='category'){ echo 'active'; } ?>">
              <a href="./addCategory" class="menu-link">
                <i class="menu-icon tf-icons bx bx-plus-circle"></i>
                <div data-i18n="Analytics">Add Categories</div>
              </a>
            </li>
            <li class="menu-item <?php if(!empty($title) && $title=='added-category'){ echo 'active'; } ?>">
              <a href="./getCategories" class="menu-link">
                <i class="menu-icon tf-icons bx bx-check-circle"></i>
                <div data-i18n="Analytics">View Categories</div>
              </a>
            </li>

            <li class="menu-item <?php if(!empty($title) && $title=='subcategory'){ echo 'active'; } ?>">
              <a href="./addSubCategory" class="menu-link">
                <i class="menu-icon tf-icons bx bx-plus-circle"></i>
                <div data-i18n="Analytics">Add Sub-Categories</div>
              </a>
            </li>
            <li class="menu-item <?php if(!empty($title) && $title=='added-subcategory'){ echo 'active'; } ?>">
              <a href="./getSubCategories" class="menu-link">
                <i class="menu-icon tf-icons bx bx-check-circle"></i>
                <div data-i18n="Analytics">View Sub-Categories</div>
              </a>
            </li>


            <li class="menu-item <?php if(!empty($title) && $title=='attribute'){ echo 'active'; } ?>">
              <a href="./addAttribute" class="menu-link">
                <i class="menu-icon tf-icons bx bx-plus-circle"></i>
                <div data-i18n="Analytics">Add Attributes</div>
              </a>
            </li>
            <li class="menu-item <?php if(!empty($title) && $title=='added-attributes'){ echo 'active'; } ?>">
              <a href="./getAttributes" class="menu-link">
                <i class="menu-icon tf-icons bx bx-check-circle"></i>
                <div data-i18n="Analytics">View Attributes</div>
              </a>
            </li>



            <li class="menu-item <?php if(!empty($title) && $title=='feature'){ echo 'active'; } ?>">
              <a href="./addFeature" class="menu-link">
                <i class="menu-icon tf-icons bx bx-plus-circle"></i>
                <div data-i18n="Analytics">Add Features</div>
              </a>
            </li>
            <li class="menu-item <?php if(!empty($title) && $title=='added-features'){ echo 'active'; } ?>">
              <a href="./getFeatures" class="menu-link">
                <i class="menu-icon tf-icons bx bx-check-circle"></i>
                <div data-i18n="Analytics">View Features</div>
              </a>
            </li>

            <li class="menu-item <?php if(!empty($title) && $title=='coupon'){ echo 'active'; } ?>">
              <a href="./addCoupon" class="menu-link">
                <i class="menu-icon tf-icons bx bx-plus-circle"></i>
                <div data-i18n="Analytics">Add Coupons</div>
              </a>
            </li>

            <li class="menu-item <?php if(!empty($title) && $title=='added-coupon'){ echo 'active'; } ?>">
              <a href="./getCoupons" class="menu-link">
                <i class="menu-icon tf-icons bx bx-check-circle"></i>
                <div data-i18n="Analytics">View Coupons</div>
              </a>
            </li>






            
            <!-- <li class="menu-item <?php if(!empty($title) && $title=='users'){ echo 'active'; } ?> ">
              <a href="users.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Analytics">View Users</div>
              </a>
            </li>
            
            
            <li class="menu-item <?php if(!empty($title) && $title=='registrations'){ echo 'active'; } ?> ">
              <a href="registrations.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Analytics">Registrations</div>
              </a>
            </li>
            
            
            <li class="menu-item <?php if(!empty($title) && $title=='pastregistrations'){ echo 'active'; } ?> ">
              <a href="pastregistrations.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Analytics">Past Registrations</div>
              </a>
            </li>
            
            
            <li class="menu-item <?php if(!empty($title) && $title=='tasks'){ echo 'active'; } ?> ">
              <a href="tasks.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Analytics">Submitted Tasks</div>
              </a>
            </li>
            
            
            <li class="menu-item <?php if(!empty($title) && $title=='careers'){ echo 'active'; } ?> ">
              <a href="careers.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Analytics">Careers</div>
              </a>
            </li>
            
            
            <li class="menu-item <?php if(!empty($title) && $title=='quotes'){ echo 'active'; } ?> ">
              <a href="quotes.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Analytics">Quotes</div>
              </a>
            </li> -->
            
            
            <li class="menu-item <?php if(!empty($title) && $title=='contact'){ echo 'active'; } ?> ">
              <a href="./getContacts.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Analytics">Contact Info</div>
              </a>
            </li>
            <li class="menu-item <?php if(!empty($title) && $title=='Subscribers'){ echo 'active'; } ?> ">
              <a href="./getSubscriber.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Analytics">View Subscribers</div>
              </a>
            </li>
            <li class="menu-item <?php if(!empty($title) && $title=='Partner'){ echo 'active'; } ?> ">
              <a href="./addPartners.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-check-circle"></i>
                <div data-i18n="Analytics">Add Partners</div>
              </a>
            </li>
            <li class="menu-item <?php if(!empty($title) && $title=='reviews'){ echo 'active'; } ?> ">
              <a href="./addreviews.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-check-circle"></i>
                <div data-i18n="Analytics">Add Reviews</div>
              </a>
            </li>
            <li class="menu-item <?php if(!empty($title) && $title=='product-reviews'){ echo 'active'; } ?> ">
              <a href="./getproductreview.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-check-circle"></i>
                <div data-i18n="Analytics">Product Reviews</div>
              </a>
            </li>
<!--             
            <li class="menu-item <?php if(!empty($title) && $title=='students'){ echo 'active'; } ?>">
              <a href="./addstudents.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-plus"></i>
                <div data-i18n="Analytics">Add Students</div>
              </a>
            </li>
            <li class="menu-item <?php if(!empty($title) && $title=='blogs'){ echo 'active'; } ?>">
              <a href="./addblogs.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-plus"></i>
                <div data-i18n="Analytics">Add Blogs</div>
              </a>
            </li>
            <li class="menu-item <?php if(!empty($title) && $title=='addtasks'){ echo 'active'; } ?>">
              <a href="./addtasks.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-plus"></i>
                <div data-i18n="Analytics">Add Tasks</div>
              </a>
            </li> -->
            <!-- <li class="menu-item <?php if(!empty($title) && $title=='registrations'){ echo 'active'; } ?>">
              <a href="./registrations.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-plus"></i>
                <div data-i18n="Analytics">Registrations</div>
              </a>
            </li>
            <li class="menu-item <?php if(!empty($title) && $title=='registrations'){ echo 'active'; } ?>">
              <a href="./registrations.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-plus"></i>
                <div data-i18n="Analytics">Registrations</div>
              </a>
            </li>
            <li class="menu-item <?php if(!empty($title) && $title=='registrations'){ echo 'active'; } ?>">
              <a href="./registrations.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-plus"></i>
                <div data-i18n="Analytics">Registrations</div>
              </a>
            </li>
            <li class="menu-item <?php if(!empty($title) && $title=='registrations'){ echo 'active'; } ?>">
              <a href="./registrations.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-plus"></i>
                <div data-i18n="Analytics">Registrations</div>
              </a>
            </li>
             -->
            <li class="menu-item ">
              <a href="logout.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-power-off"></i>
                <div data-i18n="Analytics">Logout</div>
              </a>
            </li>
          </ul>
        </aside>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar"
          >
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <!-- Search -->
              <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center">
                  <i class="bx bx-search fs-4 lh-0"></i>
                  <input
                    type="text"
                    class="form-control border-0 shadow-none"
                    placeholder="Search..."
                    aria-label="Search..."
                  />
                </div>
              </div>
              <!-- /Search -->

              <ul class="navbar-nav flex-row align-items-center ms-auto">
                

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <img src="../assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              <img src="../assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <span class="fw-semibold d-block"><?php echo $_SESSION['role'] ?></span>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <!-- <li>
                      <a class="dropdown-item" href="./profile.php">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">My Profile</span>
                      </a>
                    </li> -->
                    <li>
                      <a class="dropdown-item" href="./logout.php">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Logout</span>
                      </a>
                    </li>
                    
                    
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->