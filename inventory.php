
<html>
<body>
    <h1>This is the inventory page</h1>
    <!-- THE HTML BLOCK -->

<form>
    <!-- Beginning of PHP block -->
    <?php


    // phpinfo(); #### PHP Info page
    ### DB connection line
    // include_once("dbconn.php");
    include_once("includes.php");

    ##### SELECT * and print in table
    echo "<table>"; // table opening


    $sql = "SELECT * FROM car ";    ### the SQL query
    $results = $conn->query($sql)->fetchAll();  ### run query and get results
    foreach ($results as $item) {   ### upacking the results
        $VIN = $item['vin'];
        $brand = $item['brand'];
        $model = $item['model'];
        $price = $item['price'];
        $production_year = $item['production_year'];

        $id = $item['id'];


        echo "<tr>";    ### row begins

        echo "<td>";    ### cell begins
        echo "<input class='item' type='radio' name='select' value=$id ";
        echo "</td>";   ### cell ends
        echo "<td>";    ### cell begins
        echo "$VIN ";
        echo "</td>";   ### cell ends
        echo "<td>";    ### cell begins
        echo "$brand";
        echo "</td>";   ### cell ends
        echo "<td>";    ### cell begins
        echo "$model ";
        echo "</td>";   ### cell ends
        echo "<td>";    ### cell begins
        echo "$price ";
        echo "</td>";   ### cell ends
        echo "<td>";    ### cell begins
        echo "$production_year ";
        echo "</td>";   ### cell ends

        echo "</tr>";   ### row ends

    }

    echo "</table>"; // table closing

    ?>

    <button type='submit' name='submit'>

Submit
</button>
    </form>

    </body>
</html>

<!-- End of PHP block -->