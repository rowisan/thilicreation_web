<?php
   include("admin/config.php");
   header("HTTP/1.0 404 Not Found");
   ?>
<html>
   
   <head>
      <title>Erro - Thili Creation</title>
      
    <!-- Bootstrap  -->
    <link href="<?php echo $path; ?>/css/bootstrap.min.css" rel="stylesheet">
	<!-- jQuery --><script src="js/jquery.js"></script>
	<style>
body{
    background-color: #111;
}
.error {
  margin: 0 auto;
  text-align: center;
}

.error-code {
  bottom: 60%;
  color: #fac81a;
  font-size: 96px;
  line-height: 100px;
}

.error-desc {
  font-size: 12px;
  color: #999;
}

.m-b-10 {
  margin-bottom: 10px!important;
}

.m-b-20 {
  margin-bottom: 20px!important;
}

.m-t-20 {
  margin-top: 20px!important;
}

h3{
	color : #999;
}
  #toggle {
    width: 100px;
    height: 100px;
    background: #ccc;
  }
	</style>

   </head>
   
   <body>
      <div class="error">
        <div class="error-code m-b-10 m-t-20"><img src="<?php echo $path; ?>/img/logos.png" /><br>404 <i class="fa fa-warning"></i></div>
        <h3 class="font-bold" id="a">We couldn't find the page..</h3>

        <div class="error-desc">
            Sorry, but the page you are looking for was either not found or does not exist. <br/>
            Try refreshing the page or click the button below to go back to the Homepage.
            <div>
                <a class=" login-detail-panel-button btn" href="<?php echo $path; ?>">
                        <i class="fa fa-arrow-left"></i>
                        Go back to Homepage                        
                    </a>
            </div>
        </div>
    </div>
   </body>
   	<script>
	$("div").click(function() {
  // do fading 3 times
  for(i=0;i<1;i++) {
    $('#a').fadeTo('slow', 0.3).fadeTo('slow', 1.0);
  }
});
	</script>
</html>