<?php

require_once 'libe.php';

$cid = o_session();
if($cid) {
  /* if there is a contact_id stored in $_SESSION, we assume user has successfully logged in */
  header("Location: index.php");
  exit;
}

if(isset($_POST['username']) && isset($_POST['password'])) {
  /* check username & pw in db */
  if($stmt=$msi->prepare("select contact_id,password,first_name from contacts where lower(username)=?")) {
    $stmt->bind_param('s',$msi->real_escape_string(strtolower($_POST['username'])));
    $stmt->execute();
    $stmt->bind_result($cid, $pwhash, $HelloName);
    $stmt->fetch();
    $stmt->close();
    $phpass = new PasswordHash(12, false);
    if($phpass->CheckPassword($_POST['password'],$pwhash)) {
      $_SESSION['contact_id'] = $cid;
      $_SESSION['HelloName'] = $HelloName;
      header("Location: index.php");
      exit;
    }
    else {
      displayFooter($smarty,$message);
    }
  }
  else {
    exit("Login: unable to create mysql statement object: ".$msi->error);
  }
}

/* if we didn't have a good login re-display form */
$smarty->display('login.tpl');
?>
