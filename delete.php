<?php

$servername="localhost";
$username="root";
$password="root";
$database="school_db";

$con = new mysqli($servername, $username, $password, $database);

/**
 * queries to remove a record from the db with the id $id
 *
 * @param mysqli $con
 * @param int $id
 */
function removeStudentFromDB($con, $id){
    $command = "delete from students where id=$id";
    return $con->query($command);
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if($_POST["dialog-submit-button"] != null){
        removeStudentFromDB($con, $_POST["dialog-submit-button"]);
    }
}

// Redirect to dashboard.php
header("Location: dashboard.php");

?>
