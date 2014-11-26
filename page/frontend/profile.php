<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Profile</h1>
    </div>
</div>

<div class="row">
	<div class="col-md-1">
    </div>
    <div class="col-md-4">
        <img class="img-responsive" src="http://placehold.it/300x200" alt="">
    </div>

    <div class="col-md-4">
        <h3>USERNAME: <span id="user">USERNAME</span> <button id="btn_edit" class="btn btn-default">Edit</button></h3>
        <label>NAME:</label> <span id="name">NAME</span></br>
		<label>EMAIL:</label> <span id="email">EMAIL</span></br>
		<label>ALL SCORE:</label> <span id="all_score">ALL_SCORE</span></br></br>
        <!-- <button id="btn_friend" class="btn btn-default">Friend</button> -->
    </div>

</div>

<div id="data_row" class="row">
</div>
<hr>

<script>
    var start = 0;
    var n = 8;

	$(document).ready(function(){
        id = getUrlParameter('ID');
	    user = getUrlParameter('USERNAME');
	    name = getUrlParameter('NAME');
	    email = getUrlParameter('EMAIL');
	    profile = getUrlParameter('PROFILE');
	    score = getUrlParameter('ALL_SCORE');

	    $("#user").html(user);
	    $("#name").html(name);
	    $("#email").html(email);
	    $("#all_score").html(score);
        $("#btn_edit").click(function(){
        	window.document.location='main.php?option=edit_profile&ID='+id+'&USERNAME='+user+'&NAME='+name+'&EMAIL='+email+'&ALL_SCORE='+score+'&PROFILE='+profile;
        });
    });
</script>