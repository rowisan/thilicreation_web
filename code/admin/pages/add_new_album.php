<form class="form-horizontal" id="form">
    <fieldset>

        <!-- Form Name -->
        <legend>Create New Album</legend>

        <!-- Select Album Type -->
        <div class="form-group">
            <label class="col-md-2 control-label" for="albumType">Album Type</label>
            <div class="col-md-4">
                <select id="albumType" name="albumType" class="form-control">
                    <option value="1">Wedding</option>
                    <option value="2">Private Session</option>
                    <option value="3">Other</option>
                    <option value="4">Video</option>
                </select>
            </div>
        </div>

        <!-- Text Album ID-->
        <div class="form-group">
            <label class="col-md-2 control-label" for="albumId">Album ID</label>  
            <div class="col-md-4">
                <input id="albumId" name="albumId" placeholder="" class="form-control input-md" required="" type="text" disabled="" value="5">

            </div>
        </div>

        <!-- Text Album Name-->
        <div class="form-group">
            <label class="col-md-2 control-label" for="albumName">Album Name</label>  
            <div class="col-md-4">
                <input id="albumName" name="albumName" placeholder="Album Name" class="form-control input-md" type="text">

            </div>
        </div>

        <!-- Text Album Path-->
        <div class="form-group">
            <label class="col-md-2 control-label" for="albumPath">Album Path</label>  
            <div class="col-md-4">
                <input id="albumPath" name="albumPath" placeholder="" class="form-control input-md" required="" type="text" disabled="" value="1">

            </div>
        </div>

        <!-- Text Video URL-->
        <div class="form-group" id="vIdSection" hidden="">
            <label class="col-md-2 control-label" for="vId">Video ID</label>  
            <div class="col-md-4">
                <input id="vId" name="vId" placeholder="Video ID" class="form-control input-md" type="text" hidden="">

            </div>
        </div>

        <!-- Select Album Status -->
        <div class="form-group">
            <label class="col-md-2 control-label" for="status">Album Status</label>
            <div class="col-md-4">
                <select id="status" name="status" class="form-control">
                    <option value="A">Active</option>
                    <option value="I">Inactive</option>
                    <option value="D" disabled="">Delete</option>
                </select>
            </div>
        </div>

        <!-- Button (Double) -->
        <div class="form-group">
            <label class="col-md-2 control-label" for="btnSave"></label>
            <div class="col-md-8">
                <button id="btnSave" name="btnSave" class="btn btn-primary" data-toggle="modal" data-target="#myModal" type="button">Save</button>
                <button id="btnReset" name="btnReset" class="btn btn-warning" type="reset">Reset</button>
            </div>
        </div>
        <div id="right"></div>

        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Confirmation Dialog</h4>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure, do you want to save?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" onClick="doSave()" id="yes">Yes</button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>

    </fieldset>
</form>


<script>
    $(document).ready(getId())
    $('#albumType').change(function () {
        if ($(this).val() === '4') {
            $('#vIdSection').attr('hidden', false);
            $('#vId').attr('value', "");
        } else {
            $('#vIdSection').attr('hidden', true);
            $('#vId').attr('value', "");
        }
    });

    //Get Album ID
    $('#albumType').change(function () {
        if ($(this).val() === '4') {
            $('#vIdSection').attr('hidden', false);
            $('#vId').attr('value', "");
        } else {
            $('#vIdSection').attr('hidden', true);
            $('#vId').attr('value', "");
        }
    });

    $('#albumType').change(function () {
        getId();
    });

    function getId() {
        var albumType = $('#albumType').val();
        var albumTypeName = '';
        switch (albumType) {
            case '1':
                albumTypeName = 'wedding';
                break;
            case '2':
                albumTypeName = 'private_session';
                break;
            case '3':
                albumTypeName = 'other';
                break;
            case '4':
                albumTypeName = 'video';
                break;
        }
        $.ajax({
            type: 'GET',
            url: 'pages/common.php?albumType=' + albumType + '& method=getId', //this should be url to your PHP file
            dataType: 'html',
            /*data: {func: 'show'},*/
            beforeSend: function () {
//                $('#right').html('checking');
            },
            complete: function () {
//                $('#right').html('Compleat');
            },
            success: function (albumId) {
                $('#albumId').val(albumId);
                var path = "gal/gal_files/vlb_images1/" + albumTypeName + "/" + albumId + "/";
                $('#albumPath').val(path);
            },
            error: function () {
                $('#right').html('Error');
            }
        });
    }

    function doSave() {
        $('form').on('submit', function (e) {
            e.preventDefault();
            var albumType = $('#albumType').val();
            var albumId = $('#albumId').val();
            var albumName = $('#albumName').val();
            var albumPath = $('#albumPath').val();
            var vId = $('#vId').val();
            var status = $('#status').val();
            if ((albumId !== '' && albumName !== '' && albumPath !== '') && ((albumType == '4' && vId != '') || albumType != '4')) {
                $.ajax({
                    type: 'GET',
                    url: 'pages/func.php?albumType=' + albumType + '& albumId=' + albumId + '& albumName=' + albumName + '& albumPath=' + albumPath + '& vId=' + vId + '& status=' + status + '', //this should be url to your PHP file
                    dataType: 'html',
                    /*data: {func: 'show'},*/
                    beforeSend: function () {
                        $('#right').html('checking');
                    },
                    complete: function () {
                        $('#right').html('Compleat');
                    },
                    success: function (html) {
                        $('#page-content').load(html);
                    },
                    error: function () {
                        $('#right').html('Error');
                    }
                });
            } else {
                $('#myModal').modal('toggle');
                $('#right').html('<div class="alert alert-danger"><strong>Error</strong> - One or more required field empty</div>');
            }
        });
    }
</script>