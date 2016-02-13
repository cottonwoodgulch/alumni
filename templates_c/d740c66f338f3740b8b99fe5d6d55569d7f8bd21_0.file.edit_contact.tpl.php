<?php
/* Smarty version 3.1.30-dev/18, created on 2016-02-13 00:17:13
  from "/var/www/html/alumni/templates/edit_contact.tpl" */

if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.30-dev/18',
  'unifunc' => 'content_56be7609a6e1a9_50884681',
  'file_dependency' => 
  array (
    'd740c66f338f3740b8b99fe5d6d55569d7f8bd21' => 
    array (
      0 => '/var/www/html/alumni/templates/edit_contact.tpl',
      1 => 1455322627,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:page.tpl' => 1,
  ),
),false)) {
function content_56be7609a6e1a9_50884681 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once '/var/www/html/smarty-3.1.29/libs/smarty/libs/plugins/modifier.date_format.php';
if (!is_callable('smarty_modifier_formatPhone')) require_once '/var/www/html/alumni/plugins/modifier.formatPhone.php';
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, true);
?>


<?php 
new Block_edit_wrapper_37844441556be76099d99e0_38349843($_smarty_tpl);
?>


<?php 
new Block_content_99725886056be7609a67460_30000423($_smarty_tpl);
$_smarty_tpl->ext->_inheritance->endChild($_smarty_tpl);
$_smarty_tpl->_subTemplateRender("file:page.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 66, false);
}
/* {block 'edit_wrapper'} file:edit_contact.tpl */
class Block_edit_wrapper_37844441556be76099d99e0_38349843 extends Smarty_Internal_Block
{
public $name = "edit_wrapper";
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'edit_wrapper'} */
/* {block 'content'} file:edit_contact.tpl */
class Block_content_99725886056be7609a67460_30000423 extends Smarty_Internal_Block
{
public $name = "content";
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

  <form action="save_contact.php" method="post">
    <table class="edit">
    <tr><td>
    <table class="edit">
      <tr>
        <td class="label">
          <label for="title">Title</label>
        </td>
        <td>
          <select id="title">
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['titles']->value, 'tx');
foreach ($_from as $_smarty_tpl->tpl_vars['tx']->value) {
$_smarty_tpl->tpl_vars['tx']->_loop = true;
$__foreach_tx_0_saved = $_smarty_tpl->tpl_vars['tx'];
?>
            <?php if ($_smarty_tpl->tpl_vars['user']->value->ud['title_id'] == $_smarty_tpl->tpl_vars['tx']->value['title_id']) {?>
              <option value="<?php echo $_smarty_tpl->tpl_vars['tx']->value['title_id'];?>
" selected="selected">
                 <?php echo $_smarty_tpl->tpl_vars['tx']->value['title'];?>
</option>
            <?php } else { ?>
              <option value="<?php echo $_smarty_tpl->tpl_vars['tx']->value['title_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['tx']->value['title'];?>
</option>
            <?php }?>
            <?php
$_smarty_tpl->tpl_vars['tx'] = $__foreach_tx_0_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
          </select>  
        </td>
      </tr>
      <tr>
        <td class="label">
          <label for="first_name">First Name</label>
        </td>
        <td>
          <input id="first_name" class="contact" value="<?php echo $_smarty_tpl->tpl_vars['user']->value->ud['first_name'];?>
">
        </td>
      </tr>
      <tr>
        <td class="label">
          <label for="nickname">Nickname</label>
        </td>
        <td>
          <input id="nickname" class="contact" value="<?php echo $_smarty_tpl->tpl_vars['user']->value->ud['nickname'];?>
">
        </td>
      </tr>
      <tr>
        <td class="label">
          <label for="middle_name">Middle/Maiden Name</label>
        </td>
        <td>
          <input id="middle_name" class="contact" value="<?php echo $_smarty_tpl->tpl_vars['user']->value->ud['middle_name'];?>
">
        </td>
      </tr>
      <tr>
        <td class="label">
          <label for="primary_name">Last Name</label>
        </td>
        <td>
          <input id="primary_name" class="contact" value="<?php echo $_smarty_tpl->tpl_vars['user']->value->ud['primary_name'];?>
">
        </td>
      </tr>
      <tr>
        <td class="label">
          <label for="degree">Degree</label>
        </td>
        <td>
          <select id="degree">
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['degrees']->value, 'tx');
foreach ($_from as $_smarty_tpl->tpl_vars['tx']->value) {
$_smarty_tpl->tpl_vars['tx']->_loop = true;
$__foreach_tx_1_saved = $_smarty_tpl->tpl_vars['tx'];
?>
            <?php if ($_smarty_tpl->tpl_vars['user']->value->ud['degree_id'] == $_smarty_tpl->tpl_vars['tx']->value['degree_id']) {?>
              <option value="<?php echo $_smarty_tpl->tpl_vars['tx']->value['degree_id'];?>
" selected="selected">
                 <?php echo $_smarty_tpl->tpl_vars['tx']->value['degree'];?>
</option>
            <?php } else { ?>
              <option value="<?php echo $_smarty_tpl->tpl_vars['tx']->value['degree_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['tx']->value['degree'];?>
</option>
            <?php }?>
            <?php
$_smarty_tpl->tpl_vars['tx'] = $__foreach_tx_1_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
          </select>  
        </td>
      </tr>
      <tr><td>&nbsp;</td></tr>
      <tr>
        <td class="label">
          <label for="DOB">Date of Birth</label>
        </td>
        <td>
          <input type="date" id="DOB" class="contact" value="<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['user']->value->ud['birth_date'],"%D");?>
">
        </td>
      </tr>
      <tr>
        <td class="label">
          <label for="gender">Gender</label>
        </td>
        <td>
          <select id="gender">
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, array('Female','Male'), 'tx');
foreach ($_from as $_smarty_tpl->tpl_vars['tx']->value) {
$_smarty_tpl->tpl_vars['tx']->_loop = true;
$__foreach_tx_2_saved = $_smarty_tpl->tpl_vars['tx'];
?>
              <?php if ($_smarty_tpl->tpl_vars['user']->value->ud['gender'] == $_smarty_tpl->tpl_vars['tx']->value) {?>
                <option value="<?php echo $_smarty_tpl->tpl_vars['tx']->value;?>
" selected="selected"><?php echo $_smarty_tpl->tpl_vars['tx']->value;?>
</option>
              <?php } else { ?>
                <option value="<?php echo $_smarty_tpl->tpl_vars['tx']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['tx']->value;?>
</option>
              <?php }?>
            <?php
$_smarty_tpl->tpl_vars['tx'] = $__foreach_tx_2_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
          </select>
        </td>
      </tr>
      <tr><td>&nbsp;</td></tr>
      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['contact']->value->address, 'tx');
foreach ($_from as $_smarty_tpl->tpl_vars['tx']->value) {
$_smarty_tpl->tpl_vars['tx']->_loop = true;
$__foreach_tx_3_saved = $_smarty_tpl->tpl_vars['tx'];
?>
        <tr><td class="label"><?php echo $_smarty_tpl->tpl_vars['tx']->value['address_type'];?>
</td><td><?php echo $_smarty_tpl->tpl_vars['tx']->value['street_address_1'];?>
</td></tr>
        <tr><td></td><td><?php echo $_smarty_tpl->tpl_vars['tx']->value['street_address_2'];?>
</td></tr>
        <tr><td></td><td><?php echo $_smarty_tpl->tpl_vars['tx']->value['city'];?>
</td></tr>
        <tr><td></td><td><?php echo $_smarty_tpl->tpl_vars['tx']->value['state'];?>
</td></tr>
        <tr><td></td><td><?php echo $_smarty_tpl->tpl_vars['tx']->value['postal_code'];?>
</td></tr>
        <tr><td></td><td><?php echo $_smarty_tpl->tpl_vars['tx']->value['country'];?>
</td></tr>
      <?php
$_smarty_tpl->tpl_vars['tx'] = $__foreach_tx_3_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
      <tr><td>&nbsp;</td></tr>
      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['contact']->value->phone, 'tx');
foreach ($_from as $_smarty_tpl->tpl_vars['tx']->value) {
$_smarty_tpl->tpl_vars['tx']->_loop = true;
$__foreach_tx_4_saved = $_smarty_tpl->tpl_vars['tx'];
?>
        <tr><td class="label"><?php echo $_smarty_tpl->tpl_vars['tx']->value['phone_type'];?>
</td>
            <td><?php echo smarty_modifier_formatPhone($_smarty_tpl->tpl_vars['tx']->value['number'],$_smarty_tpl->tpl_vars['tx']->value['formatted']);?>
</td>
      <?php
$_smarty_tpl->tpl_vars['tx'] = $__foreach_tx_4_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
      <tr><td>&nbsp;</td></tr>
      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['contact']->value->email, 'tx');
foreach ($_from as $_smarty_tpl->tpl_vars['tx']->value) {
$_smarty_tpl->tpl_vars['tx']->_loop = true;
$__foreach_tx_5_saved = $_smarty_tpl->tpl_vars['tx'];
?>
        <tr><td class="label"><?php echo $_smarty_tpl->tpl_vars['tx']->value['email_type'];?>
</td><td><?php echo $_smarty_tpl->tpl_vars['tx']->value['email'];?>
</td>
      <?php
$_smarty_tpl->tpl_vars['tx'] = $__foreach_tx_5_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
    </table>
  </form>
<?php
}
}
/* {/block 'content'} */
}
