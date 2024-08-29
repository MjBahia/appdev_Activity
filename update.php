<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "app_dev";

$connection = new mysqli($servername, $username, $password, $database);

$name = "";
$description = "";
$price = "";
$quantity = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!isset($_GET["id"])) {
        header("location: index.php");
        exit;
    }

    $id = $_GET["id"];

    // Use a prepared statement to prevent SQL injection
    $sql = "SELECT * FROM product WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id); // Bind the ID as an integer
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location: index.php");
        exit;
    }

    $name = $row["name"];
    $description = $row["description"];
    $price = $row["price"];
    $quantity = $row["quantity"];
} 

if (isset($_POST['submit'])) {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $quantity = $_POST["quantity"];

    if (empty($name) || empty($description) || empty($price) || empty($quantity)) {
        $errorMessage = "All fields are required. Please fill in all the information.";
    } else {
        $sql = "UPDATE product SET name = ?, description = ?, price = ?, quantity = ? WHERE id = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ssdii", $name, $description, $price, $quantity, $id); // price should be float or decimal (s)
        
        if ($stmt->execute()) {
            $successMessage = "Product updated successfully!";
            header("location: index.php");
            exit;
        } else {
            $errorMessage = "Error updating product: " . $stmt->error;
        }
    }
}

// Close the database connection
$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
</head>
<body>
    <div class="container my-5">
        <h2>Edit Product</h2>

        <?php if (!empty($errorMessage)) : ?>
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong><?php echo htmlspecialchars($errorMessage); ?></strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
        <?php endif; ?>

        <form method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($name); ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Description</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="description" value="<?php echo htmlspecialchars($description); ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Price</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="price" value="<?php echo htmlspecialchars($price); ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Quantity</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="quantity" value="<?php echo htmlspecialchars($quantity); ?>">
                </div>
            </div>

            <?php if (!empty($successMessage)) : ?>
                <div class='row mb-3'>
                    <div class='offset-sm-3 col-sm-6'>
                        <div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <strong><?php echo htmlspecialchars($successMessage); ?></strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" name="submit" class="btn btn-primary">Update</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a href="/Dev/index.php" class="btn btn-secondary" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
