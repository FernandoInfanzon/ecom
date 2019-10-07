
<?php

// helper functions

function last_id(){
    global $connection;
    return mysqli_insert_id($connection);
}

function set_message($msg){
    if(!empty($msg)){
        $_SESSION['message'] = $msg;
    } else {
        $msg = "";
    }
}

function display_message(){
    if(isset($_SESSION['message'])){
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
}

function redirect($location){
    header("Location:$location");
}

function query($sql){
    global $connection;
    return mysqli_query($connection, $sql);
}

function confirm($result){
    global $connection;
    if(!$result){
        die("QUERY FAILED" . mysqli_error($connection));
    }
}

function escape_string($string){
    global $connection;
    return mysqli_real_escape_string($connection, $string);
}

function fetch_array($result){
    return mysqli_fetch_array($result);
     
}

//get products

function get_products(){
    $query = query("SELECT * FROM products WHERE active='1' ");
    confirm($query);

    while($row = fetch_array($query)){

$product = <<<DELIMETER
<div class="col-sm-4 col-lg-4 col-md-4">
                        <div class="thumbnail">
                        <a href="item.php?id={$row['product_id']}"><img src="{$row['product_image']}" alt=""></a>
                            <div class="caption">
                                <h4 class="pull-right">&#36;{$row['product_price']}</h4>
                                <h4><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a>
                                </h4>
                                <p>{$row['product_short_description']}</p>
                                <a class="btn btn-primary" target="_blank" href="../resources/cart.php?add={$row['product_id']}">Add to Cart</a>
                            </div>
                        </div>
                    </div>
DELIMETER;
echo $product;
    }
}

//get categories

function get_categories(){
    $query = query("SELECT * FROM categories");
    confirm($query);

    while($row = fetch_array($query)){

        $categories = <<<DELIMETER
        <a href='category.php?id={$row['cat_id']}' class='list-group-item'>{$row['cat_title']}</a>
DELIMETER;
        echo $categories;
            }
        }

// get products about category

function get_category_products(){
    $query = query("SELECT * FROM products WHERE product_category_id= " . escape_string($_GET['id']) . " ");
    confirm($query);

    while($row = fetch_array($query)){

$product = <<<DELIMETER
<div class="col-md-3 col-sm-6 hero-feature">
    <div class="thumbnail">
        <img src="{$row['product_image']}" alt="">
            <div class="caption">
                <h3>{$row['product_title']}</h3>
                <p>{$row['product_short_description']}</p>
                <p>
                    <a href="#" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
                </p>
            </div>
    </div>
</div>

DELIMETER;
echo $product;
    }
}

// get products in shop 

function get_category_products_shop(){
    $query = query("SELECT * FROM products ");
    confirm($query);

    while($row = fetch_array($query)){

$product = <<<DELIMETER
<div class="col-md-3 col-sm-6 hero-feature">
    <div class="thumbnail">
        <img src="{$row['product_image']}" alt="">
            <div class="caption">
                <h3>{$row['product_title']}</h3>
                <p>{$row['product_short_description']}</p>
                <p>
                    <a href="#" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
                </p>
            </div>
    </div>
</div>

DELIMETER;
echo $product;
    }
}

// Login user

function login_user(){
   if(isset($_POST['submit'])){
    $email = escape_string($_POST['email']);
    $password = escape_string($_POST['password']);


    $query = query(" SELECT * FROM users WHERE email = '{$email}' AND password = '{$password}' AND active='1' ");
    confirm($query);
    $row2 = fetch_array($query);
    $name = $row2['name'];

    if(mysqli_num_rows($query) == 0){
        set_message("Your Password or Username are wrong");
        redirect("login.php");

    } else {
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $name;
        // set_message("Hi {$username}, Welcome to Admin Console ");
        redirect("admin/");
    }

    }
}

function send_message(){
    if(isset($_POST['submit'])){

        $to             = "hello@technoayuda.com";
        $form_name      = $_POST['name'];
        $form_subject   = $_POST['subject'];
        $form_email     = $_POST['email'];
        $form_message   = $_POST['message'];
        
        $headers = "From: {$form_name}";

        $result = mail($to, $subject, $message, $headers);

        if(!$result) {
            set_message("Sorry we could not send your message");
            redirect("contact.php");
        } else {
            set_message("Your message has been sent");
            redirect("contact.php");
        }

    }

}

//Backend Functions

function display_orders(){
    $query = query("SELECT * FROM orders WHERE order_active='1' ");
    confirm($query);

    while($row = fetch_array($query)){

        $orders = <<<DELIMETER
        <tr>
            <td>{$row['order_id']}</td>
            <td>{$row['order_amount']}</td>
            <td>{$row['order_transaction']}</td>
            <td>{$row['order_currency']}</td>
            <td>{$row['order_status']}</td>
            <td><a class="btn btn-danger" href="../../resources/templates/back/delete_order.php?id={$row['order_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
        </tr>
DELIMETER;
        echo $orders;
            }
}


/***** Admin Products */

function get_products_in_admin(){
    $query = query("SELECT * FROM products WHERE active='1' ");
    confirm($query);

    while($row = fetch_array($query)){

$product = <<<DELIMETER
<tr>
    <td>{$row['product_id']}</td>
    <td>{$row['product_title']}<br>
        <a href="index.php?edit_product&id={$row['product_id']}">
            <img src="{$row['product_image']}" class="w-25" alt="{$row['product_title']}">
        </a>        
    </td>
    <td>Category</td>
    <td>{$row['product_price']}</td>
    <td>{$row['product_quantity']}</td>
    <td><a class="btn btn-danger" href="../../resources/templates/back/delete_product.php?id={$row['product_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>

</tr>
DELIMETER;
echo $product;
    }
}




/***** add  Products in admin */

function add_product(){
    if(isset($_POST['publish'])){
     
    $product_title              = escape_string($_POST['product_title']);
    $product_category_id        = escape_string($_POST['product_category_id']);
    $product_price              = escape_string($_POST['product_price']);
    $product_description        = escape_string($_POST['product_description']);
    $product_short_description  = escape_string($_POST['product_short_description']);
    $product_quantity           = escape_string($_POST['product_quantity']);
    $product_image              = escape_string($_FILES['file']['name']);
    $image_temp_location        = escape_string($_FILES['file']['tmp_name']);

    move_uploaded_file($image_temp_location, UPLOAD_DIRECTORY . DS . $product_image);

    $query = query("INSERT INTO products(product_title, product_category_id, product_price,
    product_description, product_short_description, product_quantity, product_image) VALUES('{$product_title}', '{$product_category_id}', '{$product_price}',
        '{$product_description}', '{$product_short_description}', '{$product_quantity}', '{$product_image}')  ");
    confirm($query);
    $last_id = last_id();
    set_message('<h4 class="bg-success text-center" style="padding:10px;">New Product with id '.$last_id.' was Added</h4>');
    redirect("index.php?products");

}}



function show_categories_add_product_page(){
    $query = query("SELECT * FROM categories");
    confirm($query);

    while($row = fetch_array($query)){

        $categories_options = <<<DELIMETER
        <option value="{$row['cat_id']}">{$row['cat_title']}</option>
DELIMETER;
        echo $categories_options;
            }
        }



?>