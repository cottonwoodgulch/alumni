/* js/release.js - javascript functions for release.tpl */

function changeCheck(id,change_class) {
  $(change_class).prop("checked",$(id).prop("checked"));
}
/*
function releaseLive() {
  // unselect fields with no change, add ,or delete
  $("input:checked").each(function() {
    var checkbox_name = new String($(this).attr("name"));
    // grab data type (user, address, phone, email) for update query
    var data_type=
        new String($(this).attr("class")).substring(0,1);
    var field_name = new String(checkbox_name.substring(2));
    //alert(field_name);
    if($('input[name="'+field_name+'"]').hasClass("change")) {
      setPost(checkbox_name,field_name,'change',data_type);
    }
    else if($('select[name="'+field_name+'"]').
             hasClass("change")) {
      setPost(checkbox_name,field_name,'change',data_type);
    }
    else if($('input[name="'+field_name+'"]').hasClass("add")) {
      setPost(checkbox_name,field_name,'add',data_type);
    }
    else if($('select[name="'+field_name+'"]').hasClass("add")) {
      setPost(checkbox_name,field_name,'add',data_type);
    }
    else if($('input[name="'+field_name+'"]').hasClass("del")) {
      setPost(checkbox_name,field_name,'del',data_type);
    }
    else if($('select[name="'+field_name+'"]').hasClass("del")) {
      setPost(checkbox_name,field_name,'del',data_type);
    }
    else {
      // turn off check boxes where there is no change, and remove fields
      $('input[name="'+checkbox_name+'"]').prop('checked',false);
      $('input[name="'+field_name+'"]').remove();
      $('input[name="c_'+field_name+'"]').remove();
      $('select[name="'+field_name+'"]').remove();
      $('select[name="c_'+field_name+'"]').remove();
    }
  });
}

function setPost(checkbox_name,field_name,
                 change_type,data_type) {
  // add an input with the type of change
  var che = document.createElement("input");
  che.setAttribute("name","ct_"+field_name);
  che.setAttribute("value",change_type);
  $('#release_form').append(che);
  // add an input with the type of data (user, address, phone, email)
  var dt = document.createElement("input");
  dt.setAttribute("name","dt_"+field_name);
  dt.setAttribute("value",data_type);
  $('#release_form').append(dt);
}
*/
