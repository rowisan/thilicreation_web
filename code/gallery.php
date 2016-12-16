<?php
//error_reporting(0);
clearstatcache();
?>

<!-- ***********************************************************************************************************  --> 
<!-- Bootstrap Core CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="css/stylish-portfolio.css" rel="stylesheet">

<!-- Custom Fonts -->
<link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

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
                    if ($no_of_album == 0) {// || ($no_of_album == 1 && is_dir($path . $_GET['cat'] . "/" . $iterator->current()))) {
                        echo "<p>Upload soon...</p>";
                    }
                    $j = 1;
                    foreach ($fi as $file) {
                        //for ($j = 1; $j <= $no_of_album; $j++) {
                        if (is_dir($path . $_GET['cat'] . "/" . $j)) {
                            $fi1 = new FilesystemIterator($path . $_GET['cat'] . "/" . $j, FilesystemIterator::SKIP_DOTS);
                            $no_of_img = iterator_count($fi1);

                            $i = 1;
                            echo "<div class='col-md-4' id='vlightbox" . $j . $j . "' onmouseover='call(" . $j . ")'>
         <div class='portfolio-item'>		 
         
		 <a class='vlightbox1' href='./gal.php?cat=" . $_GET['cat'] . "&alb=" . $file->getFilename() . "' target='_blank'>	
		 
	<img class='img-portfolio img-responsive' src='gal/gal_files/vlb_images1/" . $_GET['cat'] . "/" . $j . "/1.jpg' alt='" . $j . $i . "' style='z-index : -10'/>
	
	  </a>
	  		
	 <b> <!--<p style='background-color : #f4ca1e; color : #fff !important; z-index : 10; margin-top : -40px; padding : 5px;  text-shadow : #666'></p>--></b>
	  		
	  <p style='visibility : hidden' id = '" . $j . "'>Click on the album to see the story</p>
	  </div>
        </div>";
                        }
                        $j++;
                    }
                    if (($j-1) < 3 && ($j-1) > 0) {
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
