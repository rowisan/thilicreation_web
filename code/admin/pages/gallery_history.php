<fieldset>
    <style>
        .table-responsive{
            border-style: solid;
            border-width: 1px;
            padding: 15px;
            padding-top:5px;
            padding-bottom:5px;
            border-color: #ccc;
            border-radius: 5px;
        }
        .table{
            margin-bottom:0px;
        }
        p{
            margin-bottom:0;
        }
    </style>
    <!-- Form Name -->
    <legend>Images Gallery History</legend>
    <div id="msg"></div>
    <div class="form-horizontal" id="form" name="form">
        <div class="form-group">
            <label class="col-md-2 control-label" for="albumType" style="padding-top: 7px; margin-bottom: 0; text-align: left;">Album Type</label>
            <div class="col-md-4">
                <select id="albumType" name="albumType" class="form-control">
                    <option value="0" selected="true" disabled="disabled">Please select the album</option>
                    <option value="1">Wedding</option>
                    <option value="2">Private Session</option>
                    <option value="3">Other</option>
                    <option value="4">Video</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-2 control-label" for="status" style="padding-top: 7px; margin-bottom: 0; text-align: left;">Status</label>
            <div class="col-md-4">
                <select id="status" name="status" class="form-control">
                    <option value="A">Active</option>
                    <option value="I">Inactive</option>
                    <option value="D">Delete</option>
                    <option value="X">All</option>
                </select>
            </div>
        </div>
    </div>
    <br>
    <div class="table-responsive">
        <table id="mytable" class="table table-bordred table-striped">
            <thead>
            <th>Album ID</th>
            <th>Album Name</th>
            <th>Path</th>
            <th style="text-align:center;">Status</th>
            <th style="text-align:center;">Edit</th>
            <th style="text-align:center;">Delete</th>
            </thead>
            <tbody>
            </tbody>
        </table>

    </div>

</fieldset>
<!--
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align" id="Heading">Edit Your Detail</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input class="form-control " type="text" placeholder="Mohsin">
                </div>
                <div class="form-group">

                    <input class="form-control " type="text" placeholder="Irshad">
                </div>
                <div class="form-group">
                    <textarea rows="2" class="form-control" placeholder="CB 106/107 Street # 11 Wah Cantt Islamabad Pakistan"></textarea>


                </div>
            </div>
            <div class="modal-footer ">
                <button type="button" class="btn btn-warning btn-lg" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span> Update</button>
            </div>
        </div>
         /.modal-content  
    </div>
     /.modal-dialog  
</div>-->



<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align" id="Heading">Delete this entry</h4>
            </div>
            <div class="modal-body">

                <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete this Album (Album ID : <span id="albumId"></span>)?</div>
                <div class="modal-body">
                    <input type="text" name="albumIdHf" id="albumIdHf" value="" hidden="" /></div>
            </div>
            <div class="modal-footer ">
                <button type="button" class="btn btn-success" onClick="deleteGalery()">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
        </div>
        <!-- /.modal-content --> 
    </div>
    <!-- /.modal-dialog --> 
</div>
<script>

    function deleteGalery() {
        $('#delete').modal('toggle');
        var albumId = $('#albumIdHf').val();
        var albumType = $('#albumType').val();
        $.ajax(
                {
                    type: "GET",
                    url: 'pages/common.php?albumId=' + albumId + '&albumType=' + albumType + '&method=doDelete',
                    cache: false,
                    success: function (msg) {
                        var trHTML = '<div class="alert alert-success msg"><strong>Success</strong> - ' + msg + '</div>';
                        $('#msg').html(trHTML).fadeIn();
                        $('#msg').delay(2000).fadeOut();
                        loadAlbums();
                    },
                    beforeSend: function () {

                    },
                    error: function (msg) {
                        var trHTML = '<div class="alert alert-danger msg"><strong>Success</strong> - ' + msg + '</div>';
                        $('#msg').html(trHTML).fadeIn();
                        $('#msg').delay(2000).fadeOut();
                    }
                });
    }

    $(document).on("click", ".btn-primary", function () {
        var albumId = $(this).data('id');
        albumId = albumId.split('_')[0];
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
        var path = "gal/gal_files/vlb_images1/" + albumTypeName + "/" + albumId + "/";
        $.ajax(
                {
                    type: "GET",
                    url: 'pages/common.php?path=' + path + '&albumId=' + albumId + '&albumType=' + albumTypeName + '&method=getEditScrean',
                    cache: false,
                    success: function (msg) {
                        $('#page-content').load(msg);
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

    $(document).on("click", ".btn-danger", function () {
        var myAlbumId = $(this).data('id');
        $(".modal-body #albumId").html(myAlbumId);
        $(".modal-body #albumIdHf").val(myAlbumId);
    });

    $(document).ready(function () {
        var trHTML = '<tr><td colspan="6" style="text-align:center; padding-top:10px; font-size:12px;color:#999; padding-bottom:10px;">No data found !</td></tr>';
        $('tbody').html(trHTML);

        $("#mytable #checkall").click(function () {
            if ($("#mytable #checkall").is(':checked')) {
                $("#mytable input[type=checkbox]").each(function () {
                    $(this).prop("checked", true);
                });

            } else {
                $("#mytable input[type=checkbox]").each(function () {
                    $(this).prop("checked", false);
                });
            }
        });

        $("[data-toggle=tooltip]").tooltip();
    });

    $('#albumType').change(function () {
        loadAlbums();
    });
    $('#status').change(function () {
        loadAlbums();
    });

    function loadAlbums() {
        var albumType = $('#albumType').val();
        var status = $('#status').val();
        $('tbody').html('');
        $.ajax(
                {
                    type: "GET",
                    url: 'pages/common.php?albumType=' + albumType + '& method=getAlbums&status=' + status,
                    data: "{}",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    cache: false,
                    success: function (data) {
                        var trHTML = '';
                        $.each(data.albums, function (i, item) {
                            var status = item.status;
                            var style = '';
                            switch (status) {
                                case 'A':
                                    status = 'Active';
                                    break;
                                case 'I':
                                    status = 'Inactive';
                                    break;
                                case 'D':
                                    status = 'Delete';
                                    style = 'disabled=""';
                                    break;
                            }
                            trHTML += '<tr><td>' + item.id + '</td><td>' + item.name + '</td><td>' + item.path + '</td><td style="text-align:center;">' + status + '</td><td style="text-align:center; padding-top:10px;"><p data-placement="top" data-toggle="tooltip" title="Edit"><button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit" style="padding-top: 5px; padding-bottom: 5px;" ' + style + ' " data-id="' + item.id + '_e"><span class="glyphicon glyphicon-pencil"></span></button></p></td><td style="text-align:center; padding-top:10px;"><p data-placement="top" data-toggle="tooltip" title="Delete"><button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" data-id="' + item.id + '" style="padding-top: 5px; padding-bottom: 5px;" ' + style + '><span class="glyphicon glyphicon-trash"></span></button></p></td></tr>';
                        });

                        $('tbody').html(trHTML);
                    },
                    beforeSend: function () {
                        var trHTML = '<tr><td colspan="6" style="text-align:center; padding-top:10px; font-size:12px;color:#999; padding-bottom:10px;">No data found !</td></tr>';
                        $('tbody').html(trHTML);
                    },
                    error: function (msg) {
                        var trHTML = '<tr><td colspan="6" style="text-align:center; padding-top:10px; font-size:12px; color:#999; padding-bottom:10px;">Data feching error. !</td></tr>';
                        $('tbody').html(trHTML);
                    }
                });
    }
</script>