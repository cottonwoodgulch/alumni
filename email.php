<?php
// invite.php

require_once 'libe.php';
require_once 'objects.php';

/* This file does both "Invite" and "Send Mail" from Rosters page.
   send.tpl and invite.tpl both extend email.tpl. They contain the
   reply-to and address sections of the message, and email.tpl
   handles the subject & message body */
$email_type=isset($_GET['email_type']) ? $_GET['email_type'] : 'invite';
$smarty->assign('email_type',$email_type);

if(isset($_GET['target_id'])) {
  $target_id=$_GET['target_id'];
  $smarty->assign('target_user_data',new UserData($msi,$smarty,
     $user_id,$target_id));
  $smarty->assign('target_contact_data',
     new ContactData($msi,$smarty,$user_id,$target_id));
  /* get rosters-in-common */
  $ric = array();
  $ric_count=0;
  $stmt=$msi->stmt_init();
  if($stmt->prepare("select r.year, g.group ".
    "from (select rm.roster_id ".
    "from roster_memberships rm ".
    "where contact_id=?) tx ".
    "inner join (select rm.roster_id ".
    "from roster_memberships rm ".
    "where contact_id=?) cx on cx.roster_id=tx.roster_id ".
    "left join rosters r on r.roster_id=tx.roster_id ".
    "left join groups g on g.group_id=r.group_id")) {
    $stmt->bind_param('ii',$target_id,$user_id);
    $stmt->execute();
    $result=$stmt->get_result();
    while($r = $result->fetch_assoc()) {
      $ric[] = $r;
      $ric_count++;
    }
    $stmt->close();
    $result->free();
    $smarty->assign('rosters_in_common',$ric);
    $smarty->assign('rosters_in_common_count',$ric_count);
    /* get user's name */
    $smarty->assign('user', new UserData($msi,$smarty,$user_id));
    /* get user's (=sender's) e-mail address for reply-to
        if more than one, just get the first - user can change it
        ?? should use ContactData object for this? */
    if($stmt=$msi->prepare("select e.email ".
      "from email_associations ea ".
      "left join emails e on e.email_id=ea.email_id ".
      "where ea.contact_id=? limit 1")) {
      $stmt->bind_param('i',$user_id);
      $stmt->execute();
      $stmt->bind_result($user_email);
      if($stmt->fetch()) {
        $smarty->assign('user_email',$user_email);
      }
      else {
        $smarty->assign('user_email','');
      }
      $stmt->close();
    }
    else {
      $smarty->assign('footer','User e-mail: '.
        'unable to create mysql statement object: '.$msi->error);
    }
    $smarty->display($email_type.'.tpl');
  }
  else {
    $smarty->assign('footer','Rosters-in-common: '.
      'unable to create mysql statement object: '.$msi->error);
  }
}
else {
    $smarty->assign('footer','No target trekker specified');
}
?>
