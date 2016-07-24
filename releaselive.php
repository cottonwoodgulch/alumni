<?php
/* releaselive.php - called from release.php
   update live database with changes marked on release.tpl
*/

function releaseLive ($smarty,$msi,$user_id) {
  //echo '<pre>'.print_r($_POST,true)."</pre>";

  /* First, get the data for the fields selected for release.
     Only consider fields that have been changed.
     User fields have data_id = 'u'
     Contact fields have data_id=address_id, phone_id, or e-mail_id
       for existing items, and -hold_id for adds. */
  $contact_id=$_POST['contact_id'];
  $user_data=new UserData($msi,$smarty,$user_id,$contact_id);
  $contact_data=new ContactData($msi,$smarty,$user_id,$contact_id);
  $err_msg='';
  //echo '<pre>'.print_r($contact_data,true).'</pre>';
  //echo '<pre>'.print_r($user_data,true).'</pre>';
  $data_keys=array();
  foreach($_POST as $key => $px) {
    if(substr($key,0,1)=='s') {
      $data_type=substr($key,1,1); // a, p, e, u
      $field_name=substr($key,strpos($key,'_',3)+1);
      /*echo '<br />data type, field name: '.$data_type.'  '.
         $field_name;*/
      if($data_type == 'u') {
        $data_id='u';
        $trans_type=$user_data->getTransType($field_name);
        if($trans_type != '') {
          $val=$user_data->getVal($field_name);
          $data_keys[]=array('data_type' => $data_type,
             'data_id' => $data_id,
             'trans_type' => $trans_type,
             'field_name' => $field_name,
             'val' => $val);
        }
      }
      else {
        $data_id=substr($key,3,strpos($key,'_',3)-3);
        $trans_type=$contact_data->getTransType($data_type,$data_id,
           $field_name);
        //echo '<br />data id, trans type: '.$data_id.'  '.$trans_type;
        if($trans_type != '') {
          $val=$contact_data->getVal($data_type,$data_id,$field_name);
          $data_keys[]=array('data_type' => $data_type,
             'data_id' => $data_id,
             'trans_type' => $trans_type,
             'field_name' => $field_name,
             'val' => $val);
        }
      }
    }
  }
  //echo '<pre>'.print_r($data_keys,true).'</pre>';
  sort($data_keys);
  //echo '<pre>data keys: '.print_r($data_keys,true).'</pre>';
  
  $data_id='';
  $data_type='';
  foreach($data_keys as $px) {
    if($data_id != $px['data_id'] || $data_type != $px['data_type']) {
      if($data_id != '') {
        // update db
        setQuery($msi,$user_id,$data_type,$data_id,$contact_id,
          $trans_type,$userq,$addfields,$addvals,$changeq,$changew,
          $err_msg);
      }
      // (re-) set variables
      $data_id=$px['data_id'];
      $data_type=$px['data_type'];
      $c_count=false;
      $userq='';
      $addfields='';
      $addvals='';
      $changeq='';
      $changew=''; // where clause
    }
    $trans_type=$px['trans_type'];
    $field_name=$px['field_name'];
    $val=$px['val'];
    /*echo "<br />data_id, data_type, trans_type, field_name, val: ".
        "$data_id, $data_type, $trans_type, $field_name, $val";*/
    if($data_type=='u') {
      // user data
      if($c_count) {
        // if there is already something in the list
        $userq.=',';
      }
      if($field_name == 'birth_date') {
        $userq.=$field_name.
          "=str_to_date('$val','%m/%d/%Y')";
      }
      else {
        $userq.=$field_name."='".$val."'";
      }
    }
    else {
      // address, phone, or e-mail
      switch($trans_type) {
        case 'add':
          if($val != '') {
            if($data_type=='p' && $field_name == 'number') {
              $val=str_replace(array('(',')',' ','-'),"",$val);
            }   
            if($c_count) {
              $addfields.=',';
              $addvals.=',';
            }
            else {
              if($data_type == 'p') {
                $addfields='owner_id,formatted,';
                $addvals=$contact_id.',0,';
              }
              else {
                $addfields='owner_id,';
                $addvals=$contact_id.',';
              }
            }
            $addfields.=$field_name;
            $addvals.="'".$val."'";
          }
          break;
        case 'change':
          if($data_type == 'p' && $field_name == 'number') {
            $val=str_replace(array('(',')',' ','-'),'',$val);
          }
          if($c_count) {
            $changeq.=',';
          }
          else {
            if($data_type == 'p') {
              $changeq='formatted=0,';
            }
            else {
              $changeq='';
            }
            $changew=" where ".tableName($data_type)."_id=".$data_id;
          }
          $changeq.=$field_name."='".$val."'";
          break;
        //case 'del':
          /* delete query only uses $data_type, $data_id,
             and $contact_id, set elsewhere */
        //  break;
      }
    }
    $c_count=true;
  }
  
  setQuery($msi,$user_id,$data_type,$data_id,$contact_id,$trans_type,
      $userq,$addfields,$addvals,$changeq,$changew,$err_msg);
  unset($user_data, $contact_data);
}

function setQuery($msi,$user_id,$data_type,$data_id,$contact_id,
           $trans_type,$userq,$addfields,$addvals,$changeq,$changew,
           &$err_msg) {

  if($data_type == 'u') {
    //echo "<br />update contacts set $userq where contact_id=".$contact_id;
    if(!$msi->real_query(
       'update contacts set '.$userq.
       ' where contact_id='.$contact_id)) {
      $err_msg.='update user query 1 failed: '.$msi->error.' ';
    }
    else {
      // re-load user data. If no changes left, delete hold_user rec
      $u_d=new UserData($msi,$smarty,$user_id,$contact_id);
      /* if all changes from this hold_user rec have been released,
         delete the hold rec */
      if(no_change($u_d->ud)) {
        if(!$msi->real_query(
           "delete from hold_contact where contact_id=$contact_id")) {
          $err_msg.='update user query 2 failed: '.$msi->error.' ';
        }
      }
      //echo '<pre>'.print_r($u_d,true).'</pre>';
      unset($u_d);
    }
  }
  else {
    // address, phone, or e-mail
    switch($trans_type) {
      case 'add':
        $msi->autocommit(false);
        if($msi->real_query(
             'insert into '.tableName($data_type,'s').
             '('.$addfields.') values ('.$addvals.')')) {
          if($msi->real_query(
             'insert into '.tableName($data_type,'a').
             ' (contact_id,'.tableName($data_type).'_id)'.'
             values('.$contact_id.','.$msi->insert_id.')')) {
            if(delHold($msi,$smarty,$user_id,$contact_id,
                $data_type,'hold_id',-$data_id,$err_msg)) {
              $msi->commit();
            }
            else {
              $msi->rollback();
            }
          }
          else {
            $err_msg.='add query 2 failed: '.$msi->error.' ';
          }
        }
        else {
          $err_msg.='add query 1 failed: '.$msi->error.' ';
        }
        break;
      case 'change':
        /*echo "<br />update ".tableName($data_type,'s').
           " set $changeq$changew";*/
        if(!$msi->real_query(
           'update '.tableName($data_type,'s').
           ' set '.$changeq.$changew)) {
          $err_msg.='change query failed: '.$msi->error.' ';
        }
        else {
          delHold($msi,$smarty,$user_id,$contact_id,
              $data_type,tableName($data_type,'i'),$data_id,$err_msg);
        }
        break;
      case 'del':
        echo '<br />select count(*) from '.
           tableName($data_type,'a').
           ' where '.tableName($data_type,'i').'='.$data_id;
        if(!$msi->real_query('select count(*) from '.
           tableName($data_type,'a').
           ' where '.tableName($data_type,'i').'='.$data_id)) {
          $err_msg.='del count query failed: '.$msi->error.' ';
        }
        else {
          if(!($result=$msi->use_result())) {
            $err_msg.='del count result invalid ';
          }
          else {
            $row=$result->fetch_row();
            $result->free();
            $msi_error=false;
            $msi->autocommit(false);
            if($row[0]<=1) {
              // only 1 contact_id is associated with this item,
              //   ok to delete the item
              /*echo '<br />delete from '.tableName($data_type,'s').
                 ' where '.tableName($data_type,'i').'='.$data_id; */
              if(!$msi->real_query(
                 'delete from '.tableName($data_type,'s').
                 ' where '.tableName($data_type,'i').'='.$data_id)) {
                $err_msg.='del delete item failed: '.$msi->error.' ';
                $msi_error=true;
              }
            }
            if(!$msi_error) {
            // in any case, delete the association rec
              /*echo "<br />delete from ".tableName($data_type,'a').
                 ' where contact_id='.$contact_id.
                 ' and address_id='.$data_id;*/
              if(!$msi->real_query(
                 'delete from '.tableName($data_type,'a').
                 ' where contact_id='.$contact_id.
                 ' and address_id='.$data_id)) {
                $err_msg.='del delete association failed: '.
                  $msi->error.' ';
                $msi_error=true;
              }
            }
            if(!$msi_error && delHold($msi,$smarty,$user_id,
               $contact_id,$data_type,
               tableName($data_type,'i'),$data_id,$err_msg)) {
              //echo '<br />committing';
              $msi->commit();
            }
            else {
              //echo '<br />rolling back';
              $msi->rollback();
            }
            $msi->autocommit(true);
          }
        }
        break;
    }  // switch
  }
  return true;
}

function tableName($data_type,$table_type='') {
  /* table_type:
      a -associations
      blank - field name {address, phone, email}
      s - table name {addresses, phones, emails}
      h - hold {hold_address...}
      i - <table>_id {address_id... } */
  switch($data_type) {
    case 'a':
      $t='address';
      $suffix='e';
      break;
    case 'p':
      $t='phone';
      $suffix='';
      break;
    case 'e':
      $t='email';
      $suffix='';
    break;
  }
  switch($table_type) {
    case 'a':
      return $t.'_associations';
      break;
    case 's':
      return $t.$suffix.'s';
      break;
    case 'h':
      return 'hold_'.$t;
      break;
    case 'i':
      return $t.'_id';
      break;
    default:
      return $t;
      break;
  }
}

function delHold($msi,$smarty,$user_id,$contact_id,
     $data_type,$id_field,$data_id,&$err_msg) {
  /* delete the hold_address, _phone, or _email rec */
  $u_c=new ContactData($msi,$smarty,$user_id,$contact_id);
  switch($data_type) {
    case a:
      $da = & $uc->ad;
      break;
    case p:
      $da = & $uc->ph;
      break;
    case e:
      $da = & $uc->em;
      break;
  }
  $no_change=true;
  foreach($da as $ux) {
    if($ux['c'] != '') {
      $no_change=false;
    }
  }
  if($no_change) {
    /*echo '<br />no changes left - deleting hold '.
        'data_id: '.$data_id;*/
    /*echo '<br />delete from '.tableName($data_type,'h').
      " where contact_id=$contact_id and $id_field=$data_id";*/
    $msi_error=false;
    if(!$msi->real_query(
      'delete from '.tableName($data_type,'h').
      " where contact_id=$contact_id and $id_field=$data_id")) {
      $err_msg="data type $data_type delete hold query failed: ".
         $msi->error.' ';
      $msi_error=true;
    }
  }
  //echo '<pre>'.print_r($da,true).'</pre>';
  unset($da, $u_c);
  /* return NOT $msi_error, so delHold will return true on success */
  return !$msi_error;
}
?>
