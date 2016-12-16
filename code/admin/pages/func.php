<?php

include('../config.php');
$albumId = $_GET['albumId'];
$albumType = $_GET['albumType'];
$albumName = $_GET['albumName'];
$albumPath = $_GET['albumPath'];
$vId = $_GET['vId'];
$status = $_GET['status'];
//echo 'pages/upload_images.php?albumId=' . $_GET['albumId'];
$sql = "INSERT INTO album (id, type, name, path, video_id, status) VALUES ('" . $albumId . "', '" . $albumType . "', '" . $albumName . "', '" . $albumPath . "','" . $vId . "', '" . $status . "') ON DUPLICATE KEY UPDATE
id='" . $albumId . "', type='" . $albumType . "', name='" . $albumName . "', path='" . $albumPath . "', video_id='" . $vId . "', status='" . $status . "'";



if (mysqli_query($db, $sql)) {
//    echo 'Hiii';
    echo 'pages/upload_images.php?albumId=' . $albumId . '&albumType=' . $albumType . '&albumName=' . $albumName . '&albumPath=' . $albumPath . '&vId=' . $vId . '&status=' . $status . '&error=';
} else {
    echo 'pages/upload_images.php?albumId=&albumType=&albumName=&albumPath=&vId=&status=&error=' . mysqli_error($db);
//    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
//echo 'upload_images.php?albumId=' . $_GET['albumId1'];
?>