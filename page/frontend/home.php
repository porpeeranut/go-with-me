<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">New feed</h1>
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
            showData(obj);
        });
        function showData(obj) {
            row = "";
            for (i=0;i < obj.data.length;i++) {
                ID = obj.data[i].ID;
                CAPTION = obj.data[i].CAPTION;
                NAME = obj.data[i].owner[0].NAME;
                COMMENT = obj.data[i].comment;
                LIKE = obj.data[i].like;
                TAG = obj.data[i].tag;
                WITH = obj.data[i].with;
                row += '<div class="col-md-6 portfolio-item">';
                row += '<div class="feed_item"><a href="#">';
                row += '<img width="200" height="200" onclick="" class="img-rounded" src="images/photos/'+ID+'.jpg" alt="">';
                row += '</a><h2>';
                row += CAPTION+'</h2><br/>';
                row += 'own: '+NAME+'<br/>';
                for (j=0;j < COMMENT.length;j++) {
                    row += 'user: '+COMMENT[j].USERNAME;
                    row += ' msg: '+COMMENT[j].MSG+'<br/>';
                }
                row += '<h4>like</h4>';
                for (j=0;j < LIKE.length;j++) {
                    //row += LIKE[j].USERNAME+'<br/>';
                }
                row += LIKE.length+'<br/>';
                row += '<h4>tag</h4>';
                for (j=0;j < TAG.length;j++) {
                    row += TAG[j].USERNAME+'<br/>';
                }
                row += '<h4>with</h4>';
                for (j=0;j < WITH.length;j++) {
                    row += WITH[j].NAME+'<br/>';
                }
                row += '</div></div>';
            }
            init_table('#user-row', row);
        }
    });
</script>