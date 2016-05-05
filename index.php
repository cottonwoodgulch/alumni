<?php

require_once 'libe.php';
require_once 'objects.php';

$cid=o_session();
/* if there is a contact_id stored in $_SESSION, we assume user has successfully logged in */
if(!$cid) {
  header("Location: login.php");
  exit;
}

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
    $smarty->display('login.tpl');
    break;
  case 'rosters':
    /* get all available roster years for roster lookup dropdown */
    $smarty->assign('roster_years', get_roster_years($msi));
    $smarty->display('roster_members.tpl');
    break;
  case 'people':
    header("location: people.php");
  break;
  case 'home':
  default:
    // users may see and edit their own data
    $smarty->assign('is_contact_viewer',true);
    $smarty->assign('is_contact_editor',true);
    $smarty->assign('user',new UserData($msi,$smarty,$_SESSION['contact_id']));
    $smarty->assign('contact',
       new ContactData($msi,$smarty,$_SESSION['contact_id']));
    $tr=new RosterData($msi,$smarty,$_SESSION['contact_id']);
    $smarty->assign('roster',$tr);
    $smarty->assign('rostercount',$tr->roster_count);
    $smarty->display('home.tpl');
    break;
}
?>
