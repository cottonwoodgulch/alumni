<?php
/* updateHold.php
   Process a change to user data
   Changes are placed in hold_xxx file for review
     before posting to live database. */
  
  function updateHold ($smarty,$msi,$contact_id) {
    $ButtonAction=$_POST['buttonAction'];
    $transtype=substr($ButtonAction,0,3);
    if($transtype=='Add') {
      switch ($ButtonAction) {
      case "AddAddress":
        $stmt=$msi->prepare("insert into hold_address values".
          "(null,'A',?,null,?,?,?,?,?,?,?)");
        $stmt->bind_param('iissssss',$contact_id,
          $_POST['add_address_type'],
          $_POST['add_street_address_1'],
          $_POST['add_street_address_2'],
          $_POST['add_city'],
          $_POST['add_state'],
          $_POST['add_country'],
          $_POST['add_postal_code']);
        break;
      case "AddPhone":
        $stmt=$msi->prepare("insert into hold_phone values ".
          "(null,'A',?,null,?,?)");
        $stmt->bind_param('iis',$contact_id,
          $_POST['add_phone_type'],
          $_POST['add_phone']);
        break;
      case "AddEmail":
        $stmt=$msi->prepare("insert into hold_email values ".
          "(null,'A',?,null,?,?)");
        $stmt->bind_param('iis',$contact_id,
          $_POST['add_email_type'],
          $_POST['add_email']);
        break;
      }
    }
    elseif($transtype=='Del') {
      /* If there is an A=add rec in the hold table, delete it.
         A=add recs have the data_id changed to negative.
         If not, add a D=delete rec */
      // First, get id of item to delete
      $uloc=strrpos($ButtonAction,"_");
      $data_id=substr($ButtonAction,$uloc+1);
      $ButtonAction=substr($ButtonAction,0,$uloc);
      //echo " data_id, ButtonAction: ".$data_id.", ".$ButtonAction;
      if($data_id < 0) {
        /* there is a hold_ table A=add rec for this
           address/phone/email */
        switch ($ButtonAction) {
        case "DeleteAddress":
          $stmt=$msi->prepare("delete from hold_address ".
            "where action='A' and hold_id=?");
          break;
        case "DeletePhone":
          $stmt=$msi->prepare("delete from hold_phone ".
            "where action='A' and hold_id=?");
          break;
        case "DeleteEmail":
          $stmt=$msi->prepare("delete from hold_email ".
            "where action='A' and hold_id=?");
          break;
        }
        $hold_id=-$data_id;
        $stmt->bind_param('i',$hold_id);
      }
      else {
        /* This is to delete a rec that was already in the
           live database */
        switch ($ButtonAction) {
        case "DeleteAddress":
          $stmt=$msi->prepare("insert into hold_address ".
              "(action,contact_id,address_id) ".
              "values ('D',?,?)");
          break;
        case "DeletePhone":
          $stmt=$msi->prepare("insert into hold_phone ".
              "(action,contact_id,phone_id) values ('D',?,?)");
          break;
        case "DeleteEmail":
          $stmt=$msi->prepare("insert into hold_email ".
              "(action,contact_id,email_id) values ('D',?,?)");
          break;
        }
        $stmt->bind_param('ii', $contact_id, $data_id);
      }
    }
    else if($transtype=='UnD') {
      /* undelete - delete D rec from hold table */
      // First, get id of item to delete -> $data_id
      $uloc=strrpos($ButtonAction,"_");
      $data_id=substr($ButtonAction,$uloc+1);
      $ButtonAction=substr($ButtonAction,0,$uloc);
      switch ($ButtonAction) {
      case "UnDeleteAddress":
        $stmt=$msi->prepare("delete from hold_address ".
          "where action='D' and address_id=?");
        break;
      case "UnDeletePhone":
        $stmt=$msi->prepare("delete from hold_phone ".
          "where action='D' and phone_id=?");
        break;
      case "UnDeleteEmail":
        $stmt=$msi->prepare("delete from hold_email ".
          "where action='D' and email_id=?");
        break;
      }
      $stmt->bind_param('i',$data_id);
    }
    else if($transtype=='Sav') {
      // first, UserData
      /* delete hold_contact record for this contact_id
         if there is one */
      $stmt=$msi->prepare("delete from hold_contact ".
        "where contact_id=?");
      $stmt->bind_param("i",$contact_id);
      $stmt->execute();
      $stmt->close();
        $stmt=$msi->prepare("insert into hold_contact values ".
          "(?,?,?,?,?,?,?,str_to_date(?,'%m/%d/%Y'),?,?,?)");
        $stmt->bind_param("iisssisssss",
          $contact_id,
          $_POST["title_id"],
          $_POST["primary_name"],
          $_POST["first_name"],
          $_POST["middle_name"],
          $_POST["degree_id"],
          $_POST["nickname"],
          $_POST["birth_date"],
          $_POST["gender"],
          $_POST["username"],
          $_POST["password"]);
    }
    $stmt->execute();
    $stmt->close();
    /* address */
    /* phone */
    /* e-mail */
  }
?>
