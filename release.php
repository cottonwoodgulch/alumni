<?php
/* release.php */

require_once 'libe.php';
if(!$is_contact_editor) {
  header("Location: notauthorized.php");
}

require_once 'objects.php';
require_once 'releaselive.php';

$err_msg='';
if(isset($_POST['buttonAction'])) {
  /* this page re-load was initiated by a button */
  if($_POST['buttonAction'] == "edit") {
    /* Referred by edit contact screen, which was used to 
       do further edits to the contact data.
       Subtract 1 to get same contact. */
    $previous_contact=$_POST['contact_id']-1;
  }
  else {
    $previous_contact=$_POST['contact_id'];
    if($_POST['buttonAction'] == "release") {
      // Release Checked fields to live database
      //echo '<pre>'.print_r($_POST,true)."</pre>";
      $err_msg.=releaseLive($smarty,$msi,$user_id);
      //echo '<pre>'.print_r($_POST,true)."</pre>";
    }
  }
}
else {
  /* page being loaded for the first time, start with
     first proposed change */
  $previous_contact=0;
}
/* if submitted from this form, retrieve next proposed
   change, else start with first */
if($msi->real_query(
    "select hx.contact_id from ".
        "(select contact_id from hold_contact ".
        "union select contact_id from hold_address ".
        "union select contact_id from hold_phone ".
        "union select contact_id from hold_email ".
        "order by contact_id) hx ".
        "where contact_id>$previous_contact limit 1")) {
  $result=$msi->use_result();
  if($result && $row=$result->fetch_row()) {
    $result->free();
    /*$x=new UserData($msi,$smarty,$user_id,$row[0]);
    echo print_r($x);*/
    $smarty->assign('user',new UserData($msi,$smarty,
       $user_id,$row[0]));
    /*$x=new ContactData($msi,$smarty,$user_id,$row[0]);
    echo '<pre>'.print_r($x,true).'</pre>';*/
    $smarty->assign('contact',new ContactData($msi,$smarty,
       $user_id,$row[0]));
    
  }
  else {
    $smarty->assign('endmessage',
      $previous_contact==0 ?
         "No changes to be released" :
         "No more changes to be released");
  }
}
else {
  $err_msg.='release query failed: '.$msi->error.' ';
}
displayFooter($smarty,$err_msg);
$smarty->assign("localmenu",1);
$smarty->assign("changeclasses",1);
$smarty->display('release.tpl');
?>
