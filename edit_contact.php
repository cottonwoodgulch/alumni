<?php

require_once 'libe.php';

$cid=o_session();
/* if there is a contact_id stored in $_SESSION, we assume user has successfully logged in */
if(!$cid) {
  header("Location: login.php");
  exit;
}
$smarty->assign('menu',array('home','rosters'));
$smarty->assign('HelloName',$_SESSION['HelloName']);

if(isset($_POST['contact_id'])) {
  $contact_id=$_POST['contact_id'];
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
  /* need array of genders for gender select dropdown values
        need '' for null values in db
  $genders=array('Female','Male','');
  $smarty->assign('genders',$genders);*/
}
else {
  $smarty->assign('footer','No contact specified');
}

$smarty->display('edit_contact.tpl');

?>