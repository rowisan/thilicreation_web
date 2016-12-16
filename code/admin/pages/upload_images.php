<?php
$albumId = $_GET['albumId'];
$albumType = $_GET['albumType'];
$albumName = $_GET['albumName'];
$albumPath = $_GET['albumPath'];
$videoUrl = $_GET['videoUrl'];
$status = $_GET['status'];
switch ($_GET['status']) {
    case 'A':
        $status = 'ACTIVE';
        break;
    case 'I':
        $status = 'INACTIVE';
        break;
    default:
        $status = 'DELETE';
        break;
}

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
?>
<form method="post" class="form-horizontal" id="form" name="form"  enctype="multipart/form-data" action="pages/upload.php" style="margin-bottom: 0px;">
    <!--<form class="form-horizontal" id="form"  method="post" enctype="multipart/form-data">-->
    <fieldset>

        <!-- Form Name -->
        <legend>Upload Images</legend>
        <?php
        if (empty($_GET['error']) && !isset($_GET['error'])) {
            echo '<div class="alert alert-danger"><strong>Error</strong> - One or more required field empty ' . $_GET['error'] . '</div>';
        } else {
            echo '<div class="alert alert-success">Please Upload the Album images</div>';
        };
        ?>
        <!-- Select Album Type -->
        <div class="form-group">
            <label class="col-md-2 control-label" for="albumType">Album Type</label>
            <div class="col-md-4">
                <input id="albumType" name="albumType" placeholder="" class="form-control input-md" required="" type="text" disabled="" value="<?php echo $albumType; ?>">
            </div>
        </div>

        <!-- Text Album ID-->
        <div class="form-group">
            <label class="col-md-2 control-label" for="albumId">Album ID</label>  
            <div class="col-md-4">
                <input id="albumId" name="albumId" placeholder="" class="form-control input-md" required="" type="text" disabled="" value="<?php echo $albumId; ?>">

            </div>
        </div>

        <!-- Text Album Name-->
        <div class="form-group">
            <label class="col-md-2 control-label" for="albumName">Album Name</label>  
            <div class="col-md-4">
                <input id="albumName" name="albumName" placeholder="Album Name" class="form-control input-md" required="" type="text" disabled="" value="<?php echo $albumName; ?>">

            </div>
        </div>

        <!-- Text Album Path-->
        <div class="form-group">
            <label class="col-md-2 control-label" for="albumPath">Album Path</label>  
            <div class="col-md-4">
                <input id="albumPath" name="albumPath" placeholder="" class="form-control input-md" required="" type="text" disabled="" value="<?php echo $albumPath; ?>">

            </div>
        </div>

        <!-- Select Album Status -->
        <div class="form-group">
            <label class="col-md-2 control-label" for="status">Album Status</label>
            <div class="col-md-4">
                <input id="status" name="status" placeholder="" class="form-control input-md" required="" type="text" disabled="" value="<?php echo $status; ?>">
            </div>
        </div>

        <!-- Image Browse Section -->
        <div class="form-group">
            <label class="col-md-2 control-label" for="status">Browse Images</label>
            <div class="col-md-4">

                <p>Max file size 700kb, Valid formats jpg, png, gif</p>
                <!-- Multiple file upload html form-->

<!--<input type="file" name="files[]" multiple="multiple" accept="image/*">-->
                <input type="hidden" name="albumId" value="<?php echo $albumId ?>"/>
                <input type="hidden" name="albumType" value="<?php echo $albumType ?>"/>
                <input type="file" name="images[]" id="upload-images" multiple >


            </div>
        </div>

        <!-- Button (Double) -->
        <div id="right"></div>
    </fieldset>
</form>
<div class="form-group">
    <label class="col-md-2 control-label" for="btnSave"></label>
    <div class="col-md-8" style="padding-left: 6px;">
        <button id="btnUpload" name="btnUpload" class="btn btn-primary">Upload</button>
        <button id="btnReset" name="btnReset" class="btn btn-warning" type="reset">Reset</button>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.alert').delay(300).fadeOut();
    });

    $(document).ready(function () {
//        url: 'pages/upload.php?albumType=' + albumType + '& albumId=' + albumId,
        $('#btnUpload').on('click', function () {
//            var albumType = $('#albumType').val();
//            var albumId = $('#albumId').val();
            $('form').ajaxForm({
                beforeSubmit: function (e) {
                    $('.progress').show();
                },
                success: function (e) {
                    $('.progress').hide();
                    $('#page-content').load(e);
                },
                error: function (e) {
                }
            }).submit();
        });
    });
</script>