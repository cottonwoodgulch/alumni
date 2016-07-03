<?php
function smarty_modifier_formatPhone($number,$formatted) {

  if(is_null($number) || (trim($number)==''))return '';

  return $formatted ? $number : '(' . substr ($number, 0, 3) . ') ' .
      substr($number, 3, 3) . '-' . substr ($number, 6, 4) .
      (strlen ($number) > 10 ? ' x' . substr ($number, 10) : '');

}
?>
