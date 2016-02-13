<?php
/* Smarty version 3.1.30-dev/18, created on 2016-01-25 15:17:29
  from "/var/www/html/alumni/templates/login.tpl" */

if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.30-dev/18',
  'unifunc' => 'content_56a63c8987d600_06246012',
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
function content_56a63c8987d600_06246012 ($_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, true);
?>



<?php 
new Block_nav_24474705856a63c8986b4c4_29313232($_smarty_tpl);
?>


<?php 
new Block_edit_94241759356a63c89870729_91932041($_smarty_tpl);
?>


<?php 
new Block_content_wrapper_160188250256a63c89874da3_12117200($_smarty_tpl);
?>


<?php 
new Block_footer_144008367456a63c8987c0e1_16025609($_smarty_tpl);
?>

<?php $_smarty_tpl->ext->_inheritance->endChild($_smarty_tpl);
$_smarty_tpl->_subTemplateRender("file:page.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 66, false);
}
/* {block 'nav'} file:login.tpl */
class Block_nav_24474705856a63c8986b4c4_29313232 extends Smarty_Internal_Block
{
public $name = "nav";
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'nav'} */
/* {block 'edit'} file:login.tpl */
class Block_edit_94241759356a63c89870729_91932041 extends Smarty_Internal_Block
{
public $name = "edit";
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
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
}
}
/* {/block 'edit'} */
/* {block 'content_wrapper'} file:login.tpl */
class Block_content_wrapper_160188250256a63c89874da3_12117200 extends Smarty_Internal_Block
{
public $name = "content_wrapper";
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'content_wrapper'} */
/* {block 'footer'} file:login.tpl */
class Block_footer_144008367456a63c8987c0e1_16025609 extends Smarty_Internal_Block
{
public $name = "footer";
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

  <?php echo $_smarty_tpl->tpl_vars['footer']->value;?>

<?php
}
}
/* {/block 'footer'} */
}
