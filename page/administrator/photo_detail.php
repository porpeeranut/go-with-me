<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Photo</h1>
    </div>
</div>

<div class="row">
	<div class="col-md-1">
    </div>
    <div class="col-md-4">
        <img id="img" class="img-responsive" src="http://placehold.it/300x200" alt="">
    </div>

    <div class="col-md-4">
        </br>
        <Label>Caption:</Label> <span id="CAPTION">caption</span></br>
        <Label>OWNER_ID:</Label> <span id="OWNER_ID">OWNER_ID</span></br>
        <Label>DATE:</Label> <span id="DATE_TIME">DATE_TIME</span></br></br>
        <button id="btn_edit" onclick="" class="btn btn-default">Edit</button>
        <button id="btn_delete" class="btn btn-default">Delete</button></br></br>
        <button id="btn_comment" class="btn btn-default">Comment</button>
        <button id="btn_like" class="btn btn-default">Like</button>
        <button id="btn_tag" class="btn btn-default">Tag</button>
    </div>

</div>

<div id="data_row" class="row">
</div>
<hr>

<script>
    var start = 0;
    var n = 8;
	$(document).ready(function(){
        ID = getUrlParameter('ID');
        CAPTION = getUrlParameter('CAPTION');
        OWNER_ID = getUrlParameter('OWNER_ID');
        DATE_TIME = getUrlParameter('DATE_TIME');
        $("#CAPTION").html(CAPTION);
        $("#OWNER_ID").html(OWNER_ID);
        $("#DATE_TIME").html(DATE_TIME);
        $("#img").attr("src", "images/photos/"+ID+".jpg");
        $("#btn_edit").attr("onclick", "window.document.location='main.php?option=edit_photo&ID="+ID+"&CAPTION="+CAPTION+"';");
        $("#btn_delete").click(function(){
            if (confirm("Confirm")) {
                $.get("module/administrator/delete.php?option=photo&id="+ID, function(result) {
                    var obj = jQuery.parseJSON(result);
                    if (obj.status == "success")
                        window.document.location='main.php?option=photo';
                    else
                        alert(obj.data);
                });
            }
        });
        $("#btn_comment").click(function(){
            $.get("module/administrator/get_child.php?option=comment_photo&id="+ID, function(result) {
                var obj = jQuery.parseJSON(result);
                row = '<div class="col-lg-12"><h3 id="header">Comment</h3>';
                showComment(obj);
            });
        });
        $("#btn_like").click(function(){
            $.get("module/administrator/get_child.php?option=LIKE_PHOTO&id="+ID, function(result) {
                var obj = jQuery.parseJSON(result);
                row = '<div class="col-lg-12"><h3 id="header">Like</h3>';
                showTable(obj);
            });
        });
        $("#btn_tag").click(function(){
            $.get("module/administrator/get_child.php?option=TAG&id="+ID, function(result) {
                var obj = jQuery.parseJSON(result);
                row = '<div class="col-lg-12"><h3 id="header">Tag</h3>';
                showTable(obj);
            });
        });
        function showComment(obj) {
            row += '<table class="table table-striped table-hover" id="tb_show"><tbody><tr><th>USERNAME</th><th>MSG</th><th>DATE_TIME</th></tr>';
            for (i=0;i<obj.data.length;i++) {
                row += '<tr onclick="window.document.location=\'main.php?option=member_detail\';"><td>'+obj.data[i].USERNAME+'</td>'
                row += '<td>'+obj.data[i].MSG+'</td>'
                row += '<td>'+obj.data[i].DATE_TIME+'</td></tr>'
            }
            row += '</tbody></table></div>';
            init_table('#data_row', row);
        }
        function showTable(obj) {
            row += '<table class="table table-striped table-hover" id="tb_show"><tbody><tr><th>USERNAME</th></tr>';
            for (i=0;i<obj.data.length;i++) {
                row += '<tr onclick="window.document.location=\'main.php?option=member_detail\';"><td>'+obj.data[i].USERNAME+'</td></tr>'
            }
            row += '</tbody></table></div>';
            init_table('#data_row', row);
        }
    });
</script>