<div class="row">
    <div class="col-lg-7">
        <h1 class="page-header">Posture</h1>
    </div>
    <br/>
    <br/>
    <div class="col-lg-2">
        <select id='searchType' class="form-control">
            <option>ID</option>
            <option>NAME</option>
            <option>DETAIL</option>
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

</br>
<button id="btn_add" onclick="window.document.location='admin.php?option=add&TYPE=posture';" class="btn btn-default">Add</button>

<hr>    
<button id="btn_previous" class="btn btn-default">Previous</button>
<button id="btn_next" class="btn btn-default">Next</button>

<script>
    var start = 0;
    var n = 800;
    $(document).ready(function(){
        $.get("module/administrator/get.php?option=posture&s=0&n="+n, function(result) {
            var obj = jQuery.parseJSON(result);
            showData(obj);
        });
        $("#btn_previous").click(function(){
            if (start > 0)
                start -= n;
            $.get("module/administrator/get.php?option=posture&s="+start+"&n="+n, function(result) {
                var obj = jQuery.parseJSON(result);
                showData(obj);
            });
        });
        $("#btn_next").click(function(){
            start += n;
            $.get("module/administrator/get.php?option=posture&s="+start+"&n="+n, function(result) {
                var obj = jQuery.parseJSON(result);
                showData(obj);
            });
        });
        function showData(obj) {
            row = "";
            for (i=0;i<obj.data.length;i++) {
                if (obj.data[i].ID == 0)
                    continue;
                ID = obj.data[i].ID;
                NAME = obj.data[i].NAME;
                DETAIL = obj.data[i].DETAIL;
                row += '<div class="col-md-3 portfolio-item">';
                row += '<a href="#">';
                row += '<img onclick="window.document.location=\'admin.php?option=badge_type_detail&TYPE=postures&ID='+ID+'&NAME='+NAME+'&DETAIL='+DETAIL+'\';" class="img-responsive" src="images/postures/'+obj.data[i].ID+'.jpg" alt="">';
                row += '</a>';
                //row += '<h3>'+obj.data[i].ID+'</h3>';
                row += '<b>'+obj.data[i].NAME+'</b><br>';
                row += obj.data[i].DETAIL+'<br/>';
                row += '</div>';
            }
            init_table('#all-row', row);
        }
        $("#btnSearch").click(function(){
            $.get("module/administrator/search.php?option=posture&keyword="+$("#searchTxt").val()+"&attr="+$("#searchType").val()+"&s=0&n=8", function(result) {
                var obj = jQuery.parseJSON(result);
                row = "";
                for (i=0;i<obj.data.length;i++) {
                    ID = obj.data[i].ID;
                    NAME = obj.data[i].NAME;
                    DETAIL = obj.data[i].DETAIL;
                    row += '<div class="col-md-3 portfolio-item">';
                    row += '<a href="#">';
                    row += '<img onclick="window.document.location=\'admin.php?option=badge_type_detail&TYPE=postures&ID='+ID+'&NAME='+NAME+'&DETAIL='+DETAIL+'\';" class="img-responsive" src="images/postures/'+obj.data[i].ID+'.jpg" alt="">';
                    row += '</a>';
                    //row += '<h3>'+obj.data[i].ID+'</h3>';
                    row += '<b>'+obj.data[i].NAME+'</b><br>';
                    row += obj.data[i].DETAIL+'<br/>';
                    row += '</div>';
                }
                init_table('#all-row', row);
            });
        });
    });
</script>