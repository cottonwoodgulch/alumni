<?php
/* Smarty version 3.1.30-dev/18, created on 2016-02-06 17:33:48
  from "/var/www/html/alumni/templates/email.tpl" */

if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.30-dev/18',
  'unifunc' => 'content_56b62e7cf2cba0_20974352',
  'file_dependency' => 
  array (
    '81702f38699cf82839f1e453cbfc41df871a24ed' => 
    array (
      0 => '/var/www/html/alumni/templates/email.tpl',
      1 => 1454779875,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:page.tpl' => 1,
  ),
),false)) {
function content_56b62e7cf2cba0_20974352 ($_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, true);
?>


<?php 
new Block_edit_wrapper_65852923256b62e7cedfd07_36121755($_smarty_tpl);
?>


<?php 
new Block_content_34911135156b62e7cf291d4_77363040($_smarty_tpl);
?>


<?php $_smarty_tpl->ext->_inheritance->endChild($_smarty_tpl);
$_smarty_tpl->_subTemplateRender("file:page.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 66, false);
}
/* {block 'edit_wrapper'} file:email.tpl */
class Block_edit_wrapper_65852923256b62e7cedfd07_36121755 extends Smarty_Internal_Block
{
public $name = "edit_wrapper";
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'edit_wrapper'} */
/* {block 'addresses'} file:email.tpl */
class Block_addresses_213073306656b62e7cee6783_56555689 extends Smarty_Internal_Block
{
public $name = "addresses";
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<?php
}
}
/* {/block 'addresses'} */
/* {block 'submit_send'} file:email.tpl */
class Block_submit_send_49567415656b62e7cf27849_48960884 extends Smarty_Internal_Block
{
public $name = "submit_send";
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'submit_send'} */
/* {block 'content'} file:email.tpl */
class Block_content_34911135156b62e7cf291d4_77363040 extends Smarty_Internal_Block
{
public $name = "content";
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<?php 
new Block_addresses_213073306656b62e7cee6783_56555689($_smarty_tpl, $this->tplIndex);
?>

  <tr><td class="label"><label for="subject">Subject:</label></td>
    <td colspan="3"><input id="subject" name="subject"
      value="<?php echo $_smarty_tpl->tpl_vars['user']->value->ud['first_name'];?>
 <?php echo $_smarty_tpl->tpl_vars['user']->value->ud['middle_name'];?>
 <?php echo $_smarty_tpl->tpl_vars['user']->value->ud['primary_name'];?>
 contacting you via Cottonwood Gulch" size="87"/>
    </td>
  </tr>
  <tr>
  <td class="label"><label for="message">Message:</label></td>
  <td colspan="3">
  <textarea cols="100" rows="15" id="message" name="message">Dear <?php if (strlen($_smarty_tpl->tpl_vars['target_user_data']->value->ud['nickname']) == 0) {
echo $_smarty_tpl->tpl_vars['target_user_data']->value->ud['first_name'];
} else {
echo $_smarty_tpl->tpl_vars['target_user_data']->value->ud['nickname'];
}?>,

  <?php if ($_smarty_tpl->tpl_vars['rosters_in_common_count']->value > 0) {?>We were on the <?php $_smarty_tpl->_assignInScope("i", "1", null, 0, false);
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['rosters_in_common']->value, 'r');
foreach ($_from as $_smarty_tpl->tpl_vars['r']->value) {
$_smarty_tpl->tpl_vars['r']->_loop = true;
$__foreach_r_0_saved = $_smarty_tpl->tpl_vars['r'];
echo $_smarty_tpl->tpl_vars['r']->value['year'];?>
 <?php echo $_smarty_tpl->tpl_vars['r']->value['group'];
if ($_smarty_tpl->tpl_vars['rosters_in_common_count']->value > 1) {
if ($_smarty_tpl->tpl_vars['i']->value < $_smarty_tpl->tpl_vars['rosters_in_common_count']->value-1) {?>, <?php } elseif ($_smarty_tpl->tpl_vars['i']->value == $_smarty_tpl->tpl_vars['rosters_in_common_count']->value-1) {?> and <?php }
}
$_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1, null, 0, false);
$_smarty_tpl->tpl_vars['r'] = $__foreach_r_0_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?> together, and I am re-connecting with some of my friends from that era...
  <?php } else { ?>
 We weren't on any groups together, but I remember you ...
  <?php }?>
  
  This message is coming via the Cottonwood Gulch system, but if you respond, it will come directly back to me.
  
  Hope to hear from you.
  
Yours,
<?php echo $_smarty_tpl->tpl_vars['user']->value->ud['first_name'];?>
 <?php echo $_smarty_tpl->tpl_vars['user']->value->ud['middle_name'];?>
 <?php echo $_smarty_tpl->tpl_vars['user']->value->ud['primary_name'];?>

  </textarea>
  </td></tr>
  <tr><td>
  <?php 
new Block_submit_send_49567415656b62e7cf27849_48960884($_smarty_tpl, $this->tplIndex);
?>

  </td></tr>
</table>
</form>
<?php
}
}
/* {/block 'content'} */
}
