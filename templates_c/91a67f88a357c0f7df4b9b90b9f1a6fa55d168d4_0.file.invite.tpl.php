<?php
/* Smarty version 3.1.30-dev/18, created on 2016-02-06 17:42:16
  from "/var/www/html/alumni/templates/invite.tpl" */

if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.30-dev/18',
  'unifunc' => 'content_56b630786a44b5_82254494',
  'file_dependency' => 
  array (
    '91a67f88a357c0f7df4b9b90b9f1a6fa55d168d4' => 
    array (
      0 => '/var/www/html/alumni/templates/invite.tpl',
      1 => 1454779909,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:email.tpl' => 1,
  ),
),false)) {
function content_56b630786a44b5_82254494 ($_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, true);
?>


<?php 
new Block_addresses_41385239756b6307869ea41_42034196($_smarty_tpl);
?>


<?php 
new Block_submit_send_147753915356b630786a36e1_42679255($_smarty_tpl);
$_smarty_tpl->ext->_inheritance->endChild($_smarty_tpl);
$_smarty_tpl->_subTemplateRender("file:email.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 66, false);
}
/* {block 'addresses'} file:invite.tpl */
class Block_addresses_41385239756b6307869ea41_42034196 extends Smarty_Internal_Block
{
public $name = "addresses";
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<h3>Inviting <?php echo $_smarty_tpl->tpl_vars['target_user_data']->value->ud['first_name'];?>
 <?php echo $_smarty_tpl->tpl_vars['target_user_data']->value->ud['primary_name'];?>
</h3>
<form><table class="edit">
  <tr><td class="label"><label for="replyto">Reply-to:</label></td>
    <td><input id="replyto" name="replyto" type="text" size="30" autofocus
         <?php if (isset($_smarty_tpl->tpl_vars['user_email']->value)) {?>
           value="<?php echo $_smarty_tpl->tpl_vars['user_email']->value;?>
" />
         <?php } else { ?>
           placeholder="&lt;Your e-mail address&gt;" /> you need to supply your e-mail address for <?php echo $_smarty_tpl->tpl_vars['target_user_data']->value->ud['first_name'];?>
 
           <?php echo $_smarty_tpl->tpl_vars['target_user_data']->value->ud['primary_name'];?>
 to reply
         <?php }?>
    </td>
  </tr>
  <tr><td class="label"><label for="to">To:</label></td>
    <td><input id="to" name="to" type="text" size="30"
      placeholder="&lt;<?php echo $_smarty_tpl->tpl_vars['target_user_data']->value->ud['first_name'];?>
 <?php echo $_smarty_tpl->tpl_vars['target_user_data']->value->ud['primary_name'];?>
's e-mail&gt;" /> you need to provide the e-mail address
    </td>
  </tr>
<?php
}
}
/* {/block 'addresses'} */
/* {block 'submit_send'} file:invite.tpl */
class Block_submit_send_147753915356b630786a36e1_42679255 extends Smarty_Internal_Block
{
public $name = "submit_send";
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<?php
}
}
/* {/block 'submit_send'} */
}
