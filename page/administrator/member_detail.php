<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Member</h1>
    </div>
</div>

<div class="row">
	<div class="col-md-1">
    </div>
    <div class="col-md-4">
        <img class="img-responsive" id="showPic" width="96%" src="" alt="">
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
    var n = 800;

	$(document).ready(function(){
        $.get("module/administrator/get.php?option=member&s=0&n=999", function(result) {
            id = getUrlParameter('ID');
            var obj = jQuery.parseJSON(result);
            for (i=0;i < obj.data.length;i++) {
                if (id == obj.data[i].ID) {
                    id = obj.data[i].ID;
                    name = obj.data[i].NAME;
                    user = obj.data[i].USERNAME;
                    email = obj.data[i].EMAIL;
                    score = obj.data[i].ALL_SCORE;
                    profileEXT = obj.data[i].PROFILE;
                    badge = obj.data['badge'];
                    photo = obj.data['photo'];
                    message = obj.data['message'];
                    break;
                }
            }

            /*ID = obj.data[i].ID;
            DATE_TIME = obj.data[i].DATE_TIME;
            CAPTION = obj.data[i].CAPTION;
            picEXT = obj.data[i].EXT;
            NAME = obj.data[i].owner[0].NAME;
            OWNID = obj.data[i].owner[0].ID;
            COMMENT = obj.data[i].comment;
            LIKE = obj.data[i].like;
            TAG = obj.data[i].tag;*/

            $("#user").html(user);
            $("#name").html(name);
            $("#email").html(email);
            $("#all_score").html(score);
            $("#showPic").attr("src","images/members/"+id+"."+profileEXT);

            //$("#all_score").html(result);
        });
        /*id = getUrlParameter('ID');
	    user = getUrlParameter('USERNAME');
	    name = getUrlParameter('NAME');
	    email = getUrlParameter('EMAIL');
	    profile = getUrlParameter('PROFILE');
	    score = getUrlParameter('ALL_SCORE');*/

        $("#btn_photo").click(function(){
            if (start > 0)
                start -= n;
            $.get("module/administrator/get_child.php?option=photo&id="+id, function(result) {
                //alert(result);
                var obj = jQuery.parseJSON(result);
                showPic('Photo', obj);
            });
        });
        $("#btn_badge").click(function(){
            if (start > 0)
                start -= n;
            $.get("module/administrator/get_child.php?option=badge_collect&id="+id, function(result) {
                alert(result);
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
        	window.document.location='admin.php?option=edit_member&ID='+id;
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
                row += 'img-responsive portfolio-item" onclick="';
                if (header == 'Badge') {
                    row += 'showBadge';
                    row += '('+obj.data[i].ID+')" src="images/badges/logo_'+obj.data[i].BADGE_ID+'.jpg" alt="">';
                    row += '</a>';
                    row += '<b>'+obj.data[i].NAME+'</b><br>';
                    row += obj.data[i].DETAIL+'<br>';
                    row += obj.data[i].SCORE+'<br>';
                    row += '</div>';
                } else {
                    row += 'showPhoto';
                    row += '('+obj.data[i].ID+')" src="images/photos/'+obj.data[i].ID+'.jpg" alt="">';
                    row += '</a>';
                    row += '<b>'+obj.data[i].CAPTION+'</b><br>';
                    row += '</div>';
                }
            }
            if (obj.data.length == 0) {
                row += '<div class="col-md-3 portfolio-item">';
                row += "No "+header+".";
                row += '</div>';
            }
            init_table('#data_row', row);
        }
    });
</script>