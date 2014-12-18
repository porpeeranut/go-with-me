<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Profile</h1>
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
        <button id="btn_message" class="btn btn-default">Message</button>

        <div class="input-group custom-search-form" style="margin-top: 5px;" id="message">
          <input type="text" id="msgtxt" class="form-control" placeholder="Write a message...">
            <span class="input-group-btn">
            <button class="btn btn-default" type="button" id="btn-msg">
              Send
            </button>
          </span>
        </div>
        <!-- <button id="btn_friend" class="btn btn-default">Friend</button> -->
    </div>

</div>

<div id="data_row" class="row">
</div>
<hr>

<script>
    var start = 0;
    var n = 800;
    var id,name,user,email,score,profileEXT,badge,photo,message,detail;

    function showPhoto(id) {
        $.get("module/frontend/get.php?option=photo&s=0&n="+n, function(result) {
            var obj = jQuery.parseJSON(result);
            row = '';
            for (i=0;i < obj.data.length;i++) {
                if (obj.data[i].ID == id) {
                    ID = obj.data[i].ID;
                    picEXT = obj.data[i].EXT;
                    CAPTION = obj.data[i].CAPTION;
                    /*DATE_TIME = obj.data[i].DATE_TIME;
                    NAME = obj.data[i].owner[0].NAME;
                    OWNID = obj.data[i].owner[0].ID;
                    COMMENT = obj.data[i].comment;
                    LIKE = obj.data[i].like;
                    TAG = obj.data[i].tag;*/

                    row += '<div class="row">';

                    row += '<div class="col-md-8">';
                    row += '<img  width="100%" class="img-rounded" src="images/photos/'+ID+'.'+picEXT+'" alt="">';
                    row += '</div>';

                    row += '<div class="col-md-3"><b>'+CAPTION+'</b><br>';
                    detail = '';

                    if (obj.data[i].location[0].NAME != 'None')
                        detail += 'Location : <a href="#" onclick="showLocation('+obj.data[i].location[0].ID+');">'+obj.data[i].location[0].NAME+'</a><br>';

                    if (obj.data[i].timing[0].NAME != 'None')
                        detail += 'Timing : <a href="#" onclick="showTiming('+obj.data[i].timing[0].ID+');">'+obj.data[i].timing[0].NAME+'</a><br>';

                    if (obj.data[i].posture[0].NAME != 'None')
                        detail += 'Posture : <a href="#" onclick="showPosture('+obj.data[i].posture[0].ID+');">'+obj.data[i].posture[0].NAME+'</a><br>';

                    if (obj.data[i].thing[0].NAME != 'None')
                        detail += 'Thing : <a href="#" onclick="showThing('+obj.data[i].thing[0].ID+');">'+obj.data[i].thing[0].NAME+'<br>';

                    if (detail == '')
                        detail = "No detail.";
                    row += detail;
                    row += '</div>';
                    row += '</div>';
                }
            }
            bootbox.dialog({
            title: 'Photo',
            message: row,
            buttons: {
                success: {
                    label: "Close",
                    className: "btn-success",
                }
            }
        });
        });
    }
  var sid = 0;
	$(document).ready(function(){
        id = getUrlParameter('id');
        if (id != null) {
            sid = id;
            id = '&id='+id;
            $("#btn_message").hide();
        }
        else {
          id = '';
          $("#message").hide();
        }



        $.get("module/frontend/get.php?option=member"+id, function(result) {

            var obj = jQuery.parseJSON(result);
            id = obj.data[0].ID;
            name = obj.data[0].NAME;
            user = obj.data[0].USERNAME;
            email = obj.data[0].EMAIL;
            score = obj.data[0].ALL_SCORE;
            profileEXT = obj.data[0].PROFILE;
            badge = obj.data['badge'];
            photo = obj.data['photo'];
            message = obj.data['message'];

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
            if (profileEXT=="no") filename = "user.png";
            else filename = id+'.'+profileEXT;
            $("#showPic").attr("src","images/members/"+filename);

            //$("#all_score").html(result);
        });

        /*id = getUrlParameter('ID');
	    user = getUrlParameter('USERNAME');
	    name = getUrlParameter('NAME');
	    email = getUrlParameter('EMAIL');
	    profile = getUrlParameter('PROFILE');
	    score = getUrlParameter('ALL_SCORE');*/

        $("#btn_photo").click(function(){
            $.get("module/frontend/get.php?option=photo", function(result) {
                var all = jQuery.parseJSON(result);
                row = '<div class="col-lg-12"><h3 id="header" class="page-header">Photo</h3></div>';
                for (i=0;i < all.data.length;i++) {
                    for (b=0;b < photo.length;b++) {
                        if (all.data[i].ID == photo[b].ID) {
                            ID = all.data[i].ID;
                            CAPTION = all.data[i].CAPTION;
                            EXT = all.data[i].EXT;

                            /*SCORE = all.data[i].SCORE;
                            DETAIL = all.data[i].DETAIL;*/
                            row += '<div class="col-md-3 portfolio-item">';
                            row += '<div class="badge_detail"><a href="#">';
                            row += '<img  width="95%" onclick="showPhoto('+ID+')" class="img-rounded" src="images/photos/'+all.data[i].ID+'.'+EXT+'" alt="">';
                            row += '</a><h4>';
                            row += CAPTION+'</h4><br/>';
                            /*row += DETAIL+' (';
                            row += SCORE+' score)<br/>';*/
                            row += '</div></div>';
                        }
                    }
                }
                init_table('#data_row', row);
            });



            /*row = '<div class="col-lg-12"><h3 id="header" class="page-header">Photo</h3></div>';
            for (i=0;i < photo.length;i++) {
                row += '<div class="col-md-3 portfolio-item">';
                row += '<a href="#"><img width="200" class="img-rounded" src="images/photos/'+photo[i].ID+'.'+photo[i].EXT+'" alt=""></a>';
                row += photo[i].CAPTION+'<br/>';
                //row += 'owner '+obj.data[i].OWNER_ID+'<br/>';
                row += '</div>';
            }
            init_table('#data_row', row);*/
        });

        $("#btn_badge").click(function(){
            $.get("module/frontend/get.php?option=badge", function(result) {
                var all = jQuery.parseJSON(result);
                row = '<div class="col-lg-12"><h3 id="header" class="page-header">Badge</h3></div>';
                for (i=0;i<all.data.length;i++) {
                    for (b=0;b < badge.length;b++) {
                        if (all.data[i].ID == badge[b].BADGE_ID) {
                            ID = all.data[i].ID;
                            NAME = all.data[i].NAME;
                            SCORE = all.data[i].SCORE;
                            DETAIL = all.data[i].DETAIL;
                            row += '<div class="col-md-3 portfolio-item">';
                            row += '<div class="badge_detail"><a href="#">';
                            row += '<img  width="200" height="200" onclick="showBadge('+ID+')" class="img-circle" src="images/badges/logo_'+all.data[i].ID+'.jpg" alt="">';
                            row += '</a><h2>';
                            row += NAME+'</h2><br/>';
                            row += DETAIL+' (';
                            row += SCORE+' score)<br/>';
                            row += '</div></div>';
                        }
                    }
                }
                init_table('#data_row', row);
            });
        });

        $("#btn-msg").click(function() {
          $.get("module/frontend/add.php?option=message&to="+sid+"&msg="+$("#msgtxt").val(), function(res) {
            var obj = jQuery.parseJSON(res);
            if (obj.status=="success") {
              bootbox.alert("Send message success.", function() {
                location.reload();
              });
            } else {
              bootbox.alert("Send message failed.", function() {
                location.reload();
              });
            }
          });
        });

        $("#btn_message").click(function(){
            row = '<div class="col-lg-12"><h3 id="header" class="page-header">Message</h3></div><table>';

            for (i=0;i < message.length;i++) {
                filename = "user.png";
                if (message[i].PROFILE!="no") {
                  filename = message[i].M_ID1+'.'+message[i].PROFILE;
                }
                row += '<tr>';
                row += '<td style="padding : 10px 10px 10px 10px;"><a href="main.php?option=profile&id='+message[i].M_ID1+'"><img width="100" height="100" class="img-rounded" src="images/members/'+filename+'" alt=""></a><span class="mar-search"> </span></td>';
                row += '<td><h4>@'+message[i].USERNAME+' Say</h4>'+message[i].MSG+'<br><br>When '+message[i].DATE_TIME+'</td>';
                row += '</tr>';
            }
            row += '</table>';
            init_table('#data_row', row);
        });

        $("#btn_edit").click(function(){
        	window.document.location='main.php?option=edit_profile&id='+id+'&name='+name+'&email='+email+'&ext='+profileEXT;
        });
    });
</script>
