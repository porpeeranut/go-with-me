<div class="row">
    <div class="col-lg-7">
        <h1 class="page-header">Photo</h1>
    </div>
    <br/>
    <br/>
    <div class="col-lg-2">
        <select id='searchType' class="form-control">
            <option>ID</option>
            <option>OWNER_ID</option>
        </select>
    </div>
    <div class="col-lg-3">
        <div class="form-group input-group">
            <input id="searchTxt" type="text" class="form-control">
            <span class="input-group-btn"><button id="btnSearch" class="btn btn-default" type="button"><i class="fa fa-search"></i></button></span>
        </div>
    </div>
</div>

<div id="all-row" class="row">
</div>

<hr>    
<button id="btn_previous" class="btn btn-default">Previous</button>
<button id="btn_next" class="btn btn-default">Next</button>

<!-- <hr>
<div class="row text-center">
    <div class="col-lg-11.5">
        <ul class="pagination">
            <li>
                <a href="#">&laquo;</a>
            </li>
            <li class="active">
                <a href="#">1</a>
            </li>
            <li>
                <a href="#">2</a>
            </li>
            <li>
                <a href="#">3</a>
            </li>
            <li>
                <a href="#">4</a>
            </li>
            <li>
                <a href="#">5</a>
            </li>
            <li>
                <a href="#">&raquo;</a>
            </li>
        </ul>
    </div>
</div>
<hr> -->

<script>
    var start = 0;
    var n = 8;
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
                row += '<img onclick="window.document.location=\'main.php?option=photo_detail&ID='+ID+'&CAPTION='+CAPTION+'&OWNER_ID='+OWNER_ID+'&DATE_TIME='+DATE_TIME+'\';" class="img-responsive" src="images/photos/'+ID+'.jpg" alt="">';
                row += '</a>';
                row += '<h3>';
                row += ID;
                row += '</h3>';
                row += CAPTION+'<br/>';
                row += 'owner '+OWNER_ID+'<br/>';
                row += '</div>';
            }
            init_table('#all-row', row);
        }
        $("#btnSearch").click(function(){
            $.get("module/administrator/search.php?option=photo&keyword="+$("#searchTxt").val()+"&attr="+$("#searchType").val()+"&s=0&n=8", function(result) {
                var obj = jQuery.parseJSON(result);
                row = "";
                for (i=0;i<obj.data.length;i++) {
                    ID = obj.data[i].ID;
                    CAPTION = obj.data[i].CAPTION;
                    OWNER_ID = obj.data[i].OWNER_ID;
                    DATE_TIME = obj.data[i].DATE_TIME;
                    row += '<div class="col-md-3 portfolio-item">';
                    row += '<a href="#">';
                    row += '<img onclick="window.document.location=\'main.php?option=photo_detail&ID='+ID+'&CAPTION='+CAPTION+'&OWNER_ID='+OWNER_ID+'&DATE_TIME='+DATE_TIME+'\';" class="img-responsive" src="images/photos/'+ID+'.jpg" alt="">';
                    row += '</a>';
                    row += '<h3>';
                    row += ID;
                    row += '</h3>';
                    row += CAPTION+'<br/>';
                    row += 'owner '+OWNER_ID+'<br/>';
                    row += '</div>';
                }
                init_table('#all-row', row);
            });
        });
    });
</script>