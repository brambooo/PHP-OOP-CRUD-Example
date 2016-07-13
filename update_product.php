<?php
/**
 * Created by PhpStorm.
 * User: Bram
 * Date: 13-7-2016
 * Time: 18:41
 */

// Attributes
$pageTitle = "Producten bewerken";

// Necessary includes
include_once('assets/config/database.php');
include_once('assets//Debugging.php');
include_once('domain/Product.php');
include_once('domain/Category.php');
include_once('view/header.php');

// Initialize objects
$db = new Database();
$product = new Product($db->conn);
$category = new Category($db->conn);

// Try to get the product for editting
if(isset($_GET['id'])) {
    $productID = $_GET['id'];

    $productFromDB = $db->readRecordFromTableByID($product->tableName, $productID);
    //Debugging::printItemAsArray($productFromDB);

    // Validate product
    if(!empty($productFromDB)) {

        // Check is there is an update submitted
        if(isset($_POST['submit'])) {
            //DEBUGGING::printItemAsArray($_POST);

            // Validate fields
            if( !empty($_POST['name']) && !empty($_POST['price']) && !empty($_POST['description']) && !empty($_POST['category_id']) ) {
                $name           = $_POST['name'];
                $price          = $_POST['price'];
                $description    = $_POST['description'];
                $category_id    = $_POST['category_id'];

                // Update product in the database
                $isUpdated = $db->updateRecord('product', $productID, array('name' => $name, 'price' => $price, 'description' => $description, 'category_id' => $category_id));
                if($isUpdated) {
                    ?>
                    <div class="alert alert-success">
                        <strong>Succes!</strong> Het producten met de naam <?php echo $name ?> is succesvol bijgewerkt! <button class="btn btn-success" onclick="navigateBack()">Sluiten</button>
                    </div>
                    <?php
                }
            }
        }

    } else {
        ?>
        <div class="alert alert-danger">
            <strong>Foutmelding!</strong> Het producten met het opgegeven nummer is niet gevonden. Probeer het nog eens met een ander nummer. <button class="btn btn-danger" onclick="navigateBack()">Terug</button>
        </div>
        <?php
    }

} else {
    // Show error message
    ?>
    <div class="alert alert-danger">
        <strong>Foutmelding!</strong> Vergeet geen productnummer in te voeren!. <button class="btn btn-danger" onclick="navigateBack()">Terug</button>
    </div>
    <?php
    exit();
}

?>

    <!-- Main content -->

    <!-- edit product form -->
    <form action="update_product.php?id=<?php echo $productID; ?>" method="post">
        <div class="form-group">
            <label for="name">Naam:</label>
            <input type="name" name="name" value="<?php echo $productFromDB['name']; ?>" class="form-control" >
        </div>
        <div class="form-group">
            <label for="price">Prijs:</label>
            <input type="text" name="price"  value="<?php echo $productFromDB['price']; ?>" class="form-control">
        </div>
        <div class="form-group">
            <label for="description">Beschrijving:</label>
            <textarea name="description" class="form-control"><?php echo $productFromDB['description']; ?></textarea>
        </div>
        <div class="form-group">
            <label for="price">Categorie:</label>
            <!-- Category select -->
            <select class="form-control" name="category_id">
                <?php
                // Get all the categories from the database
                $categories = $category->readAllCategories();
                // Get selected category from the database
                $currentCategory = $db->readRecordFromTableByID('category', $productFromDB['category_id']);

                // Validate if product contain a category
                if(!empty($currentCategory)) {
                    // If so, show that category first and then the others
                    echo "<option value='{$currentCategory["id"]}'>{$currentCategory["name"]}</option>";
                } else {
                    echo "<option value='none'>Selecteer een categorie</option>";
                }
                // Load categories
                foreach($categories as $category) {
                    if($category['name'] != $currentCategory['name']) {
                        echo "<option value='{$category["id"]}'>{$category["name"]}</option>";
                    }
                }
                ?>
            </select>
        </div>
        <button type="submit" name="submit" class="btn btn-success">Opslaan</button>
    </form> <!-- end edit product form -->

    <div class="pull-right">
        <a href="create_product.php" class="btn btn-default">Product toevoegen</a>
    </div>
    <script>
        // functions
        function navigateBack() {
            window.history.back();
        }
    </script>
<?php include_once('view/footer.php'); ?>