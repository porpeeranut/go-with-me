<h1 class="page-header">Add</h1>

<div id="all-row" class="row">
</div>

<div class="col-lg-6">
    <form action="" method="post" enctype="multipart/form-data" id="add">
        <div class="form-group">
            <label for="exampleInputEmail1">Name</label>
            <input type="text" class="form-control" id="txtName" name="name">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Detail</label>
            <input type="text" class="form-control" id="txtDetail" name="detail">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Picture</label>
            <input id="ex_pic" type="file" class="filestyle" name="ex_pic">
        </div>
        <button id="submit" class="btn btn-default">Submit</button>
    </form>
</div>

<script>
    $(document).ready(function(event){
        TYPE = getUrlParameter('TYPE');
        $('#add').attr("action", "module/administrator/add.php?option="+TYPE);
        $('#add').ajaxForm(function(result) {
            var obj = jQuery.parseJSON(result);
            if (obj.status == "success")
                window.location.href = "admin.php?option="+TYPE;
            else
                alert(obj.data);
        });
    });
</script>