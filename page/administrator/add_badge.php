<h1 class="page-header">Add Badge</h1>

<div id="all-row" class="row">
</div>

<div class="col-lg-6">
    <form action="" method="post" enctype="multipart/form-data" id="add">
        <div class="form-group">
            <label for="exampleInputEmail1">Name</label>
            <input type="text" class="form-control" name="name">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Score</label>
            <input type="text" class="form-control" name="score">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Detail</label>
            <input type="text" class="form-control" name="detail">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Badge Picture</label>
            <input id="badge_pic" type="file" class="filestyle" name="badge_pic">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Ex. Picture</label>
            <input id="ex_pic" type="file" class="filestyle" name="ex_pic">
        </div>
        <div class="form-group">
            <label>
                <input id='is_tim' name='is_tim' type="checkbox">TIMING
            </label>
        </div>
        <div class="form-group">
            <select id='tim_id' multiple class="form-control" name="tim_id">
            </select>
        </div>
        <div class="form-group">
            <label>
                <input id='is_pos' name='is_pos' type="checkbox">POSTURE
            </label>
        </div>
        <div class="form-group">
            <select id='pos_id' multiple class="form-control" name="pos_id">
            </select>
        </div>
        <div class="form-group">
            <label>
                <input id='is_loc' name='is_loc' type="checkbox">LOCATION
            </label>
        </div>
        <div class="form-group">
            <select id='loc_id' multiple class="form-control" name="loc_id">
            </select>
        </div>
        <div class="form-group">
            <label>
                <input id='is_thing' name='is_thing' type="checkbox">THING
            </label>
        </div>
        <div class="form-group">
            <select id='thing_id' multiple class="form-control" name="thing_id">
            </select>
        </div>
        <div class="form-group">
            <label>
                <input id='is_mem' name='is_mem' type="checkbox">MEMBER
            </label>
        </div>
        <div class="form-group">
            <select id='mem_id' multiple class="form-control" name="mem_id">
            </select>
        </div>
        <div class="form-group">
            <label>
                <input id='is_score' name='is_score' type="checkbox">SCORE
            </label>
            <input type="text" class="form-control" id="min_score" name="min_score">
        </div>
        <button id="submit" class="btn btn-default">Submit</button>
    </form>
</div>

<script>
    $(document).ready(function(event){
        $('#add').attr("action", "module/administrator/add.php?option=badge");
        $('#add').ajaxForm(function(result) {
            var obj = jQuery.parseJSON(result);
            if (obj.status == "success")
                window.location.href = "main.php?option=badge";
            else
                alert(obj.data);
        });
        $('#tim_id').prop('disabled', 'disabled');
        $('#pos_id').prop('disabled', 'disabled');
        $('#mem_id').prop('disabled', 'disabled');
        $('#thing_id').prop('disabled', 'disabled');
        $('#loc_id').prop('disabled', 'disabled');
        $.get("module/administrator/get.php?option=timing&s=0&n=9", function(result) {
            var obj = jQuery.parseJSON(result);
            showData('#tim_id',obj);
        });
        $.get("module/administrator/get.php?option=posture&s=0&n=9", function(result) {
            var obj = jQuery.parseJSON(result);
            showData('#pos_id',obj);
        }); 
        $.get("module/administrator/get.php?option=location&s=0&n=9", function(result) {
            var obj = jQuery.parseJSON(result);
            showData('#loc_id',obj);
        });
        $.get("module/administrator/get.php?option=thing&s=0&n=9", function(result) {
            var obj = jQuery.parseJSON(result);
            showData('#thing_id',obj);
        });
        $.get("module/administrator/get.php?option=member&s=0&n=9", function(result) {
            var obj = jQuery.parseJSON(result);
            showData('#mem_id',obj);
        });

        $("#is_tim").click(function(){
            if (document.getElementById("is_tim").checked) {
                $('#tim_id').prop('disabled', false);
            } else
                $('#tim_id').prop('disabled', 'disabled');
        });
        $("#is_pos").click(function(){
            if (document.getElementById("is_pos").checked) {
                $('#pos_id').prop('disabled', false);
            } else
                $('#pos_id').prop('disabled', 'disabled');
        });
        $("#is_loc").click(function(){
            if (document.getElementById("is_loc").checked) {
                $('#loc_id').prop('disabled', false);
            } else
                $('#loc_id').prop('disabled', 'disabled');
        });
        $("#is_thing").click(function(){
            if (document.getElementById("is_thing").checked) {
                $('#thing_id').prop('disabled', false);
            } else
                $('#thing_id').prop('disabled', 'disabled');
        });
        $("#is_mem").click(function(){
            if (document.getElementById("is_mem").checked) {
                $('#mem_id').prop('disabled', false);
            } else
                $('#mem_id').prop('disabled', 'disabled');
        });
        $("#is_score").click(function(){
            if (!document.getElementById("is_score").checked) {
                document.getElementById('min_score').value = "";
            }
        });
        function showData(dst, obj) {
            row = "";
            for (i=0;i<obj.data.length;i++) {
                row += '<option>'+obj.data[i].NAME+'</option>';
            }
            init_table(dst, row);
        }
    });
</script>