<?php

class ContactData {
  /* contact info - addresses, phones, e-mails */
  public $contact_id;
  public $ad = array();
  public $ph = array();
  public $em = array();
  private $fields=array(
    "address" =>
      "t.address_id,t.address_type_id,tt.address_type,t.street_address_1,t.street_address_2,t.city,t.state,t.country,t.postal_code",
    "phone" =>
      "t.phone_id,t.phone_type_id,tt.phone_type,t.number,t.formatted",
    "email" =>
      "t.email_id,t.email_type_id,tt.email_type,t.email");
  
  function __construct($msi, $smarty, $user_id, $cid) {
    $this->contact_id = $cid;

    $this->ad=$this->getLive($msi,$smarty,"address",$user_id);
    //'<pre>'.print_r($this->ad,true).'</pre><br />';
    /* updates from hold_address */
    $ud_hold=$this->getHold($msi,$smarty,"address");
    /* combine and note changes */
    $this->getChange($this->ad,$ud_hold,"address");
 
    $this->ph=$this->getLive($msi,$smarty,"phone",$user_id);
    $ud_hold=$this->getHold($msi,$smarty,"phone");
    //echo '<pre>'.print_r($ud_hold,true).'</pre><br />';
    $this->getChange($this->ph,$ud_hold,"phone");
    //echo '<pre>'.print_r($this->ph,true).'</pre><br />';

    $this->em=$this->getLive($msi,$smarty,"email",$user_id);
    $ud_hold=$this->getHold($msi,$smarty,"email");
    $this->getChange($this->em,$ud_hold,"email");
  }
  
  function getTransType($data_type,$data_id,$field_name) {
    switch($data_type) {
      case 'a':
        return
          $this->ad[$this->findID($data_id,$this->ad,'address_id')][$field_name]['c'];
      break;
      case 'p':
        return
          $this->ph[$this->findID($data_id,$this->ph,'phone_id')][$field_name]['c'];
      break;
      case 'e':
        return
          $this->em[$this->findID($data_id,$this->em,'email_id')][$field_name]['c'];
      break;
    }
    return '';
  }
  
  function getVal($data_type,$data_id,$field_name) {
    switch($data_type) {
      case 'a':
        return
        $this->ad[$this->findID($data_id,$this->ad,'address_id')][$field_name]['v'];
      break;
      case 'p':
        return
        $this->ph[$this->findID($data_id,$this->ph,'phone_id')][$field_name]['v'];
      break;
      case 'e':
        return
        $this->em[$this->findID($data_id,$this->em,'email_id')][$field_name]['v'];
      break;
    }
    return '';
  }
  function getChange(&$ud,$hold,$table) {
    foreach($hold as $hx) {
      switch($hx["action"]) {
        case "A":
          $ud_count=count($ud);
          foreach($hx as $key => $lx) {
            if($key == "hold_id") {
              /* set address_id to negative of hold id
                 to indicate this is an add */
              $ud[$ud_count][$table."_id"]=
                array("o" => -$lx,
                      "v" => -$lx,
                      "c" => "add"
                     );
            }
            else if($key != "action" && $key !=$table."_id") {
              $ud[$ud_count][$key]=
                array("o" => null,
                      "v" => $lx,
                      "c" => "add"
                     );
            }
          }
          $ud_count++;
        break;
        case "D":
          if(($ua=$this->findID($hx[$table."_id"],
               $ud,$table."_id")) >= 0) {
            foreach($ud[$ua] as $key => $lx) {
              $ud[$ua][$key]["c"]="del";
            }
          }
        break;
        case "C":
          if(($ua=$this->findID($hx[$table."_id"],
               $ud,$table."_id")) >= 0) {
            foreach($ud[$ua] as $key => $lx) {
              /*echo 'key, v: '.$key.', '.$ud[$ua][$key]["v"].', '.
                $hx[$key].'<br />';*/
              if($ud[$ua][$key]["v"] != $hx[$key]) {
                $ud[$ua][$key]["v"] = $hx[$key];
                $ud[$ua][$key]["c"] = 'change';
              }
            }
          }
        break;
      }
    }
  }
  
  function getHold($msi,$smarty,$table) {
    $query="select t.hold_id,t.action,t.user_id,".
      "if(c.contact_type_id=1,concat(c.first_name,' ',".
      "if(c.middle_name is null || c.middle_name='','',".
      "concat(c.middle_name,' ')),c.primary_name),c.primary_name) ".
      "user_name,".$this->fields[$table].
      " from hold_".$table." t ".
      "left join contacts c on c.contact_id=t.user_id ".
      "left join ".$table."_types tt on ".
      "tt.".$table."_type_id=t.".$table."_type_id ".
      "where t.contact_id=? order by t.action";
    //echo "table: ".$table."<br />";
    //echo $table." hold query: ".$query."<br />";

    if($stmt=$msi->prepare($query)) {
      $stmt->bind_param('i',$this->contact_id);
      $stmt->execute();
      $result=$stmt->get_result();
      $ud_hold=array();
      while($tx = $result->fetch_assoc()) {
        $ud_hold[] = $tx;
      }
      $stmt->close();
      $result->free();
      return $ud_hold;
    }
    else {
      $smarty->assign('footer',$table.": hold".
        ": unable to create mysql statement object: ".
        $msi->error);
    }
    return null;
  }

  function getLive($msi,$smarty,$table,$user_id) {
    // because addresses plural has an extra e
    $db_table=$table=="address" ? "addresse" : $table;
    $query="select '".$user_id."' user_id,'' user_name,".
      $this->fields[$table].
      " from ".$table."_associations ta ".
      "inner join ".$db_table."s t on t.".$table."_id=ta.".$table."_id ".
      "left join ".$table."_types tt on ".
      "tt.".$table."_type_id=t.".$table."_type_id ".
      "where ta.contact_id=? order by tt.rank";
    //echo "table: ".$table."<br />";
    //echo $table." live query: ".$query."<br />";

    if($stmt=$msi->prepare($query)) {
      $stmt->bind_param('i',$this->contact_id);
      $stmt->execute();
      $result=$stmt->get_result();
      $ud_count=0;
      $ud=array();
      while($tx = $result->fetch_assoc()) {
        foreach($tx as $key => $lx) {
          $ud[$ud_count][$key]=
            array("o" => $lx,
                  "v" => $lx,
                  "c" => ''
                 );
        }
        $ud_count++;
      }
      $stmt->close();
      $result->free();
      return $ud;
    }
    else {
      $smarty->assign('footer','live: '.$table.
        ": unable to create mysql statement object: ".
        $msi->error);
    }
    return null;
  }
  function findID($key,$arr,$key_field) {
    /* find which row of $arr has $key_field = $key */
    foreach($arr as $k => $v) {
      /*echo 'findID: $v[$key_field], $key: '.
         $v[$key_field]["o"].', '.$key.'<br />';*/
      if($v[$key_field]["o"] == $key) {
        //echo '<br />returning: '.$k.'<br />';
        return $k;
      }
    }
    return -1;
  }
}

class UserData {
  public $contact_id;
  public $ud = array();

  function __construct($msi,$smarty,$user_id,$cid) {
    // retrieve info for a person
    $this->contact_id = $cid;
    /* data from live data tables */
    $ud_live=$this->getLive($msi,$smarty,$user_id);
    /* updates from hold_contact */
    $ud_hold=$this->getHold($msi,$smarty,false);
    /* combine and note changes */
    if(is_null($ud_hold)) {
      // there are no changes
      foreach($ud_live as $key => $lx) {
        $this->ud[$key]=
           array("o" => $lx,
                 "v" => $lx,
                 "c" => ''
                );
      }
    }
    else {
      foreach($ud_live as $key => $lx) {
        $this->ud[$key]=
           array("o" => $lx,
                 "v" => $ud_hold[$key],
                 "c" => $ud_hold[$key] == $lx ? '' : 'change'
                );
      }
    }
    //echo print_r($this->ud).'<br /><br />';
  }
  
  function getTransType($field_name) {
    return $this->ud[$field_name]['c'];
  }
  
  function getVal($field_name) {
    return $this->ud[$field_name]['v'];
  }
  
  function getHold($msi,$smarty) {
    if($stmt=$msi->prepare("select user_id,concat(c.first_name,' ',".
          "if(c.middle_name is null || c.middle_name='','',".
          "concat(c.middle_name,' ')),c.primary_name) user_name,".
          "h.first_name,h.middle_name,h.primary_name,h.nickname,".
          "ifnull(h.degree_id,0) degree_id,".
          "d.degree,date_format(h.birth_date,'%m/%d/%Y') birth_date,".
          "ifnull(h.gender,'') gender,h.deceased,h.username ".
          "from hold_contact h ".
          "left join contacts c on c.contact_id=h.user_id ".
          "left join degrees d on d.degree_id=c.degree_id ".
          "where h.contact_id=?")) {
      $stmt->bind_param('i',$this->contact_id);
      $stmt->execute();
      $result=$stmt->get_result();
      $ud = $result->fetch_assoc();
      $stmt->close();
      $result->free();
      return $ud;
    }
    else {
      $smarty->assign('footer',
        "UserData getHold: unable to create mysql statement object: ".
        $msi->error);
    }
  }
  
  function getLive($msi,$smarty,$user_id) {
    if($stmt=$msi->prepare("select $user_id user_id,".
          "concat(c.first_name,' ',".
          "if(c.middle_name is null || c.middle_name='','',".
          "concat(c.middle_name,' ')),c.primary_name) user_name,".
          "c.first_name,c.middle_name,c.primary_name,c.nickname,".
          "ifnull(c.degree_id,0) degree_id,".
          "d.degree,date_format(c.birth_date,'%m/%d/%Y') birth_date,".
          "ifnull(c.gender,'') gender,c.deceased,c.username ".
          "from contacts c ".
          "left join degrees d on d.degree_id=c.degree_id ".
          "where contact_id=?")) {
      $stmt->bind_param('i',$this->contact_id);
      $stmt->execute();
      $result=$stmt->get_result();
      $ud = $result->fetch_assoc();
      $stmt->close();
      $result->free();
      return $ud;
    }
    else {
      $smarty->assign('footer',
        "UserData getLive: unable to create mysql statement object: ".
        $msi->error);
    }
  }
}

class RosterData {
  public $contact_id;
  public $roster_count=0;
  public $rd = array();

  function __construct($msi,$smarty,$cid) {
    // retrieve the names of the alum's rosters
    $this->contact_id = $cid;
    if($stmt=$msi->prepare("select r.roster_id,r.year,".
       "ifnull(ro.role,'') role, g.group ".
       "from roster_memberships rm left join rosters r ".
       "on r.roster_id=rm.roster_id ".
       "left join roles ro on ro.role_id=rm.role_id ".
       "left join groups g on g.group_id=r.group_id ".
       "where rm.contact_id=? ".
       "and g.excluded='0' ".
       "order by r.year desc")) {
      $stmt->bind_param('i',$cid);
      $stmt->execute();
      $result=$stmt->get_result();
      while($r = $result->fetch_assoc()) {
        $this->rd[$this->roster_count] = $r;
        $this->roster_count++;
      }
      $stmt->close();
      $result->free();
    }
    else {
      $smarty->assign('footer',
         "Rosters: unable to create mysql statement object: ".
         $msi->error);
    }
  }
}

class RosterMemberData {
  public $rostermember_count = 0;
  public $rm = array();
  public $roster_year;
  public $group_name;
  
  function __construct($msi,$smarty,$roster_id) {
    /* retrieve members of group/year $roster_id
         and if they have e-mail address */
    // first, get group name & year
    if($stmt=$msi->prepare("select g.group, r.year ".
       "from rosters r ".
       "left join groups g on g.group_id=r.group_id ".
       "where r.roster_id=?")) {
      $stmt->bind_param('i',$roster_id);
      $stmt->execute();
      $stmt->bind_result($this->group_name,$this->roster_year);
      if($stmt->fetch()) {
        $stmt->close();  // close the first statement
        /* get members of group
           if they have e-mail address, get contact_id */
        if($stmt=$msi->prepare("select c.contact_id,c.primary_name,".
            "c.first_name,c.middle_name,c.nickname,c.deceased, ".
            "ifnull(dex.contact_id,0) is_email,ro.role ".
            "from roster_memberships rm ".
            "inner join contacts c on c.contact_id=rm.contact_id ".
            "left join roles ro on ro.role_id=ifnull(rm.role_id,3) ".
            "left join (select distinct c.contact_id ".
               "from email_associations ea ".
               "inner join contacts c on c.contact_id=ea.contact_id ".
               "inner join emails e on e.email_id=ea.email_id ) dex ".
            "on dex.contact_id=c.contact_id ".
            "where rm.roster_id=? ".
            "order by ro.rank,c.primary_name,c.first_name")) {
          $stmt->bind_param('i',$roster_id);
          $stmt->execute();
          $result=$stmt->get_result();
          while($rd = $result->fetch_assoc()) {
            $this->rm[$this->rostermember_count] = $rd;
            $this->rostermember_count++;
          }
          $stmt->close();
          $result->free();
        }
        else {
          $smarty->assign('footer',
            'Roster Memberships: unable to create second mysql statement object:'. $msi->error);
        }
      }
      else {
        $smarty->assign('footer',
           'Roster Memberships: no roster for id '.$roster_id);
      }
    }
    else {
      $smarty->assign('footer',
        'Roster Memberships: unable to create first mysql statement object:'. $msi->error);
    }
  }
}
?>
