<?php

require_once 'libe.php';
include 'ContactData.php';

$cid=o_session();
/* if there is a contact_id stored in $_SESSION, we assume user has successfully logged in */
if(!$cid) {
  header("Location: login.php");
  exit;
}
$smarty->assign('HelloName',$_SESSION['HelloName']);

/* contact_id has to come in via post (instead of just using $cid),
     because this page may not always be used for Edit My Data */
if(isset($_POST['contact_id'])) {
  $contact_id=$_POST['contact_id'];
  /* If ButtonAction is supplied, this is a page reset,
       which calls for data update, which is done by
       ContactData.php
     Changes are placed in hold_xxx file for review
       before posting to live database. */
  if(isset($_POST['buttonAction'])) {
    ContactData($smarty,$msi,$contact_id);
  }

  $smarty->assign('user',new UserData($msi,$smarty,$contact_id));
  $smarty->assign('contact',
       new ContactData($msi,$smarty,$contact_id));
  if($stmt=$msi->prepare("select title_id, title from titles ".
          "where deprecated=0")) {
    $stmt->execute();
    $result=$stmt->get_result();
    $titles=array();
    while($tx = $result->fetch_assoc()) {
      $titles[] = $tx;
    }
    $stmt->close();
    $result->free();
    /* create a blank for no title */
    $titles[]=array(title_id => 0, title => '');
    $smarty->assign('titles',$titles);
  }
  if($stmt=$msi->prepare("select degree_id, degree from degrees")) {
    $stmt->execute();
    $result=$stmt->get_result();
    $degrees=array();
    while($tx = $result->fetch_assoc()) {
      $degrees[] = $tx;
    }
    $stmt->close();
    $result->free();
    /* create a blank for no degree */
    $degrees[]=array(degree_id => 0, degree => '');
    $smarty->assign('degrees',$degrees);
  }
  if($stmt=$msi->prepare("select address_type_id,".
      "address_type from address_types")) {
    $stmt->execute();
    $result=$stmt->get_result();
    $address_types=array();
    while($tx = $result->fetch_assoc()) {
      $address_types[] = $tx;
    }
    $stmt->close();
    $result->free();
    $smarty->assign('address_types',$address_types);
  }
  if($stmt=$msi->prepare("select phone_type_id,".
      "phone_type from phone_types")) {
    $stmt->execute();
    $result=$stmt->get_result();
    $phone_types=array();
    while($tx = $result->fetch_assoc()) {
      $phone_types[] = $tx;
    }
    $stmt->close();
    $result->free();
    $smarty->assign('phone_types',$phone_types);
  }
  if($stmt=$msi->prepare("select email_type_id,".
      "email_type from email_types")) {
    $stmt->execute();
    $result=$stmt->get_result();
    $email_types=array();
    while($tx = $result->fetch_assoc()) {
      $email_types[] = $tx;
    }
    $stmt->close();
    $result->free();
    $smarty->assign('email_types',$email_types);
  }
}
else {
  $smarty->assign('footer','No contact specified');
}

$smarty->display('edit_contact.tpl');

?>
