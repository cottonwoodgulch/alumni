/* js/alumni.js - javascript functions for Alumni Connections */

$(document).ready(function () {
$(".drop-down li ul").hide().removeClass("fallback");
$(".drop-down li").hover(
  function () {
    $(this).find("ul").stop().slideDown(300);
  },
  function () {
    $(this).find("ul").stop().slideUp(400);
  }
);
/* the date picker on edit_contacts page */
$("input.dob").datepicker({
  dateFormat: "mm/dd/yy"
});
/* the select dropdown that gets year, then list of groups,
     then members of that group */
console.log($('select.content').length);
$("select.content").selectmenu({
  width: 100,
  create: function (ev, ui) {
    var $el = $(this);
    var classAttr = $el.attr('class');
    $el.selectmenu('instance').menu.addClass(classAttr);
  }
});
$(".del").attr("disabled","disabled");
$("#roster_year").on("selectmenuchange",function(event, ui) {
  if(this.value >= 1926) {
    // year is passed as 0 for Select Year option
    $.ajax( {
      type: "GET",
      url: "ajax/roster.php",
      data: "year="+this.value,
      dataType: "html",
      success: function(res_html, textStatus, xhr) {
        $("#roster_group_select").html(res_html);
        $("#roster_group_selectmenu").selectmenu().on(
          "selectmenuchange",
          function(event, ui) {
            if (this.value != 0) {
            // roster_id is passed as 0 for Select Group option
            window.location.href=
              'roster_members.php?roster_id='+this.value;
            }
        });
      },
      error: function(xhr, textStatus, errorThrown) {
        $("#content").html(textStatus);
      }
    })
  }
} );
} );

function hideFooter() {
  $("#footer").hide(200);  
}
