/* lookup Trekker autocomplete
    for people.php / people.tpl / AlumLookup.php
    people.tpl only activates it when no user object is provided
*/

$("#alum_name").autocomplete({
  minLength: 3,
  delay: 500,
  source: function(request, response) {
    $.ajax({
      type: "GET",
      url: "ajax/AlumLookup.php?value="+$("#alum_name").val(),
      dataType: "json",
      success: function(res_html, textStatus, xhr) {
        response(res_html);
      },
      error: function(xhr, textStatus, errorThrown) {
        alert(textStatus+' '+errorThrown);
      }
    })
  },
  select: function(event, ui) {
    $("#alum_id").val(ui.item.value);
    $("#alum_name").val(ui.item.label);
    $("#LookupAlumForm").submit();
  }
});
