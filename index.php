<?php
// Attributes
$pageTitle = "Producten bekijken";
// Necessary includes
include_once('view/header.php');

// Initialize database connection
include_once('assets/config/database.php');
$db = new Database();

?>

<!-- Main content -->
<div class="pull-right">
    <a href="create_product.php" class="btn btn-default">Product toevoegen</a>
</div>
<?php include_once('view/footer.php'); ?>