<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Edit</h1>
    </div>
</div>

<div class="row">
	<div class="col-md-1">
    </div>
    <div class="col-md-4">
        <label>Ex. picture</label>
        <img id="img" class="img-responsive" src="http://placehold.it/300x200" alt="">
    </div>

    <div class="col-md-4">
        <form action="" method="post" enctype="multipart/form-data" id="update">
            <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" class="form-control input-sm" id="name" name="name">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Detail</label>
                <input type="text" class="form-control input-sm" id="detail"name="detail">
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
        TYPE = getUrlParameter('TYPE');
        row = '';
        if (TYPE == 'locations') {
            $.get("module/administrator/get.php?option=location&s=0&n="+n, function(result) {
                var obj = jQuery.parseJSON(result);
                for (i=0;i<obj.data.length;i++) {
                    if (obj.data[i].ID == 0)
                        continue;
                    if (obj.data[i].ID == ID) {
                        NAME = obj.data[i].NAME;
                        DETAIL = obj.data[i].DETAIL;
                        $("#name").val(NAME);
                        $("#detail").val(DETAIL);
                        row += '<div class="col-md-3 portfolio-item">';
                        row += '<a href="#">';
                        row += '<img onclick="window.document.location=\'admin.php?option=badge_type_detail&TYPE=locations&ID='+ID+'\';" class="img-responsive" src="images/locations/'+obj.data[i].ID+'.jpg" alt="">';
                        row += '</a>';
                        //row += '<h3>'+obj.data[i].ID+'</h3>';
                        row += '<b>'+obj.data[i].NAME+'</b><br>';
                        row += obj.data[i].DETAIL+'<br>';
                        row += '</div>';
                    }
                }
                init_table('#all-row', row);
            });
        } else if (TYPE == 'times') {
            $.get("module/administrator/get.php?option=timing&s=0&n="+n, function(result) {
                var obj = jQuery.parseJSON(result);
                for (i=0;i<obj.data.length;i++) {
                    if (obj.data[i].ID == 0)
                        continue;
                    if (obj.data[i].ID == ID) {
                        NAME = obj.data[i].NAME;
                        DETAIL = obj.data[i].DETAIL;
                        $("#name").val(NAME);
                        $("#detail").val(DETAIL);
                        row += '<div class="col-md-3 portfolio-item">';
                        row += '<a href="#">';
                        row += '<img onclick="window.document.location=\'admin.php?option=badge_type_detail&TYPE=times&ID='+ID+'\';" class="img-responsive" src="images/times/'+obj.data[i].ID+'.jpg" alt="">';
                        row += '</a>';
                        //row += '<h3>'+obj.data[i].ID+'</h3>';
                        row += '<b>'+obj.data[i].NAME+'</b><br>';
                        row += obj.data[i].DETAIL+'<br>';
                        row += '</div>';
                    }
                }
                init_table('#all-row', row);
            });
        } else if (TYPE == 'postures') {
            $.get("module/administrator/get.php?option=posture&s=0&n="+n, function(result) {
                var obj = jQuery.parseJSON(result);
                for (i=0;i<obj.data.length;i++) {
                    if (obj.data[i].ID == 0)
                        continue;
                    if (obj.data[i].ID == ID) {
                        NAME = obj.data[i].NAME;
                        DETAIL = obj.data[i].DETAIL;
                        $("#name").val(NAME);
                        $("#detail").val(DETAIL);
                        row += '<div class="col-md-3 portfolio-item">';
                        row += '<a href="#">';
                        row += '<img onclick="window.document.location=\'admin.php?option=badge_type_detail&TYPE=postures&ID='+ID+'\';" class="img-responsive" src="images/postures/'+obj.data[i].ID+'.jpg" alt="">';
                        row += '</a>';
                        //row += '<h3>'+obj.data[i].ID+'</h3>';
                        row += '<b>'+obj.data[i].NAME+'</b><br>';
                        row += obj.data[i].DETAIL+'<br>';
                        row += '</div>';
                    }
                }
                init_table('#all-row', row);
            });
        } else if (TYPE == 'things') {
            $.get("module/administrator/get.php?option=thing&s=0&n="+n, function(result) {
                var obj = jQuery.parseJSON(result);
                for (i=0;i<obj.data.length;i++) {
                    if (obj.data[i].ID == 0)
                        continue;
                    if (obj.data[i].ID == ID) {
                        NAME = obj.data[i].NAME;
                        DETAIL = obj.data[i].DETAIL;
                        $("#name").val(NAME);
                        $("#detail").val(DETAIL);
                        row += '<div class="col-md-3 portfolio-item">';
                        row += '<a href="#">';
                        row += '<img onclick="window.document.location=\'admin.php?option=badge_type_detail&TYPE=things&ID='+ID+'\';" class="img-responsive" src="images/things/'+obj.data[i].ID+'.jpg" alt="">';
                        row += '</a>';
                        //row += '<h3>'+obj.data[i].ID+'</h3>';
                        row += '<b>'+obj.data[i].NAME+'</b><br>';
                        row += obj.data[i].DETAIL+'<br>';
                        row += '</div>';
                    }
                }
                init_table('#all-row', row);
            });
        }
        $("#img").attr("src", "images/"+TYPE+"/"+ID+".jpg");

        if (TYPE == "locations")
            TYPE = "location";
        else if (TYPE == "times")
            TYPE = "timing";
        else if (TYPE == "postures")
            TYPE = "posture";
        else if (TYPE == "things")
            TYPE = "thing";
        $('#update').attr("action", "module/administrator/update.php?option="+TYPE+"&id="+ID);
        $('#update').ajaxForm(function(result) {
            var obj = jQuery.parseJSON(result);
            if (obj.status == "success")
                window.location.href = "admin.php?option="+TYPE;
            else
                alert(obj.data);
        });
    });
</script>