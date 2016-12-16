<?php
include('session.php');
?>

<link href="../font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="../css/admin-menu.css" rel="stylesheet" type="text/css" />
<!-- Bootstrap Core CSS -->
<link href="../css/bootstrap.min.css" rel="stylesheet" />
<link rel="shortcut icon" type="image/png" href="../favicon.png"/>
<title>Admin Panel - Thili Creation</title>
<div id="wrapper">

    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <li class="sidebar-brand">
                <a href="#">
                    <img src="../img/logos.png" />
                </a>
            </li>
            <li>
                <a href="#" id="welcome">Dashboard</a>
            </li>
            <li>
                <a href="#" onClick="addNewAlbum()" id="addNew">New Gallery</a>
            </li>
            <li>
                <a href="#" id="galleryHistory">Gallery History</a>
            </li>            
        </ul>
    </div>
    <!-- /#sidebar-wrapper -->
    <!-- Top Bar-->
    <div class="top-bar">
        Welcome <?php echo $login_session; ?> | 
        <a href = "logout.php">Sign Out</a>
    </div>
    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12" id="page-content">

                </div>
            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="../js/jquery.js"></script>
<script src="../js/jquery.form.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../js/bootstrap.min.js"></script>

<!-- Menu Toggle Script -->
<script>
                    $(document).ready(function () {
                        $("#page-content").load('pages/welcome.php');
                    });
                    $("#menu-toggle").click(function (e) {
                        e.preventDefault();
                        $("#wrapper").toggleClass("toggled");
                    });
                    $("#addNew").click(function () {
                        $("#page-content").load('pages/add_new_album.php');
                    });
                    $("#welcome").click(function () {
                        $("#page-content").load('pages/welcome.php');
                    });
                    $("#galleryHistory").click(function () {
                        $("#page-content").load('pages/gallery_history.php');
                    });
</script>
