<?php

$servername="localhost";
$username="root";
$password="root";
$database="school_db";

$con = new mysqli($servername, $username, $password, $database);

/**
 * get the id request parameter from a get request (e.g. pfp.php?id=?) where id
 * is a student id in the students records.
 */
$id = $_GET["id"];

$stmt = $con->prepare("select profile_picture from students where id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->store_result();

$stmt->bind_result($image);
/**
 * if the user has a profile picture, echo the profile picture bytes. else, echo the image link
 *
 * note: echoing the profile picture here doesn't actually do anything. Keeping it to avoid
 * breaking things
 */
if ($stmt->fetch()) {
    header("Content-Type: image/jpg");
    if($image == ""){
        echo "https://static.vecteezy.com/system/resources/previews/004/511/281/original/default-avatar-photo-placeholder-profile-picture-vector.jpg";
        return;
    }
    echo $image;
} else {
    echo "https://static.vecteezy.com/system/resources/previews/004/511/281/original/default-avatar-photo-placeholder-profile-picture-vector.jpg";
}

$stmt->close();
$con->close();
?>
