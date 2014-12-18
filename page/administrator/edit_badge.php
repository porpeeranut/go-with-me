<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Badge</h1>
    </div>
</div>

<div class="row">
	<div class="col-md-2">
        <label>Logo</label>
        <img id="logo_img" class="img-responsive img-circle" src="http://placehold.it/300x200" alt="">
    </div>

    <div class="col-md-3">
        <label>Ex. picture</label>
        <img id="ex_img" class="img-responsive" src="http://placehold.it/300x200" alt="">
    </div>

    <div class="col-md-4">
        <form action="" method="post" enctype="multipart/form-data" id="update">
            <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" class="form-control input-sm" id="name" name="name">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Score</label>
                <input type="text" class="form-control input-sm" id="score" name="score">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Detail</label>
                <input type="text" class="form-control input-sm" id="detail" name="detail">
            </div>
            <button id="Submit" class="btn btn-default">Submit</button>
        </form>
    </div>

</div>

<div id="data_row" class="row">
</div>
<hr>

<script>
    var start = 0;
    var n = 800;  
	$(document).ready(function(){
        ID = getUrlParameter('ID');
        NAME = getUrlParameter('NAME');
        SCORE = getUrlParameter('SCORE');
        DETAIL = getUrlParameter('DETAIL');

        $.get("module/administrator/get.php?option=badge&s=0&n="+n, function(result) {
            var obj = jQuery.parseJSON(result);
            row = "";
            for (i=0;i<obj.data.length;i++) {
                if (ID == obj.data[i].ID) {
                    NAME = obj.data[i].NAME;
                    SCORE = obj.data[i].SCORE;
                    DETAIL = obj.data[i].DETAIL;
                    $("#name").val(NAME);
                    $("#score").val(SCORE);
                    $("#detail").val(DETAIL);
                    row += '<div class="col-md-3 portfolio-item">';
                    row += '<a href="#">';
                    row += '<img onclick="window.document.location=\'admin.php?option=badge_detail&ID='+ID+'&NAME='+NAME+'&SCORE='+SCORE+'&DETAIL='+DETAIL+'\';" class="img-responsive img-circle" src="images/badges/logo_'+obj.data[i].ID+'.jpg" alt="">';
                    row += '</a>';
                    row += 'Name: '+NAME+'<br/>';
                    row += 'Score: '+SCORE+'<br/>';
                    row += 'Detail: '+DETAIL+'<br/>';
                    row += '</div>';
                }
            }
            init_table('#all-row', row);
        });

        $("#logo_img").attr("src", "images/badges/logo_"+ID+".jpg");
        $("#ex_img").attr("src", "images/badges/ex_"+ID+".jpg");
        $('#update').attr("action", "module/administrator/update.php?option=badge&id="+ID);
        $('#update').ajaxForm(function(result) {
            var obj = jQuery.parseJSON(result);
            if (obj.status == "success")
                window.location.href = "admin.php?option=badge";
            else
                alert(obj.data);
        });
    });
</script>