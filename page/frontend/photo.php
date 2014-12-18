<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Photo</h1>
    </div>
</div>

<div id="all-row" class="row">
</div>

<hr>    
<button id="btn_previous" class="btn btn-default">Previous</button>
<button id="btn_next" class="btn btn-default">Next</button>

<script>
    var start = 0;
    var n = 800;
    $(document).ready(function(){
        $.get("module/administrator/get.php?option=photo&s=0&n="+n, function(result) {
            var obj = jQuery.parseJSON(result);
            showData(obj);
/*LOC_ID
TIMING_ID
POS_ID*/
        });
        $("#btn_previous").click(function(){
            if (start > 0)
                start -= n;
            $.get("module/administrator/get.php?option=photo&s="+start+"&n="+n, function(result) {
                var obj = jQuery.parseJSON(result);
                showData(obj);
            });
        });
        $("#btn_next").click(function(){
            start += n;
            $.get("module/administrator/get.php?option=photo&s="+start+"&n="+n, function(result) {
                var obj = jQuery.parseJSON(result);
                showData(obj);
            });
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
            init_table('#all-row', row);
        }
    });
</script>