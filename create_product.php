<?php
/**
 * Created by PhpStorm.
 * User: Bram
 * Date: 12-7-2016
 * Time: 18:21
 */
// Necessary includes
$pageTitle = "Product toevoegen";
include_once('view/header.php');

// Initialize database connection
include_once('assets/config/database.php');
$db = Database::getInstance();

include_once('domain/Category.php');
include_once('domain/Product.php');

// Initialize Category
$categoryObj = new Category($db->conn); // assign the database connection that we have created here above as the parameter (so the Category also constain the db connection to do CRUD operations to the database).

// Form handler (POST REQUEST)
if(isset($_POST['submit'])) {
    // Instantiate new product object
    $product = new Product($db->conn);

    // Validate if all the input fields aren't empty
    if(!empty($_POST['name']) && !empty($_POST['price']) && !empty($_POST['description']) && !empty($_POST['category_id'])) {

        $product->name = $_POST['name'];
        $product->price = (float) ($_POST['price']);
        $product->description = $_POST['description'];
        $product->categoryID = $_POST['category_id'];

        // Prepare Product associative array, that we want to store into the database
        $aProduct = array(
            'name'          => $product->name,
            'price'         => $product->price,
            'description'   => $product->description,
            'category_id'   => $product->categoryID
        );

        // Create the product
        if($db->createRecord($product->tableName,$aProduct)) {
            ?>
            <div class="alert alert-success">
                <strong>Succes!</strong> Het product met de naam <?php echo $product->name ?> is succesvol aangemaakt. <button class="close" data-dismiss='alert' aria-hidden="true">Sluiten</button>
            </div>
            <?php
        }
    } else {
        ?>
        <div class="alert alert-danger">
            <strong>Foutmelding!</strong> Vergeet niet alle velden in te vullen. <button class="close" data-dismiss='alert' aria-hidden="true">Sluiten</button>
        </div>
        <?php
    }
}

?>

<!-- Main content -->
    <form action="create_product.php" method="post">
        <div class="form-group">
            <label for="name">Naam:</label>
            <input type="name" name="name" class="form-control" >
        </div>
        <div class="form-group">
            <label for="price">Prijs:</label>
            <input type="text" name="price" class="form-control">
        </div>
        <div class="form-group">
            <label for="description">Beschrijving:</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="price">Categorie:</label>
            <!-- Category select -->
            <select class="form-control" name="category_id">
                <option value="none">Selecteer een categorie</option>
                <?php
                $categories = $categoryObj->readAllCategories();
                foreach($categories as $categorie) {
                    echo "<option value='{$categorie['id']}'>{$categorie['name']}</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit" name="submit" class="btn btn-success">Opslaan</button>
    </form>
<div class="right-button-margin">
    <a href="index.php" class="btn btn-default pull-right">Alle producten bekijken</a>
</div>
<?php include_once('view/footer.php'); ?>