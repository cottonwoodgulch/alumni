/* rosters.js */

$(document).ready(function () {
  slideDropDown();
} );

function getRosters(year) {
  /* Year has been selected. Retrieve groups for that year */
  if(year >= 1926) {
    // year is passed as 0 for Select Year option
    $.ajax( {
      type: "GET",
      url: "ajax/roster.php",
      data: "year="+year,
      dataType: "html",
      success: function(res_html, textStatus, xhr) {
        $("#roster_group_select").html(res_html);
        $("#roster_group").focus();
      },
      error: function(xhr, textStatus, errorThrown) {
        $("#content").html(textStatus);
      }
    })
  }
}

function selectAll(id) {
  $(id).select();
}

function selectOptionLink(roster_id) {
  /* redirect to rosters.php, which will retrieve
     members for selected year & group */
  if (roster_id != 0) {
    // roster_id is passed as 0 for Select Group option
    window.location.href='rosters.php?roster_id='+roster_id;
  }
}
