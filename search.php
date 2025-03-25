<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('./logics.class.php');
$Obj = new logics();

header('Content-Type: application/json');

$searchTerm = $_GET['query'] ?? '';

if (!empty($searchTerm)) {
    $results = $Obj->searchProducts($searchTerm);
    
    if ($results['status'] === 1) {
        $products = array();
        for ($i = 0; $i < $results['count']; $i++) {
            $actual_price = $results['ornament_weight'][$i] * $results['price_per_gram'][$i];
            $discounted_price = $actual_price - ($actual_price * $results['discount_percentage'][$i] / 100);
            
            $products[] = array(
                'id' => $results['id'][$i],
                'product_name' => $results['product_name'][$i],
                'slug' => $results['slug'][$i],
                'featured_image' => $results['featured_image'][$i],
                'actual_price' => $actual_price,
                'discounted_price' => $discounted_price,
                'discount_percentage' => $results['discount_percentage'][$i]
            );
        }
        echo json_encode($products);
    } else {
        echo json_encode(['error' => $results['error'] ?? 'No results found']);
    }
} else {
    echo json_encode(['error' => 'Empty search term']);
}