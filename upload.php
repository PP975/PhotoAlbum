<?php
/* https://www.youtube.com/watch?v=JaRq73y5MJk&list=LL&index=6 */
session_start();
    if(!isset($_SESSION["username"])) {
        header("Location: login.php");
        exit();
    }
    $session_user= $_SESSION["username"];
if (isset($_FILES['file']['name'])) {
    $f = $_FILES['file'];
    $fName = $f['name'];
    $fileTempName = $_FILES['file']['tmp_name'];
    $fileError = $_FILES['file']['error'];
    $fileExt = explode('.', $fName);
    $fActualExtenstion = strtolower(end($fileExt));
    $allowed_files = array('jpg');
    if (in_array($fActualExtenstion, $allowed_files)) {
        if ($fileError == 0) {
            $fileNewName = uniqid('', true) . "." . $fActualExtenstion;
            $fileDestination = './images/'.$session_user.'/'. $fileNewName;
            move_uploaded_file($fileTempName,  $fileDestination);
            echo $fName . "__" . $fileDestination;
            exit;
        } else {
            echo "There was an error while uploading the image!!";
            exit;
        }
    } else {
        echo "You cannot upload this type of files!!";
        exit;
    }
}
?>