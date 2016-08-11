<?php

/*
  person lookup, then show the rosters for that person, with links
*/

require_once 'libe.php';
require_once 'objects.php';

/* alum_id is the person being looked up
   user_id is the person logged in */
if(isset($_GET["alum_id"])) {
  $alum_id=$_GET["alum_id"];
  $alum=new UserData($msi,$smarty,$user_id,$alum_id);
  if(count($alum->ud) > 0) {
    /* confusing - smarty variable should be alum, but
       display_user needs it to be user */
    $smarty->assign('user',$alum);
    $smarty->assign('contact',new ContactData($msi,$smarty,
       $user_id,$alum_id));
    $tr=new RosterData($msi,$smarty,$alum_id);
    $smarty->assign('alum_name',$alum->ud['first_name']['v'].' '.
      (strlen(trim($alum->ud['middle_name']['v'])) > 0 ?
                   $alum->ud['middle_name']['v'].' ' : '').
      $alum->ud['primary_name']['v']);
    $smarty->assign('roster',$tr);
    $smarty->assign('rostercount',$tr->roster_count);
  }
}
else {
  if(strlen(trim($_POST['alum_name']))>0) {
    $alum_name=trim($_POST['alum_name']);
    $alum_list=array();
    $alum_list_count=0;
    $alum=$msi->real_escape_string($alum_name);
    if($msi->real_query(
        "select ".
        "concat_ws(' ',first_name,middle_name,primary_name) label,".
        "contact_id value from contacts where ".
        "concat_ws(' ',first_name,middle_name,primary_name) like '".
           $alum."%' ".
        "or concat_ws(' ',first_name,primary_name) like '".$alum."%' ".
        "or concat_ws(' ',nickname,primary_name) like '".$alum."%' ".
        "or concat_ws(' ',first_name,middle_name) like '".$alum."%' ".
        "or concat_ws(' ',nickname,middle_name) like '".$alum."%' ".
        "or middle_name like '".$alum."%' ".
        "or primary_name like '".$alum."%'")) {
      if($result=$msi->use_result()) {
        while($row=$result->fetch_object()) {
          $alum_list[]=$row;
          $alum_list_count++;
        }
        $result->close();
      }
    }
    if($alum_list_count>0) {
      $smarty->assign('alum_list',$alum_list);
    }
    $smarty->assign('alum_name',$alum_name);
  }
  else {
    $smarty->assign('alum_name','');
  }
  
}
$smarty->assign('referrer','people');
$smarty->display('people.tpl');

?>
