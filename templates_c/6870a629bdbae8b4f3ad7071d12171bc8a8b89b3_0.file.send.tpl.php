<?php
/* Smarty version 3.1.30-dev/18, created on 2016-02-06 17:35:36
  from "/var/www/html/alumni/templates/send.tpl" */

if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.30-dev/18',
  'unifunc' => 'content_56b62ee8481207_44555654',
  'file_dependency' => 
  array (
    '6870a629bdbae8b4f3ad7071d12171bc8a8b89b3' => 
    array (
      0 => '/var/www/html/alumni/templates/send.tpl',
      1 => 1454780134,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:email.tpl' => 1,
  ),
),false)) {
function content_56b62ee8481207_44555654 ($_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, true);
?>


<?php 
new Block_addresses_172921935756b62ee847b7f9_34813316($_smarty_tpl);
?>


<?php 
new Block_submit_send_128010983556b62ee8480409_28799284($_smarty_tpl);
$_smarty_tpl->ext->_inheritance->endChild($_smarty_tpl);
$_smarty_tpl->_subTemplateRender("file:email.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 66, false);
}
/* {block 'addresses'} file:send.tpl */
class Block_addresses_172921935756b62ee847b7f9_34813316 extends Smarty_Internal_Block
{
public $name = "addresses";
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<h3>Sending message to <?php echo $_smarty_tpl->tpl_vars['target_user_data']->value->ud['first_name'];?>
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
    <td style="height: 30px; valign: middle">Message will go to the address(es) in the database.
    </td>
  </tr>
<?php
}
}
/* {/block 'addresses'} */
/* {block 'submit_send'} file:send.tpl */
class Block_submit_send_128010983556b62ee8480409_28799284 extends Smarty_Internal_Block
{
public $name = "submit_send";
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<?php
}
}
/* {/block 'submit_send'} */
}
