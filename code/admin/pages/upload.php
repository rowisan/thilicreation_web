<?php
//if($_POST['form_submit'] == 1)
//{
$images_arr = array();
$error = "";
$count = 0;
$target_dir = "../../gal/gal_files/vlb_images1/" . strtolower($_POST['albumType']) . "/" . $_POST['albumId'] . "/";
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}
$count = iterator_count(new FilesystemIterator($target_dir, FilesystemIterator::SKIP_DOTS));
$valqq = 0;
foreach ($_FILES['images']['name'] as $key => $val) {
    $count++;
    $image_name = $_FILES['images']['name'][$key];
    $tmp_name = $_FILES['images']['tmp_name'][$key];
    $size = $_FILES['images']['size'][$key];
    $type = $_FILES['images']['type'][$key];
    $error = $_FILES['images']['error'][$key];
    //checking image type
    $allowed = array('gif', 'png', 'jpg', 'jpeg', 'JPEG');
    $filename = $_FILES['images']['name'][$key];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    //move uploaded file to uploads folder
    $target_file = $target_dir . $count . ".jpg";

    if (in_array($ext, $allowed)) {
        if (move_uploaded_file($_FILES['images']['tmp_name'][$key], $target_file)) {
            $images_arr[] = $target_file;
        }
    }
    $error = "Image type not valid";
}

// images view after upload
echo 'pages/welcome.php';

//}
?>