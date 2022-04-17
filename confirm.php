<?php
include_once("includes.php");
?>

<html>

<body>
    <h1> Confirmation Page </h1>

    <!-- ### begin the PHP code block ### -->
    <?php

if (isset($_POST['submit_confirm'])) { ### if the form is submitted ###
    $product_id = $_POST['product_id']; ### catch the variable ###
    $customer_id = $_POST['customer_id']; ### catch the variable ###

    $sql = "SELECT * FROM products WHERE product_id = $product_id "; ### query the data  
    $result = $conn->query($sql)->fetch();

    if (isset($result)) { ### if the result is not null, unpack data
        $product_id = $result['product_id'];
        $vin = $result['vin'];
        $brand = $result['brand'];
        $model = $result['model'];
        $price = $result['price'];
        $production_year = $result['production_year'];
        $image = $result['image'];
    }

    ##### Insert an order record into the orders table #####
    $sql = "INSERT INTO orders(customer_id, product_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$customer_id, $product_id]);
    echo "The orders table is updated in database.<br>";

    ##### deduct one product from the inventory number #####
    $sql = "UPDATE inventory SET num_in_stock = (num_in_stock - 1) WHERE product_id = $product_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    echo "The inventory table is updated in database.<br>";

    ##### mark the product as  solde in  the Products Page
    $sql = "UPDATE products SET sold = 'Sold' WHERE product_id = $product_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    echo "The sold products is removed from the products table in database.<br>";


}


?>

<h2>You ordered the following product: </h2>

<table>
    <tr>
        <td> <?php echo $brand; ?></td>
    </tr>
    <tr>
        <td> <?php echo $model; ?></td>
    </tr>
    <tr>
        <td> <?php echo $production_year; ?></td>
    </tr>
    <tr>
        <td>
            <img src='data:image/jpg;base64,<?php echo base64_encode($image); ?>' style='height:24'>
        </td>
    </tr>
    <tr>
        <td> <?php echo $price; ?></td>
    </tr>
</table>

<h2>Thank You And Come Again </h2>

</body>

</html>