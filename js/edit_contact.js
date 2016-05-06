/* rosters.js */

$(document).ready(function () {
  slideDropDown();
  /* the date picker on edit_contacts page */
  $("input.dob").datepicker({
    dateFormat: "mm/dd/yy"
  });
  $(".del").attr("disabled","disabled");

} );
