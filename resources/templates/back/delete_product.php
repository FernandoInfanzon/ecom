<?php require_once("../../config.php");

if(isset($_GET['id'])){
    $query = query("UPDATE products SET active='0' WHERE product_id = ".escape_string($_GET['id'])." ");
    confirm($query);
    set_message('<h4 class="bg-success text-center" style="padding:10px;">Product Deleted</h4>');
    redirect("../../../public/admin/index.php?products");
} else {
    redirect("../../../public/admin/index.php?products");
}

?>
