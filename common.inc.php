<?php

require_once('vendor/autoload.php');

$smarty = Battis\BootstrapSmarty\BootstrapSmarty::getSmarty();
$smarty->addTemplateDir(__DIR__ . '/templates');
$smarty->addStylesheet('/alumni/css/alumni.css');

?>
