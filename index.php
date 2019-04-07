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
    - added in weather widget from : https://weatherwidget.io/ - seems helpful to know weather to plan to do items

Version 5
    
    - Completed and removed debugging 
    - Completed Styling

*/

// start PHP session 

session_start();

//set session variables for date
date_default_timezone_set("Africa/Johannesburg");
$showDate = date("Y-m-d"); //h:i:sa
$_SESSION['storeDate'] = $showDate;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP ToDoList</title>
    <link rel="icon" href="http://localhost:8080/todoApp/img/favicon.ico">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css\exercise1.css">
    <link href="https://fonts.googleapis.com/css?family=Righteous" rel="stylesheet">

</head>
<body>
<div class="container">
    
<!-- create and display the form -->

    <div class="widget">
        <a class="weatherwidget-io" href="https://forecast7.com/en/n33d9218d42/cape-town/" data-label_1="CAPE TOWN" data-label_2="WEATHER" ></a>
        <script>
        !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
        </script>
    </div>
<!-- end of  weather widget -->  

<form role = "form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "POST"> 
    

    <h1> ToDoList </h1>
    <h2 class='wordDiv'>‘The secret of getting ahead is getting started’ - Mark Twain </h2>
<div id='control'>
    <br>
    Enter a Task : <input type = "text" name = "inputItem" placeholder = "Enter your tasks here " required="required" autofocus /><br class="hide desktop-show">
    Due Date : <input type = "date"  id="dueDatePicker" name = "inputDate" value="<?php echo date('Y-m-d'); ?>"/><br class="hide desktop-show">
    
    <input type = "submit" class="btn btn-success" id="addTaskBtn" name = "addTask" value = " Add Task">
    
    <a href="clearData.php" class="btn btn-danger" id="clearData" onclick="return confirm('You are about to clear the list - are you sure? - click OK to confirm');">Clear ALL Tasks</a>    <br><br>
    
    <p>   
        <span id='task'>  Task </span> | <span id='time'>Date Created</span> | <span id='due'> Due Date </span> | <span id ='deadline'> Time Remaining</span>
    </p>

</div>
<?php
    
//set session variables 
    
 if (isset($_POST['inputItem'])){
     
            
      if (!isset($_SESSION['listItem'])) { 
          $_SESSION['listItem'] = array();
      }
     
        $_SESSION['listItem'][] = $_POST['inputItem']; 
        $_SESSION['timeStamp'][] = date("Y-m-d h:i:sa");
        $_SESSION['dueDate'][] = $_POST['inputDate']; 
        
     // PRG method to prevent data from the previous post populating the list on refresh / reload
     
       header('location:'.$_SERVER['PHP_SELF']);
       return;
 
 }
    // calls the display function one the session array is populated
 if (isset($_SESSION['listItem'])) { 
     display(); }
    
  // function displays the array 
    function display(){
        echo "<ul id='taskListItems'>";
        echo "<br>";
      //  var_dump($_SESSION['listItem']);
     
        for ( $x = 0; $x<(count($_SESSION['listItem'])); $x++){
           
            echo "<li id='listItems'>";
                echo $_SESSION['listItem'][$x]. " | " ;
            echo "<span id='time'>";
                echo " ". $_SESSION['timeStamp'] [$x] ." | ";
            echo "</span>";
                echo "<span id='due'>";
            echo " ". $_SESSION['dueDate'] [$x] . " | ";
                echo "</span>";
            echo "<span id='deadline'>";
            
            // calls task due function to determine time to complete task
                taskDue($x);
             echo "</span>";
         
             echo "</li>";
             echo "<br>";
     }
        
        echo "</ul>";        
    }
    
      //  task due function determines time left to complete task
    
    function taskDue($position){
    

        $timeStamp = date_create(date("Y-m-d h:i:sa"));     
        $dueDate= date_create($_SESSION['dueDate'] [$position]);
        $duration = date_diff($dueDate, $timeStamp);
        
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
       }
?>

    </form>
</div>
    
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script>
 
    $(document).ready(function() {
    console.log( "ready!" );
        

        var lineState = 0;
        $('li').each(function(i){
            $(this).click(function(){
                          sessionKey = i;
                          
          if(lineState == 0){
                $(this).css("text-decoration", "line-through");
                lineState = 1;
                sessionStorage.setItem(sessionKey,lineState);
                                
            } else {
                $(this).css("text-decoration", "none");
                lineState= 0;
                sessionStorage.setItem(sessionKey,lineState);
                   }
          });
                    
        });
        
        $('li').each(function(i){
          if( sessionStorage.getItem(i)==1){
            $(this).css("text-decoration", "line-through");
          }
        });
        
        // clear the Java Script session data when user clears the list , if not cleared new items are marked as done 
        
          $("#clearData").click(function () {
            console.log('clicked');
            sessionStorage.clear();
                    });
        
  // generates the random quotes on the screen to provide motivation inside the h2 tag
        
        var quotes = new Array('‘Anyone who has never made a mistake has never tried anything new‘ - Albert Einstein', 
                               '‘Glory lies in the attempt to reach one’s goal and not in reaching it‘ - Mahatma Ghandi', 
                              '‘It is no good getting furious if you get stuck. What I do is keep thinking about the problem but work on something else‘ - Stephen Hawking ',
                              '‘“Those who dare to fail miserably can achieve greatly.”’ - John F. Kennedy ');
        
                var i = 0;
    
                    setInterval( function(){
                    $( '.wordDiv' ).empty().append( quotes[ i ] );
                    if( i < quotes.length ) {
                        i++;
                    } else {
                        i = 0;
                    }
                }, 30000 );
        
    });         
</script>
   
</body>
</html>