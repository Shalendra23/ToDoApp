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
    
Version 4
    
    - adding in the due date and time till due functions
    - added in disable add task until text input 
    - cleared JS session Storage on clear
    
*/

session_start();
date_default_timezone_set("Africa/Johannesburg");
$showDate = date("Y-m-d"); //h:i:sa
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

    Enter a Task : <input type = "text" name = "inputItem" placeholder = "Enter your tasks here " autofocus />
    Select a due Date <input type = "date" name = "inputDate" value="<?php echo date('Y-m-d'); ?>"/>
    
    <input type = "submit" class="btn btn-success" name = "addTask" value = " Add " disabled> 
    
    <a href="Logout.php" class="btn btn-danger" id="clearData" onclick="return confirm('You are about to clear the list - are you sure? - click OK to confirm');">Clear ALL items</a>
    
    <br><br>

<?php
    
 if (isset($_POST['inputItem'])){
     
            
      if (!isset($_SESSION['listItem'])) { 
          $_SESSION['listItem'] = array();
      }
     
        $_SESSION['listItem'][] = $_POST['inputItem']; 
        $_SESSION['timeStamp'][] = date("Y-m-d h:i:s");
        $_SESSION['dueDate'][] = $_POST['inputDate']; 
        
     // PRG method to prevent data from the previous post populating the list on refresh / reload
     
       header('location:'.$_SERVER['PHP_SELF']);
       return;
 
 }
   display();
    
  // function displays the array 
    function display(){
        echo "<ul>";
        
      //  var_dump($_SESSION['listItem']);
     
        for ( $x = 0; $x<(count($_SESSION['listItem'])); $x++){
           
            echo "<li>";
                echo $_SESSION['listItem'][$x]. "                 " ;
             echo "<time>";
                echo " ". $_SESSION['timeStamp'] [$x];
             echo "</time>";
            echo "<due>";
                echo " ". $_SESSION['dueDate'] [$x];
             echo "</due>";
            taskDue($x);
            echo "</li>";
            echo "<br>";
     }
        
        echo "</ul>";        
    }
    
    function taskDue($position){
    

        $timeStamp = date_create($_SESSION['timeStamp'] [$position]);     
        $dueDate= date_create($_SESSION['dueDate'] [$position]);
        $duration = date_diff($timeStamp, $dueDate);
        
                echo " Task due in ";
                    if ($duration->format('%y') != 0 ){
                        echo " " .$duration->format('%y') . " years"; }
                    if ($duration->format('%m') != 0 ){
                        echo " ". $duration->format('%m'). " months"; }
                    if ($duration->format('%d') != 0 ){
                        echo " ". $duration->format('%d') . " days"; }
                    if ($duration->format('%h') != 0 ){
                        echo " ". $duration->format('%h') . " hours";}

                    echo " ". $duration->format('%i') . " min";
                    echo " ". $duration->format('%s') . " sec";
    }
    ?>

</form>
</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script>
 
    $(document).ready(function() {
        console.log( "ready!" );
        renderDisplay();
        
        
        // disables the add Task ( submit button ) until text is entered into the input feild 
        var changeHandler = function (e) {
            console.log ($.trim(this.value));
            if ($.trim(this.value)){
                $("input[type=submit]").removeAttr("disabled");
            } else {
                $("input[type=submit]").attr("disabled", "disabled");        
            }
        };
               // runs above function on the input text feilds 

                    $("input[type=text]").keyup(
                        changeHandler
                    )
                
    
   var lineState = 0;
     
        $('li').click(function(){
            
            if (this.lineState == undefined)
                {
                    this.lineState = 0;
                }
            
            var strikeNum = $(this).index();
            console.log( strikeNum );
            console.log('line state ' + this.lineState);

            
            if (this.lineState == 0){
                    $(this).css("text-decoration", "line-through");
                    console.log( "line" );
                    this.lineState = 1;
                  sessionStorage.setItem(strikeNum,'1');
            } else {
                    $(this).css("text-decoration", "none");
                    console.log( "none" );
                    this.lineState = 0;  
                    sessionStorage.setItem(strikeNum,'0');
            }
        });
    });
    
        
        function renderDisplay(){
                            
            for ( var x = 0; x<(sessionStorage.length); x++ ){
              if (sessionStorage.getItem(sessionStorage.key(x)) == 1){
                $('li').eq(x).css("text-decoration", "line-through");
                  
             //    console.log(sessionStorage.getItem(sessionStorage.valueOf(x)));
            }
        }
        }
        
        // clear the Java Script session data when user clears the list , if not cleared new items are marked as done 
        
          $("#clearData").click(function () {
              console.log('clicked');
                        sessionStorage.clear();
                    });
        
    </script>
    
        
</body>
</html>