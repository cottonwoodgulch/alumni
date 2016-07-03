<?php
/* releaselive.php - called from release.php
   update live database with changes marked on release.tpl
*/

function releaseLive ($smarty,$msi) {
  //echo '<pre>'.print_r($_POST,true)."</pre>";

  /* First, get all the data keys. For user fields
      (contacts table), this = the column name. For contact
      fields (address, phone, email), this is the hold_id, 
      address_id, phone_id, or email_id + the column name. */
  $data_keys=array();
  foreach($_POST as $key => $px) {
    if(substr($key,0,2)=='s_') {
      $data_keys[]=substr($key,2);
    }
  }
  /* sorts on the whole key (data_id + field name) although
     we only care about the data_ids */
  sort($data_keys,SORT_STRING);
  echo '<pre>data keys: '.print_r($data_keys,true).'</pre>';

  $contact_id=$_POST['contact_id'];
  
  $data_id='';
  foreach($data_keys as $px) {
    if($data_id != substr($px,0,strpos($px,'_',1))) {
      if($data_id != '') {
        // update db
        setQuery($msi,$data_type,$data_id,$contact_id,$trans_type,
          $userq,$addfields,$addvals,$changeq,$changew);
      }
      // (re-) set variables
      $data_type=$_POST['dt_'.$px];
      $trans_type=$_POST['ct_'.$px];
      $data_id=substr($px,0,strpos($px,'_',1));
      $c_count=false;
      $userq='';
      $addfields='';
      $addvals='';
      $changeq='';
      $changew=''; // where clause
    }
    $field_name=substr($px,strpos($px,'_',1)+1);
    $val=$_POST[$px];
    echo '<br />data_id, data_type, trans_type: '.$data_id.', '.
         $data_type.', '.$trans_type;
    echo '<br />field name, val: '.$field_name.', '.$val;
    if($data_type=='u') {
      // user data
      if($c_count) {
        // if there is already something in the list
        $userq.=',';
      }
      if($field_name == 'birth_date') {
        $userq.=$field_name.
          "=str_to_date('".$_POST[$px]."','%m/%d/%Y')";
      }
      else {
        $userq.=$field_name."='".$_POST[$px]."'";
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
  
  if(setQuery($msi,$data_type,$data_id,$contact_id,$trans_type,
      $userq,$addfields,$addvals,$changeq,$changew)) {
    /* delete all hold records for this contact - assumes that
       ones that haven't been released are not to be released */
    /*if(!$msi->real_query(
       "delete from hold_contact where contact_id=$contact_id")) {
      echo '<br />del hold_contact query failed: '.$msi->error;
    }
    if(!$msi->real_query(
       "delete from hold_address where contact_id=$contact_id")) {
      echo '<br />del hold_address query failed: '.$msi->error;
    }
    if(!$msi->real_query(
       "delete from hold_phone where contact_id=$contact_id")) {
      echo '<br />del hold_phone query failed: '.$msi->error;
    }
    if(!$msi->real_query(
       "delete from hold_email where contact_id=$contact_id")) {
      echo '<br />del hold_email query failed: '.$msi->error;
    }*/
  }
}

function setQuery($msi,$data_type,$data_id,$contact_id,$trans_type,
      $userq,$addfields,$addvals,$changeq,$changew) {

  if($data_type == 'u') {
    if(!$msi->real_query(
       'update contacts set '.$userq.
       ' where contact_id='.$contact_id)) {
      echo '<br />add query 2 failed: '.$msi->error;
      return false;
    }
  }
  else {
    // address, phone, or e-mail
    switch($trans_type) {
      case 'add':
        if($msi->real_query(
             'insert into '.tableName($data_type,'s').
             '('.$addfields.') values ('.$addvals.')')) {
          if(!$msi->real_query(
             'insert into '.tableName($data_type,'a').
             ' (contact_id,'.tableName($data_type).'_id)'.'
             values('.$contact_id.','.$msi->insert_id.')')) {
            echo '<br />add query 2 failed: '.$msi->error;
            return false;
          }
        }
        else {
          echo '<br />add query 1 failed: '.$msi->error;
          return false;
        }
        break;
      case 'change':
        if(!$msi->real_query(
           'update '.tableName($data_type,'s').
           ' set '.$changeq.$changew)) {
          echo '<br />change query failed: '.$msi->error;
          return false;
        }
        break;
      case 'del':
        if(!$msi->real_query(
           'select count(*) from '.tableName($data_type,'a').
           ' where '.tableName($data_type).'_id='.$data_id)) {
          echo '<br />del count query failed: '.$msi->error;
          return false;
        }
        else {
          if($result=$msi->use_result()) {
            $row=$result->fetch_row();
            $result->free();
            if($row[0]<=1) {
              /* only 1 contact_ids is associated with this item,
                 ok to delete the item */
              if(!$msi->real_query(
                 'delete from '.tableName($data_type,'s').
                 ' where '.tableName($data_type).'_id='.$data_id)) {
                echo '<br />del delete item failed: '.$msi->error;
                return false;
              }
            }
            /* in any case, delete the association rec */
            if(!$msi->real_query(
               'delete from '.tableName($data_type,'a').
               ' where contact_id='.$contact_id.
               ' and address_id='.$data_id)) {
              echo '<br />del delete association failed: '.$msi->error;
              return false;
            }
          }
          else {
            echo '<br />del count result invalid';
            return false;
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
      blank - singular for xx_id
      s - table itself
      h - hold */
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
    default:
      return $t;
      break;
  }
}
?>
