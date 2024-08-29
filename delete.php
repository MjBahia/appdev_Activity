<?php
if ( isset( $_GET["ID"] ) ) {
    $id =  $_GET["ID"] ;


$servername = "localhost";
$username = "root";
$password = "";
$database = "app_dev";

$connection = new mysqli($servername, $username, $password, $database);

$sql = "DELETE FROM product WHERE id=$id";
$connection->query($sql);

}

header("location: index.php");
exit;

 ?>