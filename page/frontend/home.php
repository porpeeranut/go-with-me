<meta http-equiv='cache-control' content='no-cache'>
<meta http-equiv='expires' content='0'>
<meta http-equiv='pragma' content='no-cache'>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-photo fa-fw"></i> New feed</h1>
    </div>
</div>

<div class="modal fade" id="normal-dialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="dlgHead"></h4>
            </div>
            <div class="modal-body" id="dlgTxt"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="btnClose">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="comment-dialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="dlgHeadComment"></h4>
            </div>
            <div class="modal-body" id="dlgTxtComment"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="btnClose">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="upload-row" class="row"></div>

<div id="feed-row" class="row"></div>

<script type="text/javascript">
    var start = 0;
    var n = 800;
    var myID,myName,profileEXT;

    function setPostData(dst, obj) {
        row = "";
        if (obj == "pic") {
            //$("#pic").val('0');
            return;
        } else if (obj == "None") {
            row += '<option selected="selected" value=0>0</option>';
        } else {
            row += '<option selected="selected" value='+obj+'>'+obj+'</option>';
        }
        init_table(dst, row);
    }

    function updateEx(table) {

      var ans = $("#tmp").val().split(":");
      var id = ans[0];
      var name = ans[1];
      if (table=='timing') showTiming(id);
      if (table=='location') showLocation(id);
      if (table=='posture') showPosture(id);
      if (table=='thing') showThing(id);
    }

    function showList(table,dst){
        $.get("module/frontend/get.php?option="+table+"&start=0&end=90&all", function(result) {
            mes = result;
            var obj = jQuery.parseJSON(result);
            //alert(mes);
            mes = '<div class="form-group">';
            //mes += '<option value=CCC style="background-image:url(images/members/13.jpg);">cccc</option>';
            //mes += '<option value=ZZZ data-content="<img width=\'40\' height=\'40\' style=\'margin-top: 3px;margin-left: 40px;\' class=\'img-rounded\' src=\'images/members/13.jpg\'>">Zz</option>';
            if (table != "member") {
                mes += '<select id=\'tmp\' class="form-control" name="tmp[]" onchange="updateEx(\''+table+'\');">';
                for (i=0;i < obj.data.length;i++) {
                    mes += '<option value='+obj.data[i].ID+':'+obj.data[i].NAME+'>'+obj.data[i].NAME+'\t: '+obj.data[i].DETAIL+'</option>';
                }
            } else {
              mes += "Tag Who<br><br>";
              mes += '<select multiple id=\'tmp\' class="form-control" name="tmp[]">';
              for (i=0;i < obj.data.length;i++) {
                  mes += '<option value="'+obj.data[i].ID+'">@'+obj.data[i].USERNAME+'\t: '+obj.data[i].NAME+'</option>';
              }
            }
            mes += '</select>';
            mes += '</div>';
            bootbox.dialog({
                title: table,
                message: mes,
                buttons: {
                    success: {
                        label: "Ok",
                        className: "btn-success",
                        callback: function () {
                            if (table != "member") {
                              var ans = $("#tmp").val().split(":");
                              var id = ans[0];
                              var name = ans[1];

                              if (dst=="#loc") func = "showLocation";
                              else if (dst=="#pos") func = "showPosture";
                              else if (dst=="#timing") func = "showTiming";
                              else func = "showThing";

                              $(dst+"-show").html('<a href="#" onclick="'+func+'('+id+');">'+name+'</a>');
                              setPostData(dst+"_id", id);
                            } else {
                              var multipleValues = $( "#tmp" ).val() || [];
                              var res = multipleValues.join( "," );
                              setPostData(dst+"_id", res);
                            }

                        }
                    }
                }
            });
        });
    }

    function sendPost() {
        //alert($('#pic').val());
        if ($('#caption').val() == '' || $('#pic').val() == '') {
            bootbox.alert("Caption or photo is empty.", function() {
            });
        }
        /*if ($('#caption').val() != '' && $('#pic').val() != '') {
            $.post("module/frontend/add.php?option=photo",
            {
                caption:$('#caption').val(),
                loc_id:$('#loc_id').val(),
                pos_id:$('#pos_id').val(),
                thing_id:$('#thing_id').val(),
                pic:$('#pic').val(),
                timing_id:$('#timing_id').val()
            },
            function(result,status){
                alert(result);
                init_table('#upload-row', result);
            });
        } else {
            bootbox.alert("Caption or photo is empty.", function() {
            });
        }*/
        return false;
    }

    function sendLike(id) {
        //alert($('#like'+id).html());
        if ($('#like'+id).html() == 'Like') {
            $.post("module/frontend/add.php?option=like",
            {
                p_id:id
            },
            function(result,status){
                data = $('#LikeList'+id).attr("data-href");
                data = data+myName+'<br>';
                $('#LikeList'+id).attr("data-href", data);
                $('#like'+id).html("Unlike");
                likeNum = $('#LikeList'+id).html().split(" ")[0];
                $('#LikeList'+id).html((parseInt(likeNum)+1)+' '+$('#LikeList'+id).html().split(" ")[1]);
            });
        } else {
            $.get("module/frontend/delete.php?option=like&p_id="+id, function(result) {
                data = $('#LikeList'+id).attr("data-href");
                data = data.replace(myName+'<br>', " ");
                $('#LikeList'+id).attr("data-href", data);
                //var obj = jQuery.parseJSON(result);
                $('#like'+id).html("Like");
                likeNum = $('#LikeList'+id).html().split(" ")[0];
                $('#LikeList'+id).html((parseInt(likeNum)-1)+' '+$('#LikeList'+id).html().split(" ")[1]);
            });
        }
        return false;
    }
    function sendComment(pid) {
        //alert($('#commentText').val());
        //alert(id);
        if ($('#commentText').val() != '') {
            $.post("module/frontend/add.php?option=comment",
            {
                p_id:pid,
                msg:$('#commentText').val()
            },
            function(result,status){
                $('#commentText').val("");
                loadComment(pid);
            });
        }
        return false;
    }
    function deleteComment(pid,commentID) {
        bootbox.confirm("Are you sure?", function(result) {
            if (result == true) {
                $.get("module/frontend/delete.php?option=comment&id="+commentID, function(result) {
                    var obj = jQuery.parseJSON(result);
                    if (obj.status == "success")
                        loadComment(pid);
                    else
                        alert(obj.data);
                });
            }
        });
        return false;
    }
    function loadComment(p_id) {
        $.get("module/frontend/get.php?option=photo", function(result) {
            var obj = jQuery.parseJSON(result);
            row = "";
            //noComment = true;
            for (i=0;i < obj.data.length;i++) {
                if (p_id == obj.data[i].ID) {
                    COMMENT = obj.data[i].comment;
                    for (j=0;j < COMMENT.length;j++) {
                        row += '<div class="row">';
                        row += '<div class="col-md-2">';
                        filename = "user.png";
                        if (COMMENT[j].PROFILE!="no") {
                          filename = COMMENT[j].M_ID+'.'+COMMENT[j].PROFILE;
                        }
                        row += '<a href="main.php?option=profile&id='+COMMENT[j].M_ID+'"><img width="40" height="40" style="margin-top: 3px;margin-left: 40px;" onclick="" class="img-rounded" src="images/members/'+filename+'" alt=""></a>';
                        row += '</div>';
                        row += '<div class="col-md-8">';
                        row += '<b>@'+COMMENT[j].USERNAME+'</b><br>';
                        row += COMMENT[j].MSG+'<br>';
                        //alert('my '+myID+', com '+COMMENT[j].ID);
                        if (COMMENT[j].M_ID == myID) {
                            row += '<div align="right"';
                            //row += '<button onclick="deleteComment('+p_id+','+COMMENT[j].COMMENT_ID+');" type="submit" class="btn btn-default btn-xs">';
                            row += '<button onclick="deleteComment('+p_id+','+COMMENT[j].C_ID+');" type="submit" class="btn btn-default btn-xs">';
                            row += 'delete';
                            //<i class="fa fa-delete fa-fw"></i>delete
                            row += '</button>';
                            row += '</div>';

                            //row += ' <button id="postBtn" onclick="deleteComment('+p_id+','+COMMENT[j].COMMENT_ID+');" class="btn btn-default" type="button">Post</button>';
                        }
                        row += '</div>';
                        row += '</div>';
                    }
                    /*if (COMMENT.length != 0)
                        noComment = false;*/
                    break;
                }
            }
            /*if (noComment)
                row += 'No comment';*/

            row += '<div class="row">';
            row += '<div class="col-md-2">';
            row += '<img width="40" height="40" style="margin-top: 3px;margin-left: 40px;" onclick="" class="img-rounded" src="images/members/'+myID+'.'+profileEXT+'" alt="">';
            row += '</div>';
            row += '<div class="col-md-10">';

            row += '<div class="input-group custom-search-form" style="margin-top: 5px;">';
            row += '<input type="text" id="commentText" class="form-control" placeholder="Write a comment...">';
            row += '<span class="input-group-btn">';
            row += '<button id="commentBtn" onclick="sendComment('+p_id+');" class="btn btn-default" type="button">';
            //row += '<i class="fa fa-search"></i>Comment';
            row += 'Comment';
            row += '</button>';
            row += '</span>';
            row += '</div>';
            /*row += '<b>'+COMMENT[j].USERNAME+'</b><br>';
            row += COMMENT[j].MSG+'<br>';*/
            row += '</div>';
            row += '</div>';

            init_table('#dlgTxtComment', row);
        });
        head = 'Comment';
        init_table('#dlgHeadComment', head);
        //$(this).find('.danger').attr('href', $(e.relatedTarget).data('href'));
    }



    $.get("module/frontend/get.php?option=member", function(result) {
        //alert(result);
        var obj = jQuery.parseJSON(result);
        myID = obj.data[0].ID;
        myName = obj.data[0].NAME;
        profileEXT = obj.data[0].PROFILE;
    });
    $(document).ready(function(){

        showUpload();

        $.get("module/frontend/get.php?option=photo&s=0&n="+n, function(result) {
            //alert(result);
            //init_table('#upload-row', result);
            var obj = jQuery.parseJSON(result);
            showDataFeed(obj);
        });

        $('#postdata').attr("action", "module/frontend/add.php?option=photo");
        $('#postdata').ajaxForm(function(result) {
            var obj = jQuery.parseJSON(result);
            if (obj.status=="success") {
              var msg="<table cellpadding='10'>";

              for (i=0;i < obj.data.length;i++) {
                id = obj.data[i].ID;
                name = obj.data[i].NAME;
                detail = obj.data[i].DETAIL;
                score = obj.data[i].SCORE;

                msg+="<tr>";
                msg+="<td><img width='150' src='images/badges/logo_"+id+".jpg' onclick='showBadge("+id+")' class='img-rounded'> <span class='mar-search'> </span></td>";
                msg+="<td><h3>"+name+"</h3>"+detail+" ("+score+" score)</td>";
                msg+="</tr>";
              }
              msg+="</table>";

              bootbox.dialog({
                title: "You get new badges.",
                message: msg,
                buttons: {
                  success: {
                     label: "Close",
                      className: "btn-success",
                      callback: function() {
                        window.location.href = 'main.php?option=home';
                      }
                  }
                }
              });
            } else {
              bootbox.alert(obj.data, function(e) {
                window.location.href = 'main.php?option=home';
              });
            }

        });

        function showUpload() {
            row="";
            row += '<div class="col-md-7 portfolio-item">';
            row += '<div class="feed_item">';
            row += '<b>Upload photo</b>';
            row += '<br><br>';

            row += '<form action="" method="post" enctype="multipart/form-data" id="postdata">';

            /*row += '<div class="form-group">';
            row += '<label for="exampleInputEmail1">Name</label>';
            row += '<input type="text" class="form-control" name="name">';
            row += '</div>';*/

            row += '<textarea name="caption" style="width:480px;" rows="2" type="text" id="caption" class="form-control" placeholder="Say something about this photo..."></textarea>';
            row += '<br>';

            /*row += '<a href="#" id="post" data-href="'+ID;
            row += '" data-toggle="modal" data-target="#comment-dialog">Comment</a>';*/

            /*row += '<div class="inputWrapper">';
            row += '<input class="fileInput" type="file" name="file1"/>';
            row += '</div>';*/

            // style="display: none;"
            row += '<b>Location</b> <span id="loc-show">None</span><br>';
            row += '<b>Tag</b> <span id="tag-show">None</span><br>';
            row += '<b>Posture</b> <span id="pos-show">None</span><br>';
            row += '<b>Thing</b> <span id="thing-show">None</span><br>';
            row += '<b>Time</b> <span id="timing-show">None</span><br>';
            row += '<div class="form-group" style="display: none;">';
            row += '<select id=\'loc_id\' class="form-control" name="loc_id">';
            row += '</select>';
            row += '</div>';

            row += '<div class="form-group" style="display: none;">';
            row += '<select id=\'tag_id\' class="form-control" name="tag">';
            row += '</select>';
            row += '</div>';


            row += '<div class="form-group" style="display: none;">';
            row += '<select id=\'pos_id\' class="form-control" name="pos_id">';
            row += '</select>';
            row += '</div>';

            row += '<div class="form-group" style="display: none;">';
            row += '<select id=\'thing_id\' class="form-control" name="thing_id">';
            row += '</select>';
            row += '</div>';

            row += '<div class="form-group" style="display: none;" >';
            row += '<select id=\'timing_id\' class="form-control" name="timing_id">';
            row += '</select>';
            row += '</div>';

            row += '<input type="file" id="pic" name="pic" value="empty" style="display: none;" />';
            row += '<a href="#" onclick="javascript:document.getElementById(\'pic\').click();"><i class="fa fa-camera fa-fw"></i>Photo</a>';
            //row += '<input type="button" value="Browse..." onclick="document.getElementById("selectedFile").click();" />';
            row += ' · <a href="#" onclick="showList(\'location\',\'#loc\')"><i class="fa fa-map-marker fa-fw"></i>Location</a>';
            row += ' · <a href="#" onclick="showList(\'member\',\'#tag\')"><i class="fa fa-user fa-fw"></i>Tag</a>';
            row += ' · <a href="#" onclick="showList(\'posture\',\'#pos\')"><i class="fa fa-user fa-fw"></i>Posture</a>';
            row += ' · <a href="#" onclick="showList(\'thing\',\'#thing\')"><i class="fa fa-user fa-fw"></i>Thing</a>';
            row += ' · <a href="#" onclick="showList(\'timing\',\'#timing\')"><i class="fa fa-user fa-fw"></i>Time</a>';
            row += ' <button id="submit" name="submit" class="btn btn-default">Post</button>';
            //onclick="sendPost();"

            row += '</form>';

            row += '</div></div>';
            init_table('#upload-row', row);

            setPostData('#loc_id',"None");
            setPostData('#tag_id',"None");
            setPostData('#pos_id',"None");
            setPostData('#thing_id',"None");
            setPostData('#pic',"pic");
            setPostData('#timing_id',"None");
        }

        function showDataFeed(obj) {
            row = "";
            for (i=0;i < obj.data.length;i++) {
                ID = obj.data[i].ID;
                DATE_TIME = obj.data[i].DATE_TIME;
                CAPTION = obj.data[i].CAPTION;
                picEXT = obj.data[i].EXT;
                profileEXT = obj.data[i].owner[0].PROFILE;
                NAME = obj.data[i].owner[0].NAME;
                OWNID = obj.data[i].owner[0].ID;
                COMMENT = obj.data[i].comment;
                LIKE = obj.data[i].like;
                TAG = obj.data[i].tag;

                LIKED = false;
                row += '<div class="col-md-6 portfolio-item">';
                row += '<div class="feed_item">';
                row += '<div class="row">';
                row += '<div class="col-md-2">';
                if (profileEXT=="no") filename = "user.png";
                else filename = OWNID+'.'+profileEXT;
                row += '<a href="main.php?option=profile&id='+OWNID+'"><img width="50" height="50" style="margin-top: 3px;" onclick="" class="img-rounded" src="images/members/'+filename+'" alt=""></a>';
                row += '</div>';
                row += '<div class="col-md-6">';
                row += '<b>'+NAME+'</b><br>';

                if (TAG.length > 0) {
                    row += '<a href="#" id="Tag" data-href="'
                    for (j=0;j < TAG.length;j++) {
                        row += "<a href='main.php?option=profile&id="+TAG[j].ID+"'>@"+TAG[j].USERNAME+'</a><br>';
                    }
                    row += '" data-toggle="modal" data-target="#normal-dialog">Tag</a> · ';
                }

                row += '<a href="#" id="Detail" data-href="'

                detail = '';

                if (obj.data[i].location[0].NAME != 'None')
                    detail += '<b>Location</b> '+obj.data[i].location[0].NAME+'<br>';

                if (obj.data[i].timing[0].NAME != 'None')
                    detail += '<b>Timing</b> '+obj.data[i].timing[0].NAME+'<br>';

                if (obj.data[i].posture[0].NAME != 'None')
                    detail += '<b>Posture</b> '+obj.data[i].posture[0].NAME+'<br>';

                if (obj.data[i].thing[0].NAME != 'None')
                    detail += '<b>Thing</b> '+obj.data[i].thing[0].NAME+'<br>';

                if (detail == '')
                    detail = "No detail.";
                row += detail;
                //alert(obj.data[i].thing[0].NAME);

                row += '" data-toggle="modal" data-target="#normal-dialog">Detail</a>';

                row += '<br><font size="1">'+DATE_TIME+'</font><br>';

                row += '</div>';
                row += '</div>';

                row += '<br>'+CAPTION+'';
                row += '<br><br>';
                row += '<a href="#">';
                row += '<img width="96%" onclick="" class="img-rounded" src="images/photos/'+ID+'.'+picEXT+'" alt="" hspace="0">';
                row += '</a>';

                //row += '<form action="module/frontend/add.php?option=like" method="post" class="form">';

                for (j=0;j < LIKE.length;j++) {
                    if (LIKE[j].ID == myID) {
                        LIKED = true;
                        break;
                    }
                }
                if (LIKED) {
                    row += '<a href="javascript:void(0)" id="like'+ID+'" onclick="sendLike('+ID+');">Unlike</a>';
                } else {
                    row += '<a href="javascript:void(0)" id="like'+ID+'" onclick="sendLike('+ID+');">Like</a>';
                }
                //row += '</form>';

                //row += ' · <a href="#">Comment</a>';
                /*if (COMMENT.length > 0)
                    row += '<h4>comment</h4>';
                for (j=0;j < COMMENT.length;j++) {
                    row += 'user: '+COMMENT[j].USERNAME;
                    row += ' msg: '+COMMENT[j].MSG+'<br>';
                }*/
                row += ' · <a href="#" id="comment'+ID+'" data-href="'+ID;
                row += '" data-toggle="modal" data-target="#comment-dialog">Comment</a>';

                row += ' · <i class="fa fa-thumbs-up fa-fw"></i>';
                row += '<a href="#" id="LikeList'+ID+'" data-href="'
                for (j=0;j < LIKE.length;j++) {
                    row += LIKE[j].USERNAME+'<br>';
                }
                row += '" data-toggle="modal" data-target="#normal-dialog">'+LIKE.length+' people</a> like this.';
                row += '</div></div>';
            }
            init_table('#feed-row', row);
            $('#normal-dialog').on('show.bs.modal', function(e) {
                init_table('#dlgTxt', $(e.relatedTarget).attr('data-href'));
                head = e.relatedTarget.id;
                if (head.indexOf("Like") != -1)
                    head = 'Like';
                init_table('#dlgHead', head);
                //$(this).find('.danger').attr('href', $(e.relatedTarget).data('href'));
            });
            $('#comment-dialog').on('show.bs.modal', function(e) {
                loadComment($(e.relatedTarget).attr('data-href'));
            });
        }
    });
</script>
