<?php
include_once("includes.php");
?>


<table>

    <thead>
        <td>order_id</td>
        <td>customer_id</td>
        <td>product_id</td>
        <td>employee_id</td>
        <td>oerder_date</td>
        <td>shipper_id</td>
    </thead>

    <tbody>
        <?php
$sql = "SELECT * FROM orders "; ### the SQL query
$results = $conn->query($sql)->fetchAll(); ### run query and get results
foreach ($results as $item) { ### upacking the results

    $order_id = $item['order_id'];
    $customer_id = $item['customer_id'];
    $product_id = $item['product_id'];
    $employee_id = $item['employee_id'];
    $order_date = $item['order_date'];
    $shipper_id = $item['shipper_id'];



    echo "<tr>"; ### row begins

    echo "<td>"; ### cell begins
    echo "$order_id";
    echo "</td>"; ### cell ends

    echo "<td>"; ### cell begins
    echo "$customer_id ";
    echo "</td>"; ### cell ends

    echo "<td>"; ### cell begins
    echo "$product_id";
    echo "</td>"; ### cell ends

    echo "<td>"; ### cell begins
    echo "$employee_id";
    echo "</td>"; ### cell ends

    echo "<td>"; ### cell begins
    echo "$order_date";
    echo "</td>"; ### cell ends

    echo "<td>"; ### cell begins
    echo "$shipper_id";
    echo "</td>"; ### cell ends

    echo "</tr>"; ### row ends

}
?>

    </tbody>
</table>