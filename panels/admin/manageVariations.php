<?php 
session_start();
if(!empty($_GET['id'])){

  if(!empty($_SESSION['role']) ){
    $title="product";
  require_once('header.php');

  if(!empty($_POST['product_id']) && !empty($_POST['attribute_id']) && !empty($_POST['variation_name']) && isset($_POST['is_same_price']) && isset($_POST['product_price']) && isset($_POST['discount_percentage'])){
      require_once('./logics.class.php');
      $adminObj = new logics();

      $verification = $adminObj->AddVariations($_POST['product_id'], $_POST['attribute_id'], $_POST['variation_name'], $_POST['is_same_price'], $_POST['product_price'], $_POST['discount_percentage']);
      
      if(!empty($verification['status']) && $verification['status']==1){
          $succ = "Variation Added Successful";
      }else{
        $err = "Failed to add Variation";
      }
  }

  if(!empty($_POST['id']) && !empty($_POST['attribute_id']) && !empty($_POST['variation_name']) && isset($_POST['is_same_price']) && isset($_POST['product_price']) && isset($_POST['discount_percentage'])){
      require_once('./logics.class.php');
      $adminObj = new logics();

      $verification = $adminObj->UpdateVariation($_POST['id'], $_POST['attribute_id'], $_POST['variation_name'], $_POST['is_same_price'], $_POST['product_price'], $_POST['discount_percentage']);
      
      if(!empty($verification['status']) && $verification['status']==1){
          $succ = "Variation Updated Successful";
      }else{
        $err = "Failed to Update Variation";
      }
  }

  require_once('./logics.class.php');

  $obj = new logics();
  $editCategory = $obj->getOrnaments();
  $attributes = $obj->getAttribute();
  $variations = $obj->getProductVariations($_GET['id']);

  if (!empty($editCategory['status']) && $editCategory['status'] == 1) {
  ?>
  <!--  Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
      <div class="row">
        <div class="col-lg-12 mb-4 order-0">
          <div class="card">
            <div class="d-flex align-items-end row">
              <div class="col-sm-12">
                <div class="card-body d-flex justify-content-between">
                  <h5 class="card-title text-primary">Manage Variations of "<b><?php echo $_GET['product']; ?></b>"</h5>
                  <a href="./editProduct?id=<?php echo $_GET['id']; ?>" class="btn btn-sm btn-primary">Edit - <?php echo $_GET['product']; ?></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
        
      <div class="col-lg-12 mb-4 order-0">
        <div class="card">
          <div class="card-body">
            <?php if(!empty($succ)): ?>
              <div class="alert alert-success"><?php echo $succ ?></div>
            <?php endif; ?>
            <?php if(!empty($err)): ?>
              <div class="alert alert-danger"><?php echo $err ?></div>
            <?php endif; ?>
              
            <form action="./manageVariations?id=<?php echo $_GET['id']; ?>&product=<?php echo $_GET['product']; ?>" method="post" enctype="multipart/form-data">
              <div class="row">
                <div class="col-lg-2">
                  <label for="">Product Name</label>
                  <input type="hidden" name="product_id" value="<?php echo $_GET['id'] ?>">
                  <input type="text" name="product_name" class="form-control" value="<?php echo $_GET['product'] ?>" readonly>
                </div>
                <div class="col-lg-2">
                  <label for="">Attribute</label>
                  <select name="attribute_id" class="form-select" required>
                    <option value="">-Attribute-</option>
                    <?php for($i=0; $i<$attributes['count']; $i++): ?>
                      <option value="<?php echo $attributes['id'][$i] ?>"><?php echo $attributes['name'][$i] ?></option>
                    <?php endfor; ?>
                  </select>
                </div>
                <div class="col-lg-2">
                  <label for="">Variation Name</label>
                  <input type="text" name="variation_name" class="form-control" required>
                </div>
                <div class="col-lg-2">
                  <label for="">Is Same Price?</label>
                  <select name="is_same_price" class="form-select" required>
                    <option value="">-select-</option>
                    <option value="1">YES</option>
                    <option value="0">NO</option>
                  </select>
                </div>
                <div class="col-lg-2">
                  <label for="">Product Price</label>
                  <input type="number" name="product_price" class="form-control" step="0.01">
                </div>
                <div class="col-lg-2">
                  <label for="">Discount (%)</label>
                  <input type="number" name="discount_percentage" class="form-control">
                </div>
              </div>
              <br>
              <input type="submit" name="submit" value="Add Variation" class="btn btn-primary">
              <input type="reset" name="reset" value="Reset" class="btn btn-danger">
              <br><br>
            </form>

            <br>
            <h5><u>Added Variation</u></h5>

            <?php for($j=0; $j<$variations['count']; $j++):
              if($variations['product_id'][$j] == $_GET['id']): ?>
                <form action="./manageVariations?id=<?php echo $_GET['id']; ?>&product=<?php echo $_GET['product']; ?>" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="id" value="<?php echo $variations['id'][$j]; ?>">
                  <div class="row">
                    <div class="col-lg-2">
                      <label for="">Attribute</label>
                      <select name="attribute_id" class="form-select" required>
                        <option value="">-Attribute-</option>
                        <?php for($k=0; $k<$attributes['count']; $k++): ?>
                          <option value="<?php echo $attributes['id'][$k] ?>" <?php echo $attributes['id'][$k] == $variations['attribute_id'][$j] ? "selected" : "" ?>><?php echo $attributes['name'][$k] ?></option>
                        <?php endfor; ?>
                      </select>
                    </div>
                    <div class="col-lg-2">
                      <label for="">Variation Name</label>
                      <input type="text" name="variation_name" value="<?php echo $variations['variation_name'][$j]; ?>" class="form-control" required>
                    </div>
                    <div class="col-lg-2">
                      <label for="">Is Same Price?</label>
                      <select name="is_same_price" class="form-select" required>
                        <option value="">-select-</option>
                        <option value="1" <?php echo $variations['is_same_price'][$j]==1 ? "selected" : "" ?>>YES</option>
                        <option value="0" <?php echo $variations['is_same_price'][$j]==0 ? "selected" : "" ?>>NO</option>
                      </select>
                    </div>
                    <div class="col-lg-2">
                      <label for="">Product Price</label>
                      <input type="number" name="product_price" value="<?php echo $variations['product_price'][$j]; ?>" class="form-control" step="0.01">
                    </div>
                    <div class="col-lg-2">
                      <label for="">Discount (%)</label>
                      <input type="number" name="discount_percentage" value="<?php echo $variations['discount_percentage'][$j]; ?>" class="form-control">
                    </div>
                    <div class="col-lg-2">
                      <input type="submit" name="Update" value="Update" class="btn btn-sm btn-info">
                      <?php 
                      $partialUrl = urlencode("manageVariations?id=" . $_GET['id'] . "&product=" . $_GET['product']);
                      ?>
                      <a href="manage-status?delete_record_id=<?php echo $variations['id'][$j]; ?>&delete_table_name=product_variations&url=<?php echo $partialUrl; ?>" onclick="return confirm('Are you sure to Delete?')" class="btn btn-sm btn-danger">Delete</a>
                    </div>
                  </div>
                  <br><br>
                </form>
              <?php endif;
            endfor; ?>
          </div>
        </div>
      </div>
    </div>
  <!-- / Content -->

  <?php 
  }else{
    echo "Data Not Fetched";
  }
  
  require_once('footer.php');
  }else{
    header('location:login.php');
  }
}else{
  header('location:getCategories');
}
?>





