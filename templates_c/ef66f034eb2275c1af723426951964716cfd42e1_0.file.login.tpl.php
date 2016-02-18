<?php
/* Smarty version 3.1.30-dev/44, created on 2016-02-15 18:45:32
  from "/var/www/html/alumni/templates/login.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30-dev/44',
  'unifunc' => 'content_56c21ccc728bd3_69808605',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ef66f034eb2275c1af723426951964716cfd42e1' => 
    array (
      0 => '/var/www/html/alumni/templates/login.tpl',
      1 => 1453735044,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:page.tpl' => 1,
  ),
),false)) {
function content_56c21ccc728bd3_69808605 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, true);
?>



<?php 
new Block_nav_161570259756c21ccc717dc5_65916654($_smarty_tpl);
?>


<?php 
new Block_edit_27734229056c21ccc71cb09_03868771($_smarty_tpl);
?>


<?php 
new Block_content_wrapper_142319231256c21ccc720bd3_73821334($_smarty_tpl);
?>


<?php 
new Block_footer_810868656c21ccc727823_49898393($_smarty_tpl);
?>

<?php $_smarty_tpl->ext->_inheritance->endChild($_smarty_tpl);
$_smarty_tpl->_subTemplateRender("file:page.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block 'nav'} /var/www/html/alumni/templates/login.tpl */
class Block_nav_161570259756c21ccc717dc5_65916654 extends Smarty_Internal_Block
{
public $name = "nav";
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->blockNesting++;
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'nav'} */
/* {block 'edit'} /var/www/html/alumni/templates/login.tpl */
class Block_edit_27734229056c21ccc71cb09_03868771 extends Smarty_Internal_Block
{
public $name = "edit";
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->blockNesting++;
?>

      <form method="post" action="login.php">
        <table class="edit">
          <tr>
            <td class="label"><label for="username">User Name</label></td>
            <td><input id="username" name="username" type="text" autofocus/></td>
          </tr>
          <tr>
            <td class="label"><label for="password">Password</label></td>
            <td><input name="password" type="password"/></td>
          </tr>
          <tr>
            <td></td>
            <td><input type="submit" value="Log In"/></td>
          </tr>
        </table>
      </form>
      <p>Forgot your password? Need an account? Call the office - 505-248-0563</p>
<?php
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'edit'} */
/* {block 'content_wrapper'} /var/www/html/alumni/templates/login.tpl */
class Block_content_wrapper_142319231256c21ccc720bd3_73821334 extends Smarty_Internal_Block
{
public $name = "content_wrapper";
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->blockNesting++;
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'content_wrapper'} */
/* {block 'footer'} /var/www/html/alumni/templates/login.tpl */
class Block_footer_810868656c21ccc727823_49898393 extends Smarty_Internal_Block
{
public $name = "footer";
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->blockNesting++;
?>

  <?php echo $_smarty_tpl->tpl_vars['footer']->value;?>

<?php
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'footer'} */
}
