<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-book fa-fw"></i> Badge</h1>
    </div>
</div>

<div id="badge-row" class="row">
</div>

<script>
    var start = 0;
    var n = 800;
    $(document).ready(function(){
        $.get("module/frontend/get.php?option=badge", function(result) {
            var obj = jQuery.parseJSON(result);
            showData(obj);
        });
        function showData(obj) {
            row = "";
            for (i=0;i<obj.data.length;i++) {
                ID = obj.data[i].ID;
                NAME = obj.data[i].NAME;
                SCORE = obj.data[i].SCORE;
                DETAIL = obj.data[i].DETAIL;
                row += '<div class="col-md-3 portfolio-item">';
                row += '<div class="badge_detail"><a href="#">';
                row += '<img  width="200" height="200" onclick="showBadge('+ID+')" class="img-circle" src="images/badges/logo_'+obj.data[i].ID+'.jpg" alt="">';
                row += '</a><h2>';
                row += NAME+'</h2><br/>';
                row += DETAIL+' (';
                row += SCORE+' score)<br/>';
                row += '</div></div>';
            }
            init_table('#badge-row', row);
        }
    });
</script>
