<?php 
session_start();
if(!empty($_SESSION['username'])){
  $title="home";
require_once('header.php');
 ?>
<!--  Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <div class="col-lg-12 mb-4 order-0">
        <div class="card">
          <div class="d-flex align-items-end row">
            <div class="col-sm-7">
              <div class="card-body">
                <h5 class="card-title text-primary">Welcome <b> <?php echo $_SESSION['username'] ?></b>! 🎉</h5>
                <p class="mb-4">
                  Explore Your Dashboard...!
                </p>

                <a href="profile" class="btn btn-sm btn-outline-primary">View Profile</a>
              </div>
            </div>
          
          </div>
        </div>
      </div>
      <div class="col-lg-12 mb-4 order-0">
        <div class="card">
          <div class="d-flex align-items-end row">
            <div class="col-sm-12">
              <div class="card-body">
                <h5 class="card-title text-primary">Instructions to Use the Portal</h5>
                <ul>
                  <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus, corrupti sed asperiores excepturi debitis, officiis beatae ipsum ab libero culpa architecto quisquam. Nulla, earum asperiores.</li>
                  <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus, corrupti sed asperiores excepturi debitis, officiis beatae ipsum ab libero culpa architecto quisquam. Nulla, earum asperiores.</li>
                  <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus, corrupti sed asperiores excepturi debitis, officiis beatae ipsum ab libero culpa architecto quisquam. Nulla, earum asperiores.</li>
                  <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus, corrupti sed asperiores excepturi debitis, officiis beatae ipsum ab libero culpa architecto quisquam. Nulla, earum asperiores.</li>
                  <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus, corrupti sed asperiores excepturi debitis, officiis beatae ipsum ab libero culpa architecto quisquam. Nulla, earum asperiores.</li>
                  <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus, corrupti sed asperiores excepturi debitis, officiis beatae ipsum ab libero culpa architecto quisquam. Nulla, earum asperiores.</li>
                  <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus, corrupti sed asperiores excepturi debitis, officiis beatae ipsum ab libero culpa architecto quisquam. Nulla, earum asperiores.</li>
                </ul>

                
              </div>
            </div>
          
          </div>
        </div>
      </div>
      
    </div>
  </div>
  
<!-- / Content -->

<?php 
require_once('footer.php');
}else{
  header('location:login.php');
}
?>

            