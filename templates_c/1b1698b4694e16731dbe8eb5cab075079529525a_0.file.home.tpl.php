<?php
/* Smarty version 3.1.30-dev/18, created on 2016-02-13 14:16:17
  from "/var/www/html/alumni/templates/home.tpl" */

if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.30-dev/18',
  'unifunc' => 'content_56bf3ab1daeff2_40255631',
  'file_dependency' => 
  array (
    '1b1698b4694e16731dbe8eb5cab075079529525a' => 
    array (
      0 => '/var/www/html/alumni/templates/home.tpl',
      1 => 1455372975,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:page.tpl' => 1,
  ),
),false)) {
function content_56bf3ab1daeff2_40255631 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_formatPhone')) require_once '/var/www/html/alumni/plugins/modifier.formatPhone.php';
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, true);
?>


<?php 
new Block_edit_148798101056bf3ab1d90984_63311081($_smarty_tpl);
?>


<?php 
new Block_content_127759075956bf3ab1dad652_98341048($_smarty_tpl);
$_smarty_tpl->ext->_inheritance->endChild($_smarty_tpl);
$_smarty_tpl->_subTemplateRender("file:page.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 66, false);
}
/* {block 'edit'} file:home.tpl */
class Block_edit_148798101056bf3ab1d90984_63311081 extends Smarty_Internal_Block
{
public $name = "edit";
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

  <table class="edit">
    <tr>
      <td>
        <table class="edit">
          <tr>
            <td><?php if ($_smarty_tpl->tpl_vars['user']->value->ud['title'] != '') {
echo $_smarty_tpl->tpl_vars['user']->value->ud['title'];?>
 <?php }?>
                <?php echo $_smarty_tpl->tpl_vars['user']->value->ud['first_name'];?>
 <?php if ($_smarty_tpl->tpl_vars['user']->value->ud['nickname'] != '') {?>"<?php echo $_smarty_tpl->tpl_vars['user']->value->ud['nickname'];?>
" <?php }?>
                <?php echo $_smarty_tpl->tpl_vars['user']->value->ud['middle_name'];?>
 <?php echo $_smarty_tpl->tpl_vars['user']->value->ud['primary_name'];?>

                <?php if ($_smarty_tpl->tpl_vars['user']->value->ud['degree'] != '') {
echo $_smarty_tpl->tpl_vars['user']->value->ud['degree'];
}?></td>
          </tr>
          <tr>
            <td>Date of Birth: <?php echo $_smarty_tpl->tpl_vars['user']->value->ud['birth_date'];?>
</td>
          </tr>
          <tr>
            <td>Gender: <?php echo $_smarty_tpl->tpl_vars['user']->value->ud['gender'];?>
</td>
          </tr>
          <tr><td>&nbsp;</td></tr>
          <tr><td><form action="edit_contact.php" method="post">
            <button type="submit">Edit My Data</button>
            <input name="contact_id" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['user']->value->contact_id;?>
">
          </form></td></tr>
        </table>
      </td>
      <td>
        <table class="edit">
          <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['contact']->value->address, 'add');
foreach ($_from as $_smarty_tpl->tpl_vars['add']->value) {
$_smarty_tpl->tpl_vars['add']->_loop = true;
$__foreach_add_0_saved = $_smarty_tpl->tpl_vars['add'];
?>
            <tr>
              <td><?php echo $_smarty_tpl->tpl_vars['add']->value['address_type'];?>
:</td><td><?php echo $_smarty_tpl->tpl_vars['add']->value['street_address_1'];?>
</td>
            </tr>
            <?php if ($_smarty_tpl->tpl_vars['add']->value->street_address_2 != '') {?>
              <tr>
                <td></td><td><?php echo $_smarty_tpl->tpl_vars['add']->value['street_address_2'];?>
</td>
              </tr>
            <?php }?>
            <tr>
              <td></td><td><?php echo $_smarty_tpl->tpl_vars['add']->value['city'];?>
, <?php echo $_smarty_tpl->tpl_vars['add']->value['state'];?>
 <?php echo $_smarty_tpl->tpl_vars['add']->value['postal_code'];?>

                 <?php if ($_smarty_tpl->tpl_vars['add']->value['country'] != '' && $_smarty_tpl->tpl_vars['add']->value['country'] != 'United States') {?> <?php echo $_smarty_tpl->tpl_vars['add']->value['country'];
}?></td>
            </tr>
          <?php
$_smarty_tpl->tpl_vars['add'] = $__foreach_add_0_saved;
}
if (!$_smarty_tpl->tpl_vars['add']->_loop) {
?>
            <tr><td>No addresses in database</td></tr>
          <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
        </table>
      </td>
      <td>
        <table class="edit">
          <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['contact']->value->phone, 'ph');
foreach ($_from as $_smarty_tpl->tpl_vars['ph']->value) {
$_smarty_tpl->tpl_vars['ph']->_loop = true;
$__foreach_ph_1_saved = $_smarty_tpl->tpl_vars['ph'];
?>
            <tr>
              <td><?php echo $_smarty_tpl->tpl_vars['ph']->value['phone_type'];?>
:</td><td><?php echo smarty_modifier_formatPhone($_smarty_tpl->tpl_vars['ph']->value['number'],$_smarty_tpl->tpl_vars['formatted']->value);?>
</td>
            </tr>
          <?php
$_smarty_tpl->tpl_vars['ph'] = $__foreach_ph_1_saved;
}
if (!$_smarty_tpl->tpl_vars['ph']->_loop) {
?>
            <tr><td>No phones in database</td></tr>
          <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
        </table>
      </td>
      <td>
        <table class="edit">
          <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['contact']->value->email, 'em');
foreach ($_from as $_smarty_tpl->tpl_vars['em']->value) {
$_smarty_tpl->tpl_vars['em']->_loop = true;
$__foreach_em_2_saved = $_smarty_tpl->tpl_vars['em'];
?>
            <tr>
              <td><?php echo $_smarty_tpl->tpl_vars['em']->value['email_type'];?>
:</td><td><?php echo $_smarty_tpl->tpl_vars['em']->value['email'];?>
</td>
            </tr>
          <?php
$_smarty_tpl->tpl_vars['em'] = $__foreach_em_2_saved;
}
if (!$_smarty_tpl->tpl_vars['em']->_loop) {
?>
            <tr><td>No E-Mail addresses in database</td></tr>
          <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
        </table>
      </td>
    </tr>
  </table>
<?php
}
}
/* {/block 'edit'} */
/* {block 'content'} file:home.tpl */
class Block_content_127759075956bf3ab1dad652_98341048 extends Smarty_Internal_Block
{
public $name = "content";
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

  <ul class="link">
  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['roster']->value->rd, 'rd');
foreach ($_from as $_smarty_tpl->tpl_vars['rd']->value) {
$_smarty_tpl->tpl_vars['rd']->_loop = true;
$__foreach_rd_3_saved = $_smarty_tpl->tpl_vars['rd'];
?>
    <li><a class="filelist_normal" 
           href="roster_members.php?roster_id=<?php echo $_smarty_tpl->tpl_vars['rd']->value['roster_id'];?>
">
           <?php if ($_smarty_tpl->tpl_vars['rd']->value['role'] != '') {
echo $_smarty_tpl->tpl_vars['rd']->value['role'];?>
, <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['rd']->value['year'] > 0) {
echo $_smarty_tpl->tpl_vars['rd']->value['year'];?>
 <?php }?>
        <?php echo $_smarty_tpl->tpl_vars['rd']->value['group'];?>
</a></li>
  <?php
$_smarty_tpl->tpl_vars['rd'] = $__foreach_rd_3_saved;
}
if (!$_smarty_tpl->tpl_vars['rd']->_loop) {
?>
    <p>No rosters in database: <?php echo $_smarty_tpl->tpl_vars['rostercount']->value;?>
</p>
  <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
  </ul>
<?php
}
}
/* {/block 'content'} */
}
