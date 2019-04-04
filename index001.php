<?php
//start session 
/* ************************************************************************
Version 1

    - create PHP form with elements
    - write items to DOM
    - use JQuery to get strikethru to work 
    
*/

    session_start();

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
  <!--  <link rel="stylesheet" type="text/css" href="exercise1.css"> -->

</head>
<body>
<div class="container">

<!-- create and display the form -->

<form role = "form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "POST"> 

    Enter a number : <input type = "text" name = "inputItem" placeholder = "Enter your tasks here " />

    <input type = "submit" class="btn btn-success" name = "addTask" value = " Add "> 

<?php
  if ($_POST){
    if ($_POST['inputItem'] != ""){
        $_SESSION['listItem'] = $_POST['inputItem']; 
    }
 }

// assign session variabels ( if set ) to local php variables

 $listItem_session = (isset($_SESSION['listItem'])) ? $_SESSION['listItem'] : null;
    
    echo "<li>". $listItem_session. "</li>";
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
        
        $('li').click(function(){
        $(this).css("text-decoration", "line-through");
               console.log( "clicked!" );
        });
    });
    
    </script>
    
    
    
</body>
</html>