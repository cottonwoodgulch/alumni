<?php

require_once 'libe.php';
require_once 'objects.php';

$err_msg='';
if(isset($_GET['roster_id'])) {
  $roster_id = $_GET['roster_id'];
  $smarty->assign('roster_id',$roster_id);
  /* get members from this group & year */
  $rmd = new RosterMemberData($msi,$smarty,$roster_id);
  $smarty->assign('roster_members',$rmd);
  /* get other expeditions this year */
  $smarty->assign('this_year',
     get_expeditions($msi,$rmd->roster_year,$err_msg));
  /* get previous year expeditions */
  $smarty->assign('last_year',
     get_expeditions($msi,$rmd->roster_year-1,$err_msg));
  /* get next year expeditions */
  $smarty->assign('next_year',
     get_expeditions($msi,$rmd->roster_year+1,$err_msg));
}
/* else just show roster lookup form (template handles this) */
displayFooter($smarty,$err_msg);
$smarty->display('roster_members.tpl');


function get_expeditions($msi, $year,&$err_msg) {
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
    $err_msg.='get_expeditions: unable to create sql statement: '.
    $msi->error.' ';
  }
  return $this_year;
}
?>
