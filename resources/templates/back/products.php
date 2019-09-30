

<div class="row">
  <h1 class="page-header">All Products</h1>
  <?php display_message();?>
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Id</th>
        <th>Title</th>
        <th>Category</th>
        <th>Price</th>
        <th>Quantity</th>
      </tr>
    </thead>
    <tbody>
     <?php get_products_in_admin(); ?>
    </tbody>
  </table>
</div>

<?php include(TEMPLATE_BACK . "/footer.php"); ?>