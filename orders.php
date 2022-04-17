<?php
include_once("includes.php");
?>

<html>

<body>
    <h1> Orders Page </h1>

    <!-- ### begin the PHP code block ### -->
    <?php
##### catch the variables #####
### if the form is submitted
if (isset($_POST['submit_product'])) {      ### if submitted/posted

    $product_id = $_POST['product_id'];     ### take the posted value 

    $sql = "SELECT * FROM products WHERE product_id = $product_id "; ### get the data   
    $result = $conn->query($sql)->fetch();  

    if (isset($result)) {   ### if the result is not null, unpack data
        $product_id = $result['product_id'];
        $vin = $result['vin'];
        $brand = $result['brand'];
        $model = $result['model'];
        $price = $result['price'];
        $production_year = $result['production_year'];
        $image = $result['image'];
    }
}
    ?>
    <!-- ### close the PHP code ### -->

    <h2>You are ordering the following product: </h2>

    <form action="confirm.php" method='POST'>

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
                    <img src='data:image/jpg;base64,<?php echo base64_encode( $image ); ?>' style='height:24'>
                </td>
            </tr>
            <tr>
                <td> <?php echo $price; ?></td>
            </tr>

            <div> Please enter your Customer ID </div>
            <input type="text" name="customer_id">
        </table>


        <input name='product_id' value=<?php echo $product_id; ?> hidden>


        <button type='submit' name='submit_confirm'>
            Submit Order
        </button>

    </form>

</body>

</html>