/* js/people.js - javascript functions for Alumni Connections
     people page */

$(document).ready(function () {
  // for old-style sliding drop-downs
  slideDropDown();
  $("#alum_id").autocomplete({
    /*source: [{label: "tom", value: "695"},
             {label: "lynn", value: "224"},
             {label: "alice", value: "1259"}],*/
    source: function(request, response) {
      $.ajax( {
      type: "POST",
      url: "ajax/people.php",
      data: "alum="+request.term,
      dataType: "json",
      success: function(res_json, textStatus, xhr) {
        response(res_json);
      },
      error: function(xhr, textStatus, errorThrown) {
        $("#content").html(textStatus);
        response('');
      }
    })
    },
    select: function(event, ui) {
      $("#alum_id").val(ui.item.value);
      $("#get_alum").submit();
    },
    focus: function(event, ui) {
      event.preventDefault();
      $("#alum_id").val(ui.item.label);
    }
  });
});

