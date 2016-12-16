<?php

$method = $_GET['method'];

switch ($method) {
    case 'getId' :
        getId();
        break;
    case 'getAlbums' :
        getAlbums();
        break;
    case 'doDelete' :
        doDelete();
        break;
    case 'getEditScrean' :
        getEditScrean();
        break;
    case 'doDeleteImage' :
        doDeleteImage();
        break;
}

function getId() {

    include('../config.php');
    $albumType = $_GET['albumType'];

    $sql = "select id from album where album.`type` = '" . $albumType . "' order by album.id desc  limit 1";
    $result = mysqli_query($db, $sql);

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            echo $row["id"] + 1;
        }
    } else {
        echo "1";
    }

    mysqli_close($db);
}

function getAlbums() {

    include('../config.php');
    $albumType = $_GET['albumType'];
    $status = $_GET['status'];
    if ($status == 'X') {
        $query = "select * from album where album.`type` = '" . $albumType . "'";
    } else {
        $query = "select * from album where album.`type` = '" . $albumType . "' and status = '" . $status . "'";
    }
    $result = mysqli_query($db, $query);

    $rows = array();
    while ($r = mysqli_fetch_array($result)) {
        $rows['albums'][] = $r;
    }
    echo json_encode($rows);
}

function doDelete() {
    include('../config.php');
    $albumId = $_GET['albumId'];
    $albumTypeId = $_GET['albumType'];

    switch ($_GET['albumType']) {
        case '1':
            $albumType = 'Wedding';
            break;
        case '2':
            $albumType = 'Private Session';
            break;
        case '3':
            $albumType = 'Other';
            break;
        case '4':
            $albumType = 'Video';
            break;
        default:
            $albumType = 'Video';
            break;
    }

    $query = "UPDATE album SET status = 'D' WHERE id = '" . $albumId . "' and type = '" . $albumTypeId . "'";

    if (mysqli_query($db, $query)) {
        $old_dir = "../../gal/gal_files/vlb_images1/" . $albumType . "/" . $albumId;
        $new_dir = "../../gal/gal_files/del/" . $albumType . "/" . $albumId;
        if (!file_exists($new_dir)) {
            mkdir($new_dir . "/" . $albumId, 0777, true);
        }

        // Get array of all source files
        $files = scandir($old_dir);
        // Identify directories
        $source = $old_dir . "/";
        $destination = $new_dir . "/";
        // Cycle through all source files
        foreach ($files as $file) {
            if (in_array($file, array(".", "..")))
                continue;
            // If we copied this successfully, mark it for deletion
            if (copy($source . $file, $destination . $file)) {
                $delete[] = $source . $file;
            }
        }
        // Delete all successfully-copied files
        foreach ($delete as $file) {
            unlink($file);
        }
        rmdir($old_dir);

        echo "Albun deleted successfully";
    } else {
        echo "Error updating record: " . mysqli_error($db);
    }

    mysqli_close($db);
}

function getEditScrean() {
    $path = $_GET['path'];
    $albumId = $_GET['albumId'];
    $albumType = $_GET['albumType'];
    echo 'pages/edit_album.php?path=' . $path . '&albumId=' . $albumId . '&albumType=' . $albumType;
}

function doDeleteImage() {
    try {
        $path = $_GET['path'];
        $imageId = $_GET['imageId'];
        unlink('../' . $path . '/' . $imageId);
        echo 'Image ' . $imageId . ' deleted.';
    } catch (Exception $e) {
        throw new customException($e);
    }
}

?>