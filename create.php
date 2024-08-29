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


$errorMessage ="";
$successMessage = "";

if ( $_SERVER ["REQUEST_METHOD"] == "POST"){
    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $quantity = $_POST["quantity"];

    do{
        if(empty($name) || empty($description) || empty($price) || empty($quantity)){  
            $errorMessage = "All the field are required";
            break;
        }

        // add new product in the  database
        $sql = "INSERT INTO product (name, description, price, quantity) " .
                "VALUES ('$name' , '$description' , '$price' , '$quantity')";
        $result = $connection->query($sql); 

        $name = "";
        $description = "";
        $price = "";
        $quantity = "";

        $successMessage = "Product added Correctly";

        header("location: /Dev/index.php");
        exit;
       

    }while(false);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container my-5">
        <h2 style="text-align: center; padding-top:60px; font-size: 50px"> New Product </h2><br>
         
         <?php
         if (!empty($errorMessage)){
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>$errorMessage</strong>
            <button type='button' class='btn-close' data-bs-dissmiss='alert' arial-label='Close></button>
            </div>
            ";
         }
         
         ?>


        <form method="post">
          <div class="row mb-3">
            <label class="col-sm-3 col-form-label" style="font-size: 20px">name:</label>
            <div class="col-sm-6">
             <input type="text" class="form-control" name="name" value="<?php echo $name?>">   
            </div>
          </div>
          <div class="row mb-3">
            <label class="col-sm-3 col-form-label" style="font-size: 20px">description:</label>
            <div class="col-sm-6">
             <input type="text" class="form-control" name="description" value="<?php echo $description?>">   
            </div>
          </div>
            <div class="row mb-3">
            <label class="col-sm-3 col-form-label" style="font-size: 20px">price:</label>
            <div class="col-sm-6">
             <input type="text" class="form-control" name="price" value="<?php echo $price?>">   
            </div>
            </div>
            <div class="row mb-3">
            <label class="col-sm-3 col-form-label" style="font-size: 20px">quantity:</label>
            <div class="col-sm-6">
             <input type="text" class="form-control" name="quantity" value="<?php echo $quantity?>">   
            </div>
            </div>
          
            <?php
            if (!empty($successMessage)){
                echo "
                <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>$successMessage</strong>
            <button type='button' class='btn-close' data-bs-dissmiss='alert' arial-label='Close></button>
            </div>

                ";
            }
            
            ?>

       <div class="row mb-3">
        <div class="offset-sm-3 col-sm-3 d-grid">
       <button type="submit">Submit</button>
       </div>
       <div class="col-sm-3 d-grid">
       <a href="/Dev/index.php" role="button">Cancel</a>
       </div>
       </div>
        </form>
        </form>   
    </div>
</body>
</html>