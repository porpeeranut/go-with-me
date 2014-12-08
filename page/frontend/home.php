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

<div id="user-row" class="row">
</div>

<script>
    var start = 0;
    var n = 8;
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
                CAPTION = obj.data[i].CAPTION;
                NAME = obj.data[i].owner[0].NAME;
                OWNID = obj.data[i].owner[0].ID;
                COMMENT = obj.data[i].comment;
                LIKE = obj.data[i].like;
                TAG = obj.data[i].tag;
                WITH = obj.data[i].with;
                row += '<div class="col-md-6 portfolio-item">';
                row += '<div class="feed_item">';
                row += '<div class="row">';
                row += '<div class="col-md-2">';
                row += '<img width="50" height="50" onclick="" class="img-rounded" src="images/members/'+OWNID+'.jpg" alt="">';
                row += '</div>';
                row += '<div class="col-md-4">';
                row += '<b>'+NAME+'</b></br>';

                if (TAG.length > 0) {
                    row += '<a href="#" id="Tag" data-href="'
                    for (j=0;j < TAG.length;j++) {
                        row += TAG[j].USERNAME+'<br/>';
                    }
                    row += '" data-toggle="modal" data-target="#normal-dialog">Tag</a>';
                }

                if (WITH.length > 0) {
                    row += '<a href="#" id="With" data-href="'
                    for (j=0;j < WITH.length;j++) {
                        row += WITH[j].NAME+'<br/>';
                    }
                    row += '" data-toggle="modal" data-target="#normal-dialog"> With</a>';
                }
                
                row += '</div>';
                row += '</div>';

                row += '</br>'+CAPTION+'';
                row += '</br></br>';
                row += '<a href="#">';
                row += '<img width="400" height="400" onclick="" class="img-rounded" src="images/photos/'+ID+'.jpg" alt="" hspace="0">';
                row += '</a>';

                //row += '<form action="module/frontend/add.php?option=like" method="post" class="form">';
                row += '<a href="#" id="like">Like</a>';
                //row += '</form>';

                row += ' · <a href="#">Comment</a>';
                /*if (COMMENT.length > 0)
                    row += '<h4>comment</h4>';
                for (j=0;j < COMMENT.length;j++) {
                    row += 'user: '+COMMENT[j].USERNAME;
                    row += ' msg: '+COMMENT[j].MSG+'<br/>';
                }*/
                if (LIKE.length > 0) {
                    row += ' · <i class="fa fa-thumbs-up fa-fw"></i>';
                    row += '<a href="#" id="LikeList" data-href="'
                    for (j=0;j < LIKE.length;j++) {
                        row += LIKE[j].USERNAME+'<br/>';
                    }
                    row += '" data-toggle="modal" data-target="#normal-dialog">'+LIKE.length+' people</a> like this.';
                }
                row += '</div></div>';
            }
            init_table('#user-row', row);
            $('#normal-dialog').on('show.bs.modal', function(e) {
                init_table('#dlgTxt', $(e.relatedTarget).data('href'));
                init_table('#dlgHead', e.relatedTarget.id);
                //$(this).find('.danger').attr('href', $(e.relatedTarget).data('href'));
            });
            /*$("#like").click(function(){
                window.location.href = 'main.php?option=home';
            });*/
            /*$('#like').ajaxForm(function(result) {
                var obj = jQuery.parseJSON(result);
                alert(obj);
                if (obj.status != "success")
                    alert(obj.data);
            });*/
            $("#like").click(function(){
                $.post("module/frontend/add.php?option=like",
                {
                    p_id:document.getElementById("#like").getAttribute("href")
                },
                function(data,status){
                    alert(data);
                });
                return false;
            });
            /*$('#like').click(function (e){ 
                e.preventDefault(); // otherwise, it won't wait for the ajax response
                $link = $(this); // because '$(this)' will be out of scope in your callback

                $.ajax({
                    type: 'POST',
                    url: '/gowithme/module/frontend/add.php?option=like',
                    data: '{p_id=1}',
                    contentType: 'application/json',
                    error: function (err) {
                        alert("error - " + err);
                    },
                    success: function (obj) {
                        alert(obj);
                    }
                });
            });*/
        }
    });
</script>