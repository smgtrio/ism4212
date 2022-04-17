<!-- ##### THis is PHP ##### -->

<?php
##### includes.php #####
include("includes.php");


// ##### Show Error Message #####
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// phpinfo(); #### PHP Info page
include_once("dbconn.php"); ### DB connection


##### catch the variables #####
// if (isset($_POST['submit_car'])) {
//     $VIN = $_POST['VIN'];
//     $brand = $_POST['brand'];
//     $model = $_POST['model'];
//     $price = $_POST['price'];
//     $production_year = $_POST['production_year'];
//     // echo "The year is $production_year";
//     echo "TEST: The price is $price";
//     // echo "submitting a car";
//     $sql = "INSERT INTO car(VIN, brand, model, price, production_year) 
//     VALUES (?, ?, ?, ?, ?)";
//     $stmt = $conn->prepare($sql);
//     $stmt->execute([$VIN, $brand, $model, $price, $production_year]);
// }

// else {
//     echo "not submitting a car";
// }

// echo "This is a test. <br>";

// $sql = "SELECT * FROM car";
// $results = $conn->query($sql)->fetchAll();

// foreach ($results as $item) {
//     $model = $item['model'];
//     echo "$model <br>";
// }
?>
<!-- ##### End of PHP ##### -->

<!-- ##### THis is HTML ##### -->
<html>
<body>
<form action="processing.php" method="POST" name="test_form" >

<div>
<h1> Enter New Car Info </h1>
    <div> Enter a car VIN: </div>
    <input type="text" name="VIN">

    <div> Input a car maker: </div>
    <input type="text" name="brand">
    
    <div> Input a car model: </div>
    <input type="text" name="model">
    
    <div> Input a car price: </div>
    <input type="text" name="price">
    
    <div> Input a car production_year: </div>
    <input type="text" name="production_year">
    
</div>

<button name='submit_car' type='submit' value="tttttt"> 
Submit
</button>

</form>

</body>
</html>