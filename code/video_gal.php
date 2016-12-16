<?php
//error_reporting(0);
clearstatcache();

//function isActive($albumId, $albumType) {
include('admin/config.php');
$albumType = $_GET['cat'];
switch ($_GET['cat']) {
    case 'wedding':
        $albumType = '1';
        break;
    case 'private_session':
        $albumType = '2';
        break;
    case 'other':
        $albumType = '3';
        break;
    case 'video':
        $albumType = '4';
        break;
    default:
        $albumType = '4';
        break;
}
$query = "select video_id from album where album.`type` = '" . $albumType . "' and status = 'A'";
$result = mysqli_query($db, $query);
$num_rows = mysqli_num_rows($result);
//$rows[] = $row;
if ($num_rows > 0) {
    $rows = array();
    while ($r = mysqli_fetch_array($result)) {
        $rows[] = $r;
    }
}
//}
?>

<!-- CSS -->
<link rel="stylesheet" href="css/simple-overlay.css">
<link href="css/stylish-portfolio.css" rel="stylesheet" />

<link href="css/bootstrap.min.css" rel="stylesheet" />
<!-- JS -->
<script src="js/jquery.js"></script>
<script src="js/simple-overlay.js"></script>

<!-- Gallery -->
<section id="portfolio2" class="portfolio" style="background-color:#ededed">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 text-center">
                <center>
                    <?php
                    echo "  <h2> Gallery of " . $_GET['cat'] . "</h2>
                            <p>Click on the album to see the story</p>
                            <hr class='small'>
                            <div class='row'>";
                    $count = 1;
                    $j = '';

                    if (empty($rows)) {
                        echo "<p>Upload soon...</p>";
                    } else {
                        foreach ($rows as $file) {
                            $vId = $file[0];
                            $j = $vId;
                            ?><div>
                                <a href="https://www.youtube.com/watch?v=<?php echo $vId; ?>" class="col-md-4 btn-youtube" 
                                   data-youtube="<iframe width='560' height='315' src='https://www.youtube.com/embed/<?php echo $vId; ?>' frameborder='0' allowfullscreen></iframe>">
                                    <img class="img-portfolio img-responsive" src="http://img.youtube.com/vi/<?php echo $vId; ?>/0.jpg" alt="11" style="z-index : -10">
                                </a>
                                <!-- /.btn btn-youtube -->
                            </div>';
                            <?php
                            $i = 1;
                            $count++;
                        }
                    }
                    if (($count - 1) < 3 && ($count - 1) > 0) {
                        echo "<div class='col-md-4'>
                                <div class='portfolio-item' >
                                    <a href='#gal'>
                                        <img class='img-portfolio img-responsive' src='gal/gal_files/vlb_images1/more.jpg' />
                                    </a>
                                </div>
                            </div>";
                    }
                    ?>
                </center>
            </div>
        </div>
        <!-- /.row --> 
    </div>
    <!-- /.container --> 
</section>

<script>

    // Youtube Video overlay
    $(".btn-youtube").simpleOverlay({
        "insertBy": "embed",
        "attribute": "data-youtube"
    });

</script>
<!-- ***********************************************************************************************************  --> 
