<div id='container'>
    <div class="row">
        <div class="col-lg-7">
            <h1>Member</h1>
        </div>
        <br/>
        <div class="col-lg-2">
            <select id='searchType' class="form-control">
                <option>ID</option>
                <option>USERNAME</option>
                <option>NAME</option>
                <option>EMAIL</option>
                <option>ALL_SCORE</option>
            </select>
        </div>
        <div class="col-lg-3">
            <div class="form-group input-group">
                <input id="searchTxt" type="text" class="form-control">
                <span class="input-group-btn"><button id="btnSearch" class="btn btn-default" type="button"><i class="fa fa-search"></i></button></span>
            </div>
        </div>
    </div>
    <table class="table table-striped table-hover" id="tb_show">
        <tbody>
        </tbody>
    </table>
    <button id="btn_previous" class="btn btn-default">Previous</button>
    <button id="btn_next" class="btn btn-default">Next</button>
</div>


<script>
    var start = 0;
    var n = 8;
	$(document).ready(function(){
        $.get("module/administrator/get.php?option=member&s=0&n="+n, function(result) {
            var obj = jQuery.parseJSON(result);
            showData(obj);
        });
        $("#btn_previous").click(function(){
            if (start > 0)
                start -= n;
            $.get("module/administrator/get.php?option=member&s="+start+"&n="+n, function(result) {
                var obj = jQuery.parseJSON(result);
                showData(obj);
            });
        });
        $("#btn_next").click(function(){
            start += n;
            $.get("module/administrator/get.php?option=member&s="+start+"&n="+n, function(result) {
                var obj = jQuery.parseJSON(result);
                showData(obj);
            });
        });
        function deleteMember(event) {
            if (confirm("Confirm")) {
                $.get("module/administrator/delete.php?option=member&id="+event.data.ID, function(result) {
                    var obj = jQuery.parseJSON(result);
                    $.get("module/administrator/get.php?option=member&s=0&n="+n, function(result) {
                        var obj = jQuery.parseJSON(result);
                        showData(obj);
                    });
                });
            }

        }
        function showData(obj) {
            row = "";
            for (i=0;i<obj.data.length;i++) {
                id = obj.data[i].ID;
                user = obj.data[i].USERNAME;
                name = obj.data[i].NAME;
                email = obj.data[i].EMAIL;
                score = obj.data[i].ALL_SCORE;
                profile = obj.data[i].PROFILE;
                row += '<tr><td>'+id+'</td>'
                row += '<td>'+user+'</td>'
                row += '<td>'+name+'</td>'
                row += '<td>'+email+'</td>'
                row += '<td>'+score+'</td>'
                row += '<td><button id="btn_view" class="btn btn-xs" onclick="window.document.location=\'main.php?option=member_detail&ID='+id+'&USERNAME='+user+'&NAME='+name+'&EMAIL='+email+'&ALL_SCORE='+score+'&PROFILE='+profile+'\';">View</button>  ';
                row += '<button id="btn_delete_'+i+'" class="btn btn-xs">Delete</button></td></tr>';
            }
            init_table('#tb_show tbody', '<tr><th>ID</th><th>USERNAME</th><th>NAME</th><th>EMAIL</th><th>SCORE</th><th>OPTION</th></tr>');
            $('#tb_show tbody').append(row);
            for (i=0;i<obj.data.length;i++) {
                $("#btn_delete_"+i).click({ID: obj.data[i].ID}, deleteMember);
            }
        }
        $("#btnSearch").click(function(){
            $.get("module/administrator/search.php?option=member&keyword="+$("#searchTxt").val()+"&attr="+$("#searchType").val()+"&s=0&n=8", function(result) {
                var obj = jQuery.parseJSON(result);
                start = obj;
                row = "";
                for (i=0;i<obj.data.length;i++) {
                    id = obj.data[i].ID;
                    user = obj.data[i].USERNAME;
                    name = obj.data[i].NAME;
                    email = obj.data[i].EMAIL;
                    score = obj.data[i].ALL_SCORE;
                    profile = obj.data[i].PROFILE;
                    row += '<tr><td>'+id+'</td>'
                    row += '<td>'+user+'</td>'
                    row += '<td>'+name+'</td>'
                    row += '<td>'+email+'</td>'
                    row += '<td>'+score+'</td>'
                    row += '<td><button id="btn_view" class="btn btn-xs" onclick="window.document.location=\'main.php?option=member_detail&ID='+id+'&USERNAME='+user+'&NAME='+name+'&EMAIL='+email+'&ALL_SCORE='+score+'&PROFILE='+profile+'\';">View</button>  ';
                    row += '<button id="btn_delete_'+i+'" class="btn btn-xs">Delete</button></td></tr>';
                }
                init_table('#tb_show tbody', '<tr><th>ID</th><th>USERNAME</th><th>NAME</th><th>EMAIL</th><th>SCORE</th><th>OPTION</th></tr>');
                $('#tb_show tbody').append(row);
                for (i=0;i<obj.data.length;i++) {
                    $("#btn_delete_"+i).click({ID: obj.data[i].ID}, deleteMember);
                }
            });
        });
    });
</script>