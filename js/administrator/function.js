function init_table(tid, data) {
    $(tid).empty();
    $(tid).append(data);
}

function getUrlParameter(sParam)
{
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++)
    {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam)
        {
            return sParameterName[1];
        }
    }
}

function showPhoto(id) {
    $.get("module/frontend/get.php?option=photo&s=0&n="+n, function(result) {
        var obj = jQuery.parseJSON(result);
        row = '';
        //alert(id);
        for (i=0;i < obj.data.length;i++) {
            //alert(obj.data[i].ID);
            if (obj.data[i].ID == id) {
                ID = obj.data[i].ID;
                picEXT = obj.data[i].EXT;
                CAPTION = obj.data[i].CAPTION;

                row += '<div class="row">';

                row += '<div class="col-md-8">';
                row += '<img  width="100%" class="img-rounded" src="images/photos/'+ID+'.'+picEXT+'" alt="">';
                row += '</div>';

                row += '<div class="col-md-3"><b>'+CAPTION+'</b><br>';
                detail = '';

                if (obj.data[i].location[0].NAME != 'None')
                    detail += 'Location : <a href="#" onclick="showLocation('+obj.data[i].location[0].ID+');">'+obj.data[i].location[0].NAME+'</a><br>';

                if (obj.data[i].timing[0].NAME != 'None')
                    detail += 'Timing : <a href="#" onclick="showTiming('+obj.data[i].timing[0].ID+');">'+obj.data[i].timing[0].NAME+'</a><br>';

                if (obj.data[i].posture[0].NAME != 'None')
                    detail += 'Posture : <a href="#" onclick="showPosture('+obj.data[i].posture[0].ID+');">'+obj.data[i].posture[0].NAME+'</a><br>';

                if (obj.data[i].thing[0].NAME != 'None')
                    detail += 'Thing : <a href="#" onclick="showThing('+obj.data[i].thing[0].ID+');">'+obj.data[i].thing[0].NAME+'<br>';

                if (detail == '')
                    detail = "No detail.";
                row += detail;
                row += '</div>';
                row += '</div>';
            }
        }
        bootbox.dialog({
        title: 'Photo',
        message: row,
        buttons: {
            success: {
                label: "Close",
                className: "btn-success",
            }
        }
    });
    });
}

function showBadge(id) {
  $.get("module/frontend/search.php?option=badge&keyword="+id, function(result) {
    var obj = jQuery.parseJSON(result);
    msg = "";

    ID = obj.data.ID;
    SCORE = obj.data.SCORE;
    NAME = obj.data.NAME;
    DETAIL = obj.data.DETAIL;

    msg += DETAIL+' ('+SCORE+' score)';
    if (obj.data.T5_FLAG=="1") {
      msg += '<br>Thing: ';
      for (i=0;i<obj.data.thing.length;i++) {
        msg+= '<a href="#" onclick="showThing('+obj.data.thing[i].ID+');">'+obj.data.thing[i].NAME+'</a>';
        if (i!=obj.data.thing.length-1) msg+=', ';
      }
    }
    if (obj.data.T3_FLAG=="1") {
      msg += '<br>Member: ';
      for (i=0;i<obj.data.member.length;i++) {
        msg+= '<a href="#" onclick="showMember('+obj.data.member[i].ID+');">@'+obj.data.member[i].USERNAME+'</a>';
        if (i!=obj.data.member.length-1) msg+=', ';
      }
    }
    if (obj.data.T2_FLAG=="1") {
      msg += '<br>Timing: ';
      for (i=0;i<obj.data.timing.length;i++) {
        msg+= '<a href="#" onclick="showTiming('+obj.data.timing[i].ID+');">'+obj.data.timing[i].NAME+'</a>';
        if (i!=obj.data.timing.length-1) msg+=', ';
      }
    }
    if (obj.data.T4_FLAG=="1") {
      msg += '<br>Posture: ';
      for (i=0;i<obj.data.posture.length;i++) {
        msg+= '<a href="#" onclick="showPosture('+obj.data.posture[i].ID+');">'+obj.data.posture[i].NAME+'</a>';
        if (i!=obj.data.posture.length-1) msg+=', ';
      }
    }
    if (obj.data.T1_FLAG=="1") {
      msg += '<br>Location: ';
      for (i=0;i<obj.data.location.length;i++) {
        msg+= '<a href="#" onclick="showLocation('+obj.data.location[i].ID+');">'+obj.data.location[i].NAME+'</a>';
        if (i!=obj.data.location.length-1) msg+=', ';
      }
    }
    if (obj.data.T6_FLAG=="1") {
      msg += '<br>Score: '+obj.data.T6_SCORE;
    }

    msg += '<br><br><table class="table-badge"><tr><th>LOGO</th><th>Ex Pic</th></tr><tr><td><img  width="250" height="250" class="img-rounded" src="images/badges/logo_'+ID+'.jpg" alt="">';
    msg += '</td><td><img  width="250" height="250" class="img-rounded" src="images/badges/ex_'+ID+'.jpg" alt=""></td></tr></table>';


    bootbox.dialog({
      title: 'Badge ('+NAME+')',
      message: msg,
      buttons: {
        success: {
          label: "Close",
          className: "btn-success",
        }
      }
    });
  });
}

function showLocation(id) {
  $.get("module/frontend/search.php?option=location&keyword="+id, function(result) {
    var obj = jQuery.parseJSON(result);
    msg = "";

    ID = obj.data.ID;
    NAME = obj.data.NAME;
    DETAIL = obj.data.DETAIL;
    LAT = obj.data.LATITUDE;
    LNG = obj.data.LONGITUDE;

    msg += DETAIL + "<br><a href='map.php?name="+NAME+"&lat="+LAT+"&lng="+LNG+"' TARGET='_blank'>See Map</a>";
    msg += '<br><br><table class="table-badge"><tr><th>Ex. Picture</th></tr><tr><td><img  width="250" height="250" class="img-rounded" src="images/locations/'+ID+'.jpg" alt="">';
    msg += '</td></tr></table>';

    bootbox.dialog({
      title: 'Location ('+NAME+')',
      message: msg,
      buttons: {
        success: {
          label: "Close",
          className: "btn-success",
        }
      }
    });
  });
}

function showThing(id) {
  $.get("module/frontend/search.php?option=thing&keyword="+id, function(result) {
    var obj = jQuery.parseJSON(result);
    msg = "";

    ID = obj.data.ID;
    NAME = obj.data.NAME;
    DETAIL = obj.data.DETAIL;

    msg += DETAIL;
    msg += '<br><br><table class="table-badge"><tr><th>Ex. Picture</th></tr><tr><td><img  width="250" height="250" class="img-rounded" src="images/things/'+ID+'.jpg" alt="">';
    msg += '</td></tr></table>';

    bootbox.dialog({
      title: 'Thing ('+NAME+')',
      message: msg,
      buttons: {
        success: {
          label: "Close",
          className: "btn-success",
        }
      }
    });
  });
}

function showMember(id) {
  $.get("module/frontend/search.php?option=member&keyword="+id, function(result) {
    var obj = jQuery.parseJSON(result);
    msg = "";

    ID = obj.data.ID;
    NAME = obj.data.NAME;
    DETAIL = obj.data.DETAIL;

    msg += DETAIL;
    msg += '<br><br><table class="table-badge"><tr><th>Ex. Picture</th></tr><tr><td><img  width="250" height="250" class="img-rounded" src="images/things/'+ID+'.jpg" alt="">';
    msg += '</td></tr></table>';

    bootbox.dialog({
      title: 'Thing ('+NAME+')',
      message: msg,
      buttons: {
        success: {
          label: "Close",
          className: "btn-success",
        }
      }
    });
  });
}

function showTiming(id) {
  $.get("module/frontend/search.php?option=timing&keyword="+id, function(result) {
    var obj = jQuery.parseJSON(result);
    msg = "";

    ID = obj.data.ID;
    NAME = obj.data.NAME;
    DETAIL = obj.data.DETAIL;

    msg += DETAIL;
    msg += '<br><br><table class="table-badge"><tr><th>Ex. Picture</th></tr><tr><td><img  width="250" height="250" class="img-rounded" src="images/times/'+ID+'.jpg" alt="">';
    msg += '</td></tr></table>';

    bootbox.dialog({
      title: 'Timing ('+NAME+')',
      message: msg,
      buttons: {
        success: {
          label: "Close",
          className: "btn-success",
        }
      }
    });
  });
}

function showPosture(id) {
  $.get("module/frontend/search.php?option=posture&keyword="+id, function(result) {
    var obj = jQuery.parseJSON(result);
    msg = "";

    ID = obj.data.ID;
    NAME = obj.data.NAME;
    DETAIL = obj.data.DETAIL;

    msg += DETAIL;
    msg += '<br><br><table class="table-badge"><tr><th>Ex. Picture</th></tr><tr><td><img  width="250" height="250" class="img-rounded" src="images/postures/'+ID+'.jpg" alt="">';
    msg += '</td></tr></table>';

    bootbox.dialog({
      title: 'Posture ('+NAME+')',
      message: msg,
      buttons: {
        success: {
          label: "Close",
          className: "btn-success",
        }
      }
    });
  });
}
