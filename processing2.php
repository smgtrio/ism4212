
<?php
// ##### Show Error Message #####

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// phpinfo(); #### PHP Info page
include_once("dbconn.php"); ### DB connection


##### catch the variables #####
if (isset($_POST['submit_car'])) {
    $VIN = $_POST['VIN'];
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $price = $_POST['price'];
    $production_year = $_POST['production_year'];
    // echo "The year is $production_year";
    echo "TEST: The price is $price";
    // echo "submitting a car";
    $sql = "INSERT INTO car(VIN, brand, model, price, production_year) 
    VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$VIN, '$brand', $model, $price, $production_year]);
}