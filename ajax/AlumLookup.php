<?php
/* lookup Trekker by name for people.php / LookupAlum.js */
require_once "../libe.php";

class SF {
  public $label;
  public $value;
  function __construct($l,$v) {
    $this->label=$l;
    $this->value=$v;
  }
}

//$_GET['value']='thomas tom beal hyde';

$ErrMsg='';
if(isset($_GET['value'])){
  $query="select concat_ws(' ',c.first_name,".
     "if(isnull(c.nickname) || length(c.nickname)<1,'',concat('\"',c.nickname,'\"')),".
     "c.middle_name,c.primary_name,d.degree) name, contact_id ".
     "from contacts c left join degrees d on d.degree_id=c.degree_id where ";
    $st=explode(' ',strtolower($_GET['value']));
    $is_first=true;
    foreach($st as $wx) {
      if(!$is_first) $query.=' && ';
      $wx="'".$wx."%'";
      $query.="(lower(c.first_name) like $wx || lower(c.middle_name) like $wx || ".
        "lower(c.nickname) like $wx || lower(c.primary_name) like $wx)";
      $is_first=false;
    }
    //echo "query: $query\n\n\n";
    if(!$result=$msi->query($query)) {
      $ErrMsg=buildErrorMessage($ErrMsg,'unable to execute look up member query'.
         $msi->error);
      goto sqlerror;
    }
    while($rx=$result->fetch_row()) {
      $retval[]=new SF($rx[0],$rx[1]);
    }
    $result->free();
    echo json_encode($retval);
}
else {
  $ErrMsg=buildErrorMessage($ErrMsg,'no value provided');
}
sqlerror:
if(strlen($ErrMsg)) {
  echo $ErrMsg;
}
?>
