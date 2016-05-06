<?php
/* people.php
   ajax retrieve people as user types the name
*/

  include "../libe.php";

  $retval=array();

  //$_POST["alum"]='hy';
  
  if(isset($_POST['alum'])) {
    $alum=$msi->real_escape_string(trim($_POST['alum']));
    
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
        "or primary_name like '".$alum."%' limit 10")) {
      if($result=$msi->use_result()) {
        while($row=$result->fetch_object()) {
          $retval[]=$row;
        }
        $result->close();
      }
      echo json_encode($retval);
    }
    else {
      echo "bad query";
    }
  }
  else {
    echo "no text provided";
  }

?>
