<?php
/* Smarty version 3.1.30-dev/44, created on 2016-02-15 19:33:35
  from "/var/www/html/alumni/templates/roster_members.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30-dev/44',
  'unifunc' => 'content_56c2280febdd86_66473617',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a9f1ac2c5c6602acaea5be7c1db42f56474ad127' => 
    array (
      0 => '/var/www/html/alumni/templates/roster_members.tpl',
      1 => 1455396194,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:page.tpl' => 1,
  ),
),false)) {
function content_56c2280febdd86_66473617 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, true);
?>


<?php 
new Block_edit_wrapper_108208791256c2280fe4a2b2_51046557($_smarty_tpl);
?>


<?php 
new Block_content_15680458756c2280feb6f35_53882797($_smarty_tpl);
$_smarty_tpl->ext->_inheritance->endChild($_smarty_tpl);
$_smarty_tpl->_subTemplateRender("file:page.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block 'edit_wrapper'} /var/www/html/alumni/templates/roster_members.tpl */
class Block_edit_wrapper_108208791256c2280fe4a2b2_51046557 extends Smarty_Internal_Block
{
public $name = "edit_wrapper";
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->blockNesting++;
?>

<?php
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'edit_wrapper'} */
/* {block 'content'} /var/www/html/alumni/templates/roster_members.tpl */
class Block_content_15680458756c2280feb6f35_53882797 extends Smarty_Internal_Block
{
public $name = "content";
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->blockNesting++;
?>

  <table class="edit">
  <tr>
  <?php if (isset($_smarty_tpl->tpl_vars['roster_members']->value)) {?>
  <td style="width: 35%;">
  <table class="edit">
    <tr><td style="font-size: 1.3em; font-weight: bold;">
        <?php echo $_smarty_tpl->tpl_vars['roster_members']->value->roster_year;?>
</td></tr>
    <tr><td style="font-size: 1.3em; font-weight: bold;">
        <?php echo $_smarty_tpl->tpl_vars['roster_members']->value->group_name;?>
</td></tr>
  </table>
  </td>
  <td style="width: 45%;">
      <ul class="drop-down">
        <li><b>Other expeditions in <?php echo $_smarty_tpl->tpl_vars['roster_members']->value->roster_year;?>
</b>
          <ul class="fallback">
          <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['this_year']->value, 'y');
foreach ($_from as $_smarty_tpl->tpl_vars['y']->value) {
$_smarty_tpl->tpl_vars['y']->_loop = true;
$__foreach_y_0_saved = $_smarty_tpl->tpl_vars['y'];
?>
            <li>
              <a href="roster_members.php?roster_id=<?php echo $_smarty_tpl->tpl_vars['y']->value['roster_id'];?>
">
               <?php echo $_smarty_tpl->tpl_vars['y']->value['group'];?>
</a>
            </li>
          <?php
$_smarty_tpl->tpl_vars['y'] = $__foreach_y_0_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
          </ul>
        </li>
      
        <li><b><?php echo $_smarty_tpl->tpl_vars['roster_members']->value->roster_year-1;?>
 expeditions</b>
          <ul class="fallback">
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['last_year']->value, 'y');
foreach ($_from as $_smarty_tpl->tpl_vars['y']->value) {
$_smarty_tpl->tpl_vars['y']->_loop = true;
$__foreach_y_1_saved = $_smarty_tpl->tpl_vars['y'];
?>
            <li>
              <a href="roster_members.php?roster_id=<?php echo $_smarty_tpl->tpl_vars['y']->value['roster_id'];?>
">
                 <?php echo $_smarty_tpl->tpl_vars['y']->value['group'];?>
</a>
            </li>
            <?php
$_smarty_tpl->tpl_vars['y'] = $__foreach_y_1_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
          </ul>
        </li>
      
        <li><b><?php echo $_smarty_tpl->tpl_vars['roster_members']->value->roster_year+1;?>
 expeditions</b>
          <ul class="fallback">
          <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['next_year']->value, 'y');
foreach ($_from as $_smarty_tpl->tpl_vars['y']->value) {
$_smarty_tpl->tpl_vars['y']->_loop = true;
$__foreach_y_2_saved = $_smarty_tpl->tpl_vars['y'];
?>
            <li>
              <a href="roster_members.php?roster_id=<?php echo $_smarty_tpl->tpl_vars['y']->value['roster_id'];?>
">
                 <?php echo $_smarty_tpl->tpl_vars['y']->value['group'];?>
</a>
            </li>
          <?php
$_smarty_tpl->tpl_vars['y'] = $__foreach_y_2_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
          </ul>
        </li>
      
      </ul>
  </td>
  <?php }?>
      
  <td>
      <form method="post" action="roster_members.php">
        <table class="edit">
          <thead>
          <tr><td colspan="2">Roster Lookup</td></tr>
          </thead>
          <tr>
            <td class="label"><label for="roster_year">Year</label></td>
            <td>
            <select id="roster_year" name="roster_year" 
                 onChange="getRosters(this.value)" />
              <option value="0">Select Year</option>
              <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['roster_years']->value, 'y');
foreach ($_from as $_smarty_tpl->tpl_vars['y']->value) {
$_smarty_tpl->tpl_vars['y']->_loop = true;
$__foreach_y_3_saved = $_smarty_tpl->tpl_vars['y'];
?>
                <?php if ($_smarty_tpl->tpl_vars['y']->value == $_smarty_tpl->tpl_vars['roster_members']->value->roster_year) {?>
                  <option value="<?php echo $_smarty_tpl->tpl_vars['y']->value;?>
" selected="selected"><?php echo $_smarty_tpl->tpl_vars['y']->value;?>

                     </option>
                <?php } else { ?>
                  <option value="<?php echo $_smarty_tpl->tpl_vars['y']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['y']->value;?>
</option>
                <?php }?>
              <?php
$_smarty_tpl->tpl_vars['y'] = $__foreach_y_3_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
            </select>
            </td>
          </tr>
          <tr id="roster_group_select">
          </tr>
        </table>
      </form>
  </td>
  </tr>
  </table>
  </div>

  <p class="thin">Use &#34;Invite&#34; to send a message to a trekker whose e-mail address you know. &#34;Send E-Mail&#34; option is available for trekkers where there is an e-mail address in the database.</p>
  <table class="edit">
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['roster_members']->value->rm, 'rd');
foreach ($_from as $_smarty_tpl->tpl_vars['rd']->value) {
$_smarty_tpl->tpl_vars['rd']->_loop = true;
$__foreach_rd_4_saved = $_smarty_tpl->tpl_vars['rd'];
?>
      <tr>
        <td><?php echo $_smarty_tpl->tpl_vars['rd']->value['primary_name'];?>
, <?php echo $_smarty_tpl->tpl_vars['rd']->value['first_name'];?>
 <?php echo $_smarty_tpl->tpl_vars['rd']->value['middle_name'];?>

           <?php if ($_smarty_tpl->tpl_vars['rd']->value['nickname'] != '') {?>"<?php echo $_smarty_tpl->tpl_vars['rd']->value['nickname'];?>
"<?php }?></td>
        <td><?php echo $_smarty_tpl->tpl_vars['rd']->value['role'];?>
</td>
        <?php if ($_smarty_tpl->tpl_vars['rd']->value['deceased'] == 0) {?>
        <td><a href="email.php?target_id=<?php echo $_smarty_tpl->tpl_vars['rd']->value['contact_id'];?>
&email_type=invite">Invite</a>
        </td>
        <?php if ($_smarty_tpl->tpl_vars['rd']->value['is_email'] != 0) {?>
        <td><a href="email.php?target_id=<?php echo $_smarty_tpl->tpl_vars['rd']->value['contact_id'];?>
&email_type=send" >Send E-Mail</a>
        </td>
        <?php }?>
        <?php }?>
      </tr>
    <?php
$_smarty_tpl->tpl_vars['rd'] = $__foreach_rd_4_saved;
}
if (!$_smarty_tpl->tpl_vars['rd']->_loop) {
?>
      <?php if (isset($_smarty_tpl->tpl_vars['roster_members']->value)) {?>
        <tr><td>No members available</td></tr>
      <?php }?>
    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
  </table>
<?php
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'content'} */
}
