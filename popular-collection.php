<?php
session_start();
require_once('./header.php');

$slug = $_GET['name'];
$slug = str_replace('-', ' ', $slug);
$slug = ucwords($slug);

$productsBySubCatId = $Obj->getProductBySubCatId($_GET['id']);

// echo $productsBySubCatId['lakshmi_kubera_count']."LK count";
// echo $productsBySubCatId['max_weight']."dfsf";
// echo $productsBySubCatId['highest_product_price'];
// print_r($productsBySubCatId['ornament_counts']);
// echo "<br>";
// print_r($productsBySubCatId['weight_ranges']);

?>



    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="#">Home</a>
                    <a class="breadcrumb-item text-dark" href="#">Products</a>
                    <span class="breadcrumb-item active"><?php echo $slug ?></span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-4">
                <!-- Price Start -->
                  <!-- Special Start -->
                  <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Special</span></h5>
                  <div class="bg-light p-4 mb-30">
                      <form>
                          <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                              <input type="checkbox" class="custom-control-input" id="lakshmi-kubera" />
                              <label class="custom-control-label" for="lakshmi-kubera">Lakshmi Kubera Scheme</label>
                              <span class="badge border font-weight-normal"><?php echo $productsBySubCatId['lakshmi_kubera_count']; ?></span>
                          </div>
                      </form>
                  </div>
                  <!-- Special End -->

                <!-- Price End -->
                
                <!-- Price Start -->
                <h5 class="section-title position-relative text-uppercase mb-3">
                    <span class="bg-secondary pr-3">Filter by Price</span>
                </h5>
                <div class="bg-light p-4 mb-30">

                    <div class="d-flex justify-content-between">
                    <p class="font-weight-bold">Price</p>
                    <a href="product-listing?id=<?php echo $_GET['id'] ?>&name=<?php echo $_GET['name'] ?>">
                    <i class="fa fa-undo mx-1"></i>Reset all filters</a>

                    </div>

                    <!-- Price Range Slider -->
                    <div id="priceRangeSlider" style="margin: 20px 0;"></div>

                    <!-- Min and Max Input Boxes -->
                    <form method="get" class="d-flex justify-content-between mt-2">
                            <input type="number" name="minPrice" id="minPrice" class="form-control mr-2" readonly placeholder="Min Price"  />
                            <input type="number" name="maxPrice" id="maxPrice" class="form-control ml-2" readonly placeholder="Max Price"  />

                        <!-- <input type="submit" value="Go" class="px-2 text-light rounded border-0 bg-info mx-2" name="" id=""> -->
                    </form>
                </div>
                <!-- Price End -->





                  <!-- Size Start -->
                  <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by Type</span></h5>
                  <div class="bg-light p-4 mb-30">
                      <form method="get" action="">
                          <?php 
                          // Assuming $productsBySubCatId['ornament_counts'] is an array like:
                          // Array ( [0] => Array ( [0] => GOLD - 22K [1] => 1 ) [1] => Array ( [0] => PLATINUM [1] => 2 ) )
                          
                          foreach ($productsBySubCatId['ornament_counts'] as $ornament) {
                              // Get the ornament type and count
                              $ornamentType = $ornament[0]; // e.g., "GOLD - 22K"
                              $ornamentCount = $ornament[1]; // e.g., 1

                              // Check if the ornament type is selected from the URL parameters
                              $selected = isset($_GET['filter_type']) && is_array($_GET['filter_type']) && in_array($ornamentType, $_GET['filter_type']) ? 'checked' : '';
                          ?>
                              <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                  <input type="checkbox" class="custom-control-input" id="size-<?php echo strtolower(str_replace(' ', '-', $ornamentType)); ?>" name="filter_type[]" value="<?php echo $ornamentType; ?>" <?php echo $selected; ?>>
                                  <label class="custom-control-label" for="size-<?php echo strtolower(str_replace(' ', '-', $ornamentType)); ?>">
                                      <?php echo $ornamentType; ?>
                                  </label>
                                  <span class="badge border font-weight-normal"><?php echo $ornamentCount; ?></span>
                              </div>
                          <?php } ?>
                          <button type="submit" style="display: none;"></button> <!-- Hidden submit button for form submission on checkbox change -->
                      </form>
                  </div>
                  <!-- Size End -->





                <!-- Size Start -->
                <?php
                // Example data from PHP
                $weightRanges = $productsBySubCatId['weight_ranges']; // Example array
                ?>

                <!-- Size Start -->
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3 d-none">Filter by Weight Range</span></h5>
                <div class="bg-light p-4 mb-30 d-none">
                    <form>
                        <?php foreach ($weightRanges as $range): ?>
                            <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                <input type="checkbox" class="custom-control-input" value="<?= $range[0] ?>-<?= $range[1] ?>" id="weight-<?= $range[0] ?>-<?= $range[1] ?>" />
                                <label class="custom-control-label" for="weight-<?= $range[0] ?>-<?= $range[1] ?>"> <?= $range[0] ?> - <?= $range[1] ?>G </label>
                                <!-- <span class="badge border font-weight-normal"><?= rand(100, 1000) // Dummy value for counts ?></span> -->
                            </div>
                        <?php endforeach; ?>
                    </form>
                </div>
                <!-- Size End -->


            </div>
            <!-- Shop Sidebar End -->

            
            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-8">
              <div class="row pb-3">
                <div class="col-12 pb-1">
                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                      <button id="gridView" class="btn btn-sm btn-light active"><i class="fa fa-th-large"></i></button>
                      <button id="listView" class="btn btn-sm btn-light ml-2 d-none"><i class="fa fa-bars"></i></button>
                    </div>
                    <div class="ml-2">
                      <div class="btn-group">
                        
                      <form method="GET" id="sortForm">
                        <select name="sort" class="form-control" id="sortSelect" onchange="updateUrlAndSubmit()">
                          <option value="">Sort By</option>
                          <option value="newest" <?php if(!empty($_GET['sort']) && $_GET['sort']=='newest'){ echo "selected"; } ?>>newest</option>
                          <option value="oldest" <?php if(!empty($_GET['sort']) && $_GET['sort']=='oldest'){ echo "selected"; } ?>>oldest</option>
                          <option value="low-high" <?php if(!empty($_GET['sort']) && $_GET['sort']=='low-high'){ echo "selected"; } ?>>Lowest Price</option>
                          <option value="high-low" <?php if(!empty($_GET['sort']) && $_GET['sort']=='high-low'){ echo "selected"; } ?>>Highest Price</option>
                        </select>
                      </form>



                      </div>
                    </div>
                  </div>
                </div>
                </div>
                <div class="row grid-view">
  <?php
  if ($productsBySubCatId['count'] != 0) {
      for ($i = 0; $i < $productsBySubCatId['count']; $i++) {
          if ($productsBySubCatId['statusval'][$i] == 1) {
              $showProduct = true; // Default to showing the product




              // Filter for Lakshmi Kubera
              if (!empty($_GET['lakshmi-kubera']) && $_GET['lakshmi-kubera'] === 'on') {
                  // Show only products where `is_lakshmi_kubera` is `1`
                  if ($productsBySubCatId['is_lakshmi_kubera'][$i] != 1) {
                      $showProduct = false; // Exclude product if not Lakshmi Kubera
                    //   echo $productsBySubCatId['is_lakshmi_kubera'][$i]."temnbmb ad as a sf asf".$_GET['lakshmi-kubera'];
                  }
              }


// Sorting Logic
if (!empty($_GET['sort'])) {
    $sortedIndices = array_keys($productsBySubCatId['created_at']); // Indices for sorting

    switch ($_GET['sort']) {
        case 'newest':
            // Sort indices by descending order of `created_at`
            usort($sortedIndices, function ($a, $b) use ($productsBySubCatId) {
                return strtotime($productsBySubCatId['created_at'][$b]) - strtotime($productsBySubCatId['created_at'][$a]);
            });
            break;

        case 'oldest':
            // Sort indices by ascending order of `created_at`
            usort($sortedIndices, function ($a, $b) use ($productsBySubCatId) {
                return strtotime($productsBySubCatId['created_at'][$a]) - strtotime($productsBySubCatId['created_at'][$b]);
            });
            break;

        case 'low-high':
            // Sort indices by ascending order of `discounted_price`
            usort($sortedIndices, function ($a, $b) use ($productsBySubCatId) {
                return $productsBySubCatId['discounted_price'][$a] - $productsBySubCatId['discounted_price'][$b];
            });
            break;

        case 'high-low':
            // Sort indices by descending order of `discounted_price`
            usort($sortedIndices, function ($a, $b) use ($productsBySubCatId) {
                return $productsBySubCatId['discounted_price'][$b] - $productsBySubCatId['discounted_price'][$a];
            });
            break;

        default:
            // Invalid sort parameter, do nothing or handle as needed
            break;
    }

    // Reorder the $productsBySubCatId array based on the sorted indices
    foreach ($productsBySubCatId as $key => $values) {
        if (is_array($values)) {
            $productsBySubCatId[$key] = array_map(function ($index) use ($values) {
                return $values[$index] ?? null; // Avoid undefined key warning
            }, $sortedIndices);
        }
    }
}



              
// Filter for Multiple Types (filter_type[])
if (!empty($_GET['filter_type']) && is_array($_GET['filter_type'])) {
    $selectedTypes = $_GET['filter_type'];

    // If the array has only one value and that value is 'on', do nothing
    if (count($selectedTypes) === 1 && $selectedTypes[0] === 'on') {
        // echo "inside the price range -------------";
    } else {
        // Remove 'on' from the array if it exists and proceed with the rest
        $selectedTypes = array_diff($selectedTypes, ['on']); 

        // Example product type logic
        $productType = $productsBySubCatId['ornament_type'][$i] ?? null;

        if ($productType !== null) {
            // echo "inside the price range";

            // Check if product type is not in the remaining selected types
            if (!in_array($productType, $selectedTypes)) {
                $showProduct = false;
            }
        }
    }
}


              // Filter for Price Range (minPrice and maxPrice)
              if (isset($_GET['minPrice']) && isset($_GET['maxPrice'])) {
                  $minPrice = (int) $_GET['minPrice'];
                  $maxPrice = (int) $_GET['maxPrice'];

                  

                  if ($productsBySubCatId['discounted_price'][$i] < $minPrice || $productsBySubCatId['discounted_price'][$i] > $maxPrice) {
                      $showProduct = false; // Exclude product if price is out of range
                  }
              }

              

            //   echo $showProduct."the value of status";

              // Add more filters here as needed...

              if ($showProduct) {
                  ?>
                  <div class="col-lg-4 col-md-4 col-sm-6 pb-1 product-item productContainer gridViewContainer">
                      <!-- Grid View Container -->
                      <div class="product-item bg-light mb-4 ">
                          <div class="product-img position-relative overflow-hidden">
                              <img class="img-fluid w-100" src="./panels/admin/product/<?php echo $productsBySubCatId['featured_image'][$i]; ?>" style="height: 300px;" alt="">
                              <div class="product-action">
                                  <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                  <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                                  <a class="btn btn-outline-dark btn-square" href="./product-view?slug=<?php echo $productsBySubCatId['slug'][$i] ?>"><i class="fa fa-eye"></i></a>
                              </div>
                          </div>
                          <div class="text-center py-4">
                              <a class="h6 text-decoration-none text-truncate" href="./product-view?slug=<?php echo $productsBySubCatId['slug'][$i] ?>"><?php echo $productsBySubCatId['product_name'][$i]; ?></a>
                              <div class="d-flex align-items-center justify-content-center mt-2">
                                  <h5 class="font-weight-bold mr-2">₹<?php echo number_format(floor($productsBySubCatId['discounted_price'][$i])); ?></h5>
                                  <small class="text-muted ml-2"><del>₹<?php echo number_format(floor($productsBySubCatId['actual_price'][$i])); ?></del></small>
                              </div>
                              <span class="font-weight-bold"><small class="text-danger">Save <?php echo $productsBySubCatId['discount_percentage'][$i]; ?>% on </small><?php echo $productsBySubCatId['ornament_weight'][$i]; ?>g</span>
                          </div>
                      </div>
                  </div>
                  <?php
              }
          }
      }
  } else {
      echo "NO Products Found";
  }
  ?>
</div>


                

              </div>
            </div>
            <!-- Shop Product End -->





        </div>
    </div>
    <!-- Shop End -->

    <?php
require_once('./footer.php');
?>

  <!-- Include the noUiSlider library -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.6.1/nouislider.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.6.1/nouislider.min.css">

<script>
    // Initialize the price range slider
    var priceSlider = document.getElementById('priceRangeSlider');

    // Set the highest product price dynamically from the PHP variable `highest_product_price`
    var highestProductPrice = <?php echo $productsBySubCatId['highest_product_price']; ?>;

    // Get the min and max values from the URL or use default values if not set
    var urlParams = new URLSearchParams(window.location.search);
    var minPriceFromUrl = parseInt(urlParams.get('minPrice')) || 0;
    var maxPriceFromUrl = parseInt(urlParams.get('maxPrice')) || highestProductPrice;

    // Create the price slider with dynamic max value
    noUiSlider.create(priceSlider, {
        start: [minPriceFromUrl, maxPriceFromUrl],  // Start positions based on URL or default values
        connect: true,                            // Connect the two handles with a shaded area
        range: {
            'min': 0,                             // Minimum price
            'max': highestProductPrice           // Maximum price based on the highest product price
        },
        step: 10                                  // Increment step
    });

    // Link the slider to the input fields
    priceSlider.noUiSlider.on('update', function (values, handle) {
        if (handle === 0) {
            document.getElementById('minPrice').value = Math.round(values[0]);
        } else {
            document.getElementById('maxPrice').value = Math.round(values[1]);
        }
    });

    // Update the slider when the input fields are changed
    document.getElementById('minPrice').addEventListener('change', function () {
        var minVal = parseInt(this.value);
        var currentMax = parseInt(document.getElementById('maxPrice').value);

        // Ensure min value is less than max value
        if (minVal >= currentMax) {
            minVal = currentMax - 1;  // Prevent min from being greater than or equal to max
            document.getElementById('minPrice').value = minVal;
        }

        priceSlider.noUiSlider.set([minVal, currentMax]);
    });

    document.getElementById('maxPrice').addEventListener('change', function () {
        var maxVal = parseInt(this.value);
        var currentMin = parseInt(document.getElementById('minPrice').value);

        // Ensure max value is greater than min value
        if (maxVal <= currentMin) {
            maxVal = currentMin + 1;  // Prevent max from being less than or equal to min
            document.getElementById('maxPrice').value = maxVal;
        }

        priceSlider.noUiSlider.set([currentMin, maxVal]);
    });

    // Add onchange functionality to the slider (on change, update the URL)
    priceSlider.noUiSlider.on('change', function () {
        const form = document.querySelector('form');
        const minPrice = document.getElementById('minPrice').value;
        const maxPrice = document.getElementById('maxPrice').value;

        // Construct the new URL with the updated query parameters
        const url = new URL(window.location.href);
        url.searchParams.set('minPrice', minPrice);
        url.searchParams.set('maxPrice', maxPrice);

        // Update the browser's URL without reloading the page
        window.history.pushState({}, '', url);

        // Simulate form submission by programmatically navigating to the new URL
        window.location.href = url.toString();
    });
</script>


<script>
  function updateUrlAndSubmit() {
    const select = document.getElementById('sortSelect');
    const selectedValue = select.value;

    // Get the current URL
    const currentUrl = new URL(window.location.href);
    const params = currentUrl.searchParams;

    // Update or add the sort parameter
    if (selectedValue) {
      params.set('sort', selectedValue);
    } else {
      params.delete('sort'); // Remove the sort parameter if no value is selected
    }

    // Construct the updated URL
    const updatedUrl = currentUrl.origin + currentUrl.pathname + '?' + params.toString();

    // Redirect to the updated URL
    window.location.href = updatedUrl;
  }
</script>


<script>
    document.addEventListener('DOMContentLoaded', () => {
  const gridViewBtn = document.getElementById('gridView');
  const listViewBtn = document.getElementById('listView');
  const productItems = document.querySelectorAll('.productContainer');
  const listViewContainers = document.querySelectorAll('.listViewContainer');
  const gridViewContainers = document.querySelectorAll('.gridViewContainer');

  // Event listener for grid view
  gridViewBtn.addEventListener('click', () => {
    // Show grid view containers and hide list view containers
    gridViewContainers.forEach((container) => {
      container.classList.remove('d-none');
    });
    listViewContainers.forEach((container) => {
      container.classList.add('d-none');
    });

    // Adjust product items to show 3 per row (col-lg-4)
    productItems.forEach((item) => {
      item.classList.remove('col-lg-12');
      item.classList.add('col-lg-4');
    });

    // Update active button styles
    gridViewBtn.classList.add('active');
    listViewBtn.classList.remove('active');
  });

  // Event listener for list view
  listViewBtn.addEventListener('click', () => {
    // Show list view containers and hide grid view containers
    listViewContainers.forEach((container) => {
      container.classList.remove('d-none');
    });
    gridViewContainers.forEach((container) => {
      container.classList.add('d-none');
    });

    // Adjust product items to show 1 per row (col-lg-12)
    productItems.forEach((item) => {
      item.classList.remove('col-lg-4');
      item.classList.add('col-lg-12');
    });

    // Update active button styles
    listViewBtn.classList.add('active');
    gridViewBtn.classList.remove('active');
  });
});

</script>


<!-- Filter By Weight Checkbox  -->
<script>
  // When a checkbox is clicked
document.querySelectorAll('.custom-control-input').forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {
        // Get the current URL
        var url = new URL(window.location.href);

        // Get the value of the checkbox (e.g., "0-7")
        var value = this.value;

        // Get all current selected filter values from the URL
        var filterWeightParams = url.searchParams.getAll('filter_weight[]');

        if (this.checked) {
            // Add the value to the filter_weight[] array if checked
            filterWeightParams.push(value);
        } else {
            // Remove the value if unchecked
            filterWeightParams = filterWeightParams.filter(function(item) {
                return item !== value;
            });
        }

        // Remove the existing filter_weight[] params from the URL
        url.searchParams.delete('filter_weight[]');

        // Append all the selected filter values back to the URL
        filterWeightParams.forEach(function(param) {
            url.searchParams.append('filter_weight[]', param);
        });

        // Update the browser's URL without reloading the page
        window.history.pushState({}, '', url);

        // Refresh the page to reflect the changes
        window.location.reload();
    });
});

// Function to maintain the checkbox state based on URL on page load or refresh
function updateCheckboxStates() {
    // Get the selected filter weights from the URL
    var url = new URL(window.location.href);
    var filterWeights = url.searchParams.getAll('filter_weight[]');

    // Check the checkboxes that match the filter_weights in the URL
    document.querySelectorAll('.custom-control-input').forEach(function(checkbox) {
        if (filterWeights.includes(checkbox.value)) {
            checkbox.checked = true; // Check the box if its value is in the URL
        } else {
            checkbox.checked = false; // Uncheck if its value is not in the URL
        }
    });
}

// Run this function when the page loads to maintain the state of checkboxes
window.onload = updateCheckboxStates;

</script>

<!-- Filter by Type  -->

<script>
  document.querySelectorAll('.custom-control-input').forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {
        // Get the current URL
        var url = new URL(window.location.href);

        // Get the value of the checkbox (e.g., "GOLD - 22K")
        var value = this.value;

        // Get all current selected filter values from the URL
        var filterTypeParams = url.searchParams.getAll('filter_type[]');

        if (this.checked) {
            // Add the value to the filter_type[] array if checked
            filterTypeParams.push(value);
        } else {
            // Remove the value if unchecked
            filterTypeParams = filterTypeParams.filter(function(item) {
                return item !== value;
            });
        }

        // Remove the existing filter_type[] params from the URL
        url.searchParams.delete('filter_type[]');

        // Append all the selected filter values back to the URL
        filterTypeParams.forEach(function(param) {
            url.searchParams.append('filter_type[]', param);
        });

        // Update the browser's URL without reloading the page
        window.history.pushState({}, '', url);

        // Refresh the page to reflect the changes
        window.location.reload();
    });
});

// Function to maintain the checkbox state based on URL on page load or refresh
function updateCheckboxStates() {
    // Get the selected filter types from the URL
    var url = new URL(window.location.href);
    var filterTypes = url.searchParams.getAll('filter_type[]');

    // Check the checkboxes that match the filter_types in the URL
    document.querySelectorAll('.custom-control-input').forEach(function(checkbox) {
        if (filterTypes.includes(checkbox.value)) {
            checkbox.checked = true; // Check the box if its value is in the URL
        } else {
            checkbox.checked = false; // Uncheck if its value is not in the URL
        }
    });
}

// Run this function when the page loads to maintain the state of checkboxes
window.onload = updateCheckboxStates;

</script>

<!-- Lakshmi Kubera Filtering -->
<script>
                    // Function to update URL with filter parameters
function updateURLWithFilters() {
    // Get the current URL
    var url = new URL(window.location.href);
    // Get all the filter parameters from checkboxes
    var params = new URLSearchParams(url.search);

    // Loop through all checkboxes and update the URL parameters accordingly
    document.querySelectorAll('.custom-control-input').forEach(function(checkbox) {
        var paramName = checkbox.id; // Keep the ID as the unique parameter name

        // If checkbox is checked, set the parameter value to 'on', otherwise remove it
        if (checkbox.checked) {
            // Add the filter parameter with a unique name, e.g., lakshmi_kubera=on
            params.set(paramName, 'on');
        } else {
            // If unchecked, remove the corresponding parameter
            params.delete(paramName);
        }
    });

    // Update the URL without reloading the page
    window.history.pushState({}, '', `${url.pathname}?${params.toString()}`);
}

// Function to maintain the checkbox states based on URL parameters
function maintainCheckboxState() {
    // Get the current URL
    var url = new URL(window.location.href);
    // Get all the filter parameters from the URL
    var params = new URLSearchParams(url.search);

    // Loop through all checkboxes to set their checked state based on URL params
    document.querySelectorAll('.custom-control-input').forEach(function(checkbox) {
        var paramName = checkbox.id; // Match parameter from URL

        // Check if the parameter exists in the URL and is set to 'on'
        if (params.get(paramName) === 'on') {
            checkbox.checked = true;
        } else {
            checkbox.checked = false;
        }
    });
}

// When a checkbox is clicked, update the URL and reload the page
document.querySelectorAll('.custom-control-input').forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {
        updateURLWithFilters();
        // Reload the page after the URL is updated
        window.location.reload();
    });
});

// On page load, maintain the checkbox states based on the current URL
window.onload = maintainCheckboxState;

</script>
