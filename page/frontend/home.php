<meta http-equiv='cache-control' content='no-cache'>
<meta http-equiv='expires' content='0'>
<meta http-equiv='pragma' content='no-cache'>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">New feed</h1>
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
    var n = 8;
    var myID,myName;

    function setPostData(dst, obj) {
        row = "";
        /*for (i=0;i<obj.length;i++) {
            row += '<option selected="selected" value='+obj[i]+'>'+obj[i]+'</option>';
        }*/
        if (obj != "None")
            row += '<option selected="selected" value='+obj+'>'+obj+'</option>';
        init_table(dst, row);
    }

    function showTag(table,dst){
        $.get("module/frontend/get.php?option="+table+"&start=0&end=90", function(result) {
            mes = result;
            var obj = jQuery.parseJSON(result);
            //alert(mes);
            mes = '<div class="form-group">';
            mes += '<select id=\'tmp\' class="form-control" name="tmp[]">';
            mes += '<option value=None>None</option>';
            //mes += '<option value=CCC style="background-image:url(images/members/13.jpg);">cccc</option>';
            //mes += '<option value=ZZZ data-content="<img width=\'40\' height=\'40\' style=\'margin-top: 3px;margin-left: 40px;\' class=\'img-rounded\' src=\'images/members/13.jpg\'>">Zz</option>';
            if (table != "member") {
                for (i=0;i < obj.data.length;i++) {
                    mes += '<option value='+obj.data[i].ID+'>'+obj.data[i].NAME+'\t: '+obj.data[i].DETAIL+'</option>';
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
                            var answer = $("#tmp").val()
                            setPostData(dst, answer);
                        }
                    }
                }
            });
        });
    }

    function sendPost() {
        if ($('#caption').val() != '') {
            $.post("module/frontend/add.php?option=photo",
            {
                caption:$('#caption').val(),
                loc_id:$('#loc_id').val(),
                pos_id:$('#pos_id').val(),
                thing_id:$('#thing_id').val(),
                timing_id:$('#timing_id').val() 
            },
            function(result,status){
                alert(result);
                init_table('#upload-row', result);
            });
        } else {
            bootbox.alert("Caption is empty.", function() {
            });
        }
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
                        row += '<img width="40" height="40" style="margin-top: 3px;margin-left: 40px;" onclick="" class="img-rounded" src="images/members/'+COMMENT[j].M_ID+'.jpg" alt="">';
                        row += '</div>';
                        row += '<div class="col-md-8">';
                        row += '<b>'+COMMENT[j].USERNAME+'</b><br>';
                        row += COMMENT[j].MSG+'<br>';
                        //alert('my '+myID+', com '+COMMENT[j].ID);
                        if (COMMENT[j].M_ID == myID) {
                            row += '<div align="right"';
                            //row += '<button onclick="deleteComment('+p_id+','+COMMENT[j].COMMENT_ID+');" type="submit" class="btn btn-default btn-xs">';
                            row += '<button onclick="deleteComment('+p_id+','+COMMENT[j].C_ID+');" type="submit" class="btn btn-default btn-xs">';
                            row += '<i class="fa fa-delete fa-fw"></i>delete';
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
            row += '<img width="40" height="40" style="margin-top: 3px;margin-left: 40px;" onclick="" class="img-rounded" src="images/members/'+myID+'.jpg" alt="">';
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
            alert(result);
            /*var obj = jQuery.parseJSON(result);
            if (obj.status == "success")
                window.location.href = "admin.php?option=badge";
            else
                alert(obj.data);*/
        });

        function showUpload() {
            ID=6;
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

            //style="display: none;"
            row += '<div class="form-group" >';
            row += '<select id=\'loc_id\' class="form-control" name="loc_id[]">';
            row += '</select>';
            row += '</div>';

            row += '<div class="form-group" >';
            row += '<select id=\'tag_id\' class="form-control" name="tag_id[]">';
            row += '</select>';
            row += '</div>';

            row += '<div class="form-group" >';
            row += '<select id=\'pos_id\' class="form-control" name="pos_id[]">';
            row += '</select>';
            row += '</div>';

            row += '<div class="form-group" >';
            row += '<select id=\'thing_id\' class="form-control" name="thing_id[]">';
            row += '</select>';
            row += '</div>';

            row += '<div class="form-group" >';
            row += '<select id=\'timing_id\' class="form-control" name="timing_id[]">';
            row += '</select>';
            row += '</div>';

            row += '<input type="file" id="selectedPic" style="display: none;" />';
            row += '<a href="#" onclick="javascript:document.getElementById(\'selectedPic\').click();"><i class="fa fa-camera fa-fw"></i>Photo</a>';
            //row += '<input type="button" value="Browse..." onclick="document.getElementById("selectedFile").click();" />';
            row += ' · <a href="#" onclick="showTag(\'location\',\'#loc_id\')"><i class="fa fa-map-marker fa-fw"></i>Location</a>';
            row += ' · <a href="#" onclick="showTag(\'member\',\'#tag_id\')"><i class="fa fa-user fa-fw"></i>Tag</a>';
            row += ' · <a href="#" onclick="showTag(\'posture\',\'#pos_id\')"><i class="fa fa-user fa-fw"></i>Posture</a>';
            row += ' · <a href="#" onclick="showTag(\'thing\',\'#thing_id\')"><i class="fa fa-user fa-fw"></i>Thing</a>';
            row += ' · <a href="#" onclick="showTag(\'timing\',\'#timing_id\')"><i class="fa fa-user fa-fw"></i>Time</a>';
            row += ' <button id="submit" onclick="sendPost();" class="btn btn-default" type="button">Post</button>';

            row += '</form>';

            row += '</div></div>';
            init_table('#upload-row', row);
        }

        function showDataFeed(obj) {
            row = "";
            for (i=0;i < obj.data.length;i++) {
                ID = obj.data[i].ID;
                DATE_TIME = obj.data[i].DATE_TIME;
                CAPTION = obj.data[i].CAPTION;
                NAME = obj.data[i].owner[0].NAME;
                OWNID = obj.data[i].owner[0].ID;
                COMMENT = obj.data[i].comment;
                LIKE = obj.data[i].like;
                TAG = obj.data[i].tag;
                WITH = obj.data[i].with;
                LOC_ID = obj.data[i].LOC_ID;
                TIMING_ID = obj.data[i].TIMING_ID;
                POS_ID = obj.data[i].POS_ID;
                LIKED = false;
                row += '<div class="col-md-6 portfolio-item">';
                row += '<div class="feed_item">';
                row += '<div class="row">';
                row += '<div class="col-md-2">';
                row += '<img width="50" height="50" style="margin-top: 3px;" onclick="" class="img-rounded" src="images/members/'+OWNID+'.jpg" alt="">';
                row += '</div>';
                row += '<div class="col-md-4">';
                row += '<b>'+NAME+'</b><br>';

                if (TAG.length > 0) {
                    row += '<a href="#" id="Tag" data-href="'
                    for (j=0;j < TAG.length;j++) {
                        row += TAG[j].USERNAME+'<br>';
                    }
                    row += '" data-toggle="modal" data-target="#normal-dialog">Tag</a> · ';
                }

                row += '<a href="#" id="Detail" data-href="'
                row += LOC_ID+'<br>';
                row += TIMING_ID+'<br>';
                row += POS_ID+'<br>';
                row += WITH+'<br>';
                row += '" data-toggle="modal" data-target="#normal-dialog">Detail</a>';

                row += '<br><font size="1">'+DATE_TIME+'</font><br>';
                
                row += '</div>';
                row += '</div>';

                row += '<br>'+CAPTION+'';
                row += '<br><br>';
                row += '<a href="#">';
                row += '<img width="400" onclick="" class="img-rounded" src="images/photos/'+ID+'.jpg" alt="" hspace="0">';
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