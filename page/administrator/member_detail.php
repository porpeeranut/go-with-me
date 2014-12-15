<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Member</h1>
    </div>
</div>

<div class="row">
	<div class="col-md-1">
    </div>
    <div class="col-md-4">
        <img class="img-responsive" src="http://placehold.it/300x200" alt="">
    </div>

    <div class="col-md-4">
        <h3>USERNAME: <span id="user">USERNAME</span> <button id="btn_edit" class="btn btn-default">Edit</button></h3>
        <label>NAME:</label> <span id="name">NAME</span></br>
		<label>EMAIL:</label> <span id="email">EMAIL</span></br>
		<label>ALL SCORE:</label> <span id="all_score">ALL_SCORE</span></br></br>
        <button id="btn_photo" class="btn btn-default">Photo</button>
        <button id="btn_badge" class="btn btn-default">Badge</button>
        <!-- <button id="btn_friend" class="btn btn-default">Friend</button> -->
    </div>

</div>

<div id="data_row" class="row">
</div>
<hr>

<script>
    var start = 0;
    var n = 8;

	$(document).ready(function(){
        id = getUrlParameter('ID');
	    user = getUrlParameter('USERNAME');
	    name = getUrlParameter('NAME');
	    email = getUrlParameter('EMAIL');
	    profile = getUrlParameter('PROFILE');
	    score = getUrlParameter('ALL_SCORE');

	    $("#user").html(user);
	    $("#name").html(name);
	    $("#email").html(email);
	    $("#all_score").html(score);

        $("#btn_photo").click(function(){
            if (start > 0)
                start -= n;
            $.get("module/administrator/get_child.php?option=photo&id="+id, function(result) {
                alert(result);
                var obj = jQuery.parseJSON(result);
                showPic('Photo', obj);
            });
        });
        $("#btn_badge").click(function(){
            if (start > 0)
                start -= n;
            $.get("module/administrator/get_child.php?option=badge_collect&id="+id, function(result) {
                var obj = jQuery.parseJSON(result);
                showPic('Badge', obj);
            });
        });
        $("#btn_friend").click(function(){
            if (start > 0)
                start -= n;
            $.get("module/administrator/get.php?option=member&s="+start+"&n="+n, function(result) {
                var obj = jQuery.parseJSON(result);
                showTable(obj)
            });
        });
        $("#btn_edit").click(function(){
        	window.document.location='admin.php?option=edit_member&ID='+id+'&USERNAME='+user+'&NAME='+name+'&EMAIL='+email+'&ALL_SCORE='+score+'&PROFILE='+profile;
        });
        function showTable(obj) {
        	row = '<div class="col-lg-12"><h3 id="header">Friend</h3>';
            row += '<table class="table table-striped table-hover" id="tb_show"><tbody><tr><th>ID</th><th>USERNAME</th><th>NAME</th><th>EMAIL</th><th>SCORE</th></tr>';
            for (i=0;i<obj.data.length;i++) {
                row += '<tr onclick="window.document.location=\'admin.php?option=member_detail\';"><td>'+obj.data[i].ID+'</td>'
                row += '<td>'+obj.data[i].USERNAME+'</td>'
                row += '<td>'+obj.data[i].NAME+'</td>'
                row += '<td>'+obj.data[i].EMAIL+'</td>'
                row += '<td>'+obj.data[i].ALL_SCORE+'</td></tr>'
            }
            row += '</tbody></table></div>';
            init_table('#data_row', row);
        }
        function showPic(header, obj) {
        	row = '<div class="col-lg-12"><h3 id="header" class="page-header">'+header+'</h3></div>';
            for (i=0;i<obj.data.length;i++) {
                row += '<div class="col-md-3 portfolio-item">';
                row += '<a href="#">';
                row += '<img class="';
                if (header == 'Badge')
                	row += 'img-circle ';
                row += 'img-responsive portfolio-item" src="images/photos/'+obj.data[i].ID+'.jpg" alt="">';
                row += '</a>';
                row += '<h3>';
                row += '<a href="#">'+obj.data[i].ID+'</a>';
                row += '</h3>';
                row += obj.data[i].CAPTION+'<br/>';
                row += 'owner '+obj.data[i].OWNER_ID+'<br/>';
                row += '</div>';
            }
            init_table('#data_row', row);
        }
    });
</script>