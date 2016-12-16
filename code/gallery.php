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
        $albumType = 'Video';
        break;
}
$query = "select id from album where album.`type` = '" . $albumType . "' and status = 'A'";
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

<!-- ***********************************************************************************************************  --> 
<!-- Bootstrap Core CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="css/stylish-portfolio.css" rel="stylesheet">

<link rel="shortcut icon" type="image/png" href="favicon.png"/>

<!-- Custom Fonts -->
<link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<!--<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">-->

<!-- Gallery -->
<!--<link rel="stylesheet" href="gal/gal_files/vlb_files1/vlightbox1.css" type="text/css" />
<link rel="stylesheet" href="gal/gal_files/vlb_files1/visuallightbox.css" type="text/css" media="screen" />-->

<script src="gal/gal_files/vlb_engine/jquery.min.js" type="text/javascript"></script>
<!--<script src="gal/gal_files/vlb_engine/visuallightbox.js" type="text/javascript"></script>-->

<!--<script src="gal/gal_files/vlb_engine/vlbdata1.js" type="text/javascript"></script>-->
<script type="text/javascript">

    $.ajaxSetup({
        // Disable caching of AJAX responses
        cache: false
    });
    function call(a) {
        $("#vlightbox" + a).hover(function () {
            $('#' + a).css('visibility', 'visible');
        }, function () {
            $('#' + a).css('visibility', 'hidden');
        })
    }

</script>
<!-- Gallery -->
<section id="portfolio2" class="portfolio" style="background-color:#ededed">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 text-center">
                <center>
                    <?php
                    $path = "gal/gal_files/vlb_images1/";
                    $fii = new FilesystemIterator($path . $_GET['cat'], FilesystemIterator::SKIP_DOTS);
                    $no_of_album = iterator_count($fii);
                    $fi = iterator_to_array($fii, true);
                    natsort($fi);

                    echo "<h2> Gallery of " . $_GET['cat'] . "</h2>
		<p>Click on the album to see the story</p>
      <hr class='small'>
      <div class='row'>";
                    $count = 1;
                    $j = '';

                    if ($num_rows == 0) {
//                    if ($no_of_album == 0) {// || ($no_of_album == 1 && is_dir($path . $_GET['cat'] . "/" . $iterator->current()))) {
                        echo "<p>Upload soon...</p>";
                    } else {
//                    foreach ($fi as $file) {
                        foreach ($rows as $file) {
//                        $j = $file->getFilename();
                            $j = $file[0];
                            $albumDir = $path . $_GET['cat'] . "/" . $j;
                            //for ($j = 1; $j <= $no_of_album; $j++) {
                            if (is_dir($albumDir)) {
                                $fi1 = new FilesystemIterator($albumDir, FilesystemIterator::SKIP_DOTS);
                                $no_of_img = iterator_count($fi1);
                                $dir = $albumDir . "/";
                                $imageList = scandir($dir);
                                $i = 1;
                                echo "<div class='col-md-4' id='vlightbox" . $j . $j . "' onmouseover='call(" . $j . ")'>
         <div class='portfolio-item'>		 
         
		 <a class='vlightbox1' href='./gal.php?cat=" . $_GET['cat'] . "&alb=" . $j . "' target='a'>	
		 
	<img class='img-portfolio img-responsive' src='" . $dir.$imageList[2] . "' alt='" . $j . $i . "' style='z-index : -10'/>
	
	  </a>
	  		
	 <b> <!--<p style='background-color : #f4ca1e; color : #fff !important; z-index : 10; margin-top : -40px; padding : 5px;  text-shadow : #666'></p>--></b>
	  		
	  <p style='visibility : hidden' id = '" . $j . "'>Click on the album to see the story</p>
	  </div>
        </div>";
                            }
//                        $j++;
                            $count++;
                        }
                    }
                    if (($count - 1) < 3 && ($count - 1) > 0) {
                        echo "<div class='col-md-4'>
         <div class='portfolio-item' >";
                        echo "<a href='#gal'><img class='img-portfolio img-responsive' src='gal/gal_files/vlb_images1/more.jpg' /></a>";
                        echo "</div>
        </div>";
                    }
                    ?>
                </center>
            </div>
            <!-- /.row (nested) --> 
            <!--<a href="#" class="btn btn-dark">View More Items</a> </div> --> 
            <!-- /.col-lg-10 --> 
        </div>
        <!-- /.row --> 
    </div>
    <!-- /.container --> 
</section>

<!-- ***********************************************************************************************************  --> 
