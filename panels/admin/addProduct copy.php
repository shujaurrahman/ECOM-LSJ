<?php 
session_start();
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





if(!empty($_POST['student_id']) && !empty($_POST['name']) &&  !empty($_POST['email']) && !empty($_POST['domain'])  ){
    require_once('./logics.class.php');
    $adminObj = new logics();

    $verification = $adminObj->AddStudents($_POST['student_id'],$_POST['name'],$_POST['email'],$_POST['domain']);
    if(!empty($verification['status']) && $verification['status']==1){
        echo '<script src="../js/sweetalert.js"></script>';
        echo '<script>';
        echo 'Swal.fire({
                icon: "success",
                title: "Product Successfully Added!",
                showConfirmButton: true,
            }).then(function() {
                window.location.href = "addProduct";
            });';
        echo '</script>';
    }else{
        echo '<script src="../js/sweetalert.js"></script>';
        echo '<script>';
        echo 'Swal.fire({
                icon: "error",
                title: "Data not Submitted!",
                text: "Please try again"
            }).then(function() {
                window.location.href = "addProduct";
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
                <h5 class="card-title text-primary">Add New Product</h5>
                <a href="./getProducts.php" class="btn btn-sm btn-primary">View Added Products</a>
              </div>
            </div>
          
          </div>
        </div>
      </div>
    </div>

    <form action="./addProduct.php" method="post" enctype="multipart/form-data" class="row">
      
      <div class="col-lg-8 mb-4 order-0">
        <div class="card">
          <div class="card-body">
              <label for="category">Select Category</label>
              <select name="category_id" class="form-select mb-3" required id="category">
                  <option value="">--Select Category Name--</option>
                  <?php
                  for($i=0;$i<$categories['count'];$i++){
                    ?>
                    <option value="<?php echo $categories['id'][$i] ?>"><?php echo $categories['name'][$i] ?></option>
                    <?php
                  }
                  ?>
              </select>

              <label for="subcategory">Select Sub-Category</label>
              <select name="subcategory_id" class="form-select mb-3" required id="subcategory">
                  <option value="">--Select Sub-Category Name--</option>
                  <!-- <?php
                  for($i=0;$i<$subcategories['count'];$i++){
                    if($subcategories['statusval'][$i]==1){
                    ?>
                    <option value="<?php echo $subcategories['id'][$i] ?>"><?php echo $subcategories['name'][$i] ?></option>
                    <?php
                    }
                  }
                  ?> -->
              </select>

              <label for="product_name">Product Name</label>
              <input type="text" name="product_name" placeholder="Enter Product Name"  class="form-control mb-3" required  id="product_name">

          </div>
        </div>
      </div>

      <div class="col-lg-4 mb-4 order-0">
        <div class="card">
          <div class="card-body">

            <div class="d-flex justify-content-between mb-4">
              <label for="category">Lakshmi Kubera?</label>
                <div class="checkbox-wrapper-34 ">
                  <input class="tgl tgl-ios" id="toggle-34" type="checkbox" name="is_lakshmi_kubera" />
                  <label class="tgl-btn" for="toggle-34"></label>
                </div>
            </div>

            <div class="d-flex justify-content-between mb-4">
              <label for="category">Popular Collection?</label>
                <div class="checkbox-wrapper-34 ">
                  <input class="tgl tgl-ios" id="toggle-35" type="checkbox" name="is_popular_collection" />
                  <label class="tgl-btn" for="toggle-35"></label>
                </div>
            </div>

            <div class="d-flex justify-content-between mb-4">
              <label for="category">Recommended?</label>
                <div class="checkbox-wrapper-34 ">
                  <input class="tgl tgl-ios" id="toggle-36" type="checkbox" name="is_recommended" />
                  <label class="tgl-btn" for="toggle-36"></label>
                </div>
            </div>

            <label for="stock">Available Stock</label>
            <input type="number" name="stock" placeholder="Enter Stock Quantity"  class="form-control mb-3" required  id="stock">

          </div>
        </div>
      </div>

      <div class="col-lg-12 mb-4 order-0">
        <div class="card">
          <div class="card-body">
              <label for="featured_image">Add Featured Image</label>
              <input type="file" name="featured_image" placeholder="Enter Stock Quantity"  class="form-control mb-3" required  id="stock">


              <label for="category">Add Additional Images</label>
              <div class="d-flex">
                <input type="file" name="aaditional_images[]" placeholder="Enter Stock Quantity" class="form-control mb-3" required id="stock">
                <i class="menu-icon tf-icons bx bx-plus-circle bg-primary text-white rounded p-2" id="addImage" style="cursor: pointer; margin-left: 10px; height:100%"></i>
              </div>
              <div id="imageInputs"></div>


              <div class="row">
                <div class="col-lg-4">
                  <label for="ornament_type">Select Ornament Type</label>
                  <select name="ornament_type" class="form-select mb-3" required id="ornament_type">
                      <option value="">--Select ornament_type--</option>
                      <?php
                      for($i=0;$i<$ornaments['count'];$i++){
                        ?>
                        <option value="<?php echo $ornaments['id'][$i] ?>"><?php echo $ornaments['name'][$i] ?></option>
                        <?php
                      }
                      ?>
                  </select>
                </div>
                <div class="col-lg-4">
                  <label for="ornament_weight">Ornament Weight</label>
                  <input type="number" name="ornament_weight" placeholder="Enter Ornament Weight (In Grams)" class="form-control mb-3" required id="ornament_weight" step="0.01">
                </div>

                <div class="col-lg-4">
                  <label for="discounted_percentage">Discounted Percentage</label>
                  <input type="number" name="discounted_percentage" placeholder="Enter Discounted Percentage"  class="form-control mb-3" required  id="discounted_percentage">
                </div>
              </div>

              <label for="short_description">Short Description</label>
              <input type="text" name="short_description" placeholder="Enter Short Description"  class="form-control mb-3" required  id="short_description">

              <label for="short_description">Select Features</label>
              <div class="d-flex mb-3">

              <?php
                for($i=0;$i<$features['count'];$i++){
                  ?>
                  <div class="checkbox-wrapper-16 px-2">
                    <label class="checkbox-wrapper">
                      <input type="checkbox" name="features[]" value="<?php echo $features['id'][$i] ?>" required class="checkbox-input" />
                      <span class="checkbox-tile">
                        <span class="checkbox-icon">
                          <img src="./feature/<?php echo $features['image'][$i] ?>" width="40px" alt="">
                        </span>
                        <span class="checkbox-label"><?php echo $features['name'][$i] ?></span>
                      </span>
                    </label>
                  </div>
                  
                  <?php
                }
                ?>

                

                <!-- <div class="checkbox-wrapper-16 px-2">
                  <label class="checkbox-wrapper">
                    <input type="checkbox" name="features[]" value="2" required class="checkbox-input" />
                    <span class="checkbox-tile">
                      <span class="checkbox-icon">
                        <img src="../../images/exchange.png" width="40px" alt="">
                      </span>
                      <span class="checkbox-label">Easy Exhange</span>
                    </span>
                  </label>
                </div> -->

              </div>


              <!-- Is Variations Available Checkbox -->
              <div class="checkbox-wrapper-33 py-2">
                <label class="checkbox">
                  <input class="checkbox__trigger visuallyhidden" name="variations" type="checkbox" id="isVariationAvailable" />
                  <span class="checkbox__symbol">
                    <svg aria-hidden="true" class="icon-checkbox" width="28px" height="28px" viewBox="0 0 28 28" version="1" xmlns="http://www.w3.org/2000/svg">
                      <path d="M4 14l8 7L24 7"></path>
                    </svg>
                  </span>
                  <p class="checkbox__textwrapper">Is Variations Available?</p>
                </label>
              </div>

              <!-- Hidden Variation Options -->
              <div class="row" id="variationOptions" style="display: none;">
              <?php
                for($i=0;$i<$attributes['count'];$i++){
                  ?>
                    <div class="row">
                      <div class="col-lg-3">
                        <div class="checkbox-wrapper-33 mt-4 py-2">
                          <label class="checkbox">
                            <input class="checkbox__trigger visuallyhidden" type="checkbox" onchange="toggleOptions('<?php echo $attributes['name'][$i].'Options' ?>')" value="<?php echo $attributes
                            ['id'][$i] ?>" />
                            <span class="checkbox__symbol">
                              <svg aria-hidden="true" class="icon-checkbox" width="28px" height="28px" viewBox="0 0 28 28" version="1" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 14l8 7L24 7"></path>
                              </svg>
                            </span>
                            <p class="checkbox__textwrapper"><?php echo $attributes
                            ['name'][$i] ?></p>
                          </label>
                        </div>
                      </div>
                      <div class="col-lg-9 <?php echo $attributes['name'][$i].'Options' ?>" style="display: none;">
                        <div class="row variationRow">
                          <div class="col-lg-6">
                            <div class="row">
                              <div class="col-6">
                                <label>Variation Name</label>
                                <input type="text" name="variation_name[]" placeholder="Enter Variation Name" class="form-control mb-3" required>
                              </div>
                              <div class="col-6">
                                <label>Is Same Price</label>
                                <div class="checkbox-wrapper-33 py-2">
                                  <label class="checkbox">
                                    <input class="checkbox__trigger visuallyhidden" type="checkbox" />
                                    <span class="checkbox__symbol">
                                      <svg aria-hidden="true" class="icon-checkbox" width="28px" height="28px" viewBox="0 0 28 28" version="1" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4 14l8 7L24 7"></path>
                                      </svg>
                                    </span>
                                    <p class="checkbox__textwrapper">Same Price</p>
                                  </label>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="row">
                              <div class="col-6">
                                <label>Ornament Weight</label>
                                <input type="number" name="variation_ornament_weight[]" placeholder="Enter Ornament Weight" class="form-control mb-3" required>
                              </div>
                              <div class="col-6">
                                <label>Discounted Percentage</label>
                                <div class="d-flex">
                                  <input type="number" name="variation_discounted_percentage[]" placeholder="Enter Discount Percentage" class="form-control mb-3" required>
                                  <i class="menu-icon tf-icons bx bx-plus-circle bg-primary text-white rounded p-2" style="cursor: pointer; margin-left: 10px; height: 100%;" onclick="addVariationRow(this)"></i>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="additionalVariationRows"></div>
                      </div>
                    </div>
                  <?php

                }
                  ?>

                <div class="row">
                  <div class="col-lg-3">
                    <div class="checkbox-wrapper-33 mt-4 py-2">
                      <label class="checkbox">
                        <input class="checkbox__trigger visuallyhidden" type="checkbox" onchange="toggleOptions('colorOptions')" />
                        <span class="checkbox__symbol">
                          <svg aria-hidden="true" class="icon-checkbox" width="28px" height="28px" viewBox="0 0 28 28" version="1" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 14l8 7L24 7"></path>
                          </svg>
                        </span>
                        <p class="checkbox__textwrapper">Color</p>
                      </label>
                    </div>
                  </div>
                  <div class="col-lg-9 colorOptions" style="display: none;">
                    <div class="row variationRow">
                      <div class="col-lg-6">
                        <div class="row">
                          <div class="col-6">
                            <label>Variation Name</label>
                            <input type="text" name="variation_name[]" placeholder="Enter Variation Name" class="form-control mb-3" required>
                          </div>
                          <div class="col-6">
                            <label>Is Same Price</label>
                            <div class="checkbox-wrapper-33 py-2">
                              <label class="checkbox">
                                <input class="checkbox__trigger visuallyhidden" type="checkbox" />
                                <span class="checkbox__symbol">
                                  <svg aria-hidden="true" class="icon-checkbox" width="28px" height="28px" viewBox="0 0 28 28" version="1" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4 14l8 7L24 7"></path>
                                  </svg>
                                </span>
                                <p class="checkbox__textwrapper">Same Price</p>
                              </label>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="row">
                          <div class="col-6">
                            <label>Ornament Weight</label>
                            <input type="number" name="variation_ornament_weight[]" placeholder="Enter Ornament Weight" class="form-control mb-3" required>
                          </div>
                          <div class="col-6">
                            <label>Discounted Percentage</label>
                            <div class="d-flex">
                              <input type="number" name="variation_discounted_percentage[]" placeholder="Enter Discount Percentage" class="form-control mb-3" required>
                              <i class="menu-icon tf-icons bx bx-plus-circle bg-primary text-white rounded p-2" style="cursor: pointer; margin-left: 10px; height: 100%;" onclick="addVariationRow(this)"></i>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="additionalVariationRows"></div>
                  </div>
                </div>
                <!-- Size Section -->
                <div class="row">
                  <div class="col-lg-3">
                    <div class="checkbox-wrapper-33 mt-4 py-2">
                      <label class="checkbox">
                        <input class="checkbox__trigger visuallyhidden" type="checkbox" onchange="toggleOptions('sizeOptions')" />
                        <span class="checkbox__symbol">
                          <svg aria-hidden="true" class="icon-checkbox" width="28px" height="28px" viewBox="0 0 28 28" version="1" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 14l8 7L24 7"></path>
                          </svg>
                        </span>
                        <p class="checkbox__textwrapper">Size</p>
                      </label>
                    </div>
                  </div>
                  <div class="col-lg-9 sizeOptions" style="display: none;">
                    <div class="row variationRow">
                      <div class="col-lg-6">
                        <div class="row">
                          <div class="col-6">
                            <label>Variation Name</label>
                            <input type="text" name="variation_name[]" placeholder="Enter Variation Name" class="form-control mb-3" required>
                          </div>
                          <div class="col-6">
                            <label>Is Same Price</label>
                            <div class="checkbox-wrapper-33 py-2">
                              <label class="checkbox">
                                <input class="checkbox__trigger visuallyhidden" type="checkbox" />
                                <span class="checkbox__symbol">
                                  <svg aria-hidden="true" class="icon-checkbox" width="28px" height="28px" viewBox="0 0 28 28" version="1" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4 14l8 7L24 7"></path>
                                  </svg>
                                </span>
                                <p class="checkbox__textwrapper">Same Price</p>
                              </label>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="row">
                          <div class="col-6">
                            <label>Actual Price</label>
                            <input type="number" name="variation_actual_price[]" placeholder="Enter Price" class="form-control mb-3" required>
                          </div>
                          <div class="col-6">
                            <label>Discounted Price</label>
                            <div class="d-flex">
                              <input type="number" name="variation_discounted_price[]" placeholder="Enter Price" class="form-control mb-3" required>
                              <i class="menu-icon tf-icons bx bx-plus-circle bg-primary text-white rounded p-2" style="cursor: pointer; margin-left: 10px; height: 100%;" onclick="addVariationRow(this)"></i>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="additionalVariationRows"></div>
                  </div>
                </div>
                <!-- Size Section -->
                <div class="row">
                  <div class="col-lg-3">
                    <div class="checkbox-wrapper-33 mt-4 py-2">
                      <label class="checkbox">
                        <input class="checkbox__trigger visuallyhidden" type="checkbox" onchange="toggleOptions('newOptions')" />
                        <span class="checkbox__symbol">
                          <svg aria-hidden="true" class="icon-checkbox" width="28px" height="28px" viewBox="0 0 28 28" version="1" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 14l8 7L24 7"></path>
                          </svg>
                        </span>
                        <p class="checkbox__textwrapper">Size</p>
                      </label>
                    </div>
                  </div>
                  <div class="col-lg-9 newOptions" style="display: none;">
                    <div class="row variationRow">
                      <div class="col-lg-6">
                        <div class="row">
                          <div class="col-6">
                            <label>Variation Name</label>
                            <input type="text" name="variation_name[]" placeholder="Enter Variation Name" class="form-control mb-3" required>
                          </div>
                          <div class="col-6">
                            <label>Is Same Price</label>
                            <div class="checkbox-wrapper-33 py-2">
                              <label class="checkbox">
                                <input class="checkbox__trigger visuallyhidden" type="checkbox" />
                                <span class="checkbox__symbol">
                                  <svg aria-hidden="true" class="icon-checkbox" width="28px" height="28px" viewBox="0 0 28 28" version="1" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4 14l8 7L24 7"></path>
                                  </svg>
                                </span>
                                <p class="checkbox__textwrapper">Same Price</p>
                              </label>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="row">
                          <div class="col-6">
                            <label>Actual Price</label>
                            <input type="number" name="variation_actual_price[]" placeholder="Enter Price" class="form-control mb-3" required>
                          </div>
                          <div class="col-6">
                            <label>Discounted Price</label>
                            <div class="d-flex">
                              <input type="number" name="variation_discounted_price[]" placeholder="Enter Price" class="form-control mb-3" required>
                              <i class="menu-icon tf-icons bx bx-plus-circle bg-primary text-white rounded p-2" style="cursor: pointer; margin-left: 10px; height: 100%;" onclick="addVariationRow(this)"></i>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="additionalVariationRows"></div>
                  </div>
                </div> 
              </div>      
          </div>
        </div>
      </div>

      <div class="col-lg-12 mb-4 order-0">
        <div class="card">
          <div class="card-body">
            <span>General Info</span>
            <hr>
            <textarea name="general_info" class="form-control mb-3" rows="10" required id="general_info"></textarea>
          </div>
        </div>
      </div>

      <div class="col-lg-12 mb-4 order-0">
        <div class="card">
          <div class="card-body">
            <span>Description</span>
            <hr>
            <textarea name="description" class="form-control mb-3" rows="10" required id="description"></textarea>

            <br>
            <input type="submit" name="submit" value="Add Product" class="btn btn-primary" id="">
          </div>
        </div>
      </div>

    </form>
      
    
  </div>
  
<!-- / Content -->

<?php 
require_once('footer.php');
}else{
  header('location:login.php');
}
?>

<script src="../js/ckeditor.js"></script>
<script>
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
  ClassicEditor
      .create(document.querySelector('#general_info'))
      .catch(error => {
          console.error(error);
      });

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


  function toggleOptions(optionClass) {
    const element = document.querySelector(`.${optionClass}`);
    element.style.display = element.style.display === 'none' ? 'block' : 'none';
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









            