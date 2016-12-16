<!DOCTYPE html>
<html lang="en" style="background: url(./img/2.jpg) no-repeat bottom center fixed;">
    <head>
        <meta charset="UTF-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>Thili Creation - Image Gallery</title>
        <meta name="description" content="Gamma Gallery - A Responsive Image Gallery Experiment"/>
        <meta name="keywords" content="html5, responsive, image gallery, masonry, picture, images, sizes, fluid, history api, visibility api"/>
        <meta name="author" content="Codrops"/>
        <link rel="shortcut icon" href="../favicon.ico"> 
        <link rel="stylesheet" type="text/css" href="css/style.css"/>


        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <link href="css/modifi.css" rel="stylesheet" type="text/css">


        <script src="js/modernizr.custom.70736.js"></script>
        <noscript><link rel="stylesheet" type="text/css" href="css/noJS.css"/></noscript>
        <!--[if lte IE 7]><style>.main{display:none;} .support-note .note-ie{display:block;}</style><![endif]-->
    </head>
    <body style="background-color: #83827f">
        <div class="container">



            <div class="main">
                <header class="clearfix">

                    <div class="thi2" align="right" style="padding-right:90px; display:block; padding-top:10px; z-index:100">
                        <div class='navbar-static-top con'>
                            <div class='container-fluid' > 
                                <!-- Navigation  PC -->
                                <nav id="sidebar-wrapper-pc">
                                    <ul style="list-style-type: none; top-margin:12px">
                                      <!--<a href="#" class="btn btn-light btn-lg pull-right toggle" ><i class="fa fa-times"></i></a>
                                        <!--<li class="sidebar-brand"> <a id="menu-close" href="#top">THILI CREATION</a> </li>
                                              <li> <a href="#top">Home</a></li>
                                              <li> <a href="#about">About</a></li>
                                              <li> <a href="#services">Services</a></li>
                                              <li> <a href="#portfolio">Portfolio</a></li>-->
                                        <li id='con'> <Span style="color:#fac81a; top:5px; margin-top: 20px !important; font-size:24px; margin-bottom: 10px;">Photo Gallery</Span></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="thi1 row container"></div>


                </header>

                <div class="gamma-container gamma-loading" id="gamma-container">

                    <ul class="gamma-gallery">
                        <?php
                        $dir = "./gal/gal_files/vlb_images1/" . $_GET['cat'] . "/" . $_GET['alb'] . "/";

                        // Sort in ascending order - this is default
                        $a = scandir($dir);
                        natsort($a);
                        //echo '<br><br>';
                        foreach ($a as $value) {
                            if (pathinfo($value)['extension'] == 'jpg') {

                                echo '<li>
							<div data-alt="' . $value . '" data-description="<h3>CLICK HEAR</h3>" data-max-width="1800" data-max-height="1350">
								<div data-src="' . $dir . $value . '" data-min-width="1300"></div>
								<div data-src="' . $dir . $value . '" data-min-width="1000"></div>
								<div data-src="' . $dir . $value . '" data-min-width="700"></div>
								<div data-src="' . $dir . $value . '" data-min-width="300"></div>
								<div data-src="' . $dir . $value . '" data-min-width="200"></div>
								<div data-src="' . $dir . $value . '" data-min-width="140"></div>
								<div data-src="' . $dir . $value . '"></div>
								<noscript>
									<img src="' . $dir . $value . '" alt="' . $value . '"/>
								</noscript>
							</div>
						</li>';
                            }
                        }
                        ?>
                    </ul>

                    <div class="gamma-overlay"></div>

                    <!--<div id="loadmore" class="loadmore">Example for loading more items...</div>-->

                </div>

            </div><!--/main-->
        </div>

        <!-- Footer -->
        <footer style="background-color:#000" id="foot">
            <div class="container" >
                <div class="row">
                    <div class="col-lg-10 col-lg-offset-1 text-center" style="color:#ccc !important; background-image:url(img/footer-map-world.png); background-repeat:no-repeat">
                        <h4 style="color:#fac81a !important"><strong>Thili Creation & Studio</strong> </h4>
                        <p><strong>Thilina Gunarathna Photography</strong><br><br>Poojapitiya,<br>Kandy,<br>Sri Lanka.</p>
                        <ul class="list-unstyled">
                            <li><i class="fa fa-phone fa-fw"></i> (+94) 77 590 45 16</li>
                            <li><i class="fa fa-envelope-o fa-fw" style="color:#fac81a !important" ></i> <a href="mailto:info@thilicreation.com">info@thilicreation.com</a> <br><a href="mailto:thilinagunarathna@gmail.com">thilinagunarathna@gmail.com</a></li>
                        </ul>
                        <br>
                        <ul class="list-inline">

                            <span class='st_facebook_large' displayText='Facebook'></span>
                            <span class='st_twitter_large' displayText='Tweet'></span>
                            <span class='st_linkedin_large' displayText='LinkedIn'></span>
                            <span class='st_pinterest_large' displayText='Pinterest'></span>

                        </ul>
                        <hr class="small">
                        <p class="text-muted">Copyright &copy; <a href="http://www.santuscs.com" target="_blank">Santus CS</a> 2014</p>
                    </div>
                </div>
            </div>
        </footer>

        <!-- **************************************************************************************************** -->



        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script src="js/jquery.masonry.min.js"></script>
        <script src="js/jquery.history.js"></script>
        <script src="js/js-url.min.js"></script>
        <script src="js/jquerypp.custom.js"></script>
        <script src="js/gamma.js"></script>
        <script type="text/javascript">
            var open_target = function (form) {
                var windowName = jQuery(form).attr('target');
                window.open("", windowName);
                return true;
            };
            $(function () {

                var GammaSettings = {
                    // order is important!
                    viewport: [{
                            width: 1200,
                            columns: 5
                        }, {
                            width: 900,
                            columns: 4
                        }, {
                            width: 500,
                            columns: 3
                        }, {
                            width: 320,
                            columns: 2
                        }, {
                            width: 0,
                            columns: 2
                        }]
                };

                Gamma.init(GammaSettings, fncallback);


                // Example how to add more items (just a dummy):

                /*var page = 0,
                 items = ['<li><div data-alt="img03" data-description="<h3>CLICK HEAR</h3>" data-max-width="1800" data-max-height="1350"><div data-src="images/xxxlarge/3.jpg" data-min-width="1300"></div><div data-src="images/xxlarge/3.jpg" data-min-width="1000"></div><div data-src="images/xlarge/3.jpg" data-min-width="700"></div><div data-src="images/large/3.jpg" data-min-width="300"></div><div data-src="images/medium/3.jpg" data-min-width="200"></div><div data-src="images/small/3.jpg" data-min-width="140"></div><div data-src="images/xsmall/3.jpg"></div><noscript><img src="images/xsmall/3.jpg" alt="img03"/></noscript></div></li><li><div data-alt="img03" data-description="<h3>CLICK HEAR</h3>" data-max-width="1800" data-max-height="1350"><div data-src="images/xxxlarge/3.jpg" data-min-width="1300"></div><div data-src="images/xxlarge/3.jpg" data-min-width="1000"></div><div data-src="images/xlarge/3.jpg" data-min-width="700"></div><div data-src="images/large/3.jpg" data-min-width="300"></div><div data-src="images/medium/3.jpg" data-min-width="200"></div><div data-src="images/small/3.jpg" data-min-width="140"></div><div data-src="images/xsmall/3.jpg"></div><noscript><img src="images/xsmall/3.jpg" alt="img03"/></noscript></div></li><li><div data-alt="img03" data-description="<h3>CLICK HEAR</h3>" data-max-width="1800" data-max-height="1350"><div data-src="images/xxxlarge/3.jpg" data-min-width="1300"></div><div data-src="images/xxlarge/3.jpg" data-min-width="1000"></div><div data-src="images/xlarge/3.jpg" data-min-width="700"></div><div data-src="images/large/3.jpg" data-min-width="300"></div><div data-src="images/medium/3.jpg" data-min-width="200"></div><div data-src="images/small/3.jpg" data-min-width="140"></div><div data-src="images/xsmall/3.jpg"></div><noscript><img src="images/xsmall/3.jpg" alt="img03"/></noscript></div></li><li><div data-alt="img03" data-description="<h3>CLICK HEAR</h3>" data-max-width="1800" data-max-height="1350"><div data-src="images/xxxlarge/3.jpg" data-min-width="1300"></div><div data-src="images/xxlarge/3.jpg" data-min-width="1000"></div><div data-src="images/xlarge/3.jpg" data-min-width="700"></div><div data-src="images/large/3.jpg" data-min-width="300"></div><div data-src="images/medium/3.jpg" data-min-width="200"></div><div data-src="images/small/3.jpg" data-min-width="140"></div><div data-src="images/xsmall/3.jpg"></div><noscript><img src="images/xsmall/3.jpg" alt="img03"/></noscript></div></li><li><div data-alt="img03" data-description="<h3>CLICK HEAR</h3>" data-max-width="1800" data-max-height="1350"><div data-src="images/xxxlarge/3.jpg" data-min-width="1300"></div><div data-src="images/xxlarge/3.jpg" data-min-width="1000"></div><div data-src="images/xlarge/3.jpg" data-min-width="700"></div><div data-src="images/large/3.jpg" data-min-width="300"></div><div data-src="images/medium/3.jpg" data-min-width="200"></div><div data-src="images/small/3.jpg" data-min-width="140"></div><div data-src="images/xsmall/3.jpg"></div><noscript><img src="images/xsmall/3.jpg" alt="img03"/></noscript></div></li>']*/

                function fncallback() {

                    $('#loadmore').show().on('click', function () {

                        ++page;
                        var newitems = items[page - 1]
                        if (page <= 1) {

                            Gamma.add($(newitems));

                        }
                        if (page === 1) {

                            $(this).remove();

                        }

                    });

                }

            });

        </script>	
    </body>
</html>
