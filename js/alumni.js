/* js/alumni.js - javascript functions for Alumni Connections */

function getRosters(year) {
  /*var SearchVal = $(searchValField).val();
  $("#content").html("<p>Search Value: "+SearchVal+"</p>");*/
  if(year >= 1926) {
    // year is passed as 0 for Select Year option
    $.ajax( {
      type: "GET",
      url: "ajax/roster.php",
      data: "year="+year,
      dataType: "html",
      success: function(res_html, textStatus, xhr) {
        $("#roster_group_select").html(res_html);
      },
      error: function(xhr, textStatus, errorThrown) {
        $("#content").html(textStatus);
      }
    })
  }
}

function selectOptionLink(roster_id) {
  if (roster_id != 0) {
    // roster_id is passed as 0 for Select Group option
    window.location.href='roster_members.php?roster_id='+roster_id;
  }
}
