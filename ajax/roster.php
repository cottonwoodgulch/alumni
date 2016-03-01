<?php
/* roster.php
   ajax retrieve rosters for given year
*/

  include "../libe.php";
  
  /* the label and initial <td> for the select element
      that this query populates */
  $result = '<td class="label"><label for="roster_group">Group</label></td><td><select id="roster_group_selectmenu"  onchange="selectOptionLink(this.value)">'.
  '<option value="0">Select Group</option>';
  
  if(isset($_GET['year'])) {
    $year=$_GET['year'];
    if($stmt=$msi->prepare("select g.group, r.roster_id ".
       "from rosters r ".
       "left join groups g on g.group_id=r.group_id ".
       "where r.year=? and g.excluded='0' order by g.group")) {
      $stmt->bind_param('i',$year);
      $stmt->execute();
      $stmt->bind_result($group, $roster_id);
      while($stmt->fetch()) {
        $result.='<option value="'.$roster_id.'">'.$group.'</option>';
      }
      $stmt->close();
      $result .= '</select>';
      echo $result;
    }
    else {
    echo 'rosters: unable to create sql statement: '.$msi->error;
    }
  }
  else {
    echo "no year provided";
  }
?>
