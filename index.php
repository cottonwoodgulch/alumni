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

$page_request = isset($_GET['page_request']) ? $_GET['page_request'] : 'home';
$smarty->assign('page_request',$page_request);

switch($page_request) {
  case 'logout':
    $_SESSION = array(); // unset session variables by reinitializing $_SESSION
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
          $params["path"], $params["domain"],
          $params["secure"], $params["httponly"]
    );
    session_destroy();
    $smarty->assign('header_format','header-wrapper-edit');
    $smarty->display('login.tpl');
    break;
  case 'rosters':
    /* get all available roster years for roster lookup dropdown */
    $smarty->assign('roster_years', get_roster_years($msi));
    $smarty->assign('header_format','header-wrapper-content');
    $smarty->assign('content_format','content-wrapper-edit');
    $smarty->display('roster_members.tpl');
    break;
  case 'home':
  default:
    $smarty->assign('user',new UserData($msi,$smarty,$_SESSION['contact_id']));
    $smarty->assign('contact',
       new ContactData($msi,$smarty,$_SESSION['contact_id']));
    $tr=new RosterData($msi,$smarty,$_SESSION['contact_id']);
    $smarty->assign('roster',$tr);
       //new RosterData($msi,$smarty,$_SESSION['contact_id']));
    $smarty->assign('rostercount',$tr->roster_count);
    // use header-wrapper with space for edit box
    $smarty->assign('header_format','header-wrapper-content');
    $smarty->assign('content_format','content-wrapper-edit');
    $smarty->display('home.tpl');
    break;
}
?>