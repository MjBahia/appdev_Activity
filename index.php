<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class= "container" my-5>
        <h2>My Products</h2>
        <a  href="create.php" role="button">Add Products</a>
    <br>
    <table class="table">
             <thead>
              <tr>
                <th> Id</th>
                <th> Name</th>
                <th> Description</th>
                <th> Price</th>
                <th> Quantity</th>
                <th> Created_at</th>
                <th> Updated_at</th>
              </tr>
             </thead>
             <tbody>
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "app_dev";

                $connection = new mysqli($servername, $username, $password, $database);

                if ($connection->connect_error) {
                    die("Connection failed: " . $connection->connect_error);
                }
                $sql = "SELECT * FROM product";
                $result = $connection->query($sql);

                if(! $result) {
                    die("Invalid query: ". $connection->error);                   
                }

                while($row = $result->fetch_assoc()) {
                    echo "
                    <tr>
                    <td>$row[id]</td>
                    <td>$row[name]</td>
                    <td>$row[description]</td>
                    <td>$row[price]</td>
                    <td>$row[quantity]</td>
                    <td>$row[create_at]</td>
                    <td>$row[update_at]</td>
                    <td>
                        <a href='update.php?id=$row[id]'> Edit</a>
                        <a href='delete.php?ID=$row[id]'> Delete</a>
                    </td>
                </tr>

                    ";
                }
                
                ?>

             </tbody>
</table>
    </div>
</body>
</html>