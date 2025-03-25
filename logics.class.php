<?php
require_once('./dbcredentials.class.php');


class logics extends dbcredentials
{

    //Submitted Tasks Retieval
    public function SubmittedTasks()
    {
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
        if ($query->execute()) {
            $query->bind_result($task, $url, $doubts, $created_at, $stud_id, $name, $email, $domain);
            $i = 0;
            while ($query->fetch()) {
                $res['status'] = 1;
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
            $res['count'] = $i;
        } else {
            $err = 'Statement not Executed';
        }
        return $res;
    }


    public function getUsers()
    {
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT stud_id,name,email,domain,created_at FROM users ORDER BY id DESC');
        if ($query->execute()) {
            $query->bind_result($stud_id, $name, $email, $domain, $created_at);
            $i = 0;
            while ($query->fetch()) {
                $res['status'] = 1;
                $res['stud_id'][$i] = $stud_id;
                $res['name'][$i] = $name;
                $res['email'][$i] = $email;
                $res['domain'][$i] = $domain;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count'] = $i;
        } else {
            $err = 'Statement not Executed';
        }
        return $res;
    }


    public function getUsersProfile()
    {
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
        if ($query->execute()) {
            $query->bind_result($id, $stud_id, $name, $email, $password, $domain, $status, $created_at, $updated_at, $mobile, $college, $dept, $yop, $address, $profile);
            $i = 0;
            while ($query->fetch()) {
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
            $res['count'] = $i;
        } else {
            $err = 'Statement not Executed';
        }
        return $res;
    }

    public function getInactiveUsersProfile()
    {
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
        if ($query->execute()) {
            $query->bind_result($id, $stud_id, $name, $email, $password, $domain, $status, $created_at, $updated_at, $mobile, $college, $dept, $yop, $address, $profile);
            $i = 0;
            while ($query->fetch()) {
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
            $res['count'] = $i;
        } else {
            $err = 'Statement not Executed';
        }
        return $res;
    }

    public function updateUserProfileById($stud_id, $name, $email, $password, $domain, $mobile, $college, $dept, $yop, $address, $profile, $id)
    {
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
            $stud_id,
            $name,
            $email,
            $password,
            $domain,
            $mobile,
            $college,
            $dept,
            $yop,
            $address,
            $profile,
            $id
        );

        // Execute the query and check the result
        if ($query->execute()) {
            $res['status'] = 1;
            $res['message'] = 'Profile updated successfully';
        } else {
            $res['status'] = 0;
            $res['message'] = 'Failed to update profile';
        }

        // Close the statement and connection
        $query->close();
        $con->close();

        return $res;
    }



    public function getRegistrations()
    {
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT sno,name,mobile,email,college_name,college_location,dept,yop,created_at FROM registrations WHERE status=1 ORDER BY sno DESC');
        if ($query->execute()) {
            $query->bind_result($sno, $name, $mobile, $email, $college_name, $college_location, $dept, $yop, $created_at);
            $i = 0;
            while ($query->fetch()) {
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
            $res['count'] = $i;
        } else {
            $err = 'Statement not Executed';
        }
        return $res;
    }


    public function getInactiveRegistrations()
    {
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT sno,name,mobile,email,college_name,college_location,dept,yop,created_at FROM registrations WHERE status=0 ORDER BY sno DESC');
        if ($query->execute()) {
            $query->bind_result($sno, $name, $mobile, $email, $college_name, $college_location, $dept, $yop, $created_at);
            $i = 0;
            while ($query->fetch()) {
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
            $res['count'] = $i;
        } else {
            $err = 'Statement not Executed';
        }
        return $res;
    }



    public function getCareers()
    {
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT name,mobile,email,post,experience,resume,created_at FROM careers ORDER BY sno DESC');
        if ($query->execute()) {
            $query->bind_result($name, $mobile, $email, $post, $experience, $resume, $created_at);
            $i = 0;
            while ($query->fetch()) {
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
            $res['count'] = $i;
        } else {
            $err = 'Statement not Executed';
        }
        return $res;
    }


    public function getBlogs()
    {
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT username,blog_heading,description,category,featured_image,meta_keywords,meta_description,slug_url,status,updated_at,updated_by,created_at FROM blog ORDER BY sno DESC');
        if ($query->execute()) {
            $query->bind_result($username, $blog_heading, $description, $category, $featured_image, $meta_keywords, $meta_description, $slug_url, $status, $updated_at, $updated_by, $created_at);
            $i = 0;
            while ($query->fetch()) {
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
            $res['count'] = $i;
        } else {
            $err = 'Statement not Executed';
        }
        return $res;
    }



    public function getCategoryById($id)
    {
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT id,name,image,description,status,created_at FROM categories ORDER BY id DESC');
        if ($query->execute()) {
            $query->bind_result($id, $name, $image, $description, $status, $created_at);
            $i = 0;
            while ($query->fetch()) {
                $res['status'] = 1;
                $res['id'][$i] = $id;
                $res['name'][$i] = $name;
                $res['image'][$i] = $image;
                $res['description'][$i] = $description;
                $res['statusval'][$i] = $status;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count'] = $i;
        } else {
            $err = 'Statement not Executed';
        }
        return $res;
    }

    public function getContacts()
    {
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT name,email,mobile,query,created_at FROM contact ORDER BY sno DESC');
        if ($query->execute()) {
            $query->bind_result($name, $email, $mobile, $message, $created_at);
            $i = 0;
            while ($query->fetch()) {
                $res['status'] = 1;
                $res['name'][$i] = $name;
                $res['email'][$i] = $email;
                $res['mobile'][$i] = $mobile;
                $res['message'][$i] = $message;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count'] = $i;
        } else {
            $err = 'Statement not Executed';
        }
        return $res;
    }

    public function getQuotes()
    {
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT name,email,mobile,looking_for,when_to_start,created_at FROM quote ORDER BY sno DESC');
        if ($query->execute()) {
            $query->bind_result($name, $email, $mobile, $looking_for, $when_to_start, $created_at);
            $i = 0;
            while ($query->fetch()) {
                $res['status'] = 1;
                $res['name'][$i] = $name;
                $res['email'][$i] = $email;
                $res['mobile'][$i] = $mobile;
                $res['looking_for'][$i] = $looking_for;
                $res['when_to_start'][$i] = $when_to_start;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count'] = $i;
        } else {
            $err = 'Statement not Executed';
        }
        return $res;
    }

    public function AddBlogs($username, $blog_heading, $description, $category, $featured_image, $meta_keywords, $meta_description, $slug_url)
    {
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('INSERT INTO blog (username,blog_heading,description,category,featured_image,meta_keywords,meta_description,slug_url) values (?,?,?,?,?,?,?,?)');
        $query->bind_param('ssssssss', $username, $blog_heading, $description, $category, $featured_image, $meta_keywords, $meta_description, $slug_url);
        if ($query->execute()) {
            $res['status'] = 1;
        } else {
            $err = 'Statement not Executed';
        }
        return $res;
    }
    public function AddTasks($task_date, $domain, $task_name, $task_description, $tasks)
    {
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('INSERT INTO addtasks (task_date,domain,task_name,task_description,tasks) values (?,?,?,?,?)');
        $query->bind_param('sssss', $task_date, $domain, $task_name, $task_description, $tasks);
        if ($query->execute()) {
            $res['status'] = 1;
        } else {
            $err = 'Statement not Executed';
        }
        return $res;
    }


    public function AddProduct(
        $category_id,
        $subcategory_id,
        $product_name,
        $featured_image,
        $additional_images,
        $stock,
        $ornament_type,
        $ornament_weight,
        $discount_percentage,
        $short_description,
        $features,
        $is_lakshmi_kubera,
        $is_popular_collection,
        $is_recommended,
        $general_info,
        $description,
        $attribute_ids,
        $variation_names,
        $variation_same_prices,
        $variation_ornament_weights,
        $variation_discounted_percentages
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
            // Insert the main product
            $product_code = '123';
            $query = $con->prepare('INSERT INTO products (category_id, subcategory_id, product_code, product_name, featured_image, additional_images, stock, ornament_type, ornament_weight, discount_percentage, short_description, features, is_lakshmi_kubera, is_popular_collection, is_recommended, general_info, description) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
            $query->bind_param('sssssssssssssssss', $category_id, $subcategory_id, $product_code, $product_name, $featured_image, $additional_images, $stock, $ornament_type, $ornament_weight, $discount_percentage, $short_description, $features, $is_lakshmi_kubera, $is_popular_collection, $is_recommended, $general_info, $description);

            if ($query->execute()) {
                $product_id = $con->insert_id;

                // Prepare the insert query for product variations
                $variationQuery = $con->prepare('INSERT INTO product_variations (product_id, attribute_id, variation_name, is_same_price, ornament_weight, discounted_percentage) VALUES (?, ?, ?, ?, ?, ?)');

                $product_id = $con->insert_id;

                // Prepare the insert query for product variations
                $variationQuery = $con->prepare('INSERT INTO product_variations (product_id, attribute_id, variation_name, is_same_price, ornament_weight, discount_percentage) VALUES (?, ?, ?, ?, ?, ?)');

                foreach ($attribute_ids as $key => $attribute_id) {
                    // Check if variations exist for the current attribute
                    if (isset($variation_names[$key]) && is_array($variation_names[$key])) {
                        foreach ($variation_names[$key] as $i => $variation_name) {
                            // Retrieve the corresponding values for the current variation
                            $is_same_price = isset($variation_same_prices[$key][$i]) ? 1 : 0;  // Assume checkbox returns a 1 when checked
                            $variation_weight = $variation_ornament_weights[$key][$i] ?? null;  // Use null coalescing operator
                            $variation_discounted_percentage = $variation_discounted_percentages[$key][$i] ?? null;  // Use null coalescing operator

                            // Bind parameters and execute the query
                            $variationQuery->bind_param('iissss', $product_id, $attribute_id, $variation_name, $is_same_price, $variation_weight, $variation_discounted_percentage);
                            if (!$variationQuery->execute()) {
                                throw new Exception('Variation insert failed: ' . $variationQuery->error);
                            }
                        }
                    }
                }


                // Commit transaction
                $con->commit();
                $res['status'] = 1;
            } else {
                $con->rollback();
                $res['error'] = 'Product insert failed: ' . $query->error;
            }
        } catch (Exception $e) {
            // Rollback transaction if any error occurs
            $con->rollback();
            $res['error'] = $e->getMessage();
        }

        // Close the connection
        $con->close();
        return $res;
    }





    public function getProducts()
    {
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
                products.created_at
            FROM 
                products
            LEFT JOIN categories ON products.category_id = categories.id
            LEFT JOIN sub_categories ON products.subcategory_id = sub_categories.id
            LEFT JOIN ornaments ON products.ornament_type = ornaments.id
            LEFT JOIN features ON FIND_IN_SET(features.id, products.features) > 0
            GROUP BY products.id  
            ORDER BY products.id DESC;");

        if ($query->execute()) {
            $query->bind_result($id, $category_id, $category_name, $subcategory_id, $subcategory_name, $product_code, $product_name, $featured_image, $additional_images, $stock, $ornament_id, $ornament_type, $price_per_gram, $ornament_weight, $discount_percentage, $short_description, $features_id, $features, $is_lakshmi_kubera, $is_popular_collection, $is_recommended, $general_info, $description, $slug, $status, $created_at);

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

                // Calculate Actual Price and Discounted Price
                $actual_price = $ornament_weight * $price_per_gram;
                $discounted_price = $actual_price - ($actual_price * $discount_percentage / 100);

                // Add these to the result array
                $res['actual_price'][$i] = round($actual_price);
                $res['discounted_price'][$i] = round($discounted_price);

                $i++;
            }
            $res['count'] = $i;
        } else {
            $err = 'Statement not Executed';
        }

        return $res;
    }


    public function getProductBySubCatId($id)
    {
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());

        $query = $con->prepare("
        SELECT 
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
            ornaments.price AS price_per_gram, 
            products.ornament_weight, 
            products.discount_percentage, 
            GROUP_CONCAT(DISTINCT features.name SEPARATOR ', ') AS features, 
            products.is_lakshmi_kubera, 
            products.is_popular_collection, 
            products.is_recommended, 
            products.general_info, 
            products.description, 
            products.slug, 
            products.status, 
            products.created_at,

            MAX(products.ornament_weight) AS max_weight,
            MAX((products.ornament_weight * ornaments.price) * (1 - (products.discount_percentage / 100))) AS highest_discounted_price

        FROM 
            products
        LEFT JOIN categories ON products.category_id = categories.id
        LEFT JOIN sub_categories ON products.subcategory_id = sub_categories.id
        LEFT JOIN ornaments ON products.ornament_type = ornaments.id
        LEFT JOIN features ON FIND_IN_SET(features.id, products.features) > 0
        WHERE 
            products.subcategory_id = ?
        GROUP BY products.id
        ORDER BY products.id DESC;
    ");

        $query->bind_param('s', $id);

        if ($query->execute()) {
            $query->bind_result($id, $category_id, $category_name, $subcategory_id, $subcategory_name, $product_code, $product_name, $featured_image, $additional_images, $stock, $ornament_id, $ornament_type, $price_per_gram, $ornament_weight, $discount_percentage, $features, $is_lakshmi_kubera, $is_popular_collection, $is_recommended, $general_info, $description, $slug, $status, $created_at, $max_weight, $highest_product_price);

            $i = 0;
            $ornament_counts = [];
            $lakshmi_kubera_count = 0;  // Initialize count
            while ($query->fetch()) {
                // Check if the product has is_lakshmi_kubera as 1
                if ($is_lakshmi_kubera == 1) {
                    $lakshmi_kubera_count++;  // Increment count for lakshmi_kubera = 1
                }
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
                $res['features'][$i] = $features;
                $res['is_lakshmi_kubera'][$i] = $is_lakshmi_kubera;
                $res['is_popular_collection'][$i] = $is_popular_collection;
                $res['is_recommended'][$i] = $is_recommended;
                $res['general_info'][$i] = $general_info;
                $res['description'][$i] = $description;
                $res['slug'][$i] = $slug;
                $res['statusval'][$i] = $status;
                $res['created_at'][$i] = $created_at;

                // Calculate Actual Price and Discounted Price
                $actual_price = $ornament_weight * $price_per_gram;
                $discounted_price = $actual_price - ($actual_price * $discount_percentage / 100);

                // Add these to the result array
                $res['actual_price'][$i] = $actual_price;
                $res['discounted_price'][$i] = $discounted_price;

                // Build Ornament Counts
                if (!isset($ornament_counts[$ornament_type])) {
                    $ornament_counts[$ornament_type] = 0;
                }
                $ornament_counts[$ornament_type]++;

                $i++;
            }
            $res['count'] = $i;
            $res['lakshmi_kubera_count'] = $lakshmi_kubera_count;
            $res['max_weight'] = $max_weight;
            $res['highest_product_price'] = $highest_product_price;
            $res['ornament_counts'] = [];
            foreach ($ornament_counts as $type => $count) {
                $res['ornament_counts'][] = [$type, $count];
            }

            // Weight Ranges
            if ($max_weight > 0) {
                $res['weight_ranges'] = [
                    [0, ceil($max_weight / 3)],
                    [ceil($max_weight / 3) + 1, ceil(2 * $max_weight / 3)],
                    [ceil(2 * $max_weight / 3) + 1, $max_weight]
                ];
            }
        } else {
            $res['error'] = 'Statement not Executed';
        }

        return $res;
    }







    public function UpdateProduct(
        $category_id,
        $subcategory_id,
        $product_name,
        $featured_image,
        $additional_images,
        $stock,
        $ornament_type,
        $ornament_weight,
        $discount_percentage,
        $short_description,
        $features,
        $is_lakshmi_kubera,
        $is_popular_collection,
        $is_recommended,
        $general_info,
        $description,
        $id
    ) {
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
            $query = $con->prepare('UPDATE products SET category_id=?, subcategory_id=?, product_code=?, product_name=?, featured_image=?, additional_images=?, stock=?, ornament_type=?, ornament_weight=?, discount_percentage=?, short_description=?, features=?, is_lakshmi_kubera=?, is_popular_collection=?, is_recommended=?, general_info=?, description=? WHERE id=?');
            $query->bind_param('ssssssssssssssssss', $category_id, $subcategory_id, $product_code, $product_name, $featured_image, $additional_images, $stock, $ornament_type, $ornament_weight, $discount_percentage, $short_description, $features, $is_lakshmi_kubera, $is_popular_collection, $is_recommended, $general_info, $description, $id);

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

    public function getProductVariations($id)
    {
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare("SELECT product_variations.id, product_variations.product_id, attributes.id,attributes.name AS attribute_name, product_variations.variation_name, product_variations.is_same_price, product_variations.ornament_weight, product_variations.discount_percentage, product_variations.status,product_variations.created_at
        FROM product_variations
        JOIN attributes ON product_variations.attribute_id = attributes.id
        WHERE product_variations.product_id=?
        ");
        $query->bind_param('i', $id);

        if ($query->execute()) {
            $query->bind_result($id, $product_id, $attribute_id, $attribute_name, $variation_name, $is_same_price, $ornament_weight, $discount_percentage, $status, $created_at);
            $i = 0;
            while ($query->fetch()) {
                $res['status'] = 1;
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
            $res['count'] = $i;
        } else {
            $err = 'Statement not Executed';
        }
        return $res;
    }


    public function getAdvertisements()
    {
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT id,name,image,description,url,location,status,created_at FROM advertisements ORDER BY id DESC');
        if ($query->execute()) {
            $query->bind_result($id, $name, $image, $description, $url, $location, $status, $created_at);
            $i = 0;
            while ($query->fetch()) {
                $res['status'] = 1;
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
            $res['count'] = $i;
        } else {
            $err = 'Statement not Executed';
        }
        return $res;
    }



    public function AddFeature($name, $image)
    {
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
            $query->bind_param('ss', $name, $image);

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

    public function getFeatures()
    {
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare("SELECT id, name,image, status,created_at FROM features ORDER BY id DESC");

        if ($query->execute()) {
            $query->bind_result($id, $name, $image, $status, $created_at);
            $i = 0;
            while ($query->fetch()) {
                $res['status'] = 1;
                $res['id'][$i] = $id;
                $res['name'][$i] = $name;
                $res['image'][$i] = $image;
                $res['statusval'][$i] = $status;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count'] = $i;
        } else {
            $err = 'Statement not Executed';
        }
        return $res;
    }

    public function UpdateFeature($name, $image, $id)
    {
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
            $query->bind_param('sss', $name, $image, $id);

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

    public function AddOrnament($name, $price)
    {
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
            $query->bind_param('ss', $name, $price);

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

    public function AddVariations($product_id, $attribute_id, $variation_name, $is_same_price, $ornament_weight, $discount_percentage)
    {
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
            $query->bind_param('ssssss', $product_id, $attribute_id, $variation_name, $is_same_price, $ornament_weight, $discount_percentage);

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

    public function getOrnaments()
    {
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare("SELECT id, name,price, status,created_at FROM ornaments ORDER BY id DESC");

        if ($query->execute()) {
            $query->bind_result($id, $name, $price, $status, $created_at);
            $i = 0;
            while ($query->fetch()) {
                $res['status'] = 1;
                $res['id'][$i] = $id;
                $res['name'][$i] = $name;
                $res['price'][$i] = $price;
                $res['statusval'][$i] = $status;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count'] = $i;
        } else {
            $err = 'Statement not Executed';
        }
        return $res;
    }

    public function UpdateOrnament($name, $price, $id)
    {
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
            $query->bind_param('sss', $name, $price, $id);

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

    public function UpdateVariation($id, $attribute_id, $variation_name, $is_same_price, $ornament_weight, $discount_percentage)
    {
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
            $query->bind_param('ssssss', $attribute_id, $variation_name, $is_same_price, $ornament_weight, $discount_percentage, $id);

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


    public function AddAttribute($name)
    {
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

    public function getAttribute()
    {
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare("SELECT id, name, status,created_at FROM attributes ORDER BY id DESC");

        if ($query->execute()) {
            $query->bind_result($id, $name, $status, $created_at);
            $i = 0;
            while ($query->fetch()) {
                $res['status'] = 1;
                $res['id'][$i] = $id;
                $res['name'][$i] = $name;
                $res['statusval'][$i] = $status;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count'] = $i;
        } else {
            $err = 'Statement not Executed';
        }
        return $res;
    }

    public function UpdateAttribute($name, $id)
    {
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
            $query->bind_param('ss', $name, $id);

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

    public function UpdateStatus($table, $id, $status)
    {
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
            $query = $con->prepare('UPDATE ' . $table . ' SET status=? WHERE id=?');
            $query->bind_param('ss', $status, $id);

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

    public function DeleteRecord($table, $id)
    {
        $res = array();
        $res['status'] = 0;

        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());

        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        $con->begin_transaction();

        try {
            $query = $con->prepare('DELETE from ' . $table . ' WHERE id=?');
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

    public function AddSubCategory($category_id, $subcategory_name, $image, $description)
    {
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
            $query->bind_param('ssss', $category_id, $subcategory_name, $image, $description);

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

    public function getSubCategories()
    {
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());

        // Modified query to include product count for each subcategory
        $query = $con->prepare('
            SELECT 
                sub_categories.id, 
                sub_categories.category_id, 
                sub_categories.name, 
                sub_categories.image, 
                sub_categories.description, 
                sub_categories.status, 
                sub_categories.created_at, 
                categories.name AS category_name,
                COUNT(products.id) AS product_count
            FROM sub_categories
            JOIN categories ON sub_categories.category_id = categories.id
            LEFT JOIN products ON sub_categories.id = products.subcategory_id
            GROUP BY sub_categories.id
            ORDER BY sub_categories.id DESC
        ');

        if ($query->execute()) {
            $query->bind_result(
                $id,
                $category_id,
                $name,
                $image,
                $description,
                $status,
                $created_at,
                $category_name,
                $product_count
            );

            $i = 0;
            while ($query->fetch()) {
                $res['status'] = 1;
                $res['id'][$i] = $id;
                $res['category_id'][$i] = $category_id;
                $res['name'][$i] = $name;
                $res['image'][$i] = $image;
                $res['description'][$i] = $description;
                $res['statusval'][$i] = $status;
                $res['created_at'][$i] = $created_at;
                $res['category_name'][$i] = $category_name;
                $res['product_count'][$i] = $product_count; // Adding product count
                $i++;
            }
            $res['count'] = $i;
        } else {
            $err = 'Statement not Executed';
        }
        return $res;
    }


    public function getSubCategoriesAjax($category_id)
    {
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



    public function UpdateSubCategory($category_id, $subcategory_name, $image, $description, $id)
    {
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
            $query->bind_param('sssss', $category_id, $subcategory_name, $image, $description, $id);

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

    public function DeleteSubCategory($id)
    {
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


    public function AddCategory($category_name, $image, $description)
    {
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

    public function getCategories()
    {
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());

        // Modified query to include product count for each category
        $query = $con->prepare('
            SELECT categories.id, categories.name, categories.image, categories.description, categories.status, categories.created_at, 
                   COUNT(products.id) AS product_count
            FROM categories
            LEFT JOIN products ON categories.id = products.category_id
            GROUP BY categories.id
            ORDER BY categories.id DESC
        ');

        if ($query->execute()) {
            $query->bind_result($id, $name, $image, $description, $status, $created_at, $product_count);
            $i = 0;
            while ($query->fetch()) {
                $res['status'] = 1;
                $res['id'][$i] = $id;
                $res['name'][$i] = $name;
                $res['image'][$i] = $image;
                $res['description'][$i] = $description;
                $res['statusval'][$i] = $status;
                $res['created_at'][$i] = $created_at;
                $res['product_count'][$i] = $product_count; // Adding product count
                $i++;
            }
            $res['count'] = $i;
        } else {
            $err = 'Statement not Executed';
        }
        return $res;
    }



    public function UpdateCategory($category_name, $image, $description, $id)
    {
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
            $query->bind_param('ssss', $category_name, $image, $description, $id);

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

    public function DeleteCategory($id)
    {
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

    public function AddStudents($student_id, $name, $email, $domain)
    {
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

    public function GetAddedTasks()
    {
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT id,task_date,domain,task_name,task_description,tasks,status,created_at,updated_at FROM addtasks ORDER BY id DESC');

        if ($query->execute()) {
            $query->bind_result($id, $task_date, $domain, $task_name, $task_description, $tasks, $status, $created_at, $updated_at);
            $i = 0;
            while ($query->fetch()) {
                $res['status'] = 1;
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
            $res['count'] = $i;
        } else {
            $err = 'Statement not Executed';
        }
        return $res;
    }

    public function GetAddedStudents()
    {
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT id,stud_id,name,email,password,domain,status,created_at,updated_at FROM users ORDER BY id DESC');

        if ($query->execute()) {
            $query->bind_result($id, $stud_id, $name, $email, $password, $domain, $status, $created_at, $updated_at);
            $i = 0;
            while ($query->fetch()) {
                $res['status'] = 1;
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
            $res['count'] = $i;
        } else {
            $err = 'Statement not Executed';
        }
        return $res;
    }




    // Admin Login 
    public function AdminLogin($username, $password)
    {
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT email,role FROM admin WHERE email=? AND password=?');
        $query->bind_param('ss', $username, $password);
        if ($query->execute()) {
            $query->bind_result($email, $role);
            while ($query->fetch()) {
                $res['status'] = 1;
                $res['email'] = $email;
                $res['role'] = $role;
            }
        } else {
            $err = "Statement not Executed";
        }

        $query->close();
        $con->close();
        return $res;
    }


    public function getProfile($id)
    {
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT name,spouse,children,father,mother,email,mobile,profession,origin,city,state,country,interest,special,photos,instagram,created_at FROM register WHERE status=1 AND id=? ORDER BY id DESC');
        $query->bind_param('s', $id);
        if ($query->execute()) {
            $query->bind_result($name, $spouse, $children, $father, $mother, $email, $mobile, $profession, $origin, $city, $state, $country, $interest, $special, $photos, $instagram, $created_at);
            while ($query->fetch()) {
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
        } else {
            $err = 'Statement not Executed';
        }
        return $res;
    }



    public function updateProfile($name, $spouse, $children, $father, $mother, $email, $mobile, $profession, $origin, $city, $state, $country, $interest, $special, $photos, $instagram, $id)
    {
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('UPDATE register SET name=?,spouse=?, children=?, father=?, mother=?, email=?,mobile=?,profession=?,origin=?,city=?,state=?,country=?,interest=?,special=?,photos=?,instagram=? WHERE id=?');
        $query->bind_param('sssssssssssssssss', $name, $spouse, $children, $father, $mother, $email, $mobile, $profession, $origin, $city, $state, $country, $interest, $special, $photos, $instagram, $id);
        if ($query->execute()) {
            if (!empty($query->affected_rows) && $query->affected_rows > 0) {
                $res['status'] = 1;
            } else {
                $err = 'Data not Inserted';
            }
        }

        $con->close();
        $query->close();
        return $res;

    }

    public function RegStatusUpdate($id, $status)
    {
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('UPDATE registrations SET status=? WHERE sno=?');
        if ($status == 'Inactive') {
            $status = '0';
        } else {
            $status = '1';
        }
        $query->bind_param('ss', $status, $id);
        if ($query->execute()) {
            if (!empty($query->affected_rows) && $query->affected_rows > 0) {
                $res['status'] = 1;
            } else {
                $err = 'Data not Inserted';
            }
        }

        $con->close();
        $query->close();
        return $res;

    }

    //Change Password
    public function changepwd($id, $password)
    {
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('UPDATE register set password=? where id=?');
        $query->bind_param('ss', $password, $id);
        if ($query->execute()) {
            $res['status'] = 1;
        } else {
            $err = "Statement not Executed";
        }

        $query->close();
        $con->close();
        return $res;
    }


    // Blogs Submission
    public function blogs($image, $heading, $meta, $description)
    {
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('INSERT INTO blogs (image, heading, description, meta) values (?,?,?,?)');
        $query->bind_param('ssss', $image, $heading, $description, $meta);
        if ($query->execute()) {
            if (!empty($query->affected_rows) && $query->affected_rows > 0) {
                $res['status'] = 1;
            } else {
                $err = 'Data not Inserted';
            }
        } else {
            $err = 'Statement Not Executed';
        }
        return $res;
    }

    // Clients Submission
    public function clients($client_logo, $client_name)
    {
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('INSERT INTO clients (client_logo, client_name) values (?,?)');
        $query->bind_param('ss', $client_logo, $client_name);
        if ($query->execute()) {
            if (!empty($query->affected_rows) && $query->affected_rows > 0) {
                $res['status'] = 1;
            } else {
                $err = 'Data not Inserted';
            }
        } else {
            $err = 'Statement Not Executed';
        }
        return $res;
    }



    //contacts Retieval



    //Plans Retieval
    public function getPlans()
    {
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT pickup_location,drop_location,travel_date,return_date,travellers,name,mobile,email,message,created_at FROM plans ORDER BY sno DESC');
        if ($query->execute()) {
            $query->bind_result($pickup_location, $drop_location, $travel_date, $return_date, $travellers, $name, $mobile, $email, $message, $created_at);
            $i = 1;
            while ($query->fetch()) {
                $res['status'] = 1;
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
                $res['status'] = 1;
                $i++;
            }
            $res['count'] = $i;
        } else {
            $err = 'Statement not Executed';
        }
        return $res;
    }


    //Plans Retieval
    public function bike_rental()
    {
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT pickup_location,drop_location,travel_date,return_date,bike_model,name,mobile,email,message,created_at FROM bike_rental ORDER BY sno DESC');
        if ($query->execute()) {
            $query->bind_result($pickup_location, $drop_location, $travel_date, $return_date, $bike_model, $name, $mobile, $email, $message, $created_at);
            $i = 1;
            while ($query->fetch()) {
                $res['status'] = 1;
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
                $res['status'] = 1;
                $i++;
            }
            $res['count'] = $i;
        } else {
            $err = 'Statement not Executed';
        }
        return $res;
    }


    //Subscribes Retieval
    public function getSubscribes()
    {
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT mobile,created_at FROM callbacks ORDER BY sno DESC');
        if ($query->execute()) {
            $query->bind_result($mobile, $updatedtime);
            $i = 1;
            while ($query->fetch()) {
                $res['status'] = 1;
                $res['mobile'][$i] = $mobile;
                $res['updatedtime'][$i] = $updatedtime;
                $i++;
            }
            $res['count'] = $i;
        } else {
            $err = 'Statement not Executed';
        }
        return $res;
    }

    //Blogs Retieval
    public function getBlogsOldAlumni()
    {
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT image, heading, meta, description, created_at FROM blogs ORDER BY sno DESC');
        if ($query->execute()) {
            $query->bind_result($image, $heading, $meta, $description, $created_at);
            $i = 1;
            while ($query->fetch()) {
                $res['status'] = 1;
                $res['image'][$i] = $image;
                $res['heading'][$i] = $heading;
                $res['meta'][$i] = $meta;
                $res['description'][$i] = $description;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count'] = $i;
        } else {

            $err = 'Statement not Executed';
        }
        return $res;
    }


    //Clients Retieval
    public function getClients()
    {
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT client_logo, client_name,updatedtime FROM clients ORDER BY sno DESC');
        if ($query->execute()) {
            $query->bind_result($client_logo, $client_name, $updatedtime);
            $i = 1;
            while ($query->fetch()) {
                $res['status'] = 1;
                $res['client_logo'][$i] = $client_logo;
                $res['client_name'][$i] = $client_name;
                $res['updatedtime'][$i] = $updatedtime;
                $i++;
            }
            $res['count'] = $i;
        } else {
            $err = 'Statement not Executed';
        }
        return $res;
    }


    public function userRegistration($name, $email, $mobile, $password, $address)
    {
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
            // Check if email already exists
            $emailQuery = $con->prepare('SELECT id FROM users WHERE email = ?');
            $emailQuery->bind_param('s', $email);
            $emailQuery->execute();
            $emailQuery->store_result();
            if ($emailQuery->num_rows > 0) {
                $res['status'] = 3; // Duplicate email
                $con->rollback();
                $emailQuery->close();
                $con->close();
                return $res;
            }
            $emailQuery->close();

            // Check if mobile number already exists
            $mobileQuery = $con->prepare('SELECT id FROM users WHERE mobile = ?');
            $mobileQuery->bind_param('s', $mobile);
            $mobileQuery->execute();
            $mobileQuery->store_result();
            if ($mobileQuery->num_rows > 0) {
                $res['status'] = 4; // Duplicate mobile number
                $con->rollback();
                $mobileQuery->close();
                $con->close();
                return $res;
            }
            $mobileQuery->close();

            // Insert into users table
            $query = $con->prepare('INSERT INTO users (name, email, mobile, password, address) VALUES (?, ?, ?, ?, ?)');
            $query->bind_param('sssss', $name, $email, $mobile, $password, $address);

            if ($query->execute()) {
                // Commit transaction
                $con->commit();
                $res['status'] = 1;
                $res['user_id'] = $query->insert_id; // Get the last inserted ID
            } else {
                // Rollback transaction if users insertion fails
                $con->rollback();
                $res['error'] = 'Insert statement not executed';
            }
            $query->close();
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $con->rollback();
            $res['error'] = $e->getMessage();
        }

        // Close the connection
        $con->close();

        return $res;
    }


    // User Login 
    public function userLogin($mobile, $password)
    {
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT id,name,mobile,email FROM users WHERE mobile=? AND password=?');
        $query->bind_param('ss', $mobile, $password);
        if ($query->execute()) {
            $query->bind_result($id, $name, $mobile, $email);
            while ($query->fetch()) {
                $res['status'] = 1;
                $res['user_id'] = $id;
                $res['name'] = $name;
                $res['mobile'] = $mobile;
                $res['email'] = $email;
            }
        } else {
            $err = "Statement not Executed";
        }

        $query->close();
        $con->close();
        return $res;
    }



    public function checkEmailExists($email)
    {
        $res = array();
        $res['status'] = 0;

        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());

        // Prepare the select query to check for email existence
        $query = $con->prepare('SELECT 1 FROM users WHERE email = ? LIMIT 1');
        $query->bind_param('s', $email);
        $query->execute();

        // Check if any result is found
        $query->store_result();
        if ($query->num_rows > 0) {
            $res['status'] = 1;  // Email exists
        } else {
            $res['status'] = 0;  // Email not found
        }

        $query->close();
        $con->close();

        return $res;
    }



    public function ResetPassword($email, $password)
    {
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());

        // Prepare and execute the update query
        $query = $con->prepare('UPDATE users SET password=? WHERE email=?');
        $query->bind_param('ss', $password, $email);
        $query->execute();

        // Check if any rows were affected
        if ($query->affected_rows > 0) {
            $res['status'] = 1; // Update successful
        } else {
            $res['status'] = 0; // No record was updated, possibly email not found
            $err = 'No matching record found';
        }

        $query->close();
        $con->close();

        return $res;
    }



    public function addToCart($user_id, $product_id, $quantity)
    {
        $res = array();
        $res['status'] = 0; // Default status

        // Establish database connection
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());

        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        // Begin transaction
        $con->begin_transaction();

        try {
            // Check if product already exists in the cart for the user
            $checkQuery = $con->prepare('SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?');
            $checkQuery->bind_param('ii', $user_id, $product_id);
            $checkQuery->execute();
            $checkQuery->store_result();

            if ($checkQuery->num_rows > 0) {
                // If product exists, increment the quantity by 1
                $checkQuery->bind_result($currentQuantity);
                $checkQuery->fetch();
                $newQuantity = $currentQuantity + 1;

                $updateQuery = $con->prepare('UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?');
                $updateQuery->bind_param('iii', $newQuantity, $user_id, $product_id);

                if ($updateQuery->execute()) {
                    $res['status'] = 2; // Status 2: Product quantity incremented
                    $con->commit();
                } else {
                    $con->rollback();
                    $res['error'] = 'Failed to update product quantity';
                }
                $updateQuery->close();
            } else {
                // If product does not exist, add it to the cart
                $insertQuery = $con->prepare('INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)');
                $insertQuery->bind_param('iii', $user_id, $product_id, $quantity);

                if ($insertQuery->execute()) {
                    $res['status'] = 1; // Status 1: Product added to cart
                    $con->commit();
                } else {
                    $con->rollback();
                    $res['error'] = 'Failed to insert product into cart';
                }
                $insertQuery->close();
            }
            $checkQuery->close();
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $con->rollback();
            $res['error'] = $e->getMessage();
        }

        // Close the connection
        $con->close();

        return $res;
    }
    public function addToWishlist($user_id, $product_id)
    {
        $res = array();
        $res['status'] = 0; // Default status

        // Establish database connection
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());

        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        // Begin transaction
        $con->begin_transaction();

        try {
            // Check if product already exists in the wishlist for the user
            $checkQuery = $con->prepare('SELECT status FROM wishlist WHERE user_id = ? AND product_id = ?');
            $checkQuery->bind_param('ii', $user_id, $product_id);
            $checkQuery->execute();
            $checkQuery->store_result();

            if ($checkQuery->num_rows > 0) {
                $res['status'] = 2; // Status 2: Product already in wishlist
            } else {
                // If product does not exist, insert it into the wishlist with status 1
                $insertQuery = $con->prepare('INSERT INTO wishlist (user_id, product_id, status) VALUES (?, ?, ?)');
                $status = 1; // Status 1: Product added to wishlist
                $insertQuery->bind_param('iii', $user_id, $product_id, $status);

                if ($insertQuery->execute()) {
                    $res['status'] = 1; // Status 1: Product added to wishlist
                    $con->commit();
                } else {
                    $con->rollback();
                    $res['error'] = 'Failed to insert product into wishlist';
                }
                $insertQuery->close();
            }
            $checkQuery->close();
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $con->rollback();
            $res['error'] = $e->getMessage();
        }

        // Close the connection
        $con->close();

        return $res;
    }


    public function getCartById($id)
    {
        $res = array();
        $res['status'] = 0;

        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());

        // Query to fetch cart details along with product information
        $query = $con->prepare(
            "SELECT 
                    cart.id, 
                    cart.user_id, 
                    cart.product_id, 
                    cart.quantity, 
                    cart.status, 
                    cart.created_at, 
                    products.product_name, 
                    products.featured_image, 
                    (products.ornament_weight * ornaments.price) AS actual_price, 
                    (products.ornament_weight * ornaments.price * (1 - products.discount_percentage / 100)) AS discounted_price
                FROM cart
                INNER JOIN products ON cart.product_id = products.id
                LEFT JOIN ornaments ON products.ornament_type = ornaments.id
                WHERE cart.user_id = ?
                ORDER BY cart.id DESC"
        );

        $query->bind_param('i', $id);

        if ($query->execute()) {
            $query->bind_result(
                $id,
                $user_id,
                $product_id,
                $quantity,
                $status,
                $created_at,
                $product_name,
                $featured_image,
                $actual_price,
                $discounted_price
            );

            $i = 0;
            while ($query->fetch()) {
                $res['status'] = 1;
                $res['id'][$i] = $id;
                $res['user_id'][$i] = $user_id;
                $res['product_id'][$i] = $product_id;
                $res['quantity'][$i] = $quantity;
                $res['status_val'][$i] = $status;
                $res['created_at'][$i] = $created_at;

                // Adding product details
                $res['product_name'][$i] = $product_name;
                $res['featured_image'][$i] = $featured_image;
                $res['actual_price'][$i] = $actual_price;
                $res['discounted_price'][$i] = $discounted_price;

                $i++;
            }
            $res['count'] = $i;
        } else {
            $res['error'] = 'Statement not Executed';
        }

        return $res;
    }


    public function getWishlistById($id)
    {
        $res = array();
        $res['status'] = 0;

        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());

        // Query to fetch wishlist details along with product information
        $query = $con->prepare(
            "SELECT 
                    wishlist.id, 
                    wishlist.user_id, 
                    wishlist.product_id, 
                    wishlist.status, 
                    wishlist.created_at, 
                    products.product_name, 
                    products.featured_image, 
                    (products.ornament_weight * ornaments.price) AS actual_price, 
                    (products.ornament_weight * ornaments.price * (1 - products.discount_percentage / 100)) AS discounted_price
                FROM wishlist
                INNER JOIN products ON wishlist.product_id = products.id
                LEFT JOIN ornaments ON products.ornament_type = ornaments.id
                WHERE wishlist.user_id = ?
                ORDER BY wishlist.id DESC"
        );

        $query->bind_param('i', $id);

        if ($query->execute()) {
            $query->bind_result(
                $id,
                $user_id,
                $product_id,
                $status,
                $created_at,
                $product_name,
                $featured_image,
                $actual_price,
                $discounted_price
            );

            $i = 0;
            while ($query->fetch()) {
                $res['status'] = 1;
                $res['id'][$i] = $id;
                $res['user_id'][$i] = $user_id;
                $res['product_id'][$i] = $product_id;
                $res['status_val'][$i] = $status;
                $res['created_at'][$i] = $created_at;

                // Adding product details
                $res['product_name'][$i] = $product_name;
                $res['featured_image'][$i] = $featured_image;
                $res['actual_price'][$i] = $actual_price;
                $res['discounted_price'][$i] = $discounted_price;

                $i++;
            }
            $res['count'] = $i;
        } else {
            $res['error'] = 'Statement not Executed';
        }

        return $res;
    }


    // Update Cart Quantity
    public function UpdateCartQuantity($cart_id, $quantity)
    {
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
            $query = $con->prepare('UPDATE cart SET quantity=? WHERE id=?');
            $query->bind_param('ss', $quantity, $cart_id);

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

    // DeleteCartItem
    public function DeleteCartItem($cart_id)
    {
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
            $query = $con->prepare('DELETE FROM cart  WHERE id=?');
            $query->bind_param('s', $cart_id);

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

    // DeleteWishlistItem
    public function DeleteWishlistItem($wishlist_id)
    {
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
            $query = $con->prepare('DELETE FROM wishlist  WHERE id=?');
            $query->bind_param('s', $wishlist_id);

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


    public function ApplyCoupon($coupon, $grandTotal)
    {
        $res = array();
        $res['status'] = 0;
        $res['new_total'] = 0;  // Initialize a new total value

        // Establish database connection
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());

        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        // Begin transaction
        $con->begin_transaction();

        try {
            // SQL query to select valid coupon (checks expiry and status in the query itself)AND expiry > NOW()
            $query = $con->prepare('
                    SELECT coupon, discount, type 
                    FROM coupons 
                    WHERE coupon = ? 
                    AND status = 1 
                    AND expiry > NOW()
                    
                ');
            $query->bind_param('s', $coupon);

            if ($query->execute()) {
                $result = $query->get_result();

                // Check if the coupon exists and is valid
                if ($result->num_rows > 0) {

                    $couponData = $result->fetch_assoc();
                    $res['status'] = 1;
                    $res['discount'] = $couponData['discount'];
                    $res['type'] = $couponData['type'];

                    // Assuming you have a grand total value stored somewhere (e.g., session or database)
                    // Example of calculating new total after applying discount
                    // $grandTotal = $grandTotal; // Placeholder for original total, replace with actual value
                    if ($couponData['type'] == 'percentage') {
                        $res['new_total'] = round($grandTotal - ($grandTotal * ($couponData['discount'] / 100)));
                    } else {
                        $res['new_total'] = round($grandTotal - $couponData['discount']);
                    }
                } else {
                    $res['error'] = 'Invalid, expired, or inactive coupon code';
                }

                // Commit transaction
                $con->commit();
            } else {
                // Rollback transaction if query execution fails
                $con->rollback();
                $res['error'] = 'Statement execution failed';
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

    // public function PlaceOrder($orderData) {
    //     $res = array();
    //     $res['status'] = 0;
    
    //     try {
    //         $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    //         if ($con->connect_error) {
    //             throw new Exception("Database connection failed: " . $con->connect_error);
    //         }
    
    //         // Begin transaction
    //         $con->begin_transaction();
    
    //         // Generate unique order ID if not provided
    //         if (empty($orderData['order_id'])) {
    //             $orderData['order_id'] = 'ORD' . time() . rand(1000, 9999);
    //         }
    
    //         // For debugging, print the SQL statement
    //         error_log("Number of columns in INSERT: 38");
            
    //         // Set default values for optional fields
    //         $coupon = isset($orderData['coupon']) ? $orderData['coupon'] : '';
    //         $discount = isset($orderData['discount']) ? $orderData['discount'] : '';
    //         $coupon_type = isset($orderData['coupon_type']) ? $orderData['coupon_type'] : '';
            
    //         // Use direct SQL for debugging
    //         $sql = "INSERT INTO orders (
    //             order_id, razorpay_order_id, user_id, 
    //             billing_fullname, billing_email, billing_mobile,
    //             billing_address1, billing_address2, billing_city,
    //             billing_state, billing_pincode,
    //             shipping_fullname, shipping_email, shipping_mobile,
    //             shipping_address1, shipping_address2, shipping_city,
    //             shipping_state, shipping_pincode,
    //             total_products, subtotal, gst, total, grandtotal,
    //             coupon, discount, coupon_type,
    //             payment_mode, payment_amount, payment_reference,
    //             payment_proof, approval, remarks, status,
    //             payment_id, payment_date, order_status, payment_status
    //         ) VALUES (
    //             '{$con->real_escape_string($orderData['order_id'])}',
    //             '{$con->real_escape_string($orderData['razorpay_order_id'])}',
    //             '{$con->real_escape_string($orderData['user_id'])}',
    //             '{$con->real_escape_string($orderData['billing_fullname'])}',
    //             '{$con->real_escape_string($orderData['billing_email'])}',
    //             '{$con->real_escape_string($orderData['billing_mobile'])}',
    //             '{$con->real_escape_string($orderData['billing_address1'])}',
    //             '{$con->real_escape_string($orderData['billing_address2'])}',
    //             '{$con->real_escape_string($orderData['billing_city'])}',
    //             '{$con->real_escape_string($orderData['billing_state'])}',
    //             '{$con->real_escape_string($orderData['billing_pincode'])}',
    //             '{$con->real_escape_string($orderData['shipping_fullname'])}',
    //             '{$con->real_escape_string($orderData['shipping_email'])}',
    //             '{$con->real_escape_string($orderData['shipping_mobile'])}',
    //             '{$con->real_escape_string($orderData['shipping_address1'])}',
    //             '{$con->real_escape_string($orderData['shipping_address2'])}',
    //             '{$con->real_escape_string($orderData['shipping_city'])}',
    //             '{$con->real_escape_string($orderData['shipping_state'])}',
    //             '{$con->real_escape_string($orderData['shipping_pincode'])}',
    //             '{$con->real_escape_string($orderData['total_products'])}',
    //             '{$con->real_escape_string($orderData['subtotal'])}',
    //             '{$con->real_escape_string($orderData['gst'])}',
    //             '{$con->real_escape_string($orderData['total'])}',
    //             '{$con->real_escape_string($orderData['grandtotal'])}',
    //             '{$con->real_escape_string($coupon)}',
    //             '{$con->real_escape_string($discount)}',
    //             '{$con->real_escape_string($coupon_type)}',
    //             '{$con->real_escape_string($orderData['payment_mode'])}',
    //             '{$con->real_escape_string($orderData['payment_amount'])}',
    //             '{$con->real_escape_string($orderData['payment_reference'])}',
    //             '{$con->real_escape_string($orderData['payment_proof'])}',
    //             '{$con->real_escape_string($orderData['approval'])}',
    //             '{$con->real_escape_string($orderData['remarks'])}',
    //             '{$con->real_escape_string($orderData['status'])}',
    //             '{$con->real_escape_string($orderData['payment_id'])}',
    //             '{$con->real_escape_string($orderData['payment_date'])}',
    //             '{$con->real_escape_string($orderData['order_status'])}',
    //             '{$con->real_escape_string($orderData['payment_status'])}'
    //         )";
            
    //         error_log("Executing SQL: " . $sql);
            
    //         if ($con->query($sql)) {
    //             $order_id = $con->insert_id;
                
    //             // Fetch cart items for the user and insert into order_products
    //             $cartQuery = $con->prepare('SELECT 
    //                 cart.user_id, 
    //                 cart.product_id, 
    //                 cart.quantity, 
    //                 products.product_name, 
    //                 products.featured_image,
    //                 products.product_price as actual_price,
    //                 products.discounted_price,
    //                 products.slug,
    //                 ornaments.name AS ornament_name
    //             FROM cart 
    //             INNER JOIN products ON cart.product_id = products.id 
    //             LEFT JOIN ornaments ON products.ornament_type = ornaments.id 
    //             WHERE cart.user_id = ?');
    
    //             $cartQuery->bind_param('i', $orderData['user_id']);
    //             $cartQuery->execute();
    //             $cartResult = $cartQuery->get_result();
    
    //             // Prepare order_products insertion
    //             $orderProductQuery = $con->prepare('INSERT INTO order_products (
    //                 order_id, user_id, product_id, product_name, product_image, 
    //                 quantity, product_actual_price, product_price, product_slug, product_type
    //             ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    
    //             while ($cartRow = $cartResult->fetch_assoc()) {
    //                 $orderProductQuery->bind_param('iisssiddss', 
    //                     $order_id,
    //                     $cartRow['user_id'],
    //                     $cartRow['product_id'],
    //                     $cartRow['product_name'],
    //                     $cartRow['featured_image'],
    //                     $cartRow['quantity'],
    //                     $cartRow['actual_price'],
    //                     $cartRow['discounted_price'],
    //                     $cartRow['slug'],
    //                     $cartRow['ornament_name']
    //                 );
                    
    //                 if (!$orderProductQuery->execute()) {
    //                     throw new Exception("Failed to insert order product: " . $orderProductQuery->error);
    //                 }
    //             }
    
    //             // Clear cart
    //             $clearCart = $con->prepare('DELETE FROM cart WHERE user_id = ?');
    //             $clearCart->bind_param('s', $orderData['user_id']);
    //             if (!$clearCart->execute()) {
    //                 throw new Exception("Failed to clear cart: " . $clearCart->error);
    //             }
    
    //             $con->commit();
    //             $res['status'] = 1;
    //             $res['order_id'] = $orderData['order_id'];
    //         } else {
    //             throw new Exception("Failed to insert order: " . $con->error);
    //         }
    
    //     } catch (Exception $e) {
    //         if (isset($con)) {
    //             $con->rollback();
    //         }
    //         error_log("Error in PlaceOrder: " . $e->getMessage());
    //         $res['error'] = $e->getMessage();
    //     } finally {
    //         if (isset($cartQuery)) $cartQuery->close();
    //         if (isset($orderProductQuery)) $orderProductQuery->close();
    //         if (isset($clearCart)) $clearCart->close();
    //         if (isset($con)) $con->close();
    //     }
    
    //     return $res;
    // }
            
    public function PlaceOrder($orderData) {
        $res = array();
        $res['status'] = 0;
    
        try {
            $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
            if ($con->connect_error) {
                throw new Exception("Database connection failed: " . $con->connect_error);
            }
    
            // Begin transaction
            $con->begin_transaction();
    
            // Generate unique order ID if not provided
            if (empty($orderData['order_id'])) {
                $orderData['order_id'] = 'ORD' . time() . rand(1000, 9999);
            }
    
            // For debugging, print the SQL statement
            error_log("Number of columns in INSERT: 38");
    
            // Set default values for optional fields
            $coupon = isset($orderData['coupon']) ? $orderData['coupon'] : '';
            $discount = isset($orderData['discount']) ? $orderData['discount'] : '';
            $coupon_type = isset($orderData['coupon_type']) ? $orderData['coupon_type'] : '';
    
            // Use direct SQL for debugging
            $sql = "INSERT INTO orders (
                order_id, razorpay_order_id, user_id,
                billing_fullname, billing_email, billing_mobile,
                billing_address1, billing_address2, billing_city,
                billing_state, billing_pincode,
                shipping_fullname, shipping_email, shipping_mobile,
                shipping_address1, shipping_address2, shipping_city,
                shipping_state, shipping_pincode,
                total_products, subtotal, gst, total, grandtotal,
                coupon, discount, coupon_type,
                payment_mode, payment_amount, payment_reference,
                payment_proof, approval, remarks, status,
                payment_id, payment_date, order_status, payment_status
            ) VALUES (
                '{$con->real_escape_string($orderData['order_id'])}',
                '{$con->real_escape_string($orderData['razorpay_order_id'])}',
                '{$con->real_escape_string($orderData['user_id'])}',
                '{$con->real_escape_string($orderData['billing_fullname'])}',
                '{$con->real_escape_string($orderData['billing_email'])}',
                '{$con->real_escape_string($orderData['billing_mobile'])}',
                '{$con->real_escape_string($orderData['billing_address1'])}',
                '{$con->real_escape_string($orderData['billing_address2'])}',
                '{$con->real_escape_string($orderData['billing_city'])}',
                '{$con->real_escape_string($orderData['billing_state'])}',
                '{$con->real_escape_string($orderData['billing_pincode'])}',
                '{$con->real_escape_string($orderData['shipping_fullname'])}',
                '{$con->real_escape_string($orderData['shipping_email'])}',
                '{$con->real_escape_string($orderData['shipping_mobile'])}',
                '{$con->real_escape_string($orderData['shipping_address1'])}',
                '{$con->real_escape_string($orderData['shipping_address2'])}',
                '{$con->real_escape_string($orderData['shipping_city'])}',
                '{$con->real_escape_string($orderData['shipping_state'])}',
                '{$con->real_escape_string($orderData['shipping_pincode'])}',
                '{$con->real_escape_string($orderData['total_products'])}',
                '{$con->real_escape_string($orderData['subtotal'])}',
                '{$con->real_escape_string($orderData['gst'])}',
                '{$con->real_escape_string($orderData['total'])}',
                '{$con->real_escape_string($orderData['grandtotal'])}',
                '{$con->real_escape_string($coupon)}',
                '{$con->real_escape_string($discount)}',
                '{$con->real_escape_string($coupon_type)}',
                '{$con->real_escape_string($orderData['payment_mode'])}',
                '{$con->real_escape_string($orderData['payment_amount'])}',
                '{$con->real_escape_string($orderData['payment_reference'])}',
                '{$con->real_escape_string($orderData['payment_proof'])}',
                '{$con->real_escape_string($orderData['approval'])}',
                '{$con->real_escape_string($orderData['remarks'])}',
                '{$con->real_escape_string($orderData['status'])}',
                '{$con->real_escape_string($orderData['payment_id'])}',
                '{$con->real_escape_string($orderData['payment_date'])}',
                '{$con->real_escape_string($orderData['order_status'])}',
                '{$con->real_escape_string($orderData['payment_status'])}'
            )";
    
            error_log("Executing SQL: " . $sql);
    
            if ($con->query($sql)) {
                $order_id = $con->insert_id;
    
                // Fetch cart items for the user and insert into order_products
                $cartQuery = $con->prepare('SELECT
                    cart.user_id,
                    cart.product_id,
                    cart.quantity,
                    products.product_name,
                    products.featured_image,
                    products.ornament_weight,
                    ornaments.price AS price_per_gram,
                    products.discount_percentage,
                    products.slug,
                    ornaments.name AS ornament_name
                FROM cart
                INNER JOIN products ON cart.product_id = products.id
                LEFT JOIN ornaments ON products.ornament_type = ornaments.id
                WHERE cart.user_id = ?');
    
                $cartQuery->bind_param('i', $orderData['user_id']);
                $cartQuery->execute();
                $cartResult = $cartQuery->get_result();
    
                // Prepare order_products insertion
                $orderProductQuery = $con->prepare('INSERT INTO order_products (
                    order_id, user_id, product_id, product_name, product_image,
                    quantity, product_weight, price_per_gram, product_actual_price, product_price, product_slug, product_type
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    
                while ($cartRow = $cartResult->fetch_assoc()) {
                    // Calculate actual price and discounted price
                    $actual_price = $cartRow['ornament_weight'] * $cartRow['price_per_gram'];
                    $discounted_price = $actual_price - ($actual_price * $cartRow['discount_percentage'] / 100);
    
                    $orderProductQuery->bind_param('iisssiddssss',
                        $order_id,
                        $cartRow['user_id'],
                        $cartRow['product_id'],
                        $cartRow['product_name'],
                        $cartRow['featured_image'],
                        $cartRow['quantity'],
                        $cartRow['ornament_weight'],
                        $cartRow['price_per_gram'],
                        $actual_price,
                        $discounted_price,
                        $cartRow['slug'],
                        $cartRow['ornament_name']
                    );
    
                    if (!$orderProductQuery->execute()) {
                        throw new Exception("Failed to insert order product: " . $orderProductQuery->error);
                    }
                }
    
                // Clear cart
                $clearCart = $con->prepare('DELETE FROM cart WHERE user_id = ?');
                $clearCart->bind_param('s', $orderData['user_id']);
                if (!$clearCart->execute()) {
                    throw new Exception("Failed to clear cart: " . $clearCart->error);
                }
    
                $con->commit();
                $res['status'] = 1;
                $res['order_id'] = $orderData['order_id'];
            } else {
                throw new Exception("Failed to insert order: " . $con->error);
            }
    
        } catch (Exception $e) {
            if (isset($con)) {
                $con->rollback();
            }
            error_log("Error in PlaceOrder: " . $e->getMessage());
            $res['error'] = $e->getMessage();
        } finally {
            if (isset($cartQuery)) $cartQuery->close();
            if (isset($orderProductQuery)) $orderProductQuery->close();
            if (isset($clearCart)) $clearCart->close();
            if (isset($con)) $con->close();
        }
    
        return $res;
    }
    
    
    public function getOrders() {
                $res = array();
                $res['status'] = 0;
                $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
                $query = $con->prepare('SELECT 
                                            id, user_id, billing_fullname, billing_email, billing_mobile, 
                                            billing_address1, billing_address2, billing_city, billing_state, billing_pincode, 
                                            shipping_fullname, shipping_email, shipping_mobile, shipping_address1, 
                                            shipping_address2, shipping_city, shipping_state, shipping_pincode, 
                                            total_products, subtotal, gst, total, grandtotal, coupon, discount, 
                                            coupon_type, payment_mode, payment_amount, payment_reference, payment_proof, 
                                            approval, order_status, remarks, status, created_at 
                                        FROM orders 
                                        ORDER BY id DESC');
                
                if ($query->execute()) {
                    $query->bind_result(
                        $id, $user_id, $billing_fullname, $billing_email, $billing_mobile, 
                        $billing_address1, $billing_address2, $billing_city, $billing_state, $billing_pincode, 
                        $shipping_fullname, $shipping_email, $shipping_mobile, $shipping_address1, 
                        $shipping_address2, $shipping_city, $shipping_state, $shipping_pincode, 
                        $total_products, $subtotal, $gst, $total, $grandtotal, $coupon, $discount, 
                        $coupon_type, $payment_mode, $payment_amount, $payment_reference, $payment_proof, 
                        $approval, $order_status, $remarks, $status, $created_at
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
                        $res['status_field'][$i] = $status; // Renamed to avoid conflict with the overall 'status' field
                        $res['created_at'][$i] = $created_at;
                        $i++;
                    }
                    $res['count'] = $i;
                } else {
                    $err = 'Statement not Executed';
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
 
    public function addCustomizations($user_id, $image, $slug)
    {
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
            $query = $con->prepare('INSERT INTO customizations ( user_id, image, reference) VALUES (?, ?, ?)');
            $query->bind_param('sss', $user_id, $image, $slug);

            if ($query->execute()) {

                // Commit transaction
                $con->commit();
                $res['status'] = 1;
            } else {
                // Rollback transaction if users insertion fails
                $con->rollback();
                $err = 'Customizations statement not executed';
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


    public function addReview($user_id, $product_id, $rating, $review)
    {
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
            $query = $con->prepare('INSERT INTO ratings ( user_id, product_id, rating, review) VALUES (?, ?, ?, ?)');
            $query->bind_param('ssss', $user_id, $product_id, $rating, $review);

            if ($query->execute()) {

                // Commit transaction
                $con->commit();
                $res['status'] = 1;
            } else {
                // Rollback transaction if users insertion fails
                $con->rollback();
                $err = 'Review statement not executed';
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


    public function getReviewByProductId($id)
    {
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());

        // Modified query to include the `users` table
        $query = $con->prepare('
                SELECT 
                    r.id, r.user_id, u.name, r.product_id, r.rating, r.review, r.status, r.created_at 
                FROM 
                    ratings r
                INNER JOIN 
                    users u ON r.user_id = u.id
                WHERE 
                    r.product_id = ? 
                ORDER BY 
                    r.id DESC
            ');

        $query->bind_param('i', $id); // Bind the product ID parameter

        if ($query->execute()) {
            $query->bind_result($id, $user_id, $username, $product_id, $rating, $review, $status, $created_at);
            $i = 0;
            while ($query->fetch()) {
                $res['status'] = 1;
                $res['id'][$i] = $id;
                $res['user_id'][$i] = $user_id;
                $res['username'][$i] = $username; // Add username to the result
                $res['product_id'][$i] = $product_id;
                $res['rating'][$i] = $rating;
                $res['review'][$i] = $review;
                $res['statusval'][$i] = $status;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count'] = $i;
        } else {
            $res['error'] = 'Statement not executed';
        }

        return $res;
    }




    
    public function searchProducts($searchTerm) {
        $res = array();
        $res['status'] = 0;
    
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        if ($con->connect_error) {
            $res['error'] = "Connection failed: " . $con->connect_error;
            return $res;
        }
        
        try {
            $query = $con->prepare("
                SELECT 
                    p.id, 
                    p.product_name, 
                    p.slug, 
                    p.featured_image, 
                    p.ornament_weight, 
                    o.price AS price_per_gram, 
                    p.discount_percentage 
                FROM 
                    products p 
                LEFT JOIN 
                    ornaments o 
                ON 
                    p.ornament_type = o.id 
                WHERE 
                    p.product_name LIKE ?
            ");
            $searchTerm = '%' . $searchTerm . '%';
            $query->bind_param('s', $searchTerm);
            
            if ($query->execute()) {
                $query->store_result();
                $query->bind_result($id, $product_name, $slug, $featured_image, $ornament_weight, $price_per_gram, $discount_percentage);
                
                $res['status'] = 1;
                $res['count'] = $query->num_rows;
                $res['id'] = array();
                $res['product_name'] = array();
                $res['slug'] = array();
                $res['featured_image'] = array();
                $res['ornament_weight'] = array();
                $res['price_per_gram'] = array();
                $res['discount_percentage'] = array();
                
                while ($query->fetch()) {
                    $res['id'][] = $id;
                    $res['product_name'][] = $product_name;
                    $res['slug'][] = $slug;
                    $res['featured_image'][] = $featured_image;
                    $res['ornament_weight'][] = $ornament_weight;
                    $res['price_per_gram'][] = $price_per_gram;
                    $res['discount_percentage'][] = $discount_percentage;
                }
            } else {
                $res['error'] = "Error executing query: " . $query->error;
            }
            
            $query->close();
        } catch (Exception $e) {
            $res['error'] = "Exception: " . $e->getMessage();
        }
        
        $con->close();
        return $res;
    }






    public function AddContact($namecontact, $emailcontact, $subject, $message)
    {
        $res = array();
        $res['status'] = 0;


        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());


        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        $con->begin_transaction();

        try {

            $query = $con->prepare('INSERT INTO contact (name, email, subject, message) VALUES (?, ?, ?, ?)');
            $query->bind_param('ssss', $namecontact, $emailcontact, $subject, $message);

            if ($query->execute()) {

                $con->commit();
                $res['status'] = 1;
            } else {

                $con->rollback();
                $err = 'Contact statement not executed: ' . $query->error;
                $res['error'] = $err;
                error_log($err);
            }
        } catch (Exception $e) {

            $con->rollback();
            $res['error'] = $e->getMessage();
            error_log($e->getMessage());
        }


        $con->close();

        return $res;
    }

    public function AddSubscription($email)
    {
        $res = array();
        $res['status'] = 0;


        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());


        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }


        $con->begin_transaction();

        try {

            $query = $con->prepare('INSERT INTO subscriptions (email) VALUES (?)');
            $query->bind_param('s', $email);

            if ($query->execute()) {

                $con->commit();
                $res['status'] = 1;
            } else {

                $con->rollback();
                $err = 'Subscription statement not executed: ' . $query->error;
                $res['error'] = $err;
                error_log($err); // Log the error for debugging
            }
        } catch (Exception $e) {

            $con->rollback();
            $res['error'] = $e->getMessage();
            error_log($e->getMessage()); // Log the exception for debugging
        }


        $con->close();

        return $res;
    }

    public function getPartners()
    {
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
    public function AddTestimonial($name, $subject, $message, $rating, $image = '')
    {
        $res = array();
        $res['status'] = 0;

        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());

        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        try {
            // Begin transaction
            $con->begin_transaction();

            $query = $con->prepare("INSERT INTO testimonials (name, subject, message, rating, image) VALUES (?, ?, ?, ?, ?)");
            $query->bind_param("sssis", $name, $subject, $message, $rating, $image);

            if ($query->execute()) {
                $con->commit();
                $res['status'] = 1;
            } else {
                $con->rollback();
                $res['error'] = 'Statement not executed: ' . $query->error;
            }

            $query->close();
        } catch (Exception $e) {
            $con->rollback();
            $res['error'] = $e->getMessage();
            error_log($e->getMessage());
        }

        $con->close();
        return $res;
    }


    public function getTestimonials()
    {
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

    public function getAverageRating($product_id)
    {
        $res = array();
        $res['status'] = 0;
        $res['average_rating'] = 0; // Default average rating

        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());

        if ($con->connect_error) {
            error_log("Connection failed: " . $con->connect_error);
            die("Connection failed: " . $con->connect_error);
        }

        $query = $con->prepare("SELECT AVG(rating) as average_rating FROM ratings WHERE product_id = ? AND status = 1");

        if (!$query) {
            error_log("Prepare failed: " . $con->error);
            return $res;
        }

        $query->bind_param('i', $product_id);

        if ($query->execute()) {
            $query->bind_result($average_rating);
            if ($query->fetch()) {
                $res['status'] = 1;
                $res['average_rating'] = $average_rating ? round($average_rating, 1) : 0; // Round to 1 decimal place
            }
        } else {
            error_log("Execute failed: " . $query->error);
        }

        $query->close();
        $con->close();

        return $res;
    }


    public function savePaymentDetails($data)
    {
        $res = array();
        $res['status'] = 0;

        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());

        if ($con->connect_error) {
            $res['error'] = "Connection failed: " . $con->connect_error;
            return $res;
        }

        try {
            // Start transaction
            $con->begin_transaction();

            // First update the orders table using the primary key id
            $updateOrderQuery = $con->prepare("
    UPDATE orders 
    SET 
        payment_status = 'paid',
        payment_id = ?,
        razorpay_order_id = ?,
        payment_date = NOW(),
        order_status = 'confirmed',
        payment_mode = 'Razorpay',
        payment_amount = ?,
        payment_reference = ?,
        updated_at = NOW()
    WHERE id = ?  -- Using primary key id to update the correct row
");

            if (!$updateOrderQuery) {
                throw new Exception("Failed to prepare order update query: " . $con->error);
            }

            // Bind parameters using the order's primary key id
            $updateOrderQuery->bind_param(
                'ssssi',
                $data['payment_id'],
                $data['razorpay_order_id'],
                $data['amount'],
                $data['payment_signature'],
                $data['order_id']  // This is now the primary key id of the orders table
            );

            // Rest of the function remains the same...
            if (!$updateOrderQuery->execute()) {
                throw new Exception("Failed to update order: " . $updateOrderQuery->error);
            }

            // Then insert into payments table using the same order id
            $paymentQuery = $con->prepare("
    INSERT INTO payments (
        order_id,  -- This will store the orders table primary key
        payment_id, 
        payment_signature, 
        amount, 
        status, 
        created_at
    ) VALUES (?, ?, ?, ?, ?, ?)
");

            if (!$paymentQuery) {
                throw new Exception("Failed to prepare payment query: " . $con->error);
            }

            $status = 'success';
            $created_at = date('Y-m-d H:i:s');

            $paymentQuery->bind_param(
                'sssdss',
                $data['order_id'],  // Using the same primary key id
                $data['payment_id'],
                $data['payment_signature'],
                $data['amount'],
                $status,
                $created_at
            );

            if (!$paymentQuery->execute()) {
                throw new Exception("Failed to save payment: " . $paymentQuery->error);
            }

            $con->commit();
            $res['status'] = 1;
            $res['message'] = 'Payment saved and order updated successfully';

        } catch (Exception $e) {
            $con->rollback();
            $res['error'] = $e->getMessage();
            error_log("Payment save error: " . $e->getMessage());
        } finally {
            if (isset($updateOrderQuery))
                $updateOrderQuery->close();
            if (isset($paymentQuery))
                $paymentQuery->close();
            $con->close();
        }

        return $res;
    }

    public function getOrderDetails($order_id)
    {
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
            if (isset($orderQuery))
                $orderQuery->close();
            if (isset($productQuery))
                $productQuery->close();
            if (isset($con))
                $con->close();
        }

        return $res;
    }








}

?>