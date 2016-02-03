<?php
/**
 * Created by PhpStorm.
 * User: prasi
 * Date: 3/2/16
 * Time: 9:04 PM
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


$sql = "SELECT * FROM `uploads` ORDER BY date DESC LIMIT 10";

$result = DBManager::dosql($sql);

if($result)
{
    $imagePojoArray = array();

    while($row = mysqli_fetch_array($result))
    {

        $imagePojo = new ImagePojo();

        $imagePojo->picture = $row['picture'];
        $imagePojo->desc = $row['description'];
        $imagePojo->date = $row['date'];

        $imagePojoArray[] = $imagePojo;
    }

    $apiResponse->status = true;
    $images = new Images();
    $images->images = $imagePojoArray;
    $apiResponse->data=$images;
}
else
{
    $apiResponse->message = "unable to fetch images";
}

echo json_encode($apiResponse);

?>