<?php

class ContactData {
  /* contact info - addresses, phones, e-mails, relationships? */
  public $contact_id;
  public $address_count=0;
  public $address = array();
  public $phone_count=0;
  public $phone = array();
  public $email_count=0;
  public $email = array();
  
  function __construct($msi, $smarty, $cid) {
    $this->contact_id = $cid;
    if($stmt=$msi->prepare("select at.address_type,a.street_address_1,a.street_address_2,".
          "a.city,a.state,a.country,a.postal_code ".
          "from address_associations aa ".
          "left join addresses a on a.address_id=aa.address_id ".
          "left join address_types at on at.address_type_id=a.address_type_id ".
          "where aa.contact_id=? ".
          "order by at.rank")) {
      $stmt->bind_param('i',$cid);
      $stmt->execute();
      $result=$stmt->get_result();
      while($add = $result->fetch_assoc()) {
        $this->address[$this->address_count] = $add;
        $this->address_count++;
      }
      $stmt->close();
      $result->free();
    }
    else {
      $smarty->assign('footer',"Address: unable to create mysql statement object: ".
          $msi->error);
    }
    if($stmt=$msi->prepare("select pt.phone_type,p.number,p.formatted ".
          "from phone_associations pa ".
          "left join phones p on p.phone_id=pa.phone_id ".
          "left join phone_types pt on pt.phone_type_id=p.phone_type_id ".
          "where pa.contact_id=? ".
          "order by pt.rank")) {
      $stmt->bind_param('i',$cid);
      $stmt->execute();
      $result=$stmt->get_result();
      while($ph = $result->fetch_assoc()) {
        $this->phone[$this->phone_count] = $ph;
        $this->phone_count++;
      }
      $stmt->close();
      $result->free();
    }
    else {
      $smarty->assign('footer',"Phone: unable to create mysql statement object: ".
         $msi->error);
    }
    if($stmt=$msi->prepare("select et.email_type,e.email ".
          "from email_associations ea ".
          "left join emails e on e.email_id=ea.email_id ".
          "left join email_types et on et.email_type_id=e.email_type_id ".
          "where ea.contact_id=? ".
          "order by et.rank")) {
      $stmt->bind_param('i',$cid);
      $stmt->execute();
      $result=$stmt->get_result();
      while($em = $result->fetch_assoc()) {
        $this->email[$this->email_count] = $em;
        $this->email_count++;
      }
      $stmt->close();
      $result->free();
    }
    else {
      $smarty->assign('footer',"EMail: unable to create mysql statement object: ".
         $msi->error);
    }
  }  
}

class UserData {
  public $contact_id;
  public $ud = array();

  function __construct($msi,$smarty,$cid) {
    // retrieve info for a person
    $this->contact_id = $cid;
    if($stmt=$msi->prepare("select c.contact_id,ifnull(c.title_id,0) title_id,".
          "t.title,c.first_name,c.middle_name,c.primary_name,c.nickname,".
          "ifnull(c.degree_id,0) degree_id,d.degree,c.birth_date,c.gender ".
          "from contacts c ".
          "left join titles t on t.title_id=c.title_id ".
          "left join degrees d on d.degree_id=c.degree_id ".
          "where contact_id=?")) {
      $stmt->bind_param('i',$cid);
      $stmt->execute();
      /*$stmt->bind_result($contact_id, $title, $first_name, $middle_name, $primary_name,
          $nickname, $degree, $birth_date, $gender);*/
      $result=$stmt->get_result();
      $this->ud = $result->fetch_assoc();
      $stmt->close();
      $result->free();
    }
    else {
      $smarty->assign('footer',"UserData: unable to create mysql statement object: ".$msi->error);
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
            "left join (select c.contact_id ".
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

function get_roster_years($msi) {
  // get all the roster years in the db for the dropdown
  $roster_years = array();
  if($stmt=$msi->prepare("select distinct r.year ".
     "from rosters r ".
     "where r.year>=1926 ".
     "order by r.year")) {
    $stmt->execute();
    $stmt->bind_result($year);
    while($stmt->fetch()) {
      $roster_years[] = $year;
    }
    $stmt->close();
  }
  else {
    echo 'roster_years: unable to create sql statement: '.
    $msi->error;
  }
  return $roster_years;
}

?>