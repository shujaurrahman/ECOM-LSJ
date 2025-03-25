<?php 
session_start();
error_reporting(0);
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);


if(!empty($_SESSION['role'])){
  $title="product";
require_once('header.php');

require_once('./logics.class.php');
$Obj = new logics();

$categories = $Obj->getCategories();

$subcategories = $Obj->getSubCategories();

$ornaments = $Obj->getOrnaments();

$features = $Obj->getFeatures();

$attributes = $Obj->getAttribute();

$products = $Obj->getProducts();

$productVariations = $Obj->getProductVariations($_GET['id']);

  if(isset($_POST['submit'])){
    // print_r($_POST);
    // die();

    // Handling Featured Image
    if (!empty($_FILES['featured_image']['name'])) {
        // New featured image uploaded, process it
        $featured_imageName = $_FILES['featured_image']['name'];
        $featured_imageTempLocal = $_FILES['featured_image']['tmp_name'];
        
        // Append current date and time to the image name to make it unique
        $timestamp = date("YmdHis");
        $extension = pathinfo($featured_imageName, PATHINFO_EXTENSION);
        $featured_imageName = pathinfo($featured_imageName, PATHINFO_FILENAME) . '_' . $timestamp . '.' . $extension;

        $featured_imageStore = "product/" . $featured_imageName;

        // Move uploaded image to the desired directory
        move_uploaded_file($featured_imageTempLocal, $featured_imageStore);

        // Use the new uploaded image name
        $featured_imagePhoto = $featured_imageName;
    } else {
        // No new image uploaded, use the existing one from POST data
        $featured_imagePhoto = $_POST['actual_featured_image'];
    }

    if (!empty($_FILES['size_chart']['name'])) {
      $size_chartName = $_FILES['size_chart']['name'];
      $size_chartTempLocal = $_FILES['size_chart']['tmp_name'];
      
      // Append current date and time to the size_chart name to make it unique
      $timestamp = date("YmdHis");
      $extension = pathinfo($size_chartName, PATHINFO_EXTENSION);
      $size_chartName = pathinfo($size_chartName, PATHINFO_FILENAME) . '_' . $timestamp . '.' . $extension;
  
      $size_chartStore = "product/" . $size_chartName;
  
      // Move uploaded size_chart photo to desired directory
      move_uploaded_file($size_chartTempLocal, $size_chartStore);
  
      // Store size_chart photo name
      $size_chartPhoto = $size_chartName;
    } else {
      // No new size_chart uploaded, use the existing one from POST data
      $size_chartPhoto = $_POST['actual_size_chart'];
    }

    // Handling Additional Images
    $additional_images = !empty($_POST['actual_additional_images']) ? explode(',', $_POST['actual_additional_images']) : [];

    if (!empty($_FILES['aaditional_images']['name'][0])) {
        foreach ($_FILES['aaditional_images']['name'] as $key => $imageName) {
            $imageTempLocal = $_FILES['aaditional_images']['tmp_name'][$key];
            
            $timestamp = date("YmdHis");
            $extension = pathinfo($imageName, PATHINFO_EXTENSION);
            $imageName = pathinfo($imageName, PATHINFO_FILENAME) . '_' . $timestamp . '.' . $extension;

            $imageStore = "product/" . $imageName;
            move_uploaded_file($imageTempLocal, $imageStore);

            // Append new images to the existing ones
            $additional_images[] = $imageName;
        }
    }

    // Convert the updated array to a comma-separated string
    $additional_imagesCSV = implode(',', $additional_images);

    // Handling Selected Features
    if (!empty($_POST['features'])) {
        $selected_features = implode(',', $_POST['features']);
    } else {
        $selected_features = "";
    }

    require_once('./logics.class.php');
    $adminObj = new logics();

    $verification = $adminObj->UpdateProduct(
      $_POST['category_id'],
      $_POST['subcategory_id'],
      $_POST['product_name'],
      $featured_imagePhoto,
      $additional_imagesCSV,
      $_POST['stock'],
      $_POST['ornament_type'],
      $_POST['ornament_weight'],
      $_POST['product_Price'],  // Changed from product_Price to product_price
      $_POST['discount_percentage'],
      $_POST['short_description'],
      $selected_features,
      $_POST['is_popular_collection'],
      $_POST['is_recommended'],
      $_POST['description'],
      $_POST['id'],
      $_POST['hashtags'],
      $size_chartPhoto
    );

    if(!empty($verification['status']) && $verification['status'] == 1) {
        echo '<script src="../js/sweetalert.js"></script>';
        echo '<script>';
        echo 'Swal.fire({
                icon: "success",
                title: "Product Successfully Updated!",
                showConfirmButton: true,
            }).then(function() {
                window.location.href = "getProducts";
            });';
        echo '</script>';
    } else {
        echo '<script src="../js/sweetalert.js"></script>';
        echo '<script>';
        echo 'Swal.fire({
                icon: "error",
                title: "Data not Submitted!",
                text: "Please try again"
            }).then(function() {
                window.location.href = "getProducts";
            });';
        echo '</script>';
    }
}

 ?>
<!--  Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <div class="col-lg-12 mb-4 order-0">
        <div class="card">
          <div class="d-flex align-items-end row">
            <div class="col-sm-12">
              <div class="card-body d-flex justify-content-between">
                <h5 class="card-title text-primary">Update Product</h5>
                <a href="./getProducts.php" class="btn btn-sm btn-primary">View Added Products</a>
              </div>
            </div>
          
          </div>
        </div>
      </div>
    </div>

    <form action="./editProduct.php?id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data" class="row">
      <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>" id="">

    <?php
    for($j=0;$j<$products['count'];$j++){
      if($products['id'][$j]==$_GET['id']){
    ?>
      
      <div class="col-lg-8 mb-4 order-0">
        <div class="card">
          <div class="card-body">
              <label for="category">Select Category</label>
              <select name="category_id" class="form-select mb-3" required  id="category">
                  <option value="">--Select Category Name--</option>
                  <?php
                  for($i=0;$i<$categories['count'];$i++){
                    ?>
                    <option value="<?php echo $categories['id'][$i] ?>" <?php  if($categories['id'][$i] == $products['category_id'][$j]){ echo "selected"; } ?> ><?php echo $categories['name'][$i] ?></option>
                    <?php
                  }
                  ?>
              </select>

              <label for="subcategory">Select Sub-Category</label>
              <select name="subcategory_id" class="form-select mb-3" required  id="subcategory">
                  <option value="">--Select Sub-Category Name--</option>
                  <!-- <option value="<?php echo $products['subcategory_id'][$j] ?>" selected ><?php echo $products['subcategory_name'][$j] ?></option> -->
                  <?php
                  for($i=0;$i<$subcategories['count'];$i++){
                    if($subcategories['statusval'][$i]==1){
                      // if($subcategories['category_id'][$i]==$products['category_id'][$j]){
                      ?>
                      <option value="<?php echo $subcategories['id'][$i] ?>"  <?php  if($subcategories['id'][$i] == $products['subcategory_id'][$j]){ echo "selected"; } ?>><?php echo $subcategories['name'][$i] ?></option>
                      <?php
                      // }
                    }
                  }
                  ?>
              </select>

              <label for="product_name">Product Name</label>
              <input type="text" name="product_name" value="<?php echo $products['product_name'][$j] ?>" required placeholder="Enter Product Name"  class="form-control mb-3"   id="product_name">

          </div>
        </div>
      </div>

      <div class="col-lg-4 mb-4 order-0">
        <div class="card">
          <div class="card-body" style="padding: 2.8rem 1.5rem;">
            <!-- Commented Lakshmi Kubera section -->
            <!-- <div class="d-flex justify-content-between mb-4">
              <label for="category">Lakshmi Kubera?</label>
                <div class="checkbox-wrapper-34 ">
                <input type="hidden" name="is_lakshmi_kubera" value="0">
                <input class="tgl tgl-ios" id="toggle-34" type="checkbox" <?php if($products['is_lakshmi_kubera'][$j]==1){ echo "checked"; } ?> name="is_lakshmi_kubera" value="1" />
                  <label class="tgl-btn" for="toggle-34"></label>
                </div>
            </div> -->

            <div class="d-flex justify-content-between mb-4">
              <label for="category">Popular Collection?</label>
                <div class="checkbox-wrapper-34 ">
                  <input type="hidden" name="is_popular_collection" value="0">
                  <input class="tgl tgl-ios" id="toggle-35" type="checkbox" <?php if($products['is_popular_collection'][$j]==1){ echo "checked"; } ?> name="is_popular_collection" value="1" />
                  <label class="tgl-btn" for="toggle-35"></label>
                </div>
            </div>

            <div class="d-flex justify-content-between mb-4">
              <label for="category">Recommended?</label>
                <div class="checkbox-wrapper-34 ">
                  <input type="hidden" name="is_recommended" value="0">
                  <input class="tgl tgl-ios" id="toggle-36" type="checkbox" <?php if($products['is_recommended'][$j]==1){ echo "checked"; } ?> name="is_recommended" value="1" />
                  <label class="tgl-btn" for="toggle-36"></label>
                </div>
            </div>

            <label for="stock" style="padding-bottom:0.5rem">Available Stock</label>
            <input type="number" name="stock" value="<?php echo $products['stock'][$j] ?>" required placeholder="Enter Stock Quantity"  class="form-control mb-3"   id="stock">

          </div>
        </div>
      </div>

      <div class="col-lg-12 mb-4 order-0">
        <div class="card">
          <div class="card-body">
              <label for="featured_image">Add Featured Image</label>
              <p class="text-danger small mb-2">
                <i class="bx bx-error-circle"></i>
                Maximum image size allowed is 2MB. Image dimensions must be 100px × 400px.
              </p>
              <input type="file" name="featured_image" placeholder="Enter Stock Quantity"  class="form-control mb-3"   id="stock">
              <input type="hidden" name="actual_featured_image" value="<?php echo $products['featured_image'][$j] ?>" id="">

              <img src="./product/<?php echo $products['featured_image'][$j] ?>" width="100px" alt="">
              <br>


              <label for="category">Add Additional Images</label>
              <div class="d-flex">
                <input type="file" name="aaditional_images[]" placeholder="Enter Stock Quantity" class="form-control mb-3"  id="stock">
                <i class="menu-icon tf-icons bx bx-plus-circle bg-primary text-white rounded p-2" id="addImage" style="cursor: pointer; margin-left: 10px; height:100%"></i>
              </div>
              <div id="imageInputs"></div>

              <input type="hidden" name="actual_additional_images" value="<?php echo $products['additional_images'][$j] ?>" id="">
              <?php
              $addl_imgs = explode(',',$products['additional_images'][$j]);
              foreach($addl_imgs as $image){
                ?>
                <img src="./product/<?php echo $image ?>" width="100px" class="mx-2" alt="">
                <?php
              }
              ?>
              <br>
<br>


              <div class="row">
                <div class="col-lg-4">
                  <label for="ornament_type">Select Ornament Type</label>
                  <select name="ornament_type" required class="form-select mb-3"  id="ornament_type">
                      <option value="">--Select ornament_type--</option>
                      <?php
                      for($i=0;$i<$ornaments['count'];$i++){
                        ?>
                        <option value="<?php echo $ornaments['id'][$i] ?>" <?php  if($ornaments['id'][$i] == $products['ornament_id'][$j]){ echo "selected"; } ?> ><?php echo $ornaments['name'][$i] ?></option>
                        <?php
                      }
                      ?>
                  </select>
                </div>
                <div class="col-lg-4">
                  <label for="ornament_weight">Ornament Weight</label>
                  <input type="number" name="ornament_weight" value="<?php echo $products['ornament_weight'][$j] ?>" required placeholder="Enter Ornament Weight (In Grams)" class="form-control mb-3"  id="ornament_weight" step="0.01">
                </div>
                <div class="col-lg-6">
                  <label for="product_Price">Product Price</label>
                  <input type="number" name="product_Price" value="<?php echo $products['product_price'][$j] ?>" required placeholder="Product Price " class="form-control mb-3" id="product_Price" step="1" oninput="calculateDiscountedPrice()">
                </div>

                <div class="col-lg-4">
                  <label for="discounted_percentage">Discounted Percentage</label>
                  <input type="number" name="discount_percentage" value="<?php echo $products['discount_percentage'][$j] ?>" required placeholder="Enter Discounted Percentage" class="form-control mb-3" id="discounted_percentage" oninput="calculateDiscountedPrice()">
                </div>
                <!-- <div class="col-lg-12">
                  <label for="discounted_price">Discounted Price</label>
                  <input type="number" name="discounted_price" value="<?php echo $products['discounted_price'][$j] ?>" class="form-control mb-3" id="discounted_price" readonly>
                </div> -->
                </div>

              <label for="short_description">Short Description</label>
              <input type="text" name="short_description" value="<?php echo $products['short_description'][$j] ?>" required placeholder="Enter Short Description"  class="form-control mb-3"   id="short_description">

              <label for="short_description">Select Features</label>
              <div class="d-flex mb-3">

              <?php
              // Assuming $products['featured_id'][$j] is the comma-separated string like "2,5,6"
              $selected_features = explode(',', $products['features_id'][$j]);

              // Iterate over features from the database
              for ($i = 0; $i < $features['count']; $i++) {
                  // Check if the current feature ID exists in the $selected_features array
                  $isChecked = in_array($features['id'][$i], $selected_features) ? 'checked' : '';
                  ?>
                  <div class="checkbox-wrapper-16 px-2">
                      <label class="checkbox-wrapper">
                          <input type="checkbox" name="features[]" value="<?php echo $features['id'][$i] ?>" class="checkbox-input" <?php echo $isChecked; ?> />
                          <span class="checkbox-tile">
                              <span class="checkbox-icon">
                                  <img src="./feature/<?php echo $features['image'][$i]; ?>" width="40px" alt="">
                              </span>
                              <span class="checkbox-label"><?php echo $features['name'][$i]; ?></span>
                          </span>
                      </label>
                  </div>
                  <?php
              }

                ?>

              </div>
          </div>
        </div>
      </div>
      <div class="col-lg-12 mb-4 order-0">
        <div class="card">
          <div class="card-body">
            <label for="size_chart">Size Chart Image</label>
            <p class="text-danger small mb-2">
              <i class="bx bx-error-circle"></i>
              Maximum image size allowed is 2MB
            </p>
            <input type="file" name="size_chart" class="form-control mb-3" id="size_chart">
            <input type="hidden" name="actual_size_chart" value="<?php echo $products['size_chart'][$j] ?>" id="">

            <?php if (!empty($products['size_chart'][$j])): ?>
              <div class="mb-3">
                <p class="mb-2">Current Size Chart:</p>
                <img src="./product/<?php echo $products['size_chart'][$j] ?>" 
                     class="img-thumbnail" 
                     style="max-width: 200px;" 
                     alt="Size Chart">
              </div>
            <?php endif; ?>

            <!-- Hashtags Section -->
            <label for="hashtagInput" class="mt-3">Product Hashtags</label>
            <div class="hashtag-container">
              <div class="d-flex flex-wrap gap-2 mb-2" id="tagContainer">
                <?php
                if (!empty($products['hashtags'][$j])) {
                  $hashtags = explode(',', $products['hashtags'][$j]);
                  foreach ($hashtags as $tag) {
                    if (!empty($tag)) {
                      echo '<span class="rounded-2 px-2 py-1 d-inline-flex align-items-center" 
                                 style="font-size: 14px; color: white; background-color: #5f61e6;">
                              ' . htmlspecialchars(trim($tag)) . '
                              <span class="ms-1 fw-bold" role="button" style="cursor: pointer;" 
                                    onclick="removeTag(this, \'' . htmlspecialchars(trim($tag)) . '\')">&times;</span>
                            </span>';
                    }
                  }
                }
                ?>
              </div>
              <input type="text" class="form-control" id="hashtagInput" placeholder="Type hashtag and press Enter">
              <input type="hidden" name="hashtags" id="hashtagsHidden" value="<?php echo htmlspecialchars($products['hashtags'][$j]); ?>">
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-12 order-0">
        <div class="card">
          <b class="card-body">
            <span>Product Variations</span>
            <hr>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Sno</th>
                  <th>Attribute</th>
                  <th>Variation</th>
                  <th>Same Price?</th>
                  <th>Ornament Weight</th>
                  <th>Discount (%)</th>
                </tr>
              </thead>
              <tbody>
              <?php
              for($k=0;$k<$productVariations['count'];$k++){
                if($productVariations['product_id'][$k]==$_GET['id']){
                  ?>
                <tr>
                  <td><?php echo $k+1; ?></td>
                  <td><?php echo $productVariations['attribute_name'][$k]; ?></td>
                  <td><?php echo $productVariations['variation_name'][$k]; ?></td>
                  <td><?php echo $productVariations['is_same_price'][$k]==1 ? 'YES' : 'NO'; ?></td>
                  <td><?php echo $productVariations['attribute_name'][$k]; ?></td>
                  <td><?php echo $productVariations['variation_name'][$k]; ?></td>
                  <td><?php echo $productVariations['is_same_price'][$k]==1 ? 'YES' : 'NO'; ?></td>
                  <td><?php echo !empty($productVariations['ornament_weight'][$k]) ? $productVariations['ornament_weight'][$k] : "NA"; ?></td>
                  <td><?php echo !empty($productVariations['discount_percentage'][$k]) ? $productVariations['discount_percentage'][$k] : "NA"; ?></td>
                </tr>
                <?php
                }
              }
              ?>
              </tbody>
            </table>
            <br>
            <div class="float-end">
              <a href="./manageVariations?id=<?php echo $_GET['id']; ?>&product=<?php echo $products['product_name'][$j] ?>" target="_blank" class="btn btn-danger">Add/Edit/Delete Variances</a>
            </div>
          </div>
        </div>
      </div>

      <!-- <div class="col-lg-12 mb-4 order-0">
        <div class="card">
          <div class="card-body">
            <span>General Info</span>
            <hr>
            <textarea name="general_info"  class="form-control mb-3" rows="10"  id="general_info"><?php echo $products['general_info'][$j] ?></textarea>
          </div>
        </div>
      </div> -->




      <div class="col-lg-12 mb-4 order-0">
        <div class="card">
          <div class="card-body">
            <span>Description</span>
            <hr>
            <textarea name="description" class="form-control mb-3" rows="10"  id="description"><?php echo $products['description'][$j] ?></textarea>

            <br>
            <input type="submit" name="submit" value="Update Product" class="btn btn-primary" id="">
          </div>
        </div>
      </div>

      <?php
      }
    }
      ?>

    </form>
      
    
  </div>
  
<!-- / Content -->

<?php 
require_once('footer.php');
}else{
  header('location:login.php');
}
?>

<!-- <script src="../js/ckeditor.js"></script> -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
<script>
// Add image dimension validation function
function validateImageDimensions(file, errorCallback) {
  return new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    
    reader.onload = function(e) {
      const image = new Image();
      image.src = e.target.result;
      
      image.onload = function() {
        const width = this.width;
        const height = this.height;
        
        if (width !== 100 || height !== 400) {
          errorCallback(`Image dimensions must be 100px × 400px. Current dimensions: ${width}px × ${height}px.`);
          resolve(false);
        } else {
          resolve(true);
        }
      };
      
      image.onerror = function() {
        reject(new Error("Failed to load image"));
      };
    };
    
    reader.onerror = function() {
      reject(new Error("Failed to read file"));
    };
  });
}

function calculateDiscountedPrice() {
  const productPrice = parseFloat(document.getElementById('product_Price').value) || 0;
  const discountPercentage = parseFloat(document.getElementById('discounted_percentage').value) || 0;
  const discountedPrice = productPrice - (productPrice * (discountPercentage / 100));
  document.getElementById('discounted_price').value = discountedPrice.toFixed(2);
}

// Add this to your existing JavaScript section
document.addEventListener('DOMContentLoaded', function() {
    const hashtagInput = document.getElementById('hashtagInput');
    const tagContainer = document.getElementById('tagContainer');
    const hashtagsHidden = document.getElementById('hashtagsHidden');
    let tags = hashtagsHidden.value.split(',').filter(tag => tag.trim() !== '');

    hashtagInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const tag = this.value.trim();
            
            if (tag && !tags.includes(tag)) {
                addTag(tag);
                this.value = '';
            }
        }
    });

    function addTag(tag) {
        const tagElement = document.createElement('span');
        tagElement.className = 'rounded-2 px-2 py-1 d-inline-flex align-items-center';
        tagElement.style.fontSize = '14px';
        tagElement.style.color = 'white';
        tagElement.style.backgroundColor = '#5f61e6';
        tagElement.innerHTML = `
            ${tag}
            <span class="ms-1 fw-bold" role="button" style="cursor: pointer;" 
                  onclick="removeTag(this, '${tag}')">&times;</span>
        `;
        
        tagContainer.appendChild(tagElement);
        tags.push(tag);
        updateHiddenInput();
    }

    window.removeTag = function(element, tag) {
        element.parentElement.remove();
        tags = tags.filter(t => t !== tag);
        updateHiddenInput();
    }

    function updateHiddenInput() {
        hashtagsHidden.value = tags.join(',');
    }
});

document.querySelector('input[name="aaditional_images[]"]').addEventListener('change', function() {
    validateImageSize(this);
  });

  function validateImageSize(fileInput) {
    const maxSize = 2 * 1024 * 1024; // 2MB in bytes
    const alertDiv = document.createElement('div');
    alertDiv.id = 'sizeAlertAdditional';
    
    const existingAlert = fileInput.parentNode.querySelector('#sizeAlertAdditional');
    if (existingAlert) {
      existingAlert.remove();
    }
    
    if (fileInput.files && fileInput.files[0]) {
      // Size validation
      if (fileInput.files[0].size > maxSize) {
        // Create error alert
        alertDiv.className = 'alert alert-danger alert-dismissible fade show mt-2';
        alertDiv.innerHTML = `
          <div class="d-flex align-items-center">
            <i class="bx bx-error-circle me-2"></i>
            <strong>Error:</strong>&nbsp;Image size exceeds 2MB. Please choose a smaller file.
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        // Clear the file input
        fileInput.value = '';
      } else {
        // Dimension validation
        validateImageDimensions(fileInput.files[0], function(errorMessage) {
          alertDiv.className = 'alert alert-danger alert-dismissible fade show mt-2';
          alertDiv.innerHTML = `
            <div class="d-flex align-items-center">
              <i class="bx bx-error-circle me-2"></i>
              <strong>Error:</strong>&nbsp;${errorMessage}
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          `;
          
          // Clear the file input
          fileInput.value = '';
        });
      }
      
      // Insert alert after the file input container
      const alertContainer = document.createElement('div');
      alertContainer.className = 'w-100';
      alertContainer.appendChild(alertDiv);
      fileInput.parentNode.parentNode.insertBefore(alertContainer, fileInput.parentNode.nextSibling);
      
      // Auto-dismiss alert after 5 seconds
      setTimeout(() => {
        if (fileInput.parentNode.parentNode.querySelector('#sizeAlertAdditional')) {
          fileInput.parentNode.parentNode.querySelector('#sizeAlertAdditional').remove();
        }
      }, 5000);
    }
  }

  function addImageInput() {
    const container = document.createElement('div');
    container.className = 'd-flex mb-3';
    
    const inputField = document.createElement('input');
    inputField.type = 'file';
    inputField.name = 'aaditional_images[]';
    inputField.className = 'form-control';
    
    const trashIcon = document.createElement('i');
    trashIcon.className = 'menu-icon tf-icons bx bx-trash bg-warning text-white rounded p-2';
    trashIcon.style.cursor = 'pointer';
    trashIcon.style.marginLeft = '10px';
    trashIcon.style.height = '100%';
    
    trashIcon.addEventListener('click', function () {
      container.remove();
    });

    inputField.addEventListener('change', function() {
      validateImageSize(this);
    });

    container.appendChild(inputField);
    container.appendChild(trashIcon);
    
    document.getElementById('imageInputs').appendChild(container);
  }

document.querySelector('input[name="featured_image"]').addEventListener('change', function() {
    const fileInput = this;
    const maxSize = 2 * 1024 * 1024; // 2MB in bytes
    const alertDiv = document.createElement('div');
    alertDiv.id = 'sizeAlert';
    
    const existingAlert = document.getElementById('sizeAlert');
    if (existingAlert) {
        existingAlert.remove();
    }
    
    if (fileInput.files && fileInput.files[0]) {
        // Size validation
        if (fileInput.files[0].size > maxSize) {
            // Create error alert
            alertDiv.className = 'alert alert-danger alert-dismissible fade show mt-2';
            alertDiv.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="bx bx-error-circle me-2"></i>
                    <strong>Error:</strong>&nbsp;Image size exceeds 2MB. Please choose a smaller file.
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            
            // Clear the file input
            fileInput.value = '';
        } else {
            // Dimension validation
            validateImageDimensions(fileInput.files[0], function(errorMessage) {
                alertDiv.className = 'alert alert-danger alert-dismissible fade show mt-2';
                alertDiv.innerHTML = `
                    <div class="d-flex align-items-center">
                        <i class="bx bx-error-circle me-2"></i>
                        <strong>Error:</strong>&nbsp;${errorMessage}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
                
                // Clear the file input
                fileInput.value = '';
            });
        }
        
        // Insert alert after the file input
        fileInput.parentNode.insertBefore(alertDiv, fileInput.nextSibling);
        
        // Auto-dismiss alert after 5 seconds
        setTimeout(() => {
            if (document.getElementById('sizeAlert')) {
                document.getElementById('sizeAlert').remove();
            }
        }, 5000);
    }
});

document.querySelector('input[name="size_chart"]').addEventListener('change', function() {
    const fileInput = this;
    const maxSize = 2 * 1024 * 1024; // 2MB in bytes
    const alertDiv = document.createElement('div');
    alertDiv.id = 'sizeAlert';
    
 
    const existingAlert = document.getElementById('sizeAlert');
    if (existingAlert) {
        existingAlert.remove();
    }
    
    if (fileInput.files && fileInput.files[0]) {
        if (fileInput.files[0].size > maxSize) {
            // Create error alert
            alertDiv.className = 'alert alert-danger alert-dismissible fade show mt-2';
            alertDiv.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="bx bx-error-circle me-2"></i>
                    <strong>Error:</strong>&nbsp;Image size exceeds 2MB. Please choose a smaller file.
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            
            // Clear the file input
            fileInput.value = '';
        } else {
            // Dimension validation
            validateImageDimensions(fileInput.files[0], function(errorMessage) {
                alertDiv.className = 'alert alert-danger alert-dismissible fade show mt-2';
                alertDiv.innerHTML = `
                    <div class="d-flex align-items-center">
                        <i class="bx bx-error-circle me-2"></i>
                        <strong>Error:</strong>&nbsp;${errorMessage}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
                
                // Clear the file input
                fileInput.value = '';
            });
        }
        
        // Insert alert after the file input
        fileInput.parentNode.insertBefore(alertDiv, fileInput.nextSibling);
        
        // Auto-dismiss alert after 5 seconds
        setTimeout(() => {
            if (document.getElementById('sizeAlert')) {
                document.getElementById('sizeAlert').remove();
            }
        }, 5000);
    }
});


const hashtagInput = document.getElementById('hashtagInput');
const tagContainer = document.getElementById('tagContainer');
const hashtagsHidden = document.getElementById('hashtagsHidden');
let tags = [];

hashtagInput.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
      e.preventDefault();
      
      let tag = this.value.trim();
      if (tag && !tags.includes(tag)) {
        const tagElement = document.createElement('span');
        tagElement.className = 'rounded-2 px-2 py-1 d-inline-flex align-items-center';
        tagElement.style.fontSize = '14px';
        tagElement.style.color = 'white';
        tagElement.style.backgroundColor = '#5f61e6';
        tagElement.innerHTML = `
          ${tag}
          <span class="ms-1 fw-bold" role="button" style="cursor: pointer;" onclick="removeTag(this, '${tag}')">&times;</span>
        `;
        
        tagContainer.appendChild(tagElement);
        tags.push(tag);
        updateHiddenInput();
        this.value = '';
      }
    }
});

function removeTag(element, tag) {
    element.parentElement.remove();
    tags = tags.filter(t => t !== tag);
    updateHiddenInput();
}

function updateHiddenInput() {
    hashtagsHidden.value = tags.join(',');
}


  document.getElementById('addImage').addEventListener('click', function () {
    addImageInput();
});

function addImageInput() {
    const container = document.createElement('div');
    container.className = 'd-flex mb-3';
    
    const inputField = document.createElement('input');
    inputField.type = 'file';
    inputField.name = 'aaditional_images[]';
    inputField.className = 'form-control';
    
    const trashIcon = document.createElement('i');
    trashIcon.className = 'menu-icon tf-icons bx bx-trash bg-warning text-white rounded p-2';
    trashIcon.style.cursor = 'pointer';
    trashIcon.style.marginLeft = '10px';
    trashIcon.style.height = '100%';
    
    trashIcon.addEventListener('click', function () {
        container.remove();
    });

    container.appendChild(inputField);
    container.appendChild(trashIcon);
    
    document.getElementById('imageInputs').appendChild(container);
}


// CK Editor Scripts



// document.addEventListener("DOMContentLoaded", function() {
//     ClassicEditor
//       .create(document.querySelector('#editor'))
//       .then(editor => {
//         editor.model.document.on('change:data', () => {

//           document.querySelector('#general_info').value = editor.getData();
//         });
//       })
//       .catch(error => {
//         console.error(error);
//       });
//   });

    
  // document.addEventListener('DOMContentLoaded', function () {
  //     ClassicEditor
  //         .create(document.querySelector('#general_info'))
  //         .catch(error => {
  //             console.error(error);
  //         });
  //   });

  ClassicEditor
      .create(document.querySelector('#description'))
      .catch(error => {
          console.error(error);
      });

  // Variation Scripts

// Show 'Variation Options' div when 'Is Variations Available' checkbox is checked
document.getElementById('isVariationAvailable').addEventListener('change', function() {
  var variationOptions = document.getElementById('variationOptions');
  if (this.checked) {
    variationOptions.style.display = 'flex'; // Show the variation options
  } else {
    variationOptions.style.display = 'none'; // Hide the variation options
  }
});


function toggleOptions(optionClass, checkbox) {
    const element = document.querySelector(`.${optionClass}`);
    // Toggle the display of the options
    element.style.display = element.style.display === 'none' ? 'block' : 'none';

    // Handle the hidden input for the attribute ID based on the checkbox state
    const hiddenInputName = 'attribute_id[]'; // Name for the hidden input

    if (checkbox.checked) {
        // If checked, create and append the hidden input
        const attributeIdInput = document.createElement('input');
        attributeIdInput.type = 'hidden';
        attributeIdInput.name = hiddenInputName; // Use the same name to collect in a flat array
        attributeIdInput.value = checkbox.value; // Set the value to the checkbox's value (attribute ID)
        element.insertBefore(attributeIdInput, element.firstChild); // Insert the hidden input at the top of the row
    } else {
        // If unchecked, find and remove the existing hidden input
        const hiddenInput = element.querySelector(`input[type="hidden"][name="${hiddenInputName}"]`);
        if (hiddenInput) {
            hiddenInput.remove(); // Remove the hidden input if the checkbox is unchecked
        }
    }
}


  function addVariationRow(elem) {
    const row = elem.closest('.variationRow');
    const clone = row.cloneNode(true);

    // Change the icon to a remove icon in the cloned row
    const plusIcon = clone.querySelector('.bx-plus-circle');
    if (plusIcon) {
        plusIcon.classList.remove('bx-plus-circle');
        plusIcon.classList.add('bx-minus-circle');
        plusIcon.onclick = function() {
            clone.remove(); // Remove the cloned row when clicked
        };
    }

    // Clear the input values in the cloned row
    const inputs = clone.querySelectorAll('input');
    inputs.forEach(input => {
        input.value = ''; // Clear the input fields
        if (input.type === 'checkbox') {
            input.checked = false; // Uncheck checkboxes
        }
    });

    // Append the cloned row to the correct section
    const parentDiv = elem.closest('[class*="Options"]');
    if (parentDiv) { // Ensure parentDiv is not null
        const additionalRows = parentDiv.querySelector('.additionalVariationRows');
        additionalRows.appendChild(clone);
    } else {
        console.error('Parent div not found'); // Log an error if parentDiv is null
    }
}


// Ajax Call for dependedt Dropdown of categories and sub categories 

  $(document).ready(function(){
    $('#category').change(function(){
      var category_id = $(this).val();

      if (category_id != '') {
        $.ajax({
          url: 'getSubCategoriesByAjax.php', // Your PHP page that handles the AJAX request
          type: 'POST',
          data: {category_id_ajax: category_id},
          dataType: 'json',
          success: function(response) {
            console.log(response); // Log the response for debugging

            $('#subcategory').empty(); // Clear the existing options
            $('#subcategory').append('<option value="">--Select Sub-Category Name--</option>');

            if (response.status == 1 && response.count > 0) {
              // Loop through the id and name arrays and populate the dropdown
              for (var i = 0; i < response.count; i++) {
                if (response.statusval[i] == 1) {  // Check if the subcategory is active
                  $('#subcategory').append('<option value="'+response.id[i]+'">'+response.name[i]+'</option>');
                }
              }
            } else {
              console.log('No subcategories found');
            }
          },
          error: function(xhr, status, error) {
            console.log('Error:', error);
            console.log(xhr.responseText); // Log error response for debugging
          }
        });
      } else {
        $('#subcategory').empty();
        $('#subcategory').append('<option value="">--Select Sub-Category Name--</option>');
      }
    });
  });

</script>
<style>
.hashtag-container {
    border-radius: 4px;
    padding: 10px 0;
}

.hashtag-container span {
    margin: 2px;
    display: inline-flex;
    align-items: center;
}

.hashtag-container input {
    margin-top: 10px;
}

.img-thumbnail {
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 5px;
}
</style>









