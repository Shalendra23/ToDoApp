<?php
//start session 
/* ************************************************************************
Version 1

    - create PHP form with elements
    - write items to DOM
    - use JQuery to get strikethru to work 
    
Version 2
    
    - added in the strike thru and none css options for the multiclicks
    - make session variable an array
    - display that array is POST is set or not 
    
Version 3
    
    - added in a clear list option 
    - Start addin in custom css
    - add in JavaScript session variables 
    

*/

session_start();

$showDate = date("Y-m-d h:i:sa");
$_SESSION['storeDate'] = $showDate;

//set session variables from POST 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP ToDo App</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="css\exercise1.css">

</head>
<body>
<div class="container">

<!-- create and display the form -->

<form role = "form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "POST"> 
    
    <h1> ToDo App</h1><br>

    Enter a Task : <input type = "text" name = "inputItem" placeholder = "Enter your tasks here " />

    <input type = "submit" class="btn btn-success" name = "addTask" value = " Add "> 
    
    <a href="Logout.php" class="btn btn-danger" onclick="return confirm('You are about to clear the list - are you sure? - click OK to confirm');">Clear ALL items</a>
    <br><br>

<?php
  if ($_POST){
    if (isset($_POST['inputItem'])){
        
      if (!isset($_SESSION['listItem'])) { 
          $_SESSION['listItem'] = array();
          
          $_SESSION['listItem'][] = $_POST['inputItem']; 
          $_SESSION['timeStamp'][] = date("Y-m-d h:i:sa");
          display();
        
}
    else{
        $_SESSION['listItem'][] = $_POST['inputItem']; 
        $_SESSION['timeStamp'][] = date("Y-m-d h:i:sa");
        display();
    
    }
          
    }
  }
      
  
    function display(){
        echo "<ul>";
        
        for ( $x = 0; $x<(count($_SESSION['listItem'])); $x++){
           
            echo "<li>";
                echo $_SESSION['listItem'][$x]. " " ;
             echo "<time>";
                echo " ". $_SESSION['timeStamp'] [$x];
             echo "</time>";
            echo "</li>";
          
            echo "<br>";
     }
        
        echo "</ul>";        
        

    
    }



// assign session variabels ( if set ) to local php variables


 //$listItem_session = (isset($_SESSION['listItem'])) ? $_SESSION['listItem'] : null;
    
    //var_dump($_SESSION['listItem']);
    ?>
<?php

?>
</form>
</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script>
    // A $( document ).ready() block.
    $(document).ready(function() {
        console.log( "ready!" );
        
        var lineState = 0;
        
        $('li').click(function(){
            if (lineState == 0){
                    $(this).css("text-decoration", "line-through");
                console.log( "line" );
                    lineState = 1;
                  sessionStorage.setItem(this,'1');
            } else {
                    $(this).css("text-decoration", "none");
                console.log( "none" );
                lineState = 0;  
                sessionStorage.setItem(this,'0');
            }
        });
    });
    
        sessionStorage.setItem('testkey','testvalue');
        console.log(sessionStorage.getItem('testkey'));
        
        
    </script>
    
        
</body>
</html>