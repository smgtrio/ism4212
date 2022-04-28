<!-- Beginning of PHP block -->
<?php
include_once("includes.php");
?>

<html>

<body>
    <h1>Products Page</h1>
    <!-- end of THE HTML BLOCK -->

    <!-- ##### use FORM to SELECT * and print in table -->
    <form action="orders.php" method="POST">

        <table>
            <thead>
                <tr>
                    <td>Buy</td>
                    <td>ID</td>
                    <td>Pic</td>
                    <td>VIN</td>
                    <td>Brand</td>
                    <td>Model</td>
                    <td>Price</td>
                    <td>Year</td>
                    <td>Status</td>
                </tr>
            </thead>
            <tbody>


                <?php ### inside html, use PHP to retrieve and loop through data
$sql = "SELECT * FROM products "; ### the SQL query
$results = $conn->query($sql)->fetchAll(); ### run query and get results
foreach ($results as $item) { ### upacking the results line by line
    $vin = $item['vin']; ### save value from column into variable
    $brand = $item['brand'];
    $model = $item['model'];
    $price = $item['price'];
    $production_year = $item['production_year'];
    $product_id = $item['product_id'];
    $image = $item['image'];
    $sold = $item['sold'];
?>
                <!-- close PHP to use HTML for table ### -->

                <tr>
                    <!-- ### TR is a row. We have one row contains the info then foreach loop ### -->
                    <td>
                        <!-- ### print the value in HTML code using PHP code ### -->
                        <input type='radio' name='product_id' value=<?php echo $product_id; ?>>
                        <!-- ### we send only the id to next page. Other stuff are only for showing ### -->
                    </td>
                    <td> <?php echo $product_id; ?> </td>

                    <td> <img src='data:image/jpg;base64,<?php echo base64_encode( $image ); ?>' style='height:24'>
                    </td>

                    <td> <?php echo $vin; ?> </td>
                    <td> <?php echo $brand; ?> </td>
                    <td> <?php echo $model; ?> </td>
                    <td> <?php echo $price; ?> </td>
                    <td> <?php echo $production_year; ?> </td>
                    <td> <?php echo $sold; ?> </td>
                </tr>
            </tbody>

            <?php   ### use PHP to close (the }) the loop for data
}
?>

        </table>
        <br>
        <button type='submit' name='submit_product' value='submit_order'>
            Submit
        </button>

    </form>

</body>

</html>

<!-- End of PHP block -->