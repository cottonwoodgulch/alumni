<?php

require_once 'vendor/autoload.php';

/* PHP requires setting a timezone. This will be fine,
   since the app doesn't require a time */
date_default_timezone_set('America/New_York');

/* If sendmail is available, send emails immediately.
   If not, place in hold_email table for later release */
$on_line=true;
$email_direct=false;

$smarty = new Smarty();
$smarty->addTemplateDir(__DIR__ . '/templates');
$smarty->addPluginsDir(__DIR__ . '/plugins');

session_start();
if(isset($_SESSION['user_id'])) {
  $user_id=$_SESSION['user_id'];
  $smarty->assign('user_id',$user_id);
  $smarty->assign('HelloName',$_SESSION['HelloName']);
}
else {
  $user_id=0;
  if(!isset($login)) {
    header("Location: login.php");
  }
}

/* Set permissions.
   Viewer can see everyone's information, and suggest changes
   Editor can see info, and release suggested changes to live db
   Everyone can suggest changes to their own info -
     user_id == contact_id in people.tpl & edit_contact.tpl
*/
$rbac = new PhpRbac\Rbac();
$smarty->assign('is_contact_viewer',
  $rbac->Users->hasRole('Contact Information Viewer',$user_id));
$is_contact_editor=
   $rbac->Users->hasRole('Contact Information Editor',$user_id);
$smarty->assign('is_contact_editor',$is_contact_editor);

// database connection
include 'config.php';
$msi = new mysqli($db_host, $db_user, $db_pw, $db_db);

$sitemenu=array(array('d' => 'Home','t' => 'home'),
                array('d' => 'Rosters','t' => 'rosters'),
                array('d' => 'People', 't' => 'people'));
if($is_contact_editor && $on_line) {
  $sitemenu[]=array('d' => 'Release', 't' => 'release');
  if($on_line) {
    $sitemenu[]=array('d' => 'Release E-Mail','t' => 'email_release');
  }
  $sitemenu[]=array('d' => 'Campaign','t' => 'campaign');
}
$smarty->assign('sitemenu',$sitemenu);

function displayFooter($smarty,$err_msg) {
  /* footer will display if the smarty variable footer is set */
  if(strlen(trim($err_msg)) > 0) {
    $msg='<table><tr>
      <td class="footermsg">'.$err_msg.
      '</td><td class="footermsg"><button type="button" '.
      'onClick="hideFooter();">Close</button></td></tr></table>';
    $smarty->assign('footer',$msg);
  }
}

function getTypes($msi,$smarty) {
  getTypeData($msi,$smarty,'title',true,'where deprecated=0');
  getTypeData($msi,$smarty,'degree',true);
  getTypeData($msi,$smarty,'address_type');
  getTypeData($msi,$smarty,'phone_type');
  getTypeData($msi,$smarty,'email_type',false,
      'where email_type_id<3');
}

function getTypeData($msi,$smarty,$item,$allow_blank=false,
      $filter="") {
  if($stmt=$msi->prepare("select ".$item."_id, ".$item.
       " from ".$item."s ".$filter)) {
    $stmt->execute();
    $result=$stmt->get_result();
    $items=array();
    while($tx = $result->fetch_assoc()) {
      $items[] = $tx;
    }
    $stmt->close();
    $result->free();
    if($allow_blank) {
      /* create a blank for no title */
      $items[]=array($item."_id" => 0, $item => '');
    }
    $smarty->assign($item."s",$items);
  }
}

?>
