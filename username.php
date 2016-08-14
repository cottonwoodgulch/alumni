<?php

/*
  username.php - create username and initial password  
*/

require_once 'libe.php';
require_once 'objects.php';

$is_error=false;
$err_msg='';
if(isset($_POST['contact_id'])) {
  $alum_id=$_POST['contact_id'];
  $alum=new UserData($msi,$smarty,$user_id,$alum_id);
  $smarty->assign('alum',$alum);
}
else {
  $is_error=true;
  $err_msg.='No contact id ';
}

if(!$is_error) {
  if(isset($_POST['buttonAction'])) {
    // Save button clicked
    $username=$_POST['username'];
    $password=$_POST['pw'];
    // check that username is not in use
    if(nameAvailable($msi,$username,$is_error,$err_msg)) {
      $phpass = new PasswordHash(12, false);
      $pwhash=$phpass->HashPassword($password);
      if(!$stmt=$msi->prepare('update contacts set username=?,password=?,'.
         'password_reset=0 where contact_id=?')) {
        $is_error=true;
        $err_msg.="set username prep error: ".$msi->error.' ';
      }
      if(!$is_error) {
        if(!$stmt->bind_param('ssi',$username,$pwhash,$alum_id)) {
          $is_error=true;
          $err_msg.="set username bind param error: ".$msi->error.' ';
        }
      }
      if(!$is_error) {
        if(!$stmt->execute()) {
          $is_error=true;
          $err_msg.="set username exec error: ".$msi->error.' ';
        }
      }
      if(!$is_error) {
        $stmt->close();
        header("Location: people.php?alum_id=$alum_id");
      }
    }
    else {
      if(!$is_error) {
        // re-display
        $err_msg="User name is taken";
        $smarty->assign('username',$username);
        $smarty->assign('pw',$password);
      }
    }
  }
  else {
    // display screen to create user name
    // offer possible user name
    $tcount=1;
    $username=possibleNames($tcount,$alum);
    while(!nameAvailable($msi,$username,$is_error,$err_msg)) {
      $tcount++;
      $username=possibleNames($tcount,$alum);
    }
    $smarty->assign('username',$username);
    // default password is first_name_gulch
    $smarty->assign('pw',strtolower($alum->ud['first_name']['v']).'_gulch');
  }
}
displayFooter($smarty,$err_msg);;
$smarty->display('username.tpl');

function possibleNames($tcount,$alum) {
  switch($tcount) {
    case 1:
      // first letter of first + last
      return strtolower(substr($alum->ud['first_name']['v'],0,1).
         $alum->ud['primary_name']['v']);
      break;
    case 2:
      // first letter of first + first letter of middle + last
      return strtolower(substr($alum->ud['first_name']['v'],0,1).
             substr($alum->ud['middle_name']['v'],0,1).
             $alum->ud['primary_name']['v']);
      break;
    case 3:
      // first + last
      return strtolower($alum->ud['first_name']['v'].$alum->ud['primary_name']['v']);
      break;
    default:
      // case 1 + number
      return strtolower(substr($alum->ud['first_name']['v'],0,1).
         $alum->ud['primary_name']['v']).($tcount-3);
      break;
  }
}

function nameAvailable($msi,$username,&$is_error,&$err_msg) {
  // return true if username is not already in use
  if(!$stmt=$msi->prepare("select contact_id from contacts where username=?")) {
    $is_error=true;
    $err_msg.="nameAvailable prep error: ".$msi->error.' ';
    $stmt->close();
    return false;
  }
  if(!$stmt->bind_param('s',$username)) {
    $is_error=true;
    $err_msg.="nameAvailable bind param error: ".$msi->error.' ';
    $stmt->close();
    return false;
  }
  if(!$stmt->execute()) {
    $is_error=true;
    $err_msg.="nameAvailable exec error: ".$msi->error.' ';
    $stmt->close();
    return false;
  }
  if(!$stmt->bind_result($c_id)) {
    $is_error=true;
    $err_msg.="nameAvailable bind error: ".$msi->error.' ';
    $stmt->close();
    return false;
  }
  $result=$stmt->fetch();
  $stmt->close();
  
  if($result) {
    if(is_object($result)) {
      $result->free();
    }
    return false;
  }
  return true;
}

?>
