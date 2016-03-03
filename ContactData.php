<?php
/* ContactData.php
   Process a change to user data
   Changes are placed in hold_xxx file for review
     before posting to live database. */
  
  function ContactData ($smarty,$msi,$contact_id) {
    $ButtonAction=$_POST['buttonAction'];
    $transtype=substr($ButtonAction,0,3);
    if($transtype=='Add') {
      switch ($ButtonAction) {
      case "AddAddress":
        $stmt=$msi->prepare("insert into hold_address values".
          "(null,'A',sysdate(),?,null,?,?,?,?,?,?,?)");
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
          "(null,'A',sysdate(),?,null,?,?)");
        $stmt->bind_param('iis',$contact_id,
          $_POST['add_phone_type'],
          $_POST['add_phone']);
        break;
      case "AddEmail":
        $stmt=$msi->prepare("insert into hold_email values ".
          "(null,'A',sysdate(),?,null,?,?)");
        $stmt->bind_param('iis',$contact_id,
          $_POST['add_email_type'],
          $_POST['add_email']);
        break;
      }
    }
    elseif($transtype=='Del') {
      // get id of item to delete
      $uloc=strrpos($ButtonAction,"_");
      $data_id=substr($ButtonAction,$uloc+1);
      $ButtonAction=substr($ButtonAction,0,$uloc);
      switch ($ButtonAction) {
      case "DeleteAddress":
        $stmt=$msi->prepare("insert into hold_address ".
            "(action,sysdate(),contact_id,address_id) values ('D',?,?)");
        if(!$stmt)echo 'no statement: '.$msi->error;
        break;
      case "DeletePhone":
        $stmt=$msi->prepare("insert into hold_phone ".
            "(action,sysdate(),contact_id,phone_id) values ('D',?,?)");
        break;
      case "DeleteEmail":
        $stmt=$msi->prepare("insert into hold_email ".
            "(action,sysdate(),contact_id,email_id) values ('D',?,?)");
        break;
      }
      $stmt->bind_param('ii', $contact_id, $data_id);
    }
    $stmt->execute();
    $stmt->close();
  }
  // elseif $transtype='Sav'
?>
