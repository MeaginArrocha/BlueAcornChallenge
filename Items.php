<!-- Items page -->

<html><body>
    <h1><center><font size="32">Items</font></center></h1>
    <p><center><font size:"3">Select an option from the drop down menu and click submit!</font></center></p>

    <!--Forms for sorting -->
    <center>
    <form name = "formsort">
        <input type ="radio" name = "sort" value="ASC" checked> Ascending </br>
        <input type ="radio" name = "sort" value="DESC" > Descending </br>
    </form>

    <!-- selection for order to print by sorting section -->
    Order By
    <form method="post">
        <select name = "formItems">
            <option value = "">Select...</option>
            <option value = "item_id">ID</option>
            <option value = "item_color">Color</option>
            <option value = "item_description">Description</option>
            <option value = "item_type">Item Type</option>
            <option value = "pet_type">Pet Type</option>
            <option value = "item_price">Price</option>
            <option value = "item_name">Name</option>
        </select>
    
        </br>
        </br>
    
        <!-- Optional filter section for specific results -->
        <p>Optional: Make a selection and enter a keyword to filter your results!</p>
        Where
        <form method="post">
            <select name = "formFilter">
                <option value = "">Select...</option>
                <option value = "item_id">ID</option>
                <option value = "item_color">Color</option>
                <option value = "item_description">Description</option>
                <option value = "item_type">Item Type</option>
                <option value = "pet_type">Pet Type</option>
                <option value = "item_price">Price</option>
                <option value = "item_name">Name</option>
            </select>
        
            <!-- user can type in keyword to search for specific criteria -->
            Equals <input type="text" name="keyword">
            </br>
            </br>
            <input type ="submit" name='formSubmit'>
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
        
        $input= "";
        $where = "";
        $keyword = "";
        
        //to display database information based on user input
        function display($connection, $input, $sort, $where, $keyword){
            if($where =="" && $keyword == ""){
                $query = "SELECT * FROM item_catalog ORDER BY $input $sort";
                $result = mysqli_query($connection, $query);
            }
            elseif($where == "" && $keyword !="" || $where != "" && $keyword == ""){
                echo("<strong>Error: Unknown filter! Make sure to complete both of the criterias!</strong></br></br>");
                $query = "SELECT * FROM item_catalog ORDER BY $input $sort";
                $result = mysqli_query($connection, $query);
            }
            else{
                $query = "SELECT * FROM item_catalog 
                WHERE $where='$keyword'
                ORDER BY $input $sort";
                $result = mysqli_query($connection, $query);
            }
            
            ?>
            
            <!-- Table headers -->
            <table width="100%" cellspacing="2" border="0" ><font size="5">
                <tr>ID     </tr>
                <tr>Color     </tr>
                <tr>Description     </tr>
                <tr>Item Type     </tr>
                <tr>Pet Type     </tr>
                <tr>Price     </tr>
                <tr>Name     </tr>
            </font></table>
            
            <?php
            
            //print each column for each row
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <table cellspacing="2" border="1" ><font size="5">
                    <td><b><?php echo $row['item_id']; ?></b></td>
                    <td><?php echo $row['item_color']; ?></td>
                    <td><?php echo $row['item_description']; ?></td>
                    <td><?php echo $row['item_type']; ?></td>
                    <td><?php echo $row['pet_type']; ?></td>
                    <td><?php echo $row['item_price']; ?></td>
                    <td><?php echo $row['item_name']; ?></td>
                </font></tr></table>
                <?php
                echo("</br>");
            }
        }
            
        // error checking and receiving user input to pas to display function call
        if(isset($_POST['formSubmit'])){
            $input = $_POST['formItems'];
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
        
        //mysqli.close($connection);       
    ?>

</body></html>

