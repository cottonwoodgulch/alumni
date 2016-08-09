<?php
/* send.php */

require_once 'libe.php';
if(!$is_contact_editor) {
  header("Location: notauthorized.php");
}

require_once 'objects.php';

/* display messages in hold_msg, one user at a time */

$err_msg='';
$previous_sender = isset($_POST['sender_id']) ?
  $_POST['sender_id'] : 0;
//echo '<pre>'.print_r($_POST,true).'</pre>';
if(isset($_POST['buttonAction'])) {
  /* this page re-load was initiated by a button */
  $data_keys=array();
  foreach($_POST as $key => $px) {
    if(substr($key,0,1)=='c') {
      // it's a checked checkbox
      $data_keys[]=substr($key,2);
    }
  }
  //echo '<br />data keys: <pre>'.print_r($data_keys,true).'</pre>';
  if($_POST['buttonAction'] == "send") {
    // get checked messages and send
    foreach($data_keys as $dx) {
      if($msi->real_query("select m.user_id,m.user_email,".
         "m.subject,m.message,t.target_email from hold_msg m ".
         "join hold_target t on t.hold_msg_id=m.hold_msg_id ".
         "where m.hold_msg_id=$dx")) {
        $result=$msi->use_result();
        while($row=$result->fetch_assoc()) {
          $mailHeader='From: '.$row['user_email']."\r\n";
          $mailHeader.='Reply-To: '.$row['user_email']."\r\n";
          $mailHeader .= "X-Mailer: www.cottonwoodgulch.org\r\n";    
          $mailHeader .= 'X-ID: '.$row['user_id']."\r\n";
          $mailHeader .= "Bcc: jtbhyde@gmail.com\r\n";	
          $mailParams='-f'.$row['user_email'];
          mail($row['target_email'],$row['subject'],$row['message'],
             $mailHeader,$mailParams);
          /*echo '<br />Sending or inviting:';
          echo '<br />to: '.$row['target_email'];
          echo '<br />header: '.$mailHeader;
          echo '<br />subject: '.$row['subject'];
          echo '<br />message: '.$row['message'];
          echo '<br />params: '.$mailParams; */
        }
        $result->free();
        $err_msg.=delMsg($msi,$dx);
      }
      else {
        $err_msg.='Send query error: '.$msi->error.' ';
      }
    }
  }
  else if($_POST['buttonAction'] == "delete") {
    // delete checked messages
    foreach($data_keys as $dx) {
      $err_msg.=delMsg($msi,$dx);
    }
  }
}
// if user clicked "next" button, just retrieve next sender's e-mails

/* retrieve next sender id */
if($result=$msi->query("select m.user_id,concat_ws(' ',".
       "cs.first_name,cs.middle_name,cs.primary_name) ".
       "from hold_msg m join contacts cs on cs.contact_id=m.user_id ".
       "where m.user_id>$previous_sender order by 1 limit 1")) {
  if($row=$result->fetch_row()) {
    $sender_id=$row[0];
    $smarty->assign('sender_id',$sender_id);
    $smarty->assign('sender_name',$row[1]);
    $result->free();
    /* retrieve e-mails */
    $emails=array();
    $email_count=0;
    if($msi->real_query("select m.hold_msg_id,m.subject,m.message,".
       "concat_ws(' ',ct.first_name,ct.middle_name,".
       "ct.primary_name) target from hold_msg m ".
       "join contacts ct on ct.contact_id=m.target_id ".
       "where m.user_id=$sender_id")) {
      $result=$msi->use_result();
      while($row=$result->fetch_assoc()) {
        $emails[$email_count++]=$row;
      }
      $result->free();
      if($email_count > 0) {
        $smarty->assign('emails',$emails);
      }
    }
    else {
      $err_msg.='Error retrieving messages: '.$msi->error.' ';
    }
  }
  else {
    $smarty->assign('endmessage',
      $previous_sender==0 ?
         "No messages to send" :
         "No more messages to send");
  }
}
else {
  $err_msg.='Error retrieving next sender: '.$msi->error.' ';
}

displayFooter($smarty,$err_msg);
$smarty->assign("localmenu",1);
$smarty->display('email_release.tpl');

function delMsg($msi,$hold_msg_id) {
  $msi_error=false;
  $msi->autocommit(false);
  if($msi->query('delete from hold_msg where hold_msg_id='.
      $hold_msg_id)) {
    if($msi->query('delete from hold_target where hold_msg_id='.
       $hold_msg_id)) {
      $msi->commit();
    }
    else {
      $msi_error=true;
      $err_msg='Hold target delete error: '.$msi->error.' ';
      $msi->rollback();
    }
  }
  else {
    $msi_error=true;
    $err_msg='Hold msg delete error: '.$msi->error.' ';
  }
  $msi->autocommit(true);
  if($msi_error) {
    return $err_msg;
  }
  return '';
}
?>
