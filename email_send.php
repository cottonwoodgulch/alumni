<?php
/* email_send.php
   This file does both "Invite" and "Send Mail" from Rosters and
     People pages, and processes outgoing messages.
   Send.tpl and invite.tpl both extend email.tpl. They contain the
   reply-to and address sections of the message, and email.tpl
   handles the subject & message body.
   If user pushes cancel, need roster_id to return to correct
    roster page. Rosters page sends by GET, email by POST */

require_once 'libe.php';
require_once 'objects.php';

$err_msg='';
$referrer=$_GET['referrer'];
$email_type=$_GET['email_type'];
$smarty->assign('email_type',$email_type);
$target_id=$_GET['target_id'];
$smarty->assign('target_id',$target_id);
$roster_id=$_POST['roster_id'];

if($referrer == 'email') {
  /* Check & send e-mail. Requires replyto, to, subject, message */
  $target_first_name=$_POST['target_first_name'];
  $smarty->assign('target_first_name',$target_first_name);
  $target_name=$_POST['target_name'];
  $smarty->assign('target_name',$target_name);
  $user_first_name=$_POST['user_first_name'];
  $smarty->assign('user_first_name',$user_first_name);
  $replyto=isset($_POST["replyto"]) ? trim($_POST["replyto"]) : '';
  if(strlen(trim($replyto)) < 1) {
    $err_msg.=
    "Please enter your e-mail address for $target_first_name to reply. ";
  }
  $smarty->assign('replyto',$replyto);
  if($email_type == 'invite') {
    $to=isset($_POST["to"]) ? trim($_POST["to"]) : '';
    if(strlen(trim($to)) < 1) {
      $err_msg.=
        "Please enter $target_first_name's e-mail address. ";
    }
    $smarty->assign('to',$to);
  }
  $subject=isset($_POST["subject"]) ? trim($_POST["subject"]) : '';
  if(strlen(trim($subject)) < 1) {
    $err_msg.=
      'Please provide a subject line (mention Cottonwood Gulch). ';
  }
  else {
    $smarty->assign('subject',$subject);
  }
  $message=isset($_POST["message"]) ? $_POST["message"] : '';
  if(trim($message) == '') {
    $err_msg.='Message text is required. ';
  }
  if(strlen($err_msg) < 1) {
    /* All ok, send message and go back to roster screen.
       $on_line is set in libe.php to indicate if messages can
       be sent immediately, or should be placed in the hold_msg
       and hold_target tables.
    if the e-mail address is not in the db for the contact_id,
      checkHold creates a hold_email rec. $replyto defaults to 
      the user's email, but the user can change it. 
    Using ContactData object here to prevent creating multiple
      hold_email recs */
    $user_contact_data=new ContactData($msi,$smarty,$user_id,$user_id);
    checkHold($msi,$user_id,$user_contact_data,$replyto,$err_msg);
    unset($user_contact_data);
    if($on_line) {
      $target_contact_data=new ContactData($msi,$smarty,$user_id,
           $target_id);
      $mailHeader="From: $replyto\r\n";
      $mailHeader.="Reply-To: $replyto\r\n";
      $mailHeader .= "X-Mailer: www.cottonwoodgulch.org\r\n";    
      $mailHeader .= "X-ID: $user_id\r\n";
      $mailHeader .= "Bcc: jtbhyde@gmail.com\r\n";	
      $mailParams="-f$replyto";
      if($email_type=='send') {
        // get target e-mail address(es) from the db
        foreach($target_contact_data->em as $ex) {
          mail($ex['email']['v'],$subject,$message,$mailHeader,
             $mailParams);
        }
      }
      else {
        // invite - user provided target e-mail address
        mail($to,$subject,$message,$mailHeader,$mailParams);
        checkHold($msi,$user_id,$target_contact_data,$to,$err_msg);
      }
      unset($target_contact_data);
    }
    else {
      $msi->autocommit(false);
      $msi_error=false;
      if(!$stmt=$msi->prepare("insert into hold_msg ".
         "(msg_type,user_id,target_id,user_email,subject,message) ".
         "values (?,?,?,?,?,?)")) {
        $err_msg.='Prep hold msg insert error: '.$msi->error.' ';
        $msi_error=true;
      }
      if(!$msi_error && !$stmt->bind_param('siisss',
          $email_type,$user_id,$target_id,$replyto,$subject,$message)) {
        $err_msg.='Hold msg insert bind param error: '.$msi->error.' ';
        $msi_error=true;
      }
      if(!$msi_error) {
        $stmt->execute();
        $hold_msg_id=$msi->insert_id;
        $stmt->close();
        $target_contact_data=new ContactData($msi,$smarty,$user_id,
             $target_id);
        if($email_type=='send') {
          // get target e-mail address(es) from the db
          foreach($target_contact_data->em as $ex) {
            if(!$msi->real_query('insert into hold_target '.
              '(hold_msg_id,target_email) values '.
              "($hold_msg_id,'".$ex['email']['v']."')")) {
              $err_msg.='Send: Hold target insert error: '.
                $msi->error.' ';
                $msi_error=true;
              break;
            }
          }
        }
        else {
          // invite - user provided target e-mail address
          if(!$stmt=$msi->prepare('insert into hold_target '.
            "(hold_msg_id,target_email) values ($hold_msg_id,?)")) {
            $err_msg.='Prep invite hold target insert error: '.
              $msi->error.' ';
            $msi_error=true;
          }
          if(!$msi_error) {
            if(!$stmt->bind_param('s',$to)) {
              $err_msg.='Invite hold target insert bind param error: '.
                $msi->error.' ';
              $msi_error=true;
            }
            else {
              $stmt->execute();
              $stmt->close();
              if(!checkHold($msi,$user_id,$target_contact_data,
                  $to,$err_msg)) {
                $msi_error=true;
              }
            }
          }
        }
        unset($target_contact_data);
        if($msi_error) {
          $msi->rollback();
        }
        else {
          $msi->commit();
        }
        $msi->autocommit(true);
      }
      if(strlen(trim($err_msg)) < 1) {
        header("Location: rosters.php?roster_id=$roster_id ");
      }
    } // on_line
  }
  // else, error, display messages in footer on email_send.tpl
}

else {
  // display screen to create e-mail message

  /* get user's name and if there is one, e-mail */
  $user_data=new UserData($msi,$smarty,$user_id,$user_id);
  $user_name=$user_data->ud['first_name']['v'].' '.
       $user_data->ud['middle_name']['v'].' '.
       $user_data->ud['primary_name']['v'];
  $user_first_name=$user_data->ud['first_name']['v'];
  $smarty->assign('user_name',$user_name);
  unset($user_data);
  /* get user's (=sender's) e-mail address for reply-to
     if more than one, just get the first - user can change it */
  if($stmt=$msi->prepare("select e.email ".
        "from email_associations ea ".
        "inner join emails e on e.email_id=ea.email_id ".
        "where ea.contact_id=? limit 1")) {
    $stmt->bind_param('i',$user_id);
    $stmt->execute();
    $stmt->bind_result($user_email);
    if(!$stmt->fetch()) {
      /* if no e-mail address for user in system, leave blank -
         form will add a placeholder */
      $user_email='';
    }
    $stmt->close();
    $smarty->assign('replyto',$user_email);
    if($email_type == 'invite') {
      $smarty->assign('to','');
    }
  }
  else {
    $err_msg.='User e-mail: unable to create mysql statement object: '.
      $msi->error;
  }
  $smarty->assign('subject',$user_name.' contacting you via Cottonwood Gulch');
  $target_user_data=new UserData($msi,$smarty,$user_id,$target_id);
  $smarty->assign('target_name',
    $target_user_data->ud['first_name']['v'].' '.
    $target_user_data->ud['primary_name']['v']);
  $smarty->assign('target_first_name',
     $target_user_data->ud['first_name']['v']);
  
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
    "left join groups g on g.group_id=r.group_id ".
    "where g.excluded='0'")) {
    $stmt->bind_param('ii',$target_id,$user_id);
    $stmt->execute();
    $result=$stmt->get_result();
    while($r = $result->fetch_assoc()) {
      $ric[] = $r;
      $ric_count++;
    }
    $stmt->close();
    $result->free();
    $message.='Dear '.(strlen($target_user_data->ud['nickname']['v'])>0 ?
       $target_user_data->ud['nickname']['v'] :
       $target_user_data->ud['first_name']['v']).',

';
    if($ric_count > 0) {
      $message.='We were on the ';
      $ix=1;
      foreach($ric as $rx) {
        $message.=$rx['year'].' '.$rx['group'];
        if($ric_count>1) {
          if($ix<$ric_count-1) {
            $message.=', ';
          }
          else if($ix==$ric_count-1) {
            $message.=' and ';
          }
        }
        $ix++;
      }
      $message.=' together, and I am re-connecting with some of my '.
         'friends from that era...
';
    }
    else {
      $message.="We weren't on any groups together, but I remember you ...
";
    }
    $message.='
This message is coming via the Cottonwood Gulch system, but if you respond, it will come directly back to me.
  
Hope to hear from you.
  
Yours, 
'.$user_first_name;
  }
  else {
    $err_msg.=
      'Rosters-in-common: unable to create mysql statement object: '.
      $msi->error;
  }
  $roster_id=$_GET['roster_id'];
}

displayFooter($smarty,$err_msg);
$smarty->assign('roster_id',$roster_id);
$smarty->assign('message',$message);
$smarty->display($email_type.'.tpl');

function checkHold($msi,$user_id,$contact_data,$email,&$err_msg) {
  // if $email isn't in db for $contact_id, create hold_email rec
  foreach($contact_data->em as $ex) {
    if($ex['email']['v'] == $email) {
      return true;
    }
  }
  if(!$stmt=$msi->prepare('insert into hold_email '.
    '(user_id,action,contact_id,email_id,email_type_id,email) '.
    "values (?,'A',?,0,3,?)")) {
    $err_msg.='checkHold prep insert error: '.$msi->error.' ';
    return false;
  }
  if(!$stmt->bind_param('iis',$user_id,
      $contact_data->contact_id,$email)) {
    $err_msg.='checkHold bind param error: '.$msi->error.' ';
    return false;
  }
  if(!$stmt->execute()) {
    $err_msg.='checkHold exec error: '.$msi->error.' ';
    return false;
  }
  return true;
}
?>
