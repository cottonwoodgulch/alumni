<?php
/* updateHold.php
   Process a change to user data
   Changes are placed in hold_xxx file for review
     before posting to live database. */
  
  function updateHold ($smarty,$msi,$user_id,$contact_id) {
    $ButtonAction=$_POST['buttonAction'];
    $transtype=substr($ButtonAction,0,3);
    $err_msg='';
    if($transtype=='Add') {
      switch ($ButtonAction) {
      case "AddAddress":
        insertPostAddress($msi,'A','add',$user_id,$contact_id,
           $err_msg);
        break;
      case "AddPhone":
        insertPostPhone($msi,'A','add',$user_id,$contact_id,
           $err_msg);
        break;
      case "AddEmail":
        insertPostEmail($msi,'A','add',$user_id,$contact_id,
           $err_msg);
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
      $stmt->execute();
      $stmt->close();
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
      $stmt->execute();
      $stmt->close();
    }
    else if($transtype=='Sav') {
      // first, UserData
      /* Delete hold_contact record for this contact_id
         if there is one. If there are changes in the
         $_POST data, a new one will be created */
      $stmt=$msi->prepare("delete from hold_contact ".
        "where contact_id=?");
      $stmt->bind_param("i",$contact_id);
      $stmt->execute();
      $stmt->close();
      $user_data=new UserData($msi,$smarty,$user_id,$contact_id);
      if(isChange($user_data->ud,0,"o")) {
        $stmt=$msi->prepare("insert into hold_contact ".
          "(contact_id,user_id,primary_name,".
          "first_name,middle_name,degree_id,nickname,".
          "birth_date,gender,username) values ".
          "(?,?,?,?,?,?,?,str_to_date(?,'%m/%d/%Y'),?,?)");
        $stmt->bind_param("iisssissss",
          $contact_id,
          $user_id,
          $_POST["primary_name"],
          $_POST["first_name"],
          $_POST["middle_name"],
          $_POST["degree_id"],
          $_POST["nickname"],
          $_POST["birth_date"],
          $_POST["gender"],
          $_SESSION['username']);
        $stmt->execute();
        $stmt->close();
      }
      unset($user_data);
      $contact_data=new ContactData($msi,$smarty,
         $user_id,$contact_id);
      saveContact($msi,$smarty,'address',$contact_data->ad,
        $user_id,$contact_id,insertPostAddress);
      saveContact($msi,$smarty,'phone',$contact_data->ph,
        $user_id,$contact_id,insertPostPhone);
      saveContact($msi,$smarty,'email',$contact_data->em,
        $user_id,$contact_id,insertPostEmail);
      unset($contact_data);
    }
    displayFooter($smarty,$err_msg);
  }
  
  function saveContact($msi,$smarty,$table,$clist,
        $user_id,$contact_id,$insertPost) {
    // echo '<pre>post: '.print_r($_POST,true).'</pre><br />';
    foreach($clist as $hx) {
      //echo '<pre>hx: '.print_r($hx).'</pre><br />';
      $data_id=$hx[$table."_id"]["v"];
      //echo 'data id: '.$data_id.'<br />';
      if($hx[$table."_id"]["c"] == "add") {
        if(isChange($hx,$data_id,"v")) {
          // delete existing A hold rec
          deleteHold($msi,$table,'A',-$data_id,$contact_id);
          // insert new one
          $insertPost($msi,'A',$data_id,$user_id,$contact_id);
        }
      }
      else {
        /* Delete any existing C hold rec, replace if necessary.
           Need to delete whether there are changes or not, in case
             the user changed back to the orig value. */
        deleteHold($msi,$table,'C',$data_id,$contact_id);
        if(isChange($hx,$data_id,"o")) {
          //echo '<pre>'.print_r($hx).'</pre>';
          //if($hx[$table."_id"]["c"] == 'change') {      }
          // insert new one
          $insertPost($msi,'C',$data_id,$user_id,$contact_id);
        }
      }
    }
  }
  
  function isChange($ud,$data_id,$val) {
    // compare $ud values to $_POST
    //echo ' in isChange: '.$data_id.', '.$val.'<br />';
    foreach($ud as $key => $lx) {
      $post_key = ($data_id == 0 ? "" : $data_id."_").$key;
      //echo ' '.$post_key.': '.$_POST[$post_key].'<br />';
      if(isset($_POST[$post_key])) {
        if($key == "number") {
          /* bad kluge - convert phone number back to only digits */
          $_POST[$post_key]=preg_replace("/[^0-9]/","",
            $_POST[$post_key]);
        }
        if($_POST[$post_key] != $ud[$key][$val]) {
          return true;
        }
      }
    }
    return false;
  }
  
  function insertPostAddress($msi,$action,$data_id,$user_id,
    $contact_id, &$err_msg)
  {
    // insert a hold_address rec from $_POST
    $stmt=$msi->prepare("insert into hold_address values ".
        "(null,?,?,?,?,?,?,?,?,?,?,?)");
    if($stmt->bind_param('isiiissssss',
      $user_id,
      $action,
      $contact_id,
      $data_id,  // address_id
      $_POST[$data_id.'_address_type_id'],
      $_POST[$data_id.'_street_address_1'],
      $_POST[$data_id.'_street_address_2'],
      $_POST[$data_id.'_city'],
      $_POST[$data_id.'_state'],
      $_POST[$data_id.'_country'],
      $_POST[$data_id.'_postal_code'])) {
    $stmt->execute();
    $stmt->close();
    }
    else
      $err_msg.='insertPostAddress prep error: '.$msi->error.' ';
  }
  
  function insertPostPhone($msi,$action,$data_id,$user_id,
    $contact_id, &$err_msg) {
    // insert a hold_phone rec from $_POST
    $stmt=$msi->prepare("insert into hold_phone values ".
        "(null,?,?,?,?,?,?,?)");
    if($stmt->bind_param('isiiiss',
      $user_id,
      $action,
      $contact_id,
      $data_id,  // phone_id
      $_POST[$data_id.'_phone_type_id'],
      preg_replace('/[^0-9]/','',$_POST[$data_id.'_number']),
      $_POST[$data_id.'_formatted'])) {
    $stmt->execute();
    $stmt->close();
    }
    else
      $err_msg.='insertPostPhone prep error: '.$msi->error.' ';
  }
  
  function insertPostEmail($msi,$action,$data_id,$user_id,
    $contact_id, &$err_msg) {
    // insert a hold_email rec from $_POST
    $stmt=$msi->prepare("insert into hold_email values ".
        "(null,?,?,?,?,?,?)");
    if($stmt->bind_param('isiiis',
      $user_id,
      $action,
      $contact_id,
      $data_id,  // email_id
      $_POST[$data_id.'_email_type_id'],
      $_POST[$data_id.'_email'])) {
    $stmt->execute();
    $stmt->close();
    }
    else
      $err_msg.='insertPostEmail prep error: '.$msi->error.' ';
  }
  
  function deleteHold($msi,$table,$action,$data_id,$contact_id) {
    /*echo 'in deleteHold, table, data_id, contact_id: '.$table.', '.
       $data_id.', '.$contact_id.'<br />';*/
    /* If it's an Add record to be deleted, $data_id is hold_id,
       If a Change rec to be deleted, $data_id is address_, phone_,
         or email_id, that is $table.'_id' */
    $id_field=$action == 'A' ? 'hold_id' : $table.'_id';
    //echo 'action, id_field: '.$action.', '.$id_field.'<br />';
    $stmt=$msi->prepare("delete from hold_".$table.
      " where action=? and ".$id_field."=? and contact_id=?");
    $stmt->bind_param("sii",$action,$data_id,$contact_id);
    $stmt->execute();
    $stmt->close();
  }
?>
