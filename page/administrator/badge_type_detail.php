<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Detail</h1>
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
        </br>
        <label>NAME:</label> <span id="name">NAME</span></br>
		<label>DETAIL:</label> <span id="detail">DETAIL</span></br></br>
        <button id="btn_edit" class="btn btn-default">Edit</button>
        <button id="btn_delete" class="btn btn-default">Delete</button>
    </div>

</div>

<div id="data_row" class="row">
</div>
<hr>

<script>
    var start = 0;
    var n = 8;

	$(document).ready(function(){
        ID = getUrlParameter('ID');
        NAME = getUrlParameter('NAME');
        DETAIL = getUrlParameter('DETAIL');
        TYPE = getUrlParameter('TYPE');
        $("#name").html(NAME);
        $("#detail").html(DETAIL);
        $("#img").attr("src", "images/"+TYPE+"/"+ID+".jpg");
        $("#btn_edit").click(function(){
        	window.document.location='admin.php?option=edit_badge_type&ID='+ID+'&NAME='+NAME+'&DETAIL='+DETAIL+'&TYPE='+TYPE;
        });
        $("#btn_delete").click(function(){
            if (confirm("Confirm")) {
                var page;
                if (TYPE == "locations")
                    page = "location";
                else if (TYPE == "times")
                    page = "timing";
                else if (TYPE == "postures")
                    page = "posture";
                else if (TYPE == "things")
                    page = "thing";
                $.get("module/administrator/delete.php?option="+page+"&id="+ID, function(result) {
                    var obj = jQuery.parseJSON(result);
                    if (obj.status == "success")
                        window.document.location='admin.php?option='+page;
                    else
                        alert(obj.data);
                });
            }
        });
    });
</script>