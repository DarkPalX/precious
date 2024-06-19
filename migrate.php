<?php

    // Create connection
    $old = new mysqli("localhost", "root", "", "migration_precious_old");
    $new = new mysqli("localhost", "root", "", "migration_precious_beta");

    if ($old->connect_error) {
        die("Connection failed for old database: " . $old->connect_error);
    }
    if ($new->connect_error) {
        die("Connection failed for new database: " . $new->connect_error);
    }

    set_time_limit(0);

    echo 'Starting migration ..<br>';

    // // ADD USERS
    // $p = mysqli_query($old, "SELECT * FROM tbl_member");
    // if (!$p) {
    //     die('Select query failed on tbl_member: ' . mysqli_error($old));
    // }

    // while ($r = mysqli_fetch_array($p)) {
    //     $email = mysqli_real_escape_string($new, $r['emailAddress']);

    //     $email_exists = mysqli_query($new, "SELECT * FROM users WHERE email = '$email'");
    //     if (!$email_exists) {
    //         die('Select query failed on users: ' . mysqli_error($new));
    //     }

    //     if (mysqli_num_rows($email_exists) == 0) {
    //         $name = mysqli_real_escape_string($new, $r['firstName'] . ' ' . $r['lastName']);
    //         $firstname = mysqli_real_escape_string($new, $r['firstName']);
    //         $lastname = mysqli_real_escape_string($new, $r['lastName']);
    //         $password = mysqli_real_escape_string($new, $r['password']);
    //         $role_id = 6; // Assuming role_id is a fixed value and doesn't need escaping
    //         $mobile = mysqli_real_escape_string($new, $r['contact']);

    //         $add_user_query = "INSERT INTO users (name, firstname, lastname, email, password, role_id, mobile) 
    //                         VALUES ('$name', '$firstname', '$lastname', '$email', '$password', '$role_id', '$mobile')";
    //         $add_user = mysqli_query($new, $add_user_query);

    //         if (!$add_user) {
    //             die('Insert query failed: ' . mysqli_error($new) . "\nQuery: " . $add_user_query);
    //         }
    //     }
    // }
    // echo 'Done adding users.<br>';



    


    // // UPDATE new_id FROM NEW PRECIOUS USER ids ON OLD MEMBERS
    // $p = mysqli_query($new, "SELECT id, email FROM users");

    // while ($r = mysqli_fetch_array($p)) {
    //     $update_query = "UPDATE tbl_member SET new_id='" . $r['id'] . "' WHERE emailAddress='" . mysqli_real_escape_string($new, $r['email']) . "' AND new_id = 0 LIMIT 1";
    //     $update_id_at_old_member = mysqli_query($old, $update_query);

    //     if (!$update_id_at_old_member) {
    //         die('Update query failed on tbl_member: ' . mysqli_error($old) . "\nQuery: " . $update_query);
    //     }
    // }
    // echo 'Done updating new_id for users.<br>';






    // // FOR SETTING SKU ON OLD PRODUCTS
    // $p = mysqli_query($old, "SELECT id, name FROM tbl_eproducts");
    // if (!$p) {
    //     die('Select query failed on tbl_eproducts: ' . mysqli_error($old));
    // }

    // while ($r = mysqli_fetch_array($p)) {
    //     $ex = preg_split('/\s*[-:]\s*/', $r['name']);
    //     $sku = mysqli_real_escape_string($old, trim($ex[0]));

    //     $update_query = "UPDATE tbl_eproducts SET sku='$sku' WHERE id='" . $r['id'] . "'";
    //     $update_id_at_old_product = mysqli_query($old, $update_query);

    //     if (!$update_id_at_old_product) {
    //         die('Update query failed on tbl_eproducts: ' . mysqli_error($old) . "\nQuery: " . $update_query);
    //     }
    // }
    // echo 'Done setting SKU on old products.<br>';






    // // UPDATE new_id FROM NEW PRECIOUS PRODUCT ids BASED ON SKU
    // $p = mysqli_query($new, "SELECT id, sku FROM products");
    // if (!$p) {
    //     die('Select query failed on products: ' . mysqli_error($new));
    // }

    // while ($r = mysqli_fetch_array($p)) {
    //     $update_query = "UPDATE tbl_eproducts SET new_id='" . $r['id'] . "' WHERE sku='" . $r['sku'] . "'";
    //     $update_id_at_old_product = mysqli_query($old, $update_query);

    //     if (!$update_id_at_old_product) {
    //         die('Update query failed on tbl_eproducts: ' . mysqli_error($old) . "\nQuery: " . $update_query);
    //     }
    // }
    // echo 'Done updating new_id for products.<br>';

    // // ADD PRODUCTS FROM OLD TO NEW
    // $p = mysqli_query($old, "SELECT * FROM tbl_eproducts");
    // if (!$p) {
    //     die('Select query failed on tbl_eproducts: ' . mysqli_error($old));
    // }

    // while ($r = mysqli_fetch_array($p)) {
    //     $sku = mysqli_real_escape_string($new, $r['sku']);
    //     $name = mysqli_real_escape_string($new, $r['name']);
    //     $author = mysqli_real_escape_string($new, $r['author']);
    //     $slug = mysqli_real_escape_string($new, $r['slug']);
    //     $price = mysqli_real_escape_string($new, $r['price']);
    //     $discount_price = mysqli_real_escape_string($new, $r['discounted']);

    //     $already_exists = mysqli_query($new, "SELECT * FROM products WHERE sku = '$sku'");
    //     if (!$already_exists) {
    //         die('Select query failed on products: ' . mysqli_error($new));
    //     }

    //     if (mysqli_num_rows($already_exists) == 0) {
    //         if ($r['isEbook'] == 1) {
    //             $add_product_query = "INSERT INTO products (sku, name, author, slug, price, discount_price, book_type)
    //                                 VALUES ('$sku', '$name', '$author', '$slug', '$price', '$discount_price', 'E-book')";
    //         } else {
    //             $add_product_query = "INSERT INTO products (sku, name, author, slug, price, discount_price)
    //                                 VALUES ('$sku', '$name', '$author', '$slug', '$price', '$discount_price')";
    //         }

    //         $add_product = mysqli_query($new, $add_product_query);

    //         if (!$add_product) {
    //             die('Insert query failed: ' . mysqli_error($new) . "\nQuery: " . $add_product_query);
    //         }
    //     }
    // }
    // echo 'Done adding products.<br>';






    // // AFTER ADDING OLD PRODUCTS TO NEW, UPDATE new_id FROM NEW PRECIOUS PRODUCT ids BASED ON SKU in OLD AGAIN
    // $p = mysqli_query($new, "SELECT id, sku FROM products");
    // if (!$p) {
    //     die('Select query failed on products: ' . mysqli_error($new));
    // }

    // while ($r = mysqli_fetch_array($p)) {
    //     $update_query = "UPDATE tbl_eproducts SET new_id='" . $r['id'] . "' WHERE sku='" . $r['sku'] . "'";
    //     $update_id_at_old_product = mysqli_query($old, $update_query);

    //     if (!$update_id_at_old_product) {
    //         die('Update query failed on tbl_eproducts: ' . mysqli_error($old) . "\nQuery: " . $update_query);
    //     }
    // }
    // echo 'Done updating new_id for products again.<br>';






    // // UPDATING MEMBER ID IN TRANSACTIONS TABLE
    
    // $p = mysqli_query($old, "SELECT * FROM tbl_member");

    // while ($r = mysqli_fetch_array($p)) {
    //     $update_query = "UPDATE tbl_transactions SET new_member_id='" . $r['new_id'] . "' WHERE member_id='" . mysqli_real_escape_string($new, $r['id']) . "'";
    //     $update_id_at_old_member = mysqli_query($old, $update_query);

    //     if (!$update_id_at_old_member) {
    //         die('Update query failed on tbl_member: ' . mysqli_error($old) . "\nQuery: " . $update_query);
    //     }
    // }
    // echo 'Done updating new_member_id for transactions table.<br>';
    





    // // MIGRATING TO SALES HEADERS

    // $p = mysqli_query($old, "SELECT * FROM tbl_transactions");
    // if (!$p) {
    //     die('Select query failed on tbl_transactions: ' . mysqli_error($old));
    // }

    // while ($r = mysqli_fetch_array($p)) {

    //     $query_data = mysqli_query($new, "SELECT * FROM users WHERE id ='" . intval($r['new_member_id']) . "'");
    //     $data = mysqli_fetch_assoc($query_data);

    //     if($data){
    //         $customer_name = mysqli_real_escape_string($new, $data['name']);
    //         $customer_email = mysqli_real_escape_string($new, $data['email']);
    //         $customer_contact_number = mysqli_real_escape_string($new, $data['mobile']);
    //         $customer_address = mysqli_real_escape_string($new, $data['address_street']) . ' ' . mysqli_real_escape_string($new, $data['address_city']) . ' ' . mysqli_real_escape_string($new, $data['address_province']) . ' ' . mysqli_real_escape_string($new, $data['address_zip']);
    
    //         $add_query = "INSERT INTO ecommerce_sales_headers (user_id, 
    //                                                             order_number, 
    //                                                             customer_name, 
    //                                                             customer_email, 
    //                                                             customer_contact_number, 
    //                                                             customer_address, 
    //                                                             customer_delivery_adress, 
    //                                                             delivery_fee_amount, 
    //                                                             delivery_status, 
    //                                                             gross_amount, 
    //                                                             net_amount, 
    //                                                             discount_amount, 
    //                                                             payment_status) 
    
    //                         VALUES ('" . $r['new_member_id'] . "',
    //                                 '" . $r['transaction_number'] . "',
    //                                 '" . $customer_name . "',
    //                                 '" . $customer_email . "',
    //                                 '" . $customer_contact_number . "',
    //                                 '" . $customer_address . "',
    //                                 '" . $customer_address . "',
    //                                 '" . $r['shippingrate'] . "',
    //                                 '" . 'Shipped' . "',
    //                                 '" . $r['total'] . "',
    //                                 '" . $r['total'] . "',
    //                                 '" . $r['discount'] . "',
    //                                 '" . 'PAID' . "')";
    
    //         $insert_data = mysqli_query($new, $add_query);
    
    //         if (!$insert_data) {
    //             die('Insert query failed: ' . mysqli_error($new) . "\nQuery: " . $add_query);
    //         }
    //     }
        
    // }
    // echo 'Done adding to sales headers.<br>';





    // // UPDATING sales_header_id ID IN TRANSACTIONS CART TABLE
    
    // $p = mysqli_query($new, "SELECT * FROM ecommerce_sales_headers");

    // while ($r = mysqli_fetch_array($p)) {
    //     $sales_header_id = $r['id'];
    //     $transaction_number = mysqli_real_escape_string($new, $r['order_number']);

    //     $update_query = "UPDATE tbl_transaction_cart SET sales_header_id='$sales_header_id' WHERE transaction_number='$transaction_number'";
    //     $update_data = mysqli_query($old, $update_query);

    //     if (!$update_data) {
    //         die('Update query failed on tbl_transaction_cart: ' . mysqli_error($old) . "\nQuery: " . $update_query);
    //     }
    // }

    // echo 'Done updating sales_header_id for transaction cart table.<br>';




    
    // MIGRATING TO SALES DETAILS

    $p = mysqli_query($old, "SELECT * FROM tbl_transaction_cart");
    if (!$p) {
        die('Select query failed on tbl_transaction_cart: ' . mysqli_error($old));
    }

    while ($r = mysqli_fetch_array($p)) {

        $query_data = mysqli_query($new, "SELECT * FROM products WHERE id ='" . intval($r['prod_id']) . "'");
        $data = mysqli_fetch_assoc($query_data);

        if($data){
            $product_name = mysqli_real_escape_string($new, $data['name']);

            $add_query = "INSERT INTO ecommerce_sales_details (sales_header_id, 
                            product_id, 
                            product_name, 
                            price, 
                            qty) 
                        
                        VALUES ('" . $r['sales_header_id'] . "',
                                '" . $r['prod_id'] . "',
                                '" . $product_name . "',
                                '" . $r['price'] . "',
                                '" . $r['quantity'] . "')";



            $insert_data = mysqli_query($new, $add_query);

            if (!$insert_data) {
                die('Insert query failed: ' . mysqli_error($new) . "\nQuery: " . $add_query);
            }

            
        }
    }
    echo 'Done adding to sales details.<br>';






    set_time_limit(120);

    mysqli_close($old);
    mysqli_close($new);

    echo 'Migration success!';

?>
