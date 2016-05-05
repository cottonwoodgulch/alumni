/* js/alumni.js - javascript functions for Alumni Connections */

$(document).ready(function () {
  // for old-style sliding drop-downs
  slideDropDown();
  // disable fields marked for deletion
  $(".del").attr("disabled","disabled");
});

function slideDropDown() {
  $(".drop-down li ul").hide().removeClass("fallback");
  $(".drop-down li").hover(
    function () {
      $(this).find("ul").stop().slideDown(300);
    },
    function () {
      $(this).find("ul").stop().slideUp(400);
    }
  );
}

function hideFooter() {
  $("#footer").hide(200);  
}
