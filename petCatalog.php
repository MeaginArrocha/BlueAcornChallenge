<!-- welcome page -->

<html><body>
    <h1><center><font size="32">Welcome!</font></center></center></h1>
    <p><center><font size:"3">Please select an option from the drop down menu!</font></center></p>
        
    <!-- Create drop down form -->
    <p><center>
    <form method="post">
        <select name = "formMerch">
            <option value = "">Select...</option>
            <option value = "Pets">Pets</option>
            <option value = "Items">Items</option>
        </select>
        </br>
        </br>
        <input type ="submit" name='formSubmit'>
        </br>
        </br>
    </form>
    </br>
    </br>
    </center></p>
     
<!-- Error checking and navigation -->            
<?php
    if(isset($_POST['formSubmit'])){ //if submit button is clicked
        $merch = $_POST['formMerch']; //store which option was selected
        $error = "";
          
         if(empty($merch)){
             $error = "Oops! You forgot to select an option!";
          }
          if($error != ""){
             echo("<p><center><b> $error </b></center></p>");
          }
          
          elseif($merch == "Pets"){
             header("Location:Pets.php");
          }
          else{ 
             header("Location:Items.php");    
          }
     }
?>
</body>
</html>