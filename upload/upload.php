<?php
/**
 * Created by PhpStorm.
 * User: prasi
 * Date: 3/2/16
 * Time: 8:53 PM
 */

include_once '../db.php';
include_once '../Response.php';
include_once '../constants.php';

if(DBManager::$debug)
{
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

$apiResponse = new Response();

$description = $_REQUEST[Constant::$desc];

$target_dir = "../images/";
$target_file = $target_dir . basename($_FILES[Constant::$upload_param]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES[Constant::$upload_param]["tmp_name"]);
    if($check !== false) {
        error_log("File is an image - " . $check["mime"] . ".");
        $uploadOk = 1;
    } else {
        error_log("File is not an image.");
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file))
{
    $apiResponse->message = "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["upload"]["size"] > 1000000) {
    $apiResponse->message = "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
    $apiResponse->message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0)
{
    $apiResponse->message = "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
}
else
{
    if (move_uploaded_file($_FILES[Constant::$upload_param]["tmp_name"], $target_file))
    {
        $apiResponse->status = true;
        $apiResponse->message = "The file ". basename( $_FILES[Constant::$upload_param]["name"]). " has been uploaded.";
        $pictureName = basename( $_FILES[Constant::$upload_param]["name"]);

        $sql = "INSERT INTO `uploads` (`picture`, `description`) VALUES ('$pictureName', '$description')";

        DBManager::dosql($sql);

    }
    else
    {
        $apiResponse->message = "Sorry, there was an error uploading your file.";
        error_log("image is uploaded,  not in DB");
    }

    echo json_encode($apiResponse);
}
?>
