<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">My Badge</h1>
    </div>
</div>

<div id="all-row" class="row">
</div>

<hr>    
<button id="btn_previous" class="btn btn-default">Previous</button>
<button id="btn_next" class="btn btn-default">Next</button>

<script>
    var start = 0;
    var n = 8;
    $(document).ready(function(){
        $.get("module/administrator/get.php?option=badge&s=0&n="+n, function(result) {
            var obj = jQuery.parseJSON(result);
            showData(obj);
        });
        $("#btn_previous").click(function(){
            if (start > 0)
                start -= n;
            $.get("module/administrator/get.php?option=badge&s="+start+"&n="+n, function(result) {
                var obj = jQuery.parseJSON(result);
                showData(obj);
            });
        });
        $("#btn_next").click(function(){
            start += n;
            $.get("module/administrator/get.php?option=badge&s="+start+"&n="+n, function(result) {
                var obj = jQuery.parseJSON(result);
                showData(obj);
            });
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
            init_table('#all-row', row);
        }
    });
</script>