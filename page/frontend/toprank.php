<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Top Rank</h1>
    </div>
</div>

<div id="user-row" class="row">
</div>

<script>
    var start = 0;
    var n = 8;
    $(document).ready(function(){
        $.get("module/frontend/get.php?option=topuser", function(result) {
            var obj = jQuery.parseJSON(result);
            showData(obj);
        });
        function showData(obj) {
            row = "";
            for (i=0;i<obj.data.length;i++) {
                ID = obj.data[i].ID;
                USERNAME = obj.data[i].USERNAME;
                ALL_SCORE = obj.data[i].ALL_SCORE;

                row += '<div class="col-md-3 portfolio-item">';
                row += '<div class="badge_detail"><a href="#">';
                row += '<img width="200" height="200" onclick="" class="img-rounded" src="images/members/'+ID+'.jpg" alt="">';
                row += '</a><h2>';
                row += USERNAME+'</h2><br/>';
                row += 'Score: '+ALL_SCORE+'<br/>';
                row += '</div></div>';
            }
            init_table('#user-row', row);
        }
    });
</script>