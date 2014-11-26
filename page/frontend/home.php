<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">All Badge</h1>
    </div>
</div>

<div id="badge-row" class="row">
</div>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Top User</h1>
    </div>
</div>

<div id="user-row" class="row">
</div>

<script>
    var start = 0;
    var n = 8;
    $(document).ready(function(){
        $.get("module/administrator/get.php?option=badge&s=0&n="+n, function(result) {
            var obj = jQuery.parseJSON(result);
            showData(obj);
        });
        function showData(obj) {
            row = "";
            for (i=0;i<obj.data.length;i++) {
                ID = obj.data[i].ID;
                NAME = obj.data[i].NAME;
                SCORE = obj.data[i].SCORE;
                DETAIL = obj.data[i].DETAIL;
                row += '<div class="col-md-3 portfolio-item">';
                row += '<a href="#">';
                row += '<img onclick="window.document.location=\'admin.php?option=badge_detail&ID='+ID+'&NAME='+NAME+'&SCORE='+SCORE+'&DETAIL='+DETAIL+'\';" class="img-responsive img-circle" src="images/badges/logo_'+obj.data[i].ID+'.jpg" alt="">';
                row += '</a>';
                row += '<h3>';
                row += ID;
                row += '</h3>';
                row += 'Name: '+NAME+'<br/>';
                row += 'Score: '+SCORE+'<br/>';
                row += 'Detail: '+DETAIL+'<br/>';
                row += '</div>';
            }
            init_table('#badge-row', row);
        }
    });
</script>

<script>
    var start = 0;
    var n = 8;
    $(document).ready(function(){
        $.get("module/administrator/get.php?option=photo&s=0&n="+n, function(result) {
            var obj = jQuery.parseJSON(result);
            showData(obj);
        });
        function showData(obj) {
            row = "";
            for (i=0;i<obj.data.length;i++) {
                ID = obj.data[i].ID;
                CAPTION = obj.data[i].CAPTION;
                OWNER_ID = obj.data[i].OWNER_ID;
                DATE_TIME = obj.data[i].DATE_TIME;
                row += '<div class="col-md-3 portfolio-item">';
                row += '<a href="#">';
                row += '<img onclick="window.document.location=\'admin.php?option=photo_detail&ID='+ID+'&CAPTION='+CAPTION+'&OWNER_ID='+OWNER_ID+'&DATE_TIME='+DATE_TIME+'\';" class="img-responsive" src="images/photos/'+ID+'.jpg" alt="">';
                row += '</a>';
                row += CAPTION+'<br/>';
                row += DATE_TIME+'<br/>';
                row += '</div>';
            }
            init_table('#user-row', row);
        }
    });
</script>