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

if(isset($_GET['roster_id'])) {
  $roster_id = $_GET['roster_id'];
  //$smarty->assign('roster_id',$roster_id);
  /* get members from this group & year */
  $rmd = new RosterMemberData($msi,$smarty,$roster_id);
  $smarty->assign('roster_members',$rmd);
  /* get other expeditions this year */
  $smarty->assign('this_year',
     get_expeditions($msi,$rmd->roster_year));
  /* get previous year expeditions */
  $smarty->assign('last_year',
     get_expeditions($msi,$rmd->roster_year-1));
  /* get next year expeditions */
  $smarty->assign('next_year',
     get_expeditions($msi,$rmd->roster_year+1));
  /* get all available roster years for roster lookup dropdown */
  $smarty->assign('roster_years',
     get_roster_years($msi));
}
/* else just show roster lookup form (template handles this) */
  /* get all available roster years for roster lookup dropdown */
$smarty->assign('roster_years',
   get_roster_years($msi));
$smarty->display('roster_members.tpl');


function get_expeditions($msi, $year) {
  $this_year = array();
  if($stmt=$msi->prepare("select g.group, r.roster_id ".
     "from rosters r ".
     "left join groups g on g.group_id=r.group_id ".
     "where r.year=? and g.excluded='0' ".
     "order by g.group")) {
    $stmt->bind_param('i',$year);
    $stmt->execute();
    $result=$stmt->get_result();
    while($ty = $result->fetch_assoc()) {
      $this_year[]=$ty;
    }
    $stmt->close();
    $result->free();
  }
  else {
    echo 'get_expeditions: unable to create sql statement: '.
    $msi->error;
  }
  return $this_year;
}
?>
