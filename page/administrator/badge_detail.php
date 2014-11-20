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
        </br>
        <label>Name:</label> <span id="name">name</span></br>
        <label>Score:</label> <span id="score">score</span></br>
        <label>Detail:</label> <span id="detail">detail</span></br></br>
        <button id="btn_edit" onclick="" class="btn btn-default">Edit</button>
        <button id="btn_delete" class="btn btn-default">Delete</button></br></br>
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
        SCORE = getUrlParameter('SCORE');
        DETAIL = getUrlParameter('DETAIL');
        $("#name").html(NAME);
        $("#score").html(SCORE);
        $("#detail").html(DETAIL);
        $("#logo_img").attr("src", "images/badges/logo_"+ID+".jpg");
        $("#ex_img").attr("src", "images/badges/ex_"+ID+".jpg");
        $("#btn_edit").attr("onclick", "window.document.location='main.php?option=edit_badge&ID="+ID+"&NAME="+NAME+"&SCORE="+SCORE+"&DETAIL="+DETAIL+"';");
        $("#btn_delete").click(function(){
            if (confirm("Confirm")) {
                $.get("module/administrator/delete.php?option=badge&id="+ID, function(result) {
                    var obj = jQuery.parseJSON(result);
                    if (obj.status == "success")
                        window.document.location='main.php?option=badge';
                    else
                        alert(obj.data);
                });
            }
        });
    });
</script>