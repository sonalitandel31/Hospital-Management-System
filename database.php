<?php
    $conn = new mysqli("localhost","root","","project_hms");
    if(mysqli_error($conn))
        die ("Connection Error..!");
?>