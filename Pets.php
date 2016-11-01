<!-- Pets Page -->

<html><body>
    <h1><center><font size="32">Pets</font></center></h1>
    <p><center><font size:"3">Select an option from the drop down menu and click submit!</font></center></p>

    <!-- Forms for sorting -->
    <center>
    <form name = "formsort">
        <input type ="radio" name = "sort" value="ASC" checked> Ascending </br>
        <input type ="radio" name = "sort" value="DESC" > Descending </br>
    </form>

    <!-- selection for order to print by sorting section -->
    Order By
    <form method="post">
        <select name = "formPets">
            <option value = "">Select...</option>
            <option value = "pet_id">ID</option>
            <option value = "pet_name">Name</option>
            <option value = "pet_type">Type</option>
            <option value = "pet_breed">Breed</option>
            <option value = "pet_description">Description</option>
            <option value = "pet_color">Color</option>
            <option value = "pet_age">Age</option>
            <option value = "pet_lifespan">Lifespan</option>
            <option value = "pet_price">Price</option>
            <option value = "gender">Gender</option>
        </select>

        </br>
        </br>

        <!-- Optional filter section for specific results -->
        <p>Optional: Select and option and enter a keyword to filter your results!</p>
        Where  
        <form method="post">
            <select name = "formFilter">
                <option value = "">Select...</option>
                <option value = "pet_id">ID</option>
                <option value = "pet_name">Name</option>
                <option value = "pet_type">Type</option>
                <option value = "pet_breed">Breed</option>
                <option value = "pet_description">Description</option>
                <option value = "pet_color">Color</option>
                <option value = "pet_age">Age</option>
                <option value = "pet_lifespan">Lifespan</option>
                <option value = "pet_price">Price</option>
                <option value = "gender">Gender</option>
                <option value = "ifDiscount">Discount?</option>
            </select>

            <!-- user can type in keyword to search for specific criteria -->
            Equals  <input type="text" name="keyword">
            </br>
            </br>
            <input type ="submit" name='formSubmit'>
            </br>
        </form>
        </br>
            
        <!-- Home button - back to welcome page -->
        <form action="petCatalog.php"> 
            <input type="button" name='home' value="Home" onClick="document.location.href='petCatalog.php'" />    
        </form>
        </center>
        </br>
    </form>


    <?php
        //Connect to the database
        $host = "127.0.0.1";
        $user = "meaginarrocha";                     //cloud9 username
        $password = "";                              //no password by default
        $dbname = "pet_shop";                        //database name
        $port = 3306;                                //The port # is always 3306
        
        $connection = mysqli_connect($host, $user, $password, $dbname, $port)or die(mysql_error());
        
        //set whether pet has discount and discounted price
        $all = "SELECT * FROM pet_catalog";
        $res = mysqli_query($connection, $all);
        while($row = mysqli_fetch_assoc($res)){
            $update = "UPDATE pet_catalog
            SET ifDiscount = '1', 
            discountPrice = pet_price - (pet_price * .10)
            WHERE pet_age >= pet_lifespan / 2";
            $r = mysqli_query($connection, $update);
        }
    
    
        $input= "";
        $where = "";
        $keyword = "";
    
        //to display database information based on user input
        function display($connection, $input, $sort, $where, $keyword){
            if($where =="" && $keyword == ""){
                $query = "SELECT * FROM pet_catalog ORDER BY $input $sort";
                $result = mysqli_query($connection, $query);
            }
            elseif($where == "" && $keyword !="" || $where != "" && $keyword == ""){
                echo("<strong>Error: Unknown filter! Make sure to complete both of the criterias!</strong></br></br>");
                $query = "SELECT * FROM pet_catalog ORDER BY $input $sort";
                $result = mysqli_query($connection, $query);
            }
            else{
                $query = "SELECT * FROM pet_catalog 
                WHERE $where='$keyword'
                ORDER BY $input $sort";
                $result = mysqli_query($connection, $query);
            }
    
            ?>
            
            <!-- Table headers -->
            <table width="100%" cellspacing="2" border="0" ><font size="5">
                <tr>ID     </tr>
                <tr>Name     </tr>
                <tr>Type     </tr>
                <tr>Breed     </tr>
                <tr>Description     </tr>
                <tr>Color     </tr>
                <tr>Age     </tr>
                <tr>Lifespan     </tr>
                <tr>Price     </tr>
                <tr>Gender     </tr>
                <tr>Discount?     </tr>
                <tr>Discount Price     </tr>
            </font></table>
            
            <?php
            
            //print each column for each row
            while ($row = mysqli_fetch_assoc($result)) {
                ?>           
                <table cellspacing="2" border="1" ><font size="5">
                    <td><b><?php echo $row['pet_id']; ?></b></td>
                    <td><?php echo $row['pet_name']; ?></td>
                    <td><?php echo $row['pet_type']; ?></td>
                    <td><?php echo $row['pet_breed']; ?></td>
                    <td><?php echo $row['pet_description']; ?></td>
                    <td><?php echo $row['pet_color']; ?></td>
                    <td><?php echo $row['pet_age']; ?></td>
                    <td><?php echo $row['pet_lifespan']; ?></td>
                    <td>$<?php echo $row['pet_price']; ?></td>
                    <td><?php echo $row['gender']; ?></td>
                    <td><?php echo $row['ifDiscount']; ?></td>
                    <td>$<?php echo $row['discountPrice']; ?></td>
                </font></tr></table>
                <?php
                echo("</br>");
            
            }
        }
    
        // error checking and receiving user input to pas to display function call
        if(isset($_POST['formSubmit'])){
            $input = $_POST['formPets'];
            if($input == ""){
                echo("<center><strong>Oops! You forgot to make a selection under Order By!</strong></center>");
            }
            else{
                $sort = $_POST['formsort'];
                $where = $_POST['formFilter'];
                $keyword = $_POST['keyword'];
                display($connection, $input, $sort, $where, $keyword);
            }
            
        }
        //mysql_close($connection);      
    ?>
    

</body></html>

