
<?php
require_once('./dbcredentials.class.php');


class logics extends dbcredentials{

        //Submitted Tasks Retieval
        public function SubmittedTasks(){
            $res = array();
            $res['status'] = 0;
            $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
            $query = $con->prepare(
                'SELECT tasks.task,tasks.url,tasks.doubts,tasks.created_at ,users.stud_id,users.name,users.email,users.domain
                FROM tasks 
                JOIN users ON users.id = tasks.user_id
                WHERE tasks.status=1
                ORDER BY tasks.id DESC'
            );
            if($query->execute()){
                $query->bind_result($task, $url, $doubts, $created_at,$stud_id,$name,$email,$domain);
                $i=0;
                while($query->fetch()){
                    $res['status']=1;
                    $res['task'][$i] = $task;
                    $res['url'][$i] = $url;
                    $res['doubts'][$i] = $doubts;
                    $res['created_at'][$i] = $created_at;
                    $res['stud_id'][$i] = $stud_id;
                    $res['name'][$i] = $name;
                    $res['email'][$i] = $email;
                    $res['domain'][$i] = $domain;
                    $i++;
                }
                $res['count']=$i;
            }else{
                $err = 'Statement not Executed';
            }
            return $res;
        }


    public function getUsers1(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT stud_id,name,email,domain,created_at FROM users ORDER BY id DESC');
        if($query->execute()){
            $query->bind_result($stud_id,$name,$email,$domain,$created_at);
            $i=0;
            while($query->fetch()){
                $res['status'] = 1;
                $res['stud_id'][$i] = $stud_id;
                $res['name'][$i] = $name;
                $res['email'][$i] = $email;
                $res['domain'][$i] = $domain;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }


    public function getUsersProfile(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare(
            "SELECT users.id, users.stud_id, users.name, users.email, users.password, 
                    users.domain, users.status, users.created_at, users.updated_at, 
                    profiles.mobile, profiles.college, profiles.dept, profiles.yop, profiles.address, profiles.profile 
             FROM users 
             JOIN profiles ON users.id = profiles.user_id 
             WHERE users.status = 1 
             ORDER BY users.created_at DESC"
        );
        if($query->execute()){
            $query->bind_result($id,$stud_id,$name,$email,$password,$domain,$status,$created_at,$updated_at,$mobile,$college,$dept,$yop,$address,$profile);
            $i=0;
            while($query->fetch()){
                $res['status'] = 1;
                $res['id'][$i] = $id;
                $res['stud_id'][$i] = $stud_id;
                $res['name'][$i] = $name;
                $res['email'][$i] = $email;
                $res['password'][$i] = $password;
                $res['status'][$i] = $status;
                $res['updated_at'][$i] = $updated_at;
                $res['domain'][$i] = $domain;
                $res['created_at'][$i] = $created_at;
                $res['mobile'][$i] = $mobile;
                $res['college'][$i] = $college;
                $res['dept'][$i] = $dept;
                $res['yop'][$i] = $yop;
                $res['address'][$i] = $address;
                $res['profile'][$i] = $profile;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }

    public function getInactiveUsersProfile(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare(
            "SELECT users.id, users.stud_id, users.name, users.email, users.password, 
                    users.domain, users.status, users.created_at, users.updated_at, 
                    profiles.mobile, profiles.college, profiles.dept, profiles.yop, profiles.address, profiles.profile 
             FROM users 
             JOIN profiles ON users.id = profiles.user_id 
             WHERE users.status = 0
             ORDER BY users.created_at DESC"
        );
        if($query->execute()){
            $query->bind_result($id,$stud_id,$name,$email,$password,$domain,$status,$created_at,$updated_at,$mobile,$college,$dept,$yop,$address,$profile);
            $i=0;
            while($query->fetch()){
                $res['status'] = 1;
                $res['id'][$i] = $id;
                $res['stud_id'][$i] = $stud_id;
                $res['name'][$i] = $name;
                $res['email'][$i] = $email;
                $res['password'][$i] = $password;
                $res['status'][$i] = $status;
                $res['updated_at'][$i] = $updated_at;
                $res['domain'][$i] = $domain;
                $res['created_at'][$i] = $created_at;
                $res['mobile'][$i] = $mobile;
                $res['college'][$i] = $college;
                $res['dept'][$i] = $dept;
                $res['yop'][$i] = $yop;
                $res['address'][$i] = $address;
                $res['profile'][$i] = $profile;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }

    public function updateUserProfileById( $stud_id,$name, $email, $password, $domain, $mobile,$college, $dept, $yop, $address, $profile, $id) {
        $res = array();
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    
        // Prepare the update query
        $query = $con->prepare(
            "UPDATE users 
             JOIN profiles ON users.id = profiles.user_id 
             SET users.stud_id = ?,users.name = ?, users.email = ?, users.password = ?, 
                 users.domain = ?, profiles.mobile = ?, profiles.college = ?, 
                 profiles.dept = ?, profiles.yop = ?, profiles.address = ?, profiles.profile = ?
             WHERE users.id = ?"
        );
    
        // Bind the new data and the ID to the query
        $query->bind_param(
            'sssssssssssi', 
            $stud_id,$name, $email, $password, $domain, 
            $mobile, $college, $dept, $yop, 
            $address, $profile, $id
        );
    
        // Execute the query and check the result
        if($query->execute()){
            $res['status'] = 1;
            $res['message'] = 'Profile updated successfully';
        }else{
            $res['status'] = 0;
            $res['message'] = 'Failed to update profile';
        }
    
        // Close the statement and connection
        $query->close();
        $con->close();
    
        return $res;
    }
    


    public function getRegistrations(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT sno,name,mobile,email,college_name,college_location,dept,yop,created_at FROM registrations WHERE status=1 ORDER BY sno DESC');
        if($query->execute()){
            $query->bind_result($sno,$name,$mobile,$email,$college_name,$college_location,$dept,$yop,$created_at);
            $i=0;
            while($query->fetch()){
                $res['status'] = 1;
                $res['sno'][$i] = $sno;
                $res['name'][$i] = $name;
                $res['mobile'][$i] = $mobile;
                $res['college_name'][$i] = $college_name;
                $res['college_location'][$i] = $college_location;
                $res['dept'][$i] = $dept;
                $res['email'][$i] = $email;
                $res['yop'][$i] = $yop;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }


    public function getInactiveRegistrations(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT sno,name,mobile,email,college_name,college_location,dept,yop,created_at FROM registrations WHERE status=0 ORDER BY sno DESC');
        if($query->execute()){
            $query->bind_result($sno,$name,$mobile,$email,$college_name,$college_location,$dept,$yop,$created_at);
            $i=0;
            while($query->fetch()){
                $res['status'] = 1;
                $res['sno'][$i] = $sno;
                $res['name'][$i] = $name;
                $res['mobile'][$i] = $mobile;
                $res['college_name'][$i] = $college_name;
                $res['college_location'][$i] = $college_location;
                $res['dept'][$i] = $dept;
                $res['email'][$i] = $email;
                $res['yop'][$i] = $yop;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }



    public function getCareers(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT name,mobile,email,post,experience,resume,created_at FROM careers ORDER BY sno DESC');
        if($query->execute()){
            $query->bind_result($name,$mobile,$email,$post,$experience,$resume,$created_at);
            $i=0;
            while($query->fetch()){
                $res['status'] = 1;
                $res['name'][$i] = $name;
                $res['mobile'][$i] = $mobile;
                $res['email'][$i] = $email;
                $res['post'][$i] = $post;
                $res['experience'][$i] = $experience;
                $res['resume'][$i] = $resume;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }


    public function getBlogs(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT username,blog_heading,description,category,featured_image,meta_keywords,meta_description,slug_url,status,updated_at,updated_by,created_at FROM blog ORDER BY sno DESC');
        if($query->execute()){
            $query->bind_result($username,$blog_heading,$description,$category,$featured_image,$meta_keywords,$meta_description,$slug_url,$status,$updated_at,$updated_by,$created_at);
            $i=0;
            while($query->fetch()){
                $res['status'] = 1;
                $res['username'][$i] = $username;
                $res['blog_heading'][$i] = $blog_heading;
                $res['description'][$i] = $description;
                $res['category'][$i] = $category;
                $res['featured_image'][$i] = $featured_image;
                $res['meta_keywords'][$i] = $meta_keywords;
                $res['meta_description'][$i] = $meta_description;
                $res['slug_url'][$i] = $slug_url;
                $res['status_val'][$i] = $status;
                $res['updated_at'][$i] = $updated_at;
                $res['updated_by'][$i] = $updated_by;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }

  

    public function getCategoryById($id){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT id,name,image,description,status,created_at FROM categories ORDER BY id DESC');
        if($query->execute()){
            $query->bind_result($id,$name, $image, $description, $status, $created_at);
            $i=0;
            while($query->fetch()){
                $res['status']=1;
                $res['id'][$i] = $id;
                $res['name'][$i] = $name;
                $res['image'][$i] = $image;
                $res['description'][$i] = $description;
                $res['statusval'][$i] = $status;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }

    public function getContacts(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT name,email,mobile,,created_at FROM contact ORDER BY sno DESC');
        if($query->execute()){
            $query->bind_result($name, $email, $mobile, $message, $created_at);
            $i=0;
            while($query->fetch()){
                $res['status']=1;
                $res['name'][$i] = $name;
                $res['email'][$i] = $email;
                $res['mobile'][$i] = $mobile;
                $res['message'][$i] = $message;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }

    public function getQuotes(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT name,email,mobile,looking_for,when_to_start,created_at FROM quote ORDER BY sno DESC');
        if($query->execute()){
            $query->bind_result($name, $email, $mobile, $looking_for,$when_to_start, $created_at);
            $i=0;
            while($query->fetch()){
                $res['status']=1;
                $res['name'][$i] = $name;
                $res['email'][$i] = $email;
                $res['mobile'][$i] = $mobile;
                $res['looking_for'][$i] = $looking_for;
                $res['when_to_start'][$i] = $when_to_start;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }

    public function AddBlogs($username,$blog_heading,$description,$category,$featured_image,$meta_keywords,$meta_description,$slug_url){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('INSERT INTO blog (username,blog_heading,description,category,featured_image,meta_keywords,meta_description,slug_url) values (?,?,?,?,?,?,?,?)');
        $query->bind_param('ssssssss',$username,$blog_heading,$description,$category,$featured_image,$meta_keywords,$meta_description,$slug_url);
        if($query->execute()){
            $res['status']=1;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }
    public function AddTasks($task_date,$domain,$task_name,$task_description,$tasks){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('INSERT INTO addtasks (task_date,domain,task_name,task_description,tasks) values (?,?,?,?,?)');
        $query->bind_param('sssss',$task_date,$domain,$task_name,$task_description,$tasks);
        if($query->execute()){
            $res['status']=1;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }


    public function AddProduct(
        $category_id, $subcategory_id, $product_name, $featured_image, $additional_images, 
        $stock,  $discount_percentage, $short_description, 
        $features, $is_popular_collection, $is_recommended, 
        $description, $attribute_ids, $variation_names, 
        $variation_same_prices, $variation_ornament_weights, $variation_discounted_percentages,$product_price,$hashtags,$size_chartPhoto
    ) {
        $res = array();
        $res['status'] = 0;
    
        // Database connection setup
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        $con->begin_transaction();
    
        try {
            // Generate unique slug for the product
            $slug = $this->generateUniqueSlug($product_name, $con);
    
            // Insert the main product
            $product_code = 'lsj-'.rand(9999,99999);
            $query = $con->prepare('INSERT INTO products (category_id, subcategory_id, product_code, product_name, featured_image, additional_images, stock, ornament_type, ornament_weight, discount_percentage, short_description, features, is_popular_collection, is_recommended, , description, slug,hashtags,size_chart) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
            $query->bind_param('ssssssssssssssssss', $category_id, $subcategory_id, $product_code, $product_name, $featured_image, $additional_images, $stock, $ornament_type, $ornament_weight, $discount_percentage, $short_description, $features,  $is_popular_collection, $is_recommended,  $description, $slug,$hashtags,$size_chartPhoto);


            // $query = $con->prepare('INSERT INTO products (category_id, subcategory_id, product_code, product_name, featured_image, additional_images, stock,  ornament_type, ornament_weight,discount_percentage, short_description, features,is_lakshmi_kubera, is_popular_collection, is_recommended, description, slug, product_price, hashtags,size_chart) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
            // $query->bind_param('sssssssssssssssss', $category_id, $subcategory_id, $product_code, $product_name, $featured_image, $additional_images, $stock, $discount_percentage, $short_description, $features, $is_popular_collection, $is_recommended, $description, $slug, $product_price, $hashtags,$size_chartPhoto);
            
            if ($query->execute()) {
                $product_id = $con->insert_id;
    
                // Prepare the insert query for product variations
                $variationQuery = $con->prepare('INSERT INTO product_variations (product_id, attribute_id, variation_name, is_same_price, ornament_weight, discount_percentage) VALUES (?, ?, ?, ?, ?, ?)');
                
                foreach ($attribute_ids as $key => $attribute_id) {
                    if (isset($variation_names[$key]) && is_array($variation_names[$key])) {
                        foreach ($variation_names[$key] as $i => $variation_name) {
                            $is_same_price = isset($variation_same_prices[$key][$i]) ? 1 : 0;
                            $variation_weight = $variation_ornament_weights[$key][$i] ?? null;
                            $variation_discounted_percentage = $variation_discounted_percentages[$key][$i] ?? null;
                
                            $variationQuery->bind_param('iissss', $product_id, $attribute_id, $variation_name, $is_same_price, $variation_weight, $variation_discounted_percentage);
                            if (!$variationQuery->execute()) {
                                throw new Exception('Variation insert failed: ' . $variationQuery->error);
                            }
                        }
                    }
                }
                
                $con->commit();
                $res['status'] = 1;
            } else {
                $con->rollback();
                $res['error'] = 'Product insert failed: ' . $query->error;
            }
        } catch (Exception $e) {
            $con->rollback();
            $res['error'] = $e->getMessage();
        }
    
        $con->close();
        return $res;
    }

// public function AddProduct(
//     $category_id, $subcategory_id, $product_name, $featured_image, $additional_images, 
//     $stock, $discount_percentage, $short_description, 
//     $features, $is_popular_collection, $is_recommended, 
//     $description, $attribute_ids, $variation_names, 
//     $variation_same_prices, $variation_ornament_weights, $variation_discounted_percentages, $product_price, $hashtags, $size_chartPhoto
// ) {
//     $res = array();
//     $res['status'] = 0;

//     $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
//     if ($con->connect_error) {
//         die("Connection failed: " . $con->connect_error);
//     }
//     $con->begin_transaction();

//     try {
     
//         $slug = $this->generateUniqueSlug($product_name, $con);


//         $discounted_price = $product_price - ($product_price * $discount_percentage / 100);


//         $product_code = 'lsj-' . rand(9999, 99999);
//         $query = $con->prepare('INSERT INTO products (category_id, subcategory_id, product_code, product_name, featured_image, additional_images, stock, discount_percentage, short_description, features, is_popular_collection, is_recommended, description, slug, product_price, discounted_price, hashtags, size_chart) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
//         $query->bind_param('ssssssssssssssssss', $category_id, $subcategory_id, $product_code, $product_name, $featured_image, $additional_images, $stock, $discount_percentage, $short_description, $features, $is_popular_collection, $is_recommended, $description, $slug, $product_price, $discounted_price, $hashtags, $size_chartPhoto);

//         if ($query->execute()) {
//             $product_id = $con->insert_id;


//             $variationQuery = $con->prepare('INSERT INTO product_variations (product_id, attribute_id, variation_name, is_same_price, ornament_weight, discount_percentage) VALUES (?, ?, ?, ?, ?, ?)');

//             foreach ($attribute_ids as $key => $attribute_id) {
//                 if (isset($variation_names[$key]) && is_array($variation_names[$key])) {
//                     foreach ($variation_names[$key] as $i => $variation_name) {
//                         $is_same_price = isset($variation_same_prices[$key][$i]) ? 1 : 0;
//                         $variation_weight = $variation_ornament_weights[$key][$i] ?? null;
//                         $variation_discounted_percentage = $variation_discounted_percentages[$key][$i] ?? null;

//                         $variationQuery->bind_param('iissss', $product_id, $attribute_id, $variation_name, $is_same_price, $variation_weight, $variation_discounted_percentage);
//                         if (!$variationQuery->execute()) {
//                             throw new Exception('Variation insert failed: ' . $variationQuery->error);
//                         }
//                     }
//                 }
//             }

//             $con->commit();
//             $res['status'] = 1;
//         } else {
//             $con->rollback();
//             $res['error'] = 'Product insert failed: ' . $query->error;
//         }
//     } catch (Exception $e) {
//         $con->rollback();
//         $res['error'] = $e->getMessage();
//     }

//     $con->close();
//     return $res;
// }
    
    private function generateUniqueSlug($product_name, $con) {
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower($product_name));
        $original_slug = $slug;
        $counter = 1;
    
        $stmt = $con->prepare("SELECT COUNT(*) FROM products WHERE slug = ?");
        do {
            $stmt->bind_param("s", $slug);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
    
            if ($count > 0) {
                $slug = $original_slug . '-' . $counter;
                $counter++;
            }
        } while ($count > 0);
    
        $stmt->close();
        return $slug;
    }
    

    
    
    

    // public function getProducts() {
    //     $res = array();
    //     $res['status'] = 0;
    //     $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    
    //     $query = $con->prepare("SELECT 
    //                 products.id, 
    //                 categories.id AS category_id, 
    //                 categories.name AS category_name, 
    //                 sub_categories.id AS subcategory_id, 
    //                 sub_categories.name AS subcategory_name, 
    //                 products.product_code, 
    //                 products.product_name, 
    //                 products.featured_image, 
    //                 products.additional_images, 
    //                 products.stock, 
    //                 ornaments.id AS ornament_id, 
    //                 ornaments.name AS ornament_name,
    //                 ornaments.price AS price_per_gram,  -- Price per gram from ornaments table
    //                 products.ornament_weight, 
    //                 products.discount_percentage, 
    //                 products.short_description, 
    //                 products.features, 
    //                 GROUP_CONCAT(DISTINCT features.name SEPARATOR ', ') AS features, 
    //                 products.is_lakshmi_kubera, 
    //                 products.is_popular_collection, 
    //                 products.is_recommended, 
    //                 products.general_info, 
    //                 products.description, 
    //                 products.slug, 
    //                 products.status, 
    //                 products.created_at
    //             FROM 
    //                 products
    //             LEFT JOIN categories ON products.category_id = categories.id
    //             LEFT JOIN sub_categories ON products.subcategory_id = sub_categories.id
    //             LEFT JOIN ornaments ON products.ornament_type = ornaments.id
    //             LEFT JOIN features ON FIND_IN_SET(features.id, products.features) > 0
    //             GROUP BY products.id  
    //             ORDER BY products.id DESC;");
    
    //     if ($query->execute()) {
    //         $query->bind_result($id, $category_id, $category_name, $subcategory_id, $subcategory_name, $product_code, $product_name, $featured_image, $additional_images, $stock, $ornament_id, $ornament_type, $price_per_gram, $ornament_weight, $discount_percentage, $short_description, $features_id, $features, $is_lakshmi_kubera, $is_popular_collection, $is_recommended, $general_info, $description,$slug, $status, $created_at);
    
    //         $i = 0;
    //         while ($query->fetch()) {
    //             $res['status'] = 1;
    //             $res['id'][$i] = $id;
    //             $res['category_id'][$i] = $category_id;
    //             $res['category_name'][$i] = $category_name;
    //             $res['subcategory_id'][$i] = $subcategory_id;
    //             $res['subcategory_name'][$i] = $subcategory_name;
    //             $res['product_code'][$i] = $product_code;
    //             $res['product_name'][$i] = $product_name;
    //             $res['featured_image'][$i] = $featured_image;
    //             $res['additional_images'][$i] = $additional_images;
    //             $res['stock'][$i] = $stock;
    //             $res['ornament_id'][$i] = $ornament_id;
    //             $res['ornament_type'][$i] = $ornament_type;
    //             $res['price_per_gram'][$i] = $price_per_gram;
    //             $res['ornament_weight'][$i] = $ornament_weight;
    //             $res['discount_percentage'][$i] = $discount_percentage;
    //             $res['short_description'][$i] = $short_description;
    //             $res['features_id'][$i] = $features_id;
    //             $res['features'][$i] = $features;
    //             $res['is_lakshmi_kubera'][$i] = $is_lakshmi_kubera;
    //             $res['is_popular_collection'][$i] = $is_popular_collection;
    //             $res['is_recommended'][$i] = $is_recommended;
    //             $res['general_info'][$i] = $general_info;
    //             $res['description'][$i] = $description;
    //             $res['slug'][$i] = $slug;
    //             $res['statusval'][$i] = $status;
    //             $res['created_at'][$i] = $created_at;
    
    //             // Calculate Actual Price and Discounted Price
    //             $actual_price = $ornament_weight * $price_per_gram;
    //             $discounted_price = $actual_price - ($actual_price * $discount_percentage / 100);
    
    //             // Add these to the result array
    //             $res['actual_price'][$i] = $actual_price;
    //             $res['discounted_price'][$i] = $discounted_price;
    
    //             $i++;
    //         }
    //         $res['count'] = $i;
    //     } else {
    //         $err = 'Statement not Executed';
    //     }
    
    //     return $res;
    // }



    public function getProducts() {
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());

        $query = $con->prepare("SELECT 
                    products.id, 
                    categories.id AS category_id, 
                    categories.name AS category_name, 
                    sub_categories.id AS subcategory_id, 
                    sub_categories.name AS subcategory_name, 
                    products.product_code, 
                    products.product_name, 
                    products.featured_image, 
                    products.additional_images, 
                    products.stock, 
                    ornaments.id AS ornament_id, 
                    ornaments.name AS ornament_name,
                    ornaments.price AS price_per_gram,  -- Price per gram from ornaments table
                    products.ornament_weight, 
                    products.discount_percentage, 
                    products.short_description, 
                    products.features, 
                    GROUP_CONCAT(DISTINCT features.name SEPARATOR ', ') AS features, 
                    products.is_lakshmi_kubera, 
                    products.is_popular_collection, 
                    products.is_recommended, 
                    products.general_info, 
                    products.description, 
                    products.slug, 
                    products.status, 
                    products.created_at,
                    products.product_price,  -- product_price
                    products.hashtags,      -- hashtags
                    products.size_chart,     -- size_chart
                    products.discounted_price -- discounted_price
                FROM 
                    products
                LEFT JOIN categories ON products.category_id = categories.id
                LEFT JOIN sub_categories ON products.subcategory_id = sub_categories.id
                LEFT JOIN ornaments ON products.ornament_type = ornaments.id
                LEFT JOIN features ON FIND_IN_SET(features.id, products.features) > 0
                GROUP BY products.id  
                ORDER BY products.id DESC;");

        if ($query->execute()) {
            $query->bind_result($id, $category_id, $category_name, $subcategory_id, $subcategory_name, $product_code, $product_name, $featured_image, $additional_images, $stock, $ornament_id, $ornament_type, $price_per_gram, $ornament_weight, $discount_percentage, $short_description, $features_id, $features, $is_lakshmi_kubera, $is_popular_collection, $is_recommended, $general_info, $description, $slug, $status, $created_at, $product_price, $hashtags, $size_chart, $discounted_price);

            $i = 0;
            while ($query->fetch()) {
                $res['status'] = 1;
                $res['id'][$i] = $id;
                $res['category_id'][$i] = $category_id;
                $res['category_name'][$i] = $category_name;
                $res['subcategory_id'][$i] = $subcategory_id;
                $res['subcategory_name'][$i] = $subcategory_name;
                $res['product_code'][$i] = $product_code;
                $res['product_name'][$i] = $product_name;
                $res['featured_image'][$i] = $featured_image;
                $res['additional_images'][$i] = $additional_images;
                $res['stock'][$i] = $stock;
                $res['ornament_id'][$i] = $ornament_id;
                $res['ornament_type'][$i] = $ornament_type;
                $res['price_per_gram'][$i] = $price_per_gram;
                $res['ornament_weight'][$i] = $ornament_weight;
                $res['discount_percentage'][$i] = $discount_percentage;
                $res['short_description'][$i] = $short_description;
                $res['features_id'][$i] = $features_id;
                $res['features'][$i] = $features;
                $res['is_lakshmi_kubera'][$i] = $is_lakshmi_kubera;
                $res['is_popular_collection'][$i] = $is_popular_collection;
                $res['is_recommended'][$i] = $is_recommended;
                $res['general_info'][$i] = $general_info;
                $res['description'][$i] = $description;
                $res['slug'][$i] = $slug;
                $res['statusval'][$i] = $status;
                $res['created_at'][$i] = $created_at;
                $res['product_price'][$i] = $product_price;  // product_price to result
                $res['hashtags'][$i] = $hashtags;            // hashtags to result
                $res['size_chart'][$i] = $size_chart;        // size_chart to result
                $res['discounted_price'][$i] = $discounted_price; // discounted_price to result

                $i++;
            }
            $res['count'] = $i;
        } else {
            $err = 'Statement not Executed';
        }

        return $res;
    }




    // public function UpdateProduct($category_id, $subcategory_id, $product_name, $featured_image, $additional_images, $stock,$product_price, $discount_percentage, $short_description, 
    // $features, $is_popular_collection, $is_recommended, 
    // $description,$id,$hashtags,$size_chart) {
    //     $res = array();
    //     $res['status'] = 0;
    
    //     // Establish database connection
    //     $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
    //     // Check connection
    //     if ($con->connect_error) {
    //         die("Connection failed: " . $con->connect_error);
    //     }
        
    //     // Begin transaction
    //     $con->begin_transaction();
    
    //     try {
    //         $slug = $this->generateUniqueSlug($product_name, $con);
    //         // Insert into users table
    //         $query = $con->prepare('UPDATE products SET category_id=?, subcategory_id=?, product_code=?, product_name=?, featured_image=?, additional_images=?, stock=?, product_price=?, discount_percentage=?, short_description=?, features=?, is_popular_collection=?, is_recommended=?, description=?, slug=?, hashtags=?, size_chart=? WHERE id=?');
    //         $query->bind_param('sssssssssssssssssss',  $category_id, $subcategory_id, $product_code, $product_name, $featured_image, $additional_images, $stock, $product_price, $discount_percentage, $short_description, $features, $is_popular_collection, $is_recommended, $description, $slug, $hashtags, $size_chart, $id);
    //         if ($query->execute()) {
                
    //                 // Commit transaction
    //                 $con->commit();
    //                 $res['status'] = 1;
    //         } else {
    //             // Rollback transaction if users insertion fails
    //             $con->rollback();
    //             $err = 'statement not executed';
    //             $res['error'] = $err;
    //         }
    //     } catch (Exception $e) {
    //         // Rollback transaction in case of error
    //         $con->rollback();
    //         $res['error'] = $e->getMessage();
    //     }
    
    //     // Close the connection
    //     $con->close();
    
    //     return $res;
    // }

    public function UpdateProduct($category_id, $subcategory_id, $product_name, $featured_image, 
    $additional_images, $stock, $ornament_type,$ornament_weight,$product_price, $discount_percentage, $short_description, 
    $features, $is_popular_collection, $is_recommended, $description, $id, $hashtags, $size_chart) {
    
    $res = array();
    $res['status'] = 0;

    $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
    
    $con->begin_transaction();

    try {
        $slug = $this->generateUniqueSlug($product_name, $con);
        $discounted_price = $product_price - ($product_price * $discount_percentage / 100);
        $product_code = $id; // Using existing ID as product code for update

        $query = $con->prepare('UPDATE products SET 
            category_id=?, 
            subcategory_id=?, 
            product_name=?, 
            featured_image=?, 
            additional_images=?, 
            stock=?, 
            ornament_type=?,
            ornament_weight=?,
            product_price=?,
            discounted_price=?,
            discount_percentage=?, 
            short_description=?, 
            features=?, 
            is_popular_collection=?, 
            is_recommended=?, 
            description=?, 
            slug=?, 
            hashtags=?, 
            size_chart=? 
            WHERE id=?');

        $query->bind_param('iisssissiddssiissssi', 
            $category_id, 
            $subcategory_id, 
            $product_name, 
            $featured_image, 
            $additional_images, 
            $stock,
            $ornament_type,
            $ornament_weight, 
            $product_price,
            $discounted_price,
            $discount_percentage, 
            $short_description, 
            $features, 
            $is_popular_collection, 
            $is_recommended, 
            $description, 
            $slug, 
            $hashtags, 
            $size_chart,
            $id
        );

        if ($query->execute()) {
            $con->commit();
            $res['status'] = 1;
        } else {
            throw new Exception('Statement not executed: ' . $query->error);
        }
    } catch (Exception $e) {
        $con->rollback();
        $res['error'] = $e->getMessage();
    }

    $con->close();
    return $res;
}

    public function getProductVariations($id){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare("SELECT product_variations.id, product_variations.product_id, attributes.id,attributes.name AS attribute_name, product_variations.variation_name, product_variations.is_same_price, product_variations.ornament_weight, product_variations.discount_percentage, product_variations.status,product_variations.created_at
        FROM product_variations
        JOIN attributes ON product_variations.attribute_id = attributes.id
        WHERE product_variations.product_id=?
        ");
        $query->bind_param('i',$id);

        if($query->execute()){
            $query->bind_result($id,$product_id, $attribute_id, $attribute_name, $variation_name, $is_same_price, $ornament_weight, $discount_percentage, $status, $created_at);
            $i=0;
            while($query->fetch()){
                $res['status']=1;
                $res['id'][$i] = $id;
                $res['product_id'][$i] = $product_id;
                $res['attribute_id'][$i] = $attribute_id;
                $res['attribute_name'][$i] = $attribute_name;
                $res['variation_name'][$i] = $variation_name;
                $res['is_same_price'][$i] = $is_same_price;
                $res['ornament_weight'][$i] = $ornament_weight;
                $res['discount_percentage'][$i] = $discount_percentage;
                $res['statusval'][$i] = $status;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }



    public function AddFeature($name,$image) {
        $res = array();
        $res['status'] = 0;
    
        // Establish database connection
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        
        // Begin transaction
        $con->begin_transaction();
    
        try {
            // Insert into users table
            $query = $con->prepare('INSERT INTO features (name,image) VALUES (?,?)');
            $query->bind_param('ss', $name,$image);
            
            if ($query->execute()) {
                
                    // Commit transaction
                    $con->commit();
                    $res['status'] = 1;
            } else {
                // Rollback transaction if users insertion fails
                $con->rollback();
                $err = 'statement not executed';
                $res['error'] = $err;
            }
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $con->rollback();
            $res['error'] = $e->getMessage();
        }
    
        // Close the connection
        $con->close();
    
        return $res;
    }

    public function getFeatures(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare("SELECT id, name,image, status,created_at FROM features ORDER BY id DESC");

        if($query->execute()){
            $query->bind_result($id,$name,$image, $status, $created_at);
            $i=0;
            while($query->fetch()){
                $res['status']=1;
                $res['id'][$i] = $id;
                $res['name'][$i] = $name;
                $res['image'][$i] = $image;
                $res['statusval'][$i] = $status;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }

    public function UpdateFeature($name,$image,$id) {
        $res = array();
        $res['status'] = 0;
    
        // Establish database connection
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        
        // Begin transaction
        $con->begin_transaction();
    
        try {
            // Insert into users table
            $query = $con->prepare('UPDATE features SET name=?,image=? WHERE id=?');
            $query->bind_param('sss',  $name,$image,$id);
            
            if ($query->execute()) {
                
                    // Commit transaction
                    $con->commit();
                    $res['status'] = 1;
            } else {
                // Rollback transaction if users insertion fails
                $con->rollback();
                $err = 'statement not executed';
                $res['error'] = $err;
            }
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $con->rollback();
            $res['error'] = $e->getMessage();
        }
    
        // Close the connection
        $con->close();
    
        return $res;
    }

    public function AddOrnament($name,$price) {
        $res = array();
        $res['status'] = 0;
    
        // Establish database connection
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        
        // Begin transaction
        $con->begin_transaction();
    
        try {
            // Insert into users table
            $query = $con->prepare('INSERT INTO ornaments (name,price) VALUES (?,?)');
            $query->bind_param('ss', $name,$price);
            
            if ($query->execute()) {
                
                    // Commit transaction
                    $con->commit();
                    $res['status'] = 1;
            } else {
                // Rollback transaction if users insertion fails
                $con->rollback();
                $err = 'Category statement not executed';
                $res['error'] = $err;
            }
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $con->rollback();
            $res['error'] = $e->getMessage();
        }
    
        // Close the connection
        $con->close();
    
        return $res;
    }

    public function AddVariations($product_id,$attribute_id, $variation_name,$is_same_price,$ornament_weight, $discount_percentage) {
        $res = array();
        $res['status'] = 0;
    
        // Establish database connection
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        
        // Begin transaction
        $con->begin_transaction();
    
        try {
            // Insert into users table
            $query = $con->prepare('INSERT INTO product_variations (product_id,attribute_id,variation_name,is_same_price, ornament_weight,discount_percentage) VALUES (?,?,?,?,?,?)');
            $query->bind_param('ssssss', $product_id,$attribute_id, $variation_name,$is_same_price,$ornament_weight, $discount_percentage);
            
            if ($query->execute()) {
                
                    // Commit transaction
                    $con->commit();
                    $res['status'] = 1;
            } else {
                // Rollback transaction if users insertion fails
                $con->rollback();
                $err = 'Category statement not executed';
                $res['error'] = $err;
            }
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $con->rollback();
            $res['error'] = $e->getMessage();
        }
    
        // Close the connection
        $con->close();
    
        return $res;
    }

    public function getOrnaments(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare("SELECT id, name,price, status,created_at FROM ornaments ORDER BY id DESC");

        if($query->execute()){
            $query->bind_result($id,$name,$price, $status, $created_at);
            $i=0;
            while($query->fetch()){
                $res['status']=1;
                $res['id'][$i] = $id;
                $res['name'][$i] = $name;
                $res['price'][$i] = $price;
                $res['statusval'][$i] = $status;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }

    public function UpdateOrnament($name,$price,$id) {
        $res = array();
        $res['status'] = 0;
    
        // Establish database connection
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        
        // Begin transaction
        $con->begin_transaction();
    
        try {
            // Insert into users table
            $query = $con->prepare('UPDATE ornaments SET name=?,price=? WHERE id=?');
            $query->bind_param('sss',  $name,$price,$id);
            
            if ($query->execute()) {
                
                    // Commit transaction
                    $con->commit();
                    $res['status'] = 1;
            } else {
                // Rollback transaction if users insertion fails
                $con->rollback();
                $err = 'statement not executed';
                $res['error'] = $err;
            }
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $con->rollback();
            $res['error'] = $e->getMessage();
        }
    
        // Close the connection
        $con->close();
    
        return $res;
    }

    public function UpdateVariation($id,$attribute_id, $variation_name,$is_same_price,$ornament_weight,$discount_percentage) {
        $res = array();
        $res['status'] = 0;
    
        // Establish database connection
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        
        // Begin transaction
        $con->begin_transaction();
    
        try {
            // Insert into users table
            $query = $con->prepare('UPDATE product_variations SET attribute_id=?,variation_name=?,is_same_price=?,ornament_weight=?,discount_percentage=? WHERE id=?');
            $query->bind_param('ssssss',  $attribute_id, $variation_name,$is_same_price,$ornament_weight,$discount_percentage,$id);
            
            if ($query->execute()) {
                
                    // Commit transaction
                    $con->commit();
                    $res['status'] = 1;
            } else {
                // Rollback transaction if users insertion fails
                $con->rollback();
                $err = 'statement not executed';
                $res['error'] = $err;
            }
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $con->rollback();
            $res['error'] = $e->getMessage();
        }
    
        // Close the connection
        $con->close();
    
        return $res;
    }


    public function AddAttribute($name) {
        $res = array();
        $res['status'] = 0;
    
        // Establish database connection
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        
        // Begin transaction
        $con->begin_transaction();
    
        try {
            // Insert into users table
            $query = $con->prepare('INSERT INTO attributes (name) VALUES (?)');
            $query->bind_param('s', $name);
            
            if ($query->execute()) {
                
                    // Commit transaction
                    $con->commit();
                    $res['status'] = 1;
            } else {
                // Rollback transaction if users insertion fails
                $con->rollback();
                $err = 'Category statement not executed';
                $res['error'] = $err;
            }
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $con->rollback();
            $res['error'] = $e->getMessage();
        }
    
        // Close the connection
        $con->close();
    
        return $res;
    }

    public function getAttribute(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare("SELECT id, name, status,created_at FROM attributes ORDER BY id DESC");

        if($query->execute()){
            $query->bind_result($id,$name, $status, $created_at);
            $i=0;
            while($query->fetch()){
                $res['status']=1;
                $res['id'][$i] = $id;
                $res['name'][$i] = $name;
                $res['statusval'][$i] = $status;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }

    public function UpdateAttribute($name,$id) {
        $res = array();
        $res['status'] = 0;
    
        // Establish database connection
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        
        // Begin transaction
        $con->begin_transaction();
    
        try {
            // Insert into users table
            $query = $con->prepare('UPDATE attributes SET name=? WHERE id=?');
            $query->bind_param('ss',  $name,$id);
            
            if ($query->execute()) {
                
                    // Commit transaction
                    $con->commit();
                    $res['status'] = 1;
            } else {
                // Rollback transaction if users insertion fails
                $con->rollback();
                $err = 'statement not executed';
                $res['error'] = $err;
            }
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $con->rollback();
            $res['error'] = $e->getMessage();
        }
    
        // Close the connection
        $con->close();
    
        return $res;
    }

    public function UpdateStatus($table,$id,$status) {
        $res = array();
        $res['status'] = 0;
    
        // Establish database connection
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        
        // Begin transaction
        $con->begin_transaction();
    
        try {
            // Insert into users table
            $query = $con->prepare('UPDATE '.$table.' SET status=? WHERE id=?');
            $query->bind_param('ss',  $status,$id);
            
            if ($query->execute()) {
                
                    // Commit transaction
                    $con->commit();
                    $res['status'] = 1;
            } else {
                // Rollback transaction if users insertion fails
                $con->rollback();
                $err = 'statement not executed';
                $res['error'] = $err;
            }
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $con->rollback();
            $res['error'] = $e->getMessage();
        }
    
        // Close the connection
        $con->close();
    
        return $res;
    }

    public function DeleteRecord($table,$id) {
        $res = array();
        $res['status'] = 0;
    
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        $con->begin_transaction();
    
        try {
            $query = $con->prepare('DELETE from '.$table.' WHERE id=?');
            $query->bind_param('s',$id);
            
            if ($query->execute()) {
                $con->commit();
                $res['status'] = 1;
            } else {
                $con->rollback();
                $err = 'statement not executed';
                $res['error'] = $err;
            }
        } catch (Exception $e) {
            $con->rollback();
            $res['error'] = $e->getMessage();
        }
    
        $con->close();
    
        return $res;
    }

    public function AddSubCategory($category_id,$subcategory_name, $image, $description) {
        $res = array();
        $res['status'] = 0;
    
        // Establish database connection
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        
        // Begin transaction
        $con->begin_transaction();
    
        try {
            // Insert into users table
            $query = $con->prepare('INSERT INTO sub_categories ( category_id,name, image, description) VALUES (?, ?, ?,?)');
            $query->bind_param('ssss', $category_id,$subcategory_name, $image, $description);
            
            if ($query->execute()) {
                
                    // Commit transaction
                    $con->commit();
                    $res['status'] = 1;
            } else {
                // Rollback transaction if users insertion fails
                $con->rollback();
                $err = 'Category statement not executed';
                $res['error'] = $err;
            }
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $con->rollback();
            $res['error'] = $e->getMessage();
        }
    
        // Close the connection
        $con->close();
    
        return $res;
    }

    public function getSubCategories(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('
            SELECT sub_categories.id, sub_categories.category_id, sub_categories.name, sub_categories.image, sub_categories.description, sub_categories.status, sub_categories.created_at, categories.name AS category_name
            FROM sub_categories
            JOIN categories ON sub_categories.category_id = categories.id
            ORDER BY sub_categories.id DESC
        ');

        if($query->execute()){
            $query->bind_result($id,$category_id,$name, $image, $description, $status, $created_at,$category_name);
            $i=0;
            while($query->fetch()){
                $res['status']=1;
                $res['id'][$i] = $id;
                $res['category_id'][$i] = $category_id;
                $res['name'][$i] = $name;
                $res['image'][$i] = $image;
                $res['description'][$i] = $description;
                $res['statusval'][$i] = $status;
                $res['created_at'][$i] = $created_at;
                $res['category_name'][$i] = $category_name;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }

    public function getSubCategoriesAjax($category_id) {
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    
        // Query with a condition to filter by category_id
        $query = $con->prepare('
            SELECT sub_categories.id, sub_categories.name, sub_categories.status
            FROM sub_categories
            WHERE sub_categories.category_id = ? AND sub_categories.status = 1
        ');
    
        $query->bind_param('i', $category_id); // Bind category_id
    
        if ($query->execute()) {
            $query->bind_result($id, $name, $status);
            $i = 0;
            while ($query->fetch()) {
                $res['status'] = 1;
                $res['id'][$i] = $id;
                $res['name'][$i] = $name;
                $res['statusval'][$i] = $status;
                $i++;
            }
            $res['count'] = $i;
        } else {
            $res['error'] = 'Statement not Executed';
        }
    
        $con->close();
        return $res;
    }
    


    public function UpdateSubCategory($category_id,$subcategory_name, $image, $description,$id) {
        $res = array();
        $res['status'] = 0;
    
        // Establish database connection
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        
        // Begin transaction
        $con->begin_transaction();
    
        try {
            // Insert into users table
            $query = $con->prepare('UPDATE sub_categories SET category_id=?,name=?, image=?, description=? WHERE id=?');
            $query->bind_param('sssss', $category_id,$subcategory_name, $image, $description,$id);
            
            if ($query->execute()) {
                
                    // Commit transaction
                    $con->commit();
                    $res['status'] = 1;
            } else {
                // Rollback transaction if users insertion fails
                $con->rollback();
                $err = 'statement not executed';
                $res['error'] = $err;
            }
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $con->rollback();
            $res['error'] = $e->getMessage();
        }
    
        // Close the connection
        $con->close();
    
        return $res;
    }

    public function DeleteSubCategory($id) {
        $res = array();
        $res['status'] = 0;
    
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        $con->begin_transaction();
    
        try {
            $query = $con->prepare('DELETE from sub_categories WHERE id=?');
            $query->bind_param('s', $id);
            
            if ($query->execute()) {
                $con->commit();
                $res['status'] = 1;
            } else {
                $con->rollback();
                $err = 'statement not executed';
                $res['error'] = $err;
            }
        } catch (Exception $e) {
            $con->rollback();
            $res['error'] = $e->getMessage();
        }
    
        $con->close();
    
        return $res;
    }


    public function AddCategory($category_name, $image, $description) {
        $res = array();
        $res['status'] = 0;
    
        // Establish database connection
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        
        // Begin transaction
        $con->begin_transaction();
    
        try {
            // Insert into users table
            $query = $con->prepare('INSERT INTO categories ( name, image, description) VALUES (?, ?, ?)');
            $query->bind_param('sss', $category_name, $image, $description);
            
            if ($query->execute()) {
                
                    // Commit transaction
                    $con->commit();
                    $res['status'] = 1;
            } else {
                // Rollback transaction if users insertion fails
                $con->rollback();
                $err = 'Category statement not executed';
                $res['error'] = $err;
            }
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $con->rollback();
            $res['error'] = $e->getMessage();
        }
    
        // Close the connection
        $con->close();
    
        return $res;
    }

    public function getCategories(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT id,name,image,description,status,created_at FROM categories ORDER BY id DESC');
        if($query->execute()){
            $query->bind_result($id,$name, $image, $description, $status, $created_at);
            $i=0;
            while($query->fetch()){
                $res['status']=1;
                $res['id'][$i] = $id;
                $res['name'][$i] = $name;
                $res['image'][$i] = $image;
                $res['description'][$i] = $description;
                $res['statusval'][$i] = $status;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }


    public function UpdateCategory($category_name, $image, $description,$id) {
        $res = array();
        $res['status'] = 0;
    
        // Establish database connection
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        
        // Begin transaction
        $con->begin_transaction();
    
        try {
            // Insert into users table
            $query = $con->prepare('UPDATE categories SET name=?, image=?, description=? WHERE id=?');
            $query->bind_param('ssss', $category_name, $image, $description,$id);
            
            if ($query->execute()) {
                
                    // Commit transaction
                    $con->commit();
                    $res['status'] = 1;
            } else {
                // Rollback transaction if users insertion fails
                $con->rollback();
                $err = 'Category statement not executed';
                $res['error'] = $err;
            }
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $con->rollback();
            $res['error'] = $e->getMessage();
        }
    
        // Close the connection
        $con->close();
    
        return $res;
    }

    public function AddCoupon($coupon, $discount, $type, $expiry) {
        $res = array();
        $res['status'] = 0;
    
        // Establish database connection
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        
        // Begin transaction
        $con->begin_transaction();
    
        try {
            // Insert into users table
            $query = $con->prepare('INSERT INTO coupons ( coupon, discount, type, expiry) VALUES (?, ?, ?, ?)');
            $query->bind_param('ssss', $coupon, $discount, $type, $expiry);
            
            if ($query->execute()) {
                
                    // Commit transaction
                    $con->commit();
                    $res['status'] = 1;
            } else {
                // Rollback transaction if users insertion fails
                $con->rollback();
                $err = 'Coupon statement not executed';
                $res['error'] = $err;
            }
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $con->rollback();
            $res['error'] = $e->getMessage();
        }
    
        // Close the connection
        $con->close();
    
        return $res;
    }

    public function getCoupons(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT id,coupon,discount,type,expiry,status,created_at FROM coupons ORDER BY id DESC');
        if($query->execute()){
            $query->bind_result($id,$coupon, $discount, $type, $expiry, $status, $created_at);
            $i=0;
            while($query->fetch()){
                $res['status']=1;
                $res['id'][$i] = $id;
                $res['coupon'][$i] = $coupon;
                $res['discount'][$i] = $discount;
                $res['type'][$i] = $type;
                $res['expiry'][$i] = $expiry;
                $res['statusval'][$i] = $status;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }


    public function UpdateCoupon($coupon, $discount, $type,$expiry,$id) {
        $res = array();
        $res['status'] = 0;
    
        // Establish database connection
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        
        // Begin transaction
        $con->begin_transaction();
    
        try {
            // Insert into users table
            $query = $con->prepare('UPDATE coupons SET coupon=?, discount=?, type=?, expiry=? WHERE id=?');
            $query->bind_param('sssss', $coupon, $discount, $type,$expiry,$id);
            
            if ($query->execute()) {
                
                    // Commit transaction
                    $con->commit();
                    $res['status'] = 1;
            } else {
                // Rollback transaction if users insertion fails
                $con->rollback();
                $err = 'Coupon statement not executed';
                $res['error'] = $err;
            }
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $con->rollback();
            $res['error'] = $e->getMessage();
        }
    
        // Close the connection
        $con->close();
    
        return $res;
    }

    public function AddAdvertisement($category_name, $image, $description,$url, $location) {
        $res = array();
        $res['status'] = 0;
    
        // Establish database connection
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        
        // Begin transaction
        $con->begin_transaction();
    
        try {
            // Insert into users table
            $query = $con->prepare('INSERT INTO advertisements ( name, image, description, url, location) VALUES (?, ?, ?, ?, ?)');
            $query->bind_param('sssss', $category_name, $image, $description,$url, $location);
            
            if ($query->execute()) {
                
                    // Commit transaction
                    $con->commit();
                    $res['status'] = 1;
            } else {
                // Rollback transaction if users insertion fails
                $con->rollback();
                $err = 'advertisements statement not executed';
                $res['error'] = $err;
            }
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $con->rollback();
            $res['error'] = $e->getMessage();
        }
    
        // Close the connection
        $con->close();
    
        return $res;
    }

    public function getAdvertisements(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT id,name,image,description,url,location,status,created_at FROM advertisements ORDER BY id DESC');
        if($query->execute()){
            $query->bind_result($id,$name, $image, $description,$url,$location, $status, $created_at);
            $i=0;
            while($query->fetch()){
                $res['status']=1;
                $res['id'][$i] = $id;
                $res['name'][$i] = $name;
                $res['image'][$i] = $image;
                $res['description'][$i] = $description;
                $res['url'][$i] = $url;
                $res['location'][$i] = $location;
                $res['statusval'][$i] = $status;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }


    public function UpdateAdvertisement($category_name, $image, $description,$url,$location,$id) {
        $res = array();
        $res['status'] = 0;
    
        // Establish database connection
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        
        // Begin transaction
        $con->begin_transaction();
    
        try {
            // Insert into users table
            $query = $con->prepare('UPDATE advertisements SET name=?, image=?, description=?,url=?, location=? WHERE id=?');
            $query->bind_param('ssssss', $category_name, $image, $description, $url, $location,$id);
            
            if ($query->execute()) {
                
                    // Commit transaction
                    $con->commit();
                    $res['status'] = 1;
            } else {
                // Rollback transaction if users insertion fails
                $con->rollback();
                $err = 'Advertisements statement not executed';
                $res['error'] = $err;
            }
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $con->rollback();
            $res['error'] = $e->getMessage();
        }
    
        // Close the connection
        $con->close();
    
        return $res;
    }

    public function DeleteCategory($id) {
        $res = array();
        $res['status'] = 0;
    
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        $con->begin_transaction();
    
        try {
            $query = $con->prepare('DELETE from categories WHERE id=?');
            $query->bind_param('s', $id);
            
            if ($query->execute()) {
                $con->commit();
                $res['status'] = 1;
            } else {
                $con->rollback();
                $err = 'statement not executed';
                $res['error'] = $err;
            }
        } catch (Exception $e) {
            $con->rollback();
            $res['error'] = $e->getMessage();
        }
    
        $con->close();
    
        return $res;
    }

    public function AddStudents($student_id, $name, $email, $domain) {
        $res = array();
        $res['status'] = 0;
    
        // Establish database connection
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        
        // Begin transaction
        $con->begin_transaction();
    
        try {
            // Insert into users table
            $query = $con->prepare('INSERT INTO users (stud_id, name, email, password, domain) VALUES (?, ?, ?, ?, ?)');
            $query->bind_param('sssss', $student_id, $name, $email, $email, $domain);
            
            if ($query->execute()) {
                // Get the last inserted ID
                $user_id = $con->insert_id;
    
                // Insert into profiles table
                $profile_query = $con->prepare('INSERT INTO profiles (user_id) VALUES (?)');
                $profile_query->bind_param('i', $user_id);
                
                if ($profile_query->execute()) {
                    // Commit transaction
                    $con->commit();
                    $res['status'] = 1;
                } else {
                    // Rollback transaction if profiles insertion fails
                    $con->rollback();
                    $err = 'Profiles statement not executed';
                    $res['error'] = $err;
                }
            } else {
                // Rollback transaction if users insertion fails
                $con->rollback();
                $err = 'Users statement not executed';
                $res['error'] = $err;
            }
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $con->rollback();
            $res['error'] = $e->getMessage();
        }
    
        // Close the connection
        $con->close();
    
        return $res;
    }
    
    public function GetAddedTasks(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT id,task_date,domain,task_name,task_description,tasks,status,created_at,updated_at FROM addtasks ORDER BY id DESC');
        
        if($query->execute()){
            $query->bind_result($id,$task_date,$domain,$task_name,$task_description,$tasks,$status,$created_at,$updated_at);
            $i=0;
            while($query->fetch()){
                $res['status']=1;
                $res['id'][$i] = $id;
                $res['task_date'][$i] = $task_date;
                $res['domain'][$i] = $domain;
                $res['task_name'][$i] = $task_name;
                $res['task_description'][$i] = $task_description;
                $res['tasks'][$i] = $tasks;
                $res['status_val'][$i] = $status;
                $res['updated_at'][$i] = $updated_at;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }

    public function GetAddedStudents(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT id,stud_id,name,email,password,domain,status,created_at,updated_at FROM users ORDER BY id DESC');
        
        if($query->execute()){
            $query->bind_result($id,$stud_id,$name,$email,$password,$domain,$status,$created_at,$updated_at);
            $i=0;
            while($query->fetch()){
                $res['status']=1;
                $res['id'][$i] = $id;
                $res['stud_id'][$i] = $stud_id;
                $res['name'][$i] = $name;
                $res['email'][$i] = $email;
                $res['password'][$i] = $password;
                $res['domain'][$i] = $domain;
                $res['status_val'][$i] = $status;
                $res['updated_at'][$i] = $updated_at;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }




    // Admin Login 
    public function AdminLogin($username,$password){
        $res = array();
        $res['status']=0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT email,role FROM admin WHERE email=? AND password=?');
        $query ->bind_param('ss',$username,$password);
        if($query ->execute()){
            $query ->bind_result($email,$role);
            while($query ->fetch()){
                $res['status']=1;
                $res['email']=$email;
                $res['role']=$role;
            }
        }else{
            $err = "Statement not Executed";
        }

        $query -> close();
        $con -> close();
        return $res;
    }


    public function getProfile($id){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT name,spouse,children,father,mother,email,mobile,profession,origin,city,state,country,interest,special,photos,instagram,created_at FROM register WHERE status=1 AND id=? ORDER BY id DESC');
        $query->bind_param('s',$id);
        if($query->execute()){
            $query->bind_result($name,$spouse,$children,$father,$mother,$email,$mobile,$profession,$origin,$city,$state,$country,$interest,$special,$photos,$instagram,$created_at);
            while($query->fetch()){
                $res['status'] = 1;
                $res['name'] = $name;
                $res['spouse'] = $spouse;
                $res['children'] = $children;
                $res['father'] = $father;
                $res['mother'] = $mother;
                $res['email'] = $email;
                $res['mobile'] = $mobile;
                $res['profession'] = $profession;
                $res['origin'] = $origin;
                $res['city'] = $city;
                $res['state'] = $state;
                $res['country'] = $country;
                $res['interest'] = $interest;
                $res['special'] = $special;
                $res['photos'] = $photos;
                $res['instagram'] = $instagram;
                $res['created_at'] = $created_at;

            }
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }


    
    public function updateProfile($name,$spouse, $children, $father, $mother, $email,$mobile,$profession,$origin,$city,$state,$country,$interest,$special,$photos,$instagram,$id){
        $res = array();
        $res['status']=0;
        $con = new mysqli($this->hostName(),$this->userName(),$this->password(),$this->dbName() );
        $query = $con->prepare('UPDATE register SET name=?,spouse=?, children=?, father=?, mother=?, email=?,mobile=?,profession=?,origin=?,city=?,state=?,country=?,interest=?,special=?,photos=?,instagram=? WHERE id=?');
        $query->bind_param('sssssssssssssssss',$name,$spouse, $children, $father, $mother, $email,$mobile,$profession,$origin,$city,$state,$country,$interest,$special,$photos,$instagram,$id);
        if ($query->execute()) {
            if(!empty($query ->affected_rows) && $query ->affected_rows >0){
                $res['status']=1;
            }else{
                $err = 'Data not Inserted';
            }
        }

        $con->close();
        $query->close();
        return $res;

    }

    public function RegStatusUpdate($id,$status){
        $res = array();
        $res['status']=0;
        $con = new mysqli($this->hostName(),$this->userName(),$this->password(),$this->dbName() );
        $query = $con->prepare('UPDATE registrations SET status=? WHERE sno=?');
        if($status == 'Inactive'){
            $status='0';
        }else{
            $status='1';
        }
        $query->bind_param('ss',$status,$id);
        if ($query->execute()) {
            if(!empty($query ->affected_rows) && $query ->affected_rows >0){
                $res['status']=1;
            }else{
                $err = 'Data not Inserted';
            }
        }

        $con->close();
        $query->close();
        return $res;

    }

    //Change Password
    public function changepwd($id,$password){
        $res = array();
        $res['status']=0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('UPDATE register set password=? where id=?');
        $query ->bind_param('ss',$password,$id);
        if($query ->execute()){
                $res['status']=1;
        }else{
            $err = "Statement not Executed";
        }

        $query -> close();
        $con -> close();
        return $res;
    }


    // Blogs Submission
    public function blogs($image, $heading, $meta, $description){
        $res =array();
        $res['status']=0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('INSERT INTO blogs (image, heading, description, meta) values (?,?,?,?)');
        $query ->bind_param('ssss',$image, $heading, $description, $meta);
        if($query ->execute()){
            if(!empty($query ->affected_rows) && $query ->affected_rows >0){
                $res['status']=1;
            }else{
                $err = 'Data not Inserted';
            }
        }else{
            $err = 'Statement Not Executed';
        }
        return $res;
    }

    // Clients Submission
    public function clients($client_logo, $client_name){
        $res =array();
        $res['status']=0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('INSERT INTO clients (client_logo, client_name) values (?,?)');
        $query ->bind_param('ss',$client_logo, $client_name);
        if($query ->execute()){
            if(!empty($query ->affected_rows) && $query ->affected_rows >0){
                $res['status']=1;
            }else{
                $err = 'Data not Inserted';
            }
        }else{
            $err = 'Statement Not Executed';
        }
        return $res;
    }

    

    //contacts Retieval



    //Plans Retieval
    public function getPlans(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT pickup_location,drop_location,travel_date,return_date,travellers,name,mobile,email,message,created_at FROM plans ORDER BY sno DESC');
        if($query->execute()){
            $query->bind_result($pickup_location,$drop_location,$travel_date,$return_date,$travellers,$name,$mobile,$email,$message,$created_at);
            $i=1;
            while($query->fetch()){
                $res['status']=1;
                $res['name'][$i] = $name;
                $res['email'][$i] = $email;
                $res['mobile'][$i] = $mobile;
                $res['message'][$i] = $message;
                $res['pickup_location'][$i] = $pickup_location;
                $res['drop_location'][$i] = $drop_location;
                $res['travel_date'][$i] = $travel_date;
                $res['return_date'][$i] = $return_date;
                $res['travellers'][$i] = $travellers;
                $res['created_at'][$i] = $created_at;
                $res['status']=1;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }

    
    //Plans Retieval
    public function bike_rental(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT pickup_location,drop_location,travel_date,return_date,bike_model,name,mobile,email,message,created_at FROM bike_rental ORDER BY sno DESC');
        if($query->execute()){
            $query->bind_result($pickup_location,$drop_location,$travel_date,$return_date,$bike_model,$name,$mobile,$email,$message,$created_at);
            $i=1;
            while($query->fetch()){
                $res['status']=1;
                $res['name'][$i] = $name;
                $res['email'][$i] = $email;
                $res['mobile'][$i] = $mobile;
                $res['message'][$i] = $message;
                $res['pickup_location'][$i] = $pickup_location;
                $res['drop_location'][$i] = $drop_location;
                $res['travel_date'][$i] = $travel_date;
                $res['return_date'][$i] = $return_date;
                $res['bike_model'][$i] = $bike_model;
                $res['created_at'][$i] = $created_at;
                $res['status']=1;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }


     //Subscribes Retieval
     public function getSubscribes(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT mobile,created_at FROM callbacks ORDER BY sno DESC');
        if($query->execute()){
            $query->bind_result($mobile, $updatedtime);
            $i=1;
            while($query->fetch()){
                $res['status']=1;
                $res['mobile'][$i] = $mobile;
                $res['updatedtime'][$i] = $updatedtime;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }

      //Blogs Retieval
      public function getBlogsOldAlumni(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT image, heading, meta, description, created_at FROM blogs ORDER BY sno DESC');
        if($query->execute()){
            $query->bind_result($image, $heading, $meta, $description, $created_at);
            $i=1;
            while($query->fetch()){
                $res['status']=1;
                $res['image'][$i] = $image;
                $res['heading'][$i] = $heading;
                $res['meta'][$i] = $meta;
                $res['description'][$i] = $description;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count']=$i;
        }else{

            $err = 'Statement not Executed';
        }
        return $res;
    }


      //Clients Retieval
      public function getClients(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT client_logo, client_name,updatedtime FROM clients ORDER BY sno DESC');
        if($query->execute()){
            $query->bind_result($client_logo, $client_name, $updatedtime);
            $i=1;
            while($query->fetch()){
                $res['status']=1;
                $res['client_logo'][$i] = $client_logo;
                $res['client_name'][$i] = $client_name;
                $res['updatedtime'][$i] = $updatedtime;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }

    public function getOrders() {
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT 
                                    o.id, o.user_id, o.billing_fullname, o.billing_email, o.billing_mobile, 
                                    o.billing_address1, o.billing_address2, o.billing_city, o.billing_state, o.billing_pincode, 
                                    o.shipping_fullname, o.shipping_email, o.shipping_mobile, o.shipping_address1, 
                                    o.shipping_address2, o.shipping_city, o.shipping_state, o.shipping_pincode, 
                                    o.total_products, o.subtotal, o.gst, o.total, o.grandtotal, o.coupon, o.discount, 
                                    o.coupon_type, o.payment_mode, o.payment_amount, o.payment_reference, o.payment_proof, 
                                    o.approval, o.order_status, o.remarks, o.status, o.created_at,
                                    u.name AS user_name, u.email AS user_email, u.mobile AS user_mobile, u.address AS user_address
                                FROM orders o
                                LEFT JOIN users u ON o.user_id = u.id
                                ORDER BY o.id DESC');
        
        if ($query->execute()) {
            $query->bind_result(
                $id, $user_id, $billing_fullname, $billing_email, $billing_mobile, 
                $billing_address1, $billing_address2, $billing_city, $billing_state, $billing_pincode, 
                $shipping_fullname, $shipping_email, $shipping_mobile, $shipping_address1, 
                $shipping_address2, $shipping_city, $shipping_state, $shipping_pincode, 
                $total_products, $subtotal, $gst, $total, $grandtotal, $coupon, $discount, 
                $coupon_type, $payment_mode, $payment_amount, $payment_reference, $payment_proof, 
                $approval, $order_status, $remarks, $status, $created_at,
                $user_name, $user_email, $user_mobile, $user_address
            );
            $i = 0;
            while ($query->fetch()) {
                $res['status'] = 1;
                $res['id'][$i] = $id;
                $res['user_id'][$i] = $user_id;
                $res['billing_fullname'][$i] = $billing_fullname;
                $res['billing_email'][$i] = $billing_email;
                $res['billing_mobile'][$i] = $billing_mobile;
                $res['billing_address1'][$i] = $billing_address1;
                $res['billing_address2'][$i] = $billing_address2;
                $res['billing_city'][$i] = $billing_city;
                $res['billing_state'][$i] = $billing_state;
                $res['billing_pincode'][$i] = $billing_pincode;
                $res['shipping_fullname'][$i] = $shipping_fullname;
                $res['shipping_email'][$i] = $shipping_email;
                $res['shipping_mobile'][$i] = $shipping_mobile;
                $res['shipping_address1'][$i] = $shipping_address1;
                $res['shipping_address2'][$i] = $shipping_address2;
                $res['shipping_city'][$i] = $shipping_city;
                $res['shipping_state'][$i] = $shipping_state;
                $res['shipping_pincode'][$i] = $shipping_pincode;
                $res['total_products'][$i] = $total_products;
                $res['subtotal'][$i] = $subtotal;
                $res['gst'][$i] = $gst;
                $res['total'][$i] = $total;
                $res['grandtotal'][$i] = $grandtotal;
                $res['coupon'][$i] = $coupon;
                $res['discount'][$i] = $discount;
                $res['coupon_type'][$i] = $coupon_type;
                $res['payment_mode'][$i] = $payment_mode;
                $res['payment_amount'][$i] = $payment_amount;
                $res['payment_reference'][$i] = $payment_reference;
                $res['payment_proof'][$i] = $payment_proof;
                $res['approval'][$i] = $approval;
                $res['order_status'][$i] = $order_status;
                $res['remarks'][$i] = $remarks;
                $res['statusval'][$i] = $status; // Renamed to avoid conflict with the overall 'status' field
                $res['created_at'][$i] = $created_at;
                $res['user_name'][$i] = $user_name;
                $res['user_email'][$i] = $user_email;
                $res['user_mobile'][$i] = $user_mobile;
                $res['user_address'][$i] = $user_address;
                $i++;
            }
            $res['count'] = $i;
        } else {
            $res['error'] = 'Statement not Executed';
        }
        return $res;
    }
    

    public function getOrderProducts($order_id) {
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT 
                                    id, order_id, user_id, product_id, product_name, product_image, 
                                    quantity, product_weight, price_per_gram, product_actual_price, 
                                    product_price, product_slug, product_type, status, created_at 
                                FROM order_products 
                                WHERE order_id = ? 
                                ORDER BY id DESC');
        
        $query->bind_param('i', $order_id);
        
        if ($query->execute()) {
            $query->bind_result(
                $id, $order_id, $user_id, $product_id, $product_name, $product_image, 
                $quantity, $product_weight, $price_per_gram, $product_actual_price, 
                $product_price, $product_slug, $product_type, $status, $created_at
            );
            $i = 0;
            while ($query->fetch()) {
                $res['status'] = 1;
                $res['id'][$i] = $id;
                $res['order_id'][$i] = $order_id;
                $res['user_id'][$i] = $user_id;
                $res['product_id'][$i] = $product_id;
                $res['product_name'][$i] = $product_name;
                $res['product_image'][$i] = $product_image;
                $res['quantity'][$i] = $quantity;
                $res['product_weight'][$i] = $product_weight;
                $res['price_per_gram'][$i] = $price_per_gram;
                $res['product_actual_price'][$i] = $product_actual_price;
                $res['product_price'][$i] = $product_price;
                $res['product_slug'][$i] = $product_slug;
                $res['product_type'][$i] = $product_type;
                $res['status_field'][$i] = $status;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count'] = $i;
        } else {
            $err = 'Statement not Executed';
        }
        return $res;
    }


    public function getUsers(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT id,name,email,mobile,address,status,created_at FROM users ORDER BY id DESC');
        if($query->execute()){
            $query->bind_result($id,$name, $email, $mobile, $address, $status, $created_at);
            $i=0;
            while($query->fetch()){
                $res['status']=1;
                $res['id'][$i] = $id;
                $res['name'][$i] = $name;
                $res['email'][$i] = $email;
                $res['mobile'][$i] = $mobile;
                $res['address'][$i] = $address;
                $res['statusval'][$i] = $status;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }
    public function getCustomizations(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        // Modified query to join users table and fetch username, email, and mobile
        $query = $con->prepare('
            SELECT c.id, c.user_id, c.image, c.reference, c.status, c.created_at, 
                   u.name, u.email, u.mobile 
            FROM customizations c 
            JOIN users u ON c.user_id = u.id 
            ORDER BY c.id DESC
        ');
        
        if($query->execute()){
            $query->bind_result($id, $user_id, $image, $reference, $status, $created_at, $username, $email, $mobile);
            $i = 0;
            while($query->fetch()){
                $res['status'] = 1;
                $res['id'][$i] = $id;
                $res['user_id'][$i] = $user_id;
                $res['image'][$i] = $image;
                $res['product_slug'][$i] = $reference;
                $res['statusval'][$i] = $status;
                $res['created_at'][$i] = $created_at;
                $res['user_name'][$i] = $username;
                $res['user_email'][$i] = $email;
                $res['user_mobile'][$i] = $mobile;
                $i++;
            }
            $res['count'] = $i;
        } else {
            $err = 'Statement not Executed';
        }
        return $res;
    }
    
        public function getContact(){
            $res = array();
            $res['status'] = 0;
            $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
            $query = $con->prepare('SELECT id, name, email, subject, message, submitted_at FROM contact ORDER BY id DESC');
            if($query->execute()){
                $query->bind_result($id, $name, $email, $subject, $message, $created_at);
                $i=0;
                while($query->fetch()){
                    $res['status']=1;
                    $res['id'][$i] = $id;
                    $res['name'][$i] = $name;
                    $res['email'][$i] = $email;
                    $res['subject'][$i] = $subject;
                    $res['message'][$i] = $message;
                    $res['submitted_at'][$i] = $created_at;
                    $i++;
                }
                $res['count']=$i;
            }else{
                $err = 'Statement not Executed';
            }
            return $res;
        }
        public function getSubscribers(){
            $res = array();
            $res['status'] = 0;
            $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
            $query = $con->prepare('SELECT id, email, subscribed_at FROM subscriptions ORDER BY id DESC');
            if($query->execute()){
                $query->bind_result($id, $email, $subsribed_at);
                $i=0;
                while($query->fetch()){
                    $res['status']=1;
                    $res['id'][$i] = $id;
                    $res['email'][$i] = $email;
                    $res['subscribed_at'][$i] = $subsribed_at;
                    $i++;
                }
                $res['count']=$i;
            }else{
                $err = 'Statement not Executed';
            }
            return $res;
        }


        public function AddPartner($name, $image) {
            $res = array();
            $res['status'] = 0;
        
            // Establish database connection
            $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
            
            // Check connection
            if ($con->connect_error) {
                die("Connection failed: " . $con->connect_error);
            }
            
            // Begin transaction
            $con->begin_transaction();
        
            try {
                // Insert into partners table
                $query = $con->prepare('INSERT INTO partners (name, image) VALUES (?, ?)');
                $query->bind_param('ss', $name, $image);
                
                if ($query->execute()) {
                    // Commit transaction
                    $con->commit();
                    $res['status'] = 1;
                } else {
                    // Rollback transaction if insertion fails
                    $con->rollback();
                    $err = 'Partner statement not executed: ' . $query->error;
                    $res['error'] = $err;
                    error_log($err); // Log the error for debugging
                }
            } catch (Exception $e) {
                // Rollback transaction in case of error
                $con->rollback();
                $res['error'] = $e->getMessage();
                error_log($e->getMessage()); // Log the exception for debugging
            }
        
            // Close the connection
            $con->close();
        
            return $res;
        }


            public function getPartners() {
            $res = array();
            $res['status'] = 0;
            $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());

            if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
            }

            $query = $con->prepare("SELECT id, name, image, created_at FROM partners ORDER BY id DESC");

            if ($query->execute()) {
            $query->bind_result($id, $name, $image, $created_at);
            $i = 0;
            while ($query->fetch()) {
                $res['status'] = 1;
                $res['id'][$i] = $id;
                $res['name'][$i] = $name;
                $res['image'][$i] = $image;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count'] = $i;
            } else {
            $res['error'] = 'Statement not executed: ' . $query->error;
            }

            $query->close();
            $con->close();

            return $res;
            }

            public function getTestimonials() {
                $res = array();
                $res['status'] = 0;
                
                $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
                
                if ($con->connect_error) {
                    error_log("Connection failed: " . $con->connect_error);
                    die("Connection failed: " . $con->connect_error);
                }
            
                $query = $con->prepare("SELECT id, name, subject, message, rating, image, status, created_at 
                                       FROM testimonials 
                                       ORDER BY created_at DESC");
                
                if (!$query) {
                    error_log("Prepare failed: " . $con->error);
                    return $res;
                }
                
                if ($query->execute()) {
                    $query->bind_result($id, $name, $subject, $message, $rating, $image, $status, $created_at);
                    $i = 0;
                    while ($query->fetch()) {
                        $res['status'] = 1;
                        $res['id'][$i] = $id;
                        $res['name'][$i] = $name;
                        $res['subject'][$i] = $subject;
                        $res['message'][$i] = $message;
                        $res['rating'][$i] = $rating;
                        $res['image'][$i] = $image;
                        $res['statusval'][$i] = $status;
                        $res['created_at'][$i] = $created_at;
                        $i++;
                    }
                    $res['count'] = $i;
                    error_log("Found " . $i . " testimonials");
                } else {
                    error_log("Execute failed: " . $query->error);
                }
            
                $query->close();
                $con->close();
                
                return $res;
            }

            public function getTestimonialById($id) {
                $res = array();
                $res['status'] = 0;
                
                $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
                
                if ($con->connect_error) {
                    error_log("Connection failed: " . $con->connect_error);
                    die("Connection failed: " . $con->connect_error);
                }
            
                $query = $con->prepare("SELECT id, name, subject, message, rating, image, status, created_at 
                                       FROM testimonials 
                                       WHERE id = ?");
                
                if (!$query) {
                    error_log("Prepare failed: " . $con->error);
                    return $res;
                }
                
                $query->bind_param('i', $id);
                
                if ($query->execute()) {
                    $query->bind_result($id, $name, $subject, $message, $rating, $image, $status, $created_at);
                    
                    if ($query->fetch()) {
                        $res['status'] = 1;
                        $res['id'] = $id;
                        $res['name'] = $name;
                        $res['subject'] = $subject;
                        $res['review'] = $message; // Map 'message' to 'review' for form
                        $res['designation'] = $subject; // Map 'subject' to 'designation' for form
                        $res['rating'] = $rating;
                        $res['image'] = $image;
                        $res['statusval'] = $status;
                        $res['created_at'] = $created_at;
                        error_log("Found testimonial with ID: " . $id);
                    } else {
                        error_log("Testimonial with ID " . $id . " not found");
                    }
                } else {
                    error_log("Execute failed: " . $query->error);
                }
            
                $query->close();
                $con->close();
                
                return $res;
            }
            
            public function UpdateTestimonial($id, $name, $designation, $review, $rating, $image) {
                $res = array();
                $res['status'] = 0;
                
                $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
                
                if ($con->connect_error) {
                    error_log("Connection failed: " . $con->connect_error);
                    die("Connection failed: " . $con->connect_error);
                }
            
                try {
                    $con->begin_transaction();
                    
                    // Set current timestamp for updated_at
                    $updated_at = date('Y-m-d H:i:s');
                    
                    // Map form fields to database fields:
                    // 'designation' form field becomes 'subject' in database
                    // 'review' form field becomes 'message' in database
                    $query = $con->prepare("UPDATE testimonials 
                                           SET name = ?, subject = ?, message = ?, rating = ?, image = ?, updated_at = ? 
                                           WHERE id = ?");
                    
                    if (!$query) {
                        throw new Exception("Prepare failed: " . $con->error);
                    }
                    
                    $query->bind_param('sssissi', $name, $designation, $review, $rating, $image, $updated_at, $id);
                    
                    if ($query->execute()) {
                        if ($query->affected_rows > 0 || $query->affected_rows === 0) {
                            $res['status'] = 1;
                            error_log("Testimonial updated successfully: " . $id);
                            $con->commit();
                        } else {
                            throw new Exception("Failed to update testimonial: No rows affected");
                        }
                    } else {
                        throw new Exception("Execute failed: " . $query->error);
                    }
                    
                } catch (Exception $e) {
                    $con->rollback();
                    error_log("Error updating testimonial: " . $e->getMessage());
                    $res['message'] = $e->getMessage();
                }
            
                if (isset($query)) {
                    $query->close();
                }
                $con->close();
                
                return $res;
            }
                
            public function UpdateLakshmiKuberaStatus($product_id, $status) {
                $res = array();
                $res['status'] = 0;

                $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());

                if ($con->connect_error) {
                    $res['error'] = "Connection failed: " . $con->connect_error;
                    return $res;
                }

                $query = $con->prepare("UPDATE products SET is_lakshmi_kubera = ? WHERE id = ?");
                $query->bind_param('ii', $status, $product_id);

                if ($query->execute()) {
                    $res['status'] = 1;
                } else {
                    $res['error'] = "Statement not executed: " . $query->error;
                }

                $query->close();
                $con->close();
                return $res;
            }
            public function getProductReviews() {
                $res = array();
                $res['status'] = 0;
                
                $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
                
                if ($con->connect_error) {
                    error_log("Connection failed: " . $con->connect_error);
                    die("Connection failed: " . $con->connect_error);
                }
            
                $query = $con->prepare("
                    SELECT 
                        pr.id,
                        pr.user_id,
                        pr.product_id,
                        pr.rating,
                        pr.review,
                        pr.status,
                        pr.created_at,
                        p.product_name,
                        u.name as user_name
                    FROM ratings pr 
                    LEFT JOIN products p ON pr.product_id = p.id 
                    LEFT JOIN users u ON pr.user_id = u.id 
                    ORDER BY pr.created_at DESC
                ");
                
                if (!$query) {
                    error_log("Prepare failed: " . $con->error);
                    return $res;
                }
                
                if ($query->execute()) {
                    $query->bind_result($id, $user_id, $product_id, $rating, $review, $status, $created_at, $product_name, $user_name);
                    $i = 0;
                    while ($query->fetch()) {
                        $res['status'] = 1;
                        $res['id'][$i] = $id;
                        $res['user_id'][$i] = $user_id;
                        $res['product_id'][$i] = $product_id;
                        $res['rating'][$i] = $rating;
                        $res['review'][$i] = $review;
                        $res['statusval'][$i] = $status; // Changed from status to statusval for consistency
                        $res['created_at'][$i] = $created_at;
                        $res['product_name'][$i] = $product_name;
                        $res['user_name'][$i] = $user_name;
                        $i++;
                    }
                    $res['count'] = $i;
                    error_log("Found " . $i . " product reviews");
                } else {
                    error_log("Execute failed: " . $query->error);
                }
            
                $query->close();
                $con->close();
                
                return $res;
            }

    
            public function  getPayments() {
                $res = array();
                $res['result'] = 0;
                
                $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
                
                $query = $con->prepare('SELECT 
                    id,
                    order_id,
                    razorpay_order_id,
                    user_id,
                    billing_fullname,
                    billing_email,
                    billing_mobile,
                    total_products,
                    subtotal,
                    gst,
                    total,
                    grandtotal,
                    payment_mode,
                    payment_amount,
                    payment_reference,
                    payment_id,
                    payment_date,
                    payment_status,
                    order_status,
                    created_at
                FROM orders 
                ORDER BY id DESC');
                
                if ($query->execute()) {
                    $result = $query->get_result();
                    $i = 0;
                    
                    while ($row = $result->fetch_assoc()) {
                        $res['result'] = 1;
                        $res['id'][$i] = $row['id'];
                        $res['order_id'][$i] = $row['order_id'];
                        $res['razorpay_order_id'][$i] = $row['razorpay_order_id'];
                        $res['user_id'][$i] = $row['user_id'];
                        $res['billing_fullname'][$i] = $row['billing_fullname'];
                        $res['billing_email'][$i] = $row['billing_email'];
                        $res['billing_mobile'][$i] = $row['billing_mobile'];
                        $res['total_products'][$i] = $row['total_products'];
                        $res['subtotal'][$i] = $row['subtotal'];
                        $res['gst'][$i] = $row['gst'];
                        $res['total'][$i] = $row['total'];
                        $res['grandtotal'][$i] = $row['grandtotal'];
                        $res['payment_mode'][$i] = $row['payment_mode'];
                        $res['payment_amount'][$i] = $row['payment_amount'];
                        $res['payment_reference'][$i] = $row['payment_reference'];
                        $res['payment_id'][$i] = $row['payment_id'];
                        $res['payment_date'][$i] = $row['payment_date'];
                        $res['payment_status'][$i] = $row['payment_status'];
                        $res['order_status'][$i] = $row['order_status'];
                        $res['created_at'][$i] = $row['created_at'];
                        $i++;
                    }
                    $res['count'] = $i;
                }
                
                $query->close();
                $con->close();
                return $res;
            }
            public function getOrderDetails($order_id) {
                $res = array();
                $res['status'] = 0;
            
                try {
                    $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
                    
                    if ($con->connect_error) {
                        throw new Exception("Connection failed: " . $con->connect_error);
                    }
            
                    // Get order information with formatted date
                    $orderQuery = $con->prepare("
                        SELECT 
                            o.*,
                            DATE_FORMAT(o.created_at, '%d %M %Y') as formatted_date
                        FROM orders o 
                        WHERE o.id = ?
                    ");
                    
                    $orderQuery->bind_param('i', $order_id);
                    $orderQuery->execute();
                    $orderResult = $orderQuery->get_result();
                    
                    if ($orderRow = $orderResult->fetch_assoc()) {
                        $res['order'] = $orderRow;
                        $res['status'] = 1;
                        
                        // Get ordered products from order_products table
                        $productQuery = $con->prepare("
                            SELECT 
                                op.*,
                                o.payment_status,
                                o.order_status
                            FROM order_products op
                            JOIN orders o ON op.order_id = o.id
                            WHERE op.order_id = ?
                            ORDER BY op.id ASC
                        ");
                        
                        $productQuery->bind_param('i', $order_id);
                        $productQuery->execute();
                        $productResult = $productQuery->get_result();
                        
                        $products = array();
                        $total_items = 0;
                        
                        while ($row = $productResult->fetch_assoc()) {
                            $products[] = array(
                                'id' => $row['id'],
                                'product_id' => $row['product_id'],
                                'product_name' => $row['product_name'],
                                'product_image' => $row['product_image'],
                                'quantity' => $row['quantity'],
                                'product_type' => $row['product_type'],
                                'product_weight' => $row['product_weight'],
                                'price_per_gram' => $row['price_per_gram'],
                                'product_actual_price' => $row['product_actual_price'],
                                'product_price' => $row['product_price'],
                                'product_slug' => $row['product_slug'],
                                'payment_status' => $row['payment_status'],
                                'order_status' => $row['order_status']
                            );
                            
                            $total_items += $row['quantity'];
                        }
                        
                        $res['products'] = $products;
                        $res['total_items'] = $total_items;
                    }
            
                } catch (Exception $e) {
                    $res['error'] = $e->getMessage();
                } finally {
                    if (isset($orderQuery)) $orderQuery->close();
                    if (isset($productQuery)) $productQuery->close();
                    if (isset($con)) $con->close();
                }
            
                return $res;
            }
            
            public function getDashboardStats($timeframe = 'all') {
                $stats = array();
                try {
                    $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
                    
                    // Set time constraint based on timeframe
                    $timeConstraint = '';
                    switch($timeframe) {
                        case '24h':
                            $timeConstraint = "AND created_at >= DATE_SUB(NOW(), INTERVAL 24 HOUR)";
                            break;
                        case '7d':
                            $timeConstraint = "AND created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
                            break;
                        case '30d':
                            $timeConstraint = "AND created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
                            break;
                    }
            
                    // Orders Statistics
                    $orderQuery = $con->query("
                        SELECT 
                            COUNT(*) as total_orders,
                            COUNT(CASE WHEN order_status = 'pending' THEN 1 END) as pending_orders,
                            COUNT(CASE WHEN order_status = 'confirmed' THEN 1 END) as confirmed_orders,
                            COUNT(CASE WHEN order_status = 'processing' THEN 1 END) as processing_orders,
                            COUNT(CASE WHEN order_status = 'shipped' THEN 1 END) as shipped_orders,
                            COUNT(CASE WHEN order_status = 'delivered' THEN 1 END) as delivered_orders,
                            COUNT(CASE WHEN payment_status = 'paid' THEN 1 END) as paid_orders,
                            SUM(payment_amount) as total_revenue
                        FROM orders 
                        WHERE status = 1 $timeConstraint"
                    );
                    $stats['orders'] = $orderQuery->fetch_assoc();
            
                    // Categories and Subcategories
                    $categoryQuery = $con->query("
                        SELECT 
                            (SELECT COUNT(*) FROM categories WHERE status = 1) as total_categories,
                            (SELECT COUNT(*) FROM sub_categories WHERE status = 1) as total_subcategories
                    ");
                    $stats['categories'] = $categoryQuery->fetch_assoc();
            
                    // Products Statistics
                    $productQuery = $con->query("
                        SELECT 
                            COUNT(*) as total_products,
                            COUNT(CASE WHEN status = 1 THEN 1 END) as active_products,
                            COUNT(CASE WHEN is_popular_collection = '1' THEN 1 END) as popular_products,
                            COUNT(CASE WHEN is_recommended = '1' THEN 1 END) as recommended_products,
                            COUNT(CASE WHEN is_lakshmi_kubera = '1' THEN 1 END) as special_products
                        FROM products
                        WHERE status = 1 $timeConstraint"
                    );
                    $stats['products'] = $productQuery->fetch_assoc();
            
                    // Users and Reviews
                    $userQuery = $con->query("
                        SELECT 
                            (SELECT COUNT(*) FROM users WHERE status = 1) as total_users,
                            (SELECT COUNT(*) FROM ratings WHERE status = 1) as total_reviews,
                            (SELECT COUNT(*) FROM contact) as total_inquiries,
                            (SELECT COUNT(*) FROM subscriptions) as total_subscribers
                    ");
                    $stats['users'] = $userQuery->fetch_assoc();
            
                    // Cart and Wishlist Analysis
                    $cartQuery = $con->query("
                        SELECT 
                            COUNT(DISTINCT user_id) as users_with_cart,
                            COUNT(*) as total_cart_items
                        FROM cart 
                        WHERE status = 1"
                    );
                    $stats['cart'] = $cartQuery->fetch_assoc();
            
                    $wishlistQuery = $con->query("
                        SELECT 
                            COUNT(DISTINCT user_id) as users_with_wishlist,
                            COUNT(*) as total_wishlist_items
                        FROM wishlist 
                        WHERE status = 1"
                    );
                    $stats['wishlist'] = $wishlistQuery->fetch_assoc();
            
                } catch (Exception $e) {
                    error_log("Error in getDashboardStats: " . $e->getMessage());
                    $stats['error'] = $e->getMessage();
                } finally {
                    if (isset($con)) $con->close();
                }
                
               
                return $stats;
            }

public function saveShipment($shipment_data) {
    $res = array();
    $res['status'] = 0;
    
    // Establish database connection
    $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    
    // Check connection
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    
    // Begin transaction
    $con->begin_transaction();
    
    try {
        // Build columns and values for insertion
        $columns = implode(', ', array_keys($shipment_data));
        $placeholders = '';
        $types = '';
        $values = [];
        
        // Build the placeholder string and types string for bind_param
        foreach ($shipment_data as $key => $value) {
            $placeholders .= '?, ';
            if (is_int($value)) {
                $types .= 'i';
            } elseif (is_float($value)) {
                $types .= 'd';
            } else {
                $types .= 's';
            }
            $values[] = $value;
        }
        
        // Remove trailing comma and space from placeholders
        $placeholders = rtrim($placeholders, ', ');
        
        // Create SQL query
        $sql = "INSERT INTO shipments ($columns) VALUES ($placeholders)";
        $stmt = $con->prepare($sql);
        
        if ($stmt) {
            // Use reflection to bind parameters dynamically
            $params = array();
            $params[] = &$types;
            
            for ($i = 0; $i < count($values); $i++) {
                $params[] = &$values[$i];
            }
            
            call_user_func_array(array($stmt, 'bind_param'), $params);
            
            if ($stmt->execute()) {
                $con->commit();
                $res['status'] = 1;
                $res['insert_id'] = $stmt->insert_id;
            } else {
                $con->rollback();
                $res['error'] = 'Statement not executed: ' . $stmt->error;
            }
        } else {
            $con->rollback();
            $res['error'] = 'Prepare statement failed: ' . $con->error;
        }
    } catch (Exception $e) {
        $con->rollback();
        $res['error'] = $e->getMessage();
    }
    
    // Close the connection
    if (isset($stmt)) {
        $stmt->close();
    }
    $con->close();
    
    return $res['status'] == 1;
}


public function getShipmentByOrderId($order_id) {
    $res = array();
    $res['status'] = 0;
    
    $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    
    if ($con->connect_error) {
        error_log("Connection failed: " . $con->connect_error);
        return null;
    }
    
    $query = $con->prepare("SELECT * FROM shipments WHERE order_id = ? ORDER BY created_at DESC LIMIT 1");
    
    if (!$query) {
        error_log("Prepare failed: " . $con->error);
        $con->close();
        return null;
    }
    
    $query->bind_param('s', $order_id);
    
    if ($query->execute()) {
        $result = $query->get_result();
        $shipment = $result->fetch_assoc();
        $query->close();
        $con->close();
        return $shipment;
    } else {
        error_log("Execute failed: " . $query->error);
        $query->close();
        $con->close();
        return null;
    }
}


public function getAllShipments($limit = 20, $offset = 0) {
    $res = array();
    $res['status'] = 0;
    
    $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    
    if ($con->connect_error) {
        error_log("Connection failed: " . $con->connect_error);
        return [];
    }
    
    $query = $con->prepare("SELECT * FROM shipments ORDER BY created_at DESC LIMIT ?, ?");
    
    if (!$query) {
        error_log("Prepare failed: " . $con->error);
        $con->close();
        return [];
    }
    
    $query->bind_param('ii', $offset, $limit);
    
    $shipments = [];
    if ($query->execute()) {
        $result = $query->get_result();
        while ($row = $result->fetch_assoc()) {
            $shipments[] = $row;
        }
    } else {
        error_log("Execute failed: " . $query->error);
    }
    
    $query->close();
    $con->close();
    return $shipments;
}

public function updateShipmentStatus($order_id, $status) {
    $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    
    if ($con->connect_error) {
        error_log("Connection failed: " . $con->connect_error);
        return false;
    }
    
    $stmt = $con->prepare("UPDATE shipments SET status = ? WHERE order_id = ?");
    
    if (!$stmt) {
        error_log("Prepare failed: " . $con->error);
        $con->close();
        return false;
    }
    
    $stmt->bind_param("si", $status, $order_id);
    
    $success = $stmt->execute();
    
    $stmt->close();
    $con->close();
    
    return $success;
}
public function updateOrderStatus($order_id, $order_status) {
    $res = array();
    $res['status'] = 0;

    $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());

    if ($con->connect_error) {
        $res['error'] = "Connection failed: " . $con->connect_error;
        return $res;
    }

    try {
        error_log("Updating order ID: $order_id to status: $order_status");

        $query = $con->prepare("UPDATE orders SET order_status = ? WHERE id = ?");

        if (!$query) {
            $res['error'] = "Prepare failed: " . $con->error;
            return $res;
        }

        $query->bind_param('si', $order_status, $order_id);

        if ($query->execute()) {
            $res['status'] = 1;
            $res['message'] = "Status updated successfully";
            error_log("Update successful. Affected rows: " . $query->affected_rows);
        } else {
            $res['error'] = "Error executing query: " . $query->error;
            error_log("Update failed: " . $query->error);
        }

        $query->close();
    } catch (Exception $e) {
        $res['error'] = "Exception: " . $e->getMessage();
        error_log("Exception in updateOrderStatus: " . $e->getMessage());
    }

    $con->close();
    return $res;
}



        }


?>