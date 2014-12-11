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

<div id="user-row" class="row">
</div>

<script>
    var start = 0;
    var n = 8;
    var myID,myName;
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
    function sendComment(id) {
        //alert($('#commentText').val());
        //alert(id);
        if ($('#commentText').val() != '') {
            $.post("module/frontend/add.php?option=comment",
            {
                p_id:id,
                msg:$('#commentText').val()
            },
            function(result,status){
                alert(result);
            });
        }
        return false; 
    }
    $.get("module/frontend/get.php?option=member", function(result) {
        var obj = jQuery.parseJSON(result);
        myID = obj.data[0].ID;
        myName = obj.data[0].NAME;
    });
    $(document).ready(function(){
        $.get("module/frontend/get.php?option=photo&s=0&n="+n, function(result) {
            //alert(result);
            var obj = jQuery.parseJSON(result);
            //init_table('#user-row', result);
            showData(obj);
        });
        function showData(obj) {
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
                row += '<b>'+NAME+'</b></br>';

                if (TAG.length > 0) {
                    row += '<a href="#" id="Tag" data-href="'
                    for (j=0;j < TAG.length;j++) {
                        row += TAG[j].USERNAME+'<br>';
                    }
                    row += '" data-toggle="modal" data-target="#normal-dialog">Tag</a>';
                }

                row += ' · <a href="#" id="Detail" data-href="'
                row += LOC_ID+'<br>';
                row += TIMING_ID+'<br>';
                row += POS_ID+'<br>';
                row += WITH+'<br>';
                row += '" data-toggle="modal" data-target="#normal-dialog">Detail</a>';

                row += '<br><font size="1">'+DATE_TIME+'</font></br>';
                
                row += '</div>';
                row += '</div>';

                row += '</br>'+CAPTION+'';
                row += '</br></br>';
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
            init_table('#user-row', row);
            $('#normal-dialog').on('show.bs.modal', function(e) {
                init_table('#dlgTxt', $(e.relatedTarget).attr('data-href'));
                head = e.relatedTarget.id;
                if (head.indexOf("Like") != -1)
                    head = 'Like';
                init_table('#dlgHead', head);
                //$(this).find('.danger').attr('href', $(e.relatedTarget).data('href'));
            });
            $('#comment-dialog').on('show.bs.modal', function(e) {
                $.get("module/frontend/get.php?option=photo", function(result) {
                    var obj = jQuery.parseJSON(result);
                    row = "";
                    id = $(e.relatedTarget).attr('data-href');
                    //noComment = true;
                    for (i=0;i < obj.data.length;i++) {
                        if (id == obj.data[i].ID) {
                            COMMENT = obj.data[i].comment;
                            for (j=0;j < COMMENT.length;j++) {
                                row += '<div class="row">';
                                row += '<div class="col-md-2">';
                                row += '<img width="40" height="40" style="margin-top: 3px;margin-left: 40px;" onclick="" class="img-rounded" src="images/members/'+COMMENT[j].ID+'.jpg" alt="">';
                                row += '</div>';
                                row += '<div class="col-md-6">';
                                row += '<b>'+COMMENT[j].USERNAME+'</b><br>';
                                row += COMMENT[j].MSG+'<br>';
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
                    row += '<button id="commentBtn" onclick="sendComment('+id+');" class="btn btn-default" type="button">';
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
                
                head = e.relatedTarget.id;
                if (head.indexOf("comment") != -1)
                    head = 'Comment';
                init_table('#dlgHeadComment', head);
                //$(this).find('.danger').attr('href', $(e.relatedTarget).data('href'));
            });
        }
    });
</script>