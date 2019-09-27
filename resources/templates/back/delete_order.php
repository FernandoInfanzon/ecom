<?php require_once("../../config.php");

if(isset($_GET['id'])){
    $query = query("UPDATE orders SET order_active='0' WHERE order_id = ".escape_string($_GET['id'])." ");
    confirm($query);
    set_message('<h4 class="bg-success text-center" style="padding:10px;">Order Deleted</h4>');
    redirect("../../../public/admin/index.php?orders");
} else {
    redirect("../../../public/admin/index.php?orders");
}

?>
