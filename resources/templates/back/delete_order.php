<?php require_once("../../config.php");

if(isset($_GET['id'])){
    $query = query("DELETE FROM orders WHERE order_id = ".escape_string($_GET['id'])." ");
    confirm($query);
    set_message('<h4 class="bg-success text-center" style="padding:10px;">Order Deleted</h4>');
    redirect("../../../public/admin/index.php?orders");
} else {
    redirect("../../../public/admin/index.php?orders");
}

?>
