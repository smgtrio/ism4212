<?php
include_once("includes.php");
?>

<html>

<body>
    <h1> Confirmation Page </h1>

    <!-- ### begin the PHP code block ### -->
    <?php

if (isset($_POST['submit_confirm'])) { ### if the form is submitted ###
    $petname = $_POST['petname']; ### catch the variable ###
    $dropofftime = $_POST['dropofftime']; ### catch the variable ###

    $sql = "SELECT * FROM customers WHERE petname = $petname "; ### query the data  
    $result = $conn->query($sql)->fetch();

    if (isset($result)) { ### if the result is not null, unpack data
        $petname = $result['petname'];
        $dropofftime = $result['dropofftime'];
        $pettype = $result['pettype'];
        $image = $result['image'];
    }

    ##### Insert an order record into the orders table #####
    $sql = "INSERT INTO customers (petname, dropofftime) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$customer_id, $product_id]);
    echo "The orders table is updated in database.<br>";

    ##### deduct one product from the inventory number #####
    $sql = "UPDATE customers WHERE petname = $petname";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    echo "The inventory table is updated in database.<br>";

    ##### mark the product as  solde in  the Products Page
    $sql = "UPDATE petname WHERE product_id = $petname";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    echo "The sold products is removed from the products table in database.<br>";


}


?>

<h2>You ordered the following service: </h2>

<table>
    <tr>
        <td> <?php echo $petname; ?></td>
    </tr>
    <tr>
        <td> <?php echo $dropofftime; ?></td>
    </tr>
    <tr>
        <td> <?php echo $pickuptime; ?></td>
    </tr>
    <tr>
        <td>
            <img src='data:image/jpg;base64,<?php echo base64_encode($image); ?>' style='height:24'>
        </td>
    </tr>
    <tr>
        <td> <?php echo $Payment_Total; ?></td>
    </tr>
</table>

<h2>Thank You And Come Again </h2>

</body>

</html>