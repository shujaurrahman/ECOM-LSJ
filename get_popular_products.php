<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

require_once('./logics.class.php');
$Obj = new logics();

header('Content-Type: application/json');

$results = $Obj->getProducts();

if ($results['status'] === 1) {
    $products = array();
    for ($i = 0; $i < $results['count']; $i++) {
        // Only include products that are marked as popular
        if ($results['is_popular_collection'][$i] == 1) {
            $products[] = array(
                'id' => $results['id'][$i],
                'product_name' => $results['product_name'][$i],
                'slug' => $results['slug'][$i],
                'featured_image' => $results['featured_image'][$i],
                'discounted_price' => number_format($results['discounted_price'][$i], 2),
                'product_price' => number_format($results['product_price'][$i], 2),
                'discount_percentage' => $results['discount_percentage'][$i]
            );
        }
    }
    echo json_encode($products);
} else {
    echo json_encode([]);
}
?>