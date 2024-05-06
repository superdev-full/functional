<html>
<body>  
<?php
//code could be better but it's just an error log.
$errorPaths = ['admin','askquestion','assets','contact','controllers','investors','logout', 'messages','models','paypal','privacy','yourquestions','settings','terms','tutor','views','zFutureFeatures0x'];

// Clear error logs  if requested
if(array_key_exists('deleteErrorLogs', $_POST)) {
    deleteErrorLogs();
}

// Display current error logs 
foreach ($errorPaths as $folder) {
    $filepath = strval($folder . '/error_log');
    try {
        echo nl2br("<b>{$folder}</b>\n");
        if (file_exists($filepath)) {   
            echo nl2br(htmlentities(file_get_contents( $filepath ))); // get the contents, and echo it out.
        }
    }
    catch(Exception $ignored){
    }    
}


 function deleteErrorLogs() {
    global $errorPaths;
     
     foreach ($errorPaths as $value) {
        $filepath = strval($value . '/error_log');
         if (file_exists($filepath)) {
             try {
                 $file_pointer = $value . "/error_log";
                 // Use unlink() function to delete a file
                 if (!unlink($file_pointer)) {
                     echo ("$file_pointer cannot be deleted due to an error<br>");
                 }
                 else
                 {
                     echo ("$file_pointer has been deleted<br>");
                 }
             }
             catch(Exception $ignored){
             }
         }
     }
 } 

?>

  
<form method="post">
  <input type="submit" name="deleteErrorLogs"
                class="button" value="Delete Error Logs" />
</form>
</body>
</html>



