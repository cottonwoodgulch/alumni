/* js functions for dialogs on edit_contact.tpl / .php */

function getAddress() {
  $("#AddressDialog").dialog({
    height: "auto",
    width: "auto",
    closeOnEscape: true,
    buttons: [
      {
        text: "Save",
        type: "button",
        name: "buttonAction",
        value: "AddAddress",
        click: function() {
          $("#AddressDialogForm").submit();
        }
      },
      {
        text: "Cancel",
        click: function() {
          $(this).dialog("destroy");
        }
      }
    ]
  });
  //$("#add-address-type").selectmenu().appendTo("#AddressDialog");
  
};

function getPhone() {
  $("#PhoneDialog").dialog({
    height: "auto",
    width: "auto",
    closeOnEscape: true,
    buttons: [
      {
        text: "Save",
        type: "button",
        click: function() {
          $("#PhoneDialogForm").submit();
        }
      },
      {
        text: "Cancel",
        click: function() {
          $(this).dialog("destroy");
        }
      }
    ]
  });
  //$("#add-phone-type").selectmenu().appendTo("#PhoneDialog");
};

function getEmail() {
  $("#EmailDialog").dialog({
    height: "auto",
    width: "auto",
    closeOnEscape: true,
    buttons: [
      {
        text: "Save",
        type: "button",
        click: function() {
          $("#EmailDialogForm").submit();
        }
      },
      {
        text: "Cancel",
        click: function() {
          $(this).dialog("destroy");
        }
      }
    ]
  });
  //$("#add-email-type").selectmenu().appendTo("#EmailDialog");
};
