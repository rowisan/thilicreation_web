<style>
    /*@import "http://fonts.googleapis.com/css?family=Roboto:300,400,500,700";*/

    .panel { position: relative; overflow: hidden; display: block; border-radius: 0 !important;  }
    .panel-default { border-color: #ebedef !important; }
    .panel .panel-body { position: relative; padding: 0 !important; overflow: hidden; height: auto; }
    .panel .panel-body a { overflow: hidden; }
    .panel .panel-body a img { display: block; margin: 0; width: 100%; height: auto; 
                               transition: all 0.5s; 
                               -moz-transition: all 0.5s; 
                               -webkit-transition: all 0.5s; 
                               -o-transition: all 0.5s; 
    }
    .panel .panel-body a.zoom:hover img { transform: scale(1.3); -ms-transform: scale(1.3); -webkit-transform: scale(1.3); -o-transform: scale(1.3); -moz-transform: scale(1.3); }
    .panel .panel-body a.zoom span.overlay { position: absolute; top: 0; left: 0; visibility: hidden; height: 100%; width: 100%; background-color: #000; opacity: 0; 
                                             transition: opacity .25s ease-out;
                                             -moz-transition: opacity .25s ease-out;
                                             -webkit-transition: opacity .25s ease-out;
                                             -o-transition: opacity .25s ease-out;
    }     
    .panel .panel-body a.zoom:hover span.overlay { display: block; visibility: visible; opacity: 0.55; -moz-opacity: 0.55; -webkit-opacity: 0.55; filter: alpha(opacity=65); -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=65)"; }  
    .panel .panel-body a.zoom:hover span.overlay i { position: absolute; top: 45%; left: 0%; width: 100%; font-size: 2.25em; color: #fff !important; text-align: center;
                                                     opacity: 1;
                                                     -moz-opacity: 1;
                                                     -webkit-opacity: 1;
                                                     filter: alpha(opacity=1);    
                                                     -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=1)";
    }
    .panel .panel-footer { padding: 8px !important; background-color: #f9f9f9 !important; border-bottom-right-radius: 0 !important; border-bottom-left-radius: 0 !important; }	
    .panel .panel-footer h4 { display: inline; font: 400 normal 1.125em "Roboto",Arial,Verdana,sans-serif; color: #34495e; margin: 0 !important; padding: 0 !important; }
    .panel .panel-footer i.glyphicon { display: inline; font-size: 1.125em; cursor: pointer; }
    .panel .panel-footer i.glyphicon-edit { color: #1abc9c; }
    .panel .panel-footer i.glyphicon-trash { color: #e74c3c; padding-left: 5px; }
    .panel .panel-footer div { width: 15px; display: inline; font: 300 normal 1.125em "Roboto",Arial,Verdana,sans-serif; color: #34495e; text-align: center; background-color: transparent !important; border: none !important; }	

    .modal-title { font: 400 normal 1.625em "Roboto",Arial,Verdana,sans-serif; }
    .modal-footer { font: 400 normal 1.125em "Roboto",Arial,Verdana,sans-serif; } 
    .path {
        margin-top: 10px;
        margin-bottom: 30px;
        color : #333;
        font-size: 14px;
    }
    /*!
     * Lightbox for Bootstrap 3 by @ashleydw
     * https://github.com/ashleydw/lightbox
     *
     * License: https://github.com/ashleydw/lightbox/blob/master/LICENSE
     */.ekko-lightbox-container{position:relative}.ekko-lightbox-nav-overlay{position:absolute;top:0;left:0;z-index:100;width:100%;height:100%}.ekko-lightbox-nav-overlay a{z-index:100;display:block;width:49%;height:100%;padding-top:45%;font-size:30px;color:#fff;text-shadow:2px 2px 4px #000;opacity:0;filter:dropshadow(color=#000000,offx=2,offy=2);-webkit-transition:opacity .5s;-moz-transition:opacity .5s;-o-transition:opacity .5s;transition:opacity .5s}.ekko-lightbox-nav-overlay a:empty{width:49%}.ekko-lightbox a:hover{text-decoration:none;opacity:1}.ekko-lightbox .glyphicon-chevron-left{left:0;float:left;padding-left:15px;text-align:left}.ekko-lightbox .glyphicon-chevron-right{right:0;float:right;padding-right:15px;text-align:right}.ekko-lightbox .modal-footer{text-align:left}
</style>
<?php
$path = $_GET['path'];
$albumId = $_GET['albumId'];
$albumType = $_GET['albumType'];
?>
<div class="container col-md-12">
    <section class="row">
        <p class="path">Album > <?php echo $albumType; ?> > <?php echo $albumId; ?></p>
        <div id="msg"></div>
        <?php
        $dir = "../../" . $path;
        $a = scandir($dir);
        natsort($a);
        foreach ($a as $value) {
            if (pathinfo($value)['extension'] == 'jpg') {
                $value = pathinfo($value)['filename'];
                ?>
                <article class="col-xs-12 col-sm-6 col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <a href="#" title="Thili Creation's Photo Gallery" class="zoom" data-title="Thili Creation's Photo Gallery" data-footer="All movments are special" data-type="image" data-toggle="lightbox">
                                <img src="<?php echo '../' . $path . '/' . $value . '.jpg'; ?> " alt="Thili Creation's Photo Gallery" />
                            </a>
                        </div>
                        <div class="panel-footer">
                            <h4><a href="#" title="Nature Portfolio"><?php echo $value; ?></a></h4>
                            <span class="pull-right s_<?php echo $value; ?>">
                                <i id="like_<?php echo $value; ?>"  data_id="<?php echo $value; ?>" data-path="../<?php echo $path; ?>" class="edit glyphicon glyphicon glyphicon-edit <?php echo $value; ?>"></i> <div id="like-bs3_<?php echo $value; ?>"></div>
                                <i id="dislike_<?php echo $value; ?>"  data-id="<?php echo $value; ?>" data-path="../<?php echo $path; ?>" class="delete glyphicon glyphicon glyphicon-trash <?php echo $value; ?>"></i> <div id="dislike-bs3_<?php echo $value; ?>"></div>
                            </span>
                        </div>
                    </div>
                </article>
                <?php
            }
        }
        ?>
        <script>
            $('.delete').click(function () {
                var path = $(this).data('path');
                var imageId = $(this).data('id');
                $.ajax(
                        {
                            type: "GET",
                            url: 'pages/common.php?path=' + path + '&imageId=' + imageId + '.jpg' + '&method=doDeleteImage',
                            cache: false,
                            success: function (msg) {
                                $('.' + imageId).hide();
                                $('.s_' + imageId).html('<i style="color:#d80f0f; font-size:12px;" class="glyphicons glyphicons-check">deleted</i>');
//                                $('#page-content').load(msg);
                                var trHTML = '<div class="alert alert-success msg"><strong>Success</strong> - ' + msg + '</div>';
                                $('#msg').html(trHTML).fadeIn();
                                $('#msg').delay(2000).fadeOut();
                            },
                            beforeSend: function () {

                            },
                            error: function (msg) {
                                var trHTML = '<div class="alert alert-danger msg"><strong>Success</strong> - ' + msg + '</div>';
                                $('#msg').html(trHTML).fadeIn();
                                $('#msg').delay(2000).fadeOut();
                            }
                        });
            });
        </script>
    </section>
</div>