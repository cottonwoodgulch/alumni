<?php
/* Smarty version 3.1.30-dev/18, created on 2016-02-13 20:47:02
  from "/var/www/html/alumni/templates/page.tpl" */

if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.30-dev/18',
  'unifunc' => 'content_56bf9646ec9e79_72337916',
  'file_dependency' => 
  array (
    '1e6758e7fc7cfee779e1fc89cf63b790bec707dd' => 
    array (
      0 => '/var/www/html/alumni/templates/page.tpl',
      1 => 1455396414,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_56bf9646ec9e79_72337916 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_capitalize')) require_once '/var/www/html/smarty-3.1.29/libs/smarty/libs/plugins/modifier.capitalize.php';
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, false);
?>
<!DOCTYPE html>
<html><head>
  <title>Alumni Connections</title>
  <link rel="stylesheet" href="css/alumni.css" />
  <link rel="icon" href="images/skull.ico" />
  <?php echo '<script'; ?>
 src="vendor/jquery/jquery-1.12.0.js"><?php echo '</script'; ?>
>
  <?php echo '<script'; ?>
 src="js/alumni.js"><?php echo '</script'; ?>
>
  <?php 
new Block_js_161556212656bf9646e7d181_91099950($_smarty_tpl);
?>

</head>
<body>

<?php 
new Block_header_133304792156bf9646ea8f76_59405837($_smarty_tpl);
?>

  
<?php 
new Block_edit_wrapper_86566225056bf9646eb18d0_93222636($_smarty_tpl);
?>


<?php 
new Block_content_wrapper_208055077356bf9646ebafb8_51395213($_smarty_tpl);
?>


<?php if (isset($_smarty_tpl->tpl_vars['footer']->value)) {?>
  <?php 
new Block_footer_wrapper_122571424656bf9646ec7025_08619056($_smarty_tpl);
?>

<?php }?>

</body></html><?php }
/* {block 'js'} file:page.tpl */
class Block_js_161556212656bf9646e7d181_91099950 extends Smarty_Internal_Block
{
public $name = "js";
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <?php echo '<script'; ?>
>
      $(document).ready(function () {
        $(".drop-down li ul").hide().removeClass("fallback");
        $(".drop-down li").hover(
          function () {
            $(this).find("ul").stop().slideDown(300);
          },
          function () {
            $(this).find("ul").stop().slideUp(300);
          }
        );
      } );
    <?php echo '</script'; ?>
>
  <?php
}
}
/* {/block 'js'} */
/* {block 'nav'} file:page.tpl */
class Block_nav_200754386556bf9646ea5e88_14049780 extends Smarty_Internal_Block
{
public $name = "nav";
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

      <div id="nav-wrapper">
        <div id="nav1"><ul class="navbar">
          <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['menu']->value, 'menuitem');
foreach ($_from as $_smarty_tpl->tpl_vars['menuitem']->value) {
$_smarty_tpl->tpl_vars['menuitem']->_loop = true;
$__foreach_menuitem_0_saved = $_smarty_tpl->tpl_vars['menuitem'];
?>
            <?php if ($_smarty_tpl->tpl_vars['menuitem']->value == $_smarty_tpl->tpl_vars['page_request']->value) {?>
              <li><?php echo smarty_modifier_capitalize($_smarty_tpl->tpl_vars['menuitem']->value);?>
</li>
            <?php } else { ?>
              <li><a class="filelist_normal" href="index.php?page_request=<?php echo $_smarty_tpl->tpl_vars['menuitem']->value;?>
"><?php echo smarty_modifier_capitalize($_smarty_tpl->tpl_vars['menuitem']->value);?>
</a></li>
            <?php }?>
          <?php
$_smarty_tpl->tpl_vars['menuitem'] = $__foreach_menuitem_0_saved;
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
          </ul>
        </div>
        <div id="nav2">
          <ul class="drop-down">
          <li><b><?php echo $_smarty_tpl->tpl_vars['HelloName']->value;?>
</b>
            <ul class="fallback">
              <li>Change Password</li>
              <li><a class="filelist_normal" href="index.php?page_request=logout" >Logout</a></li>
            </ul>
          </ul>
        </div>
      </div>
      <?php
}
}
/* {/block 'nav'} */
/* {block 'header'} file:page.tpl */
class Block_header_133304792156bf9646ea8f76_59405837 extends Smarty_Internal_Block
{
public $name = "header";
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

  <div id="<?php echo $_smarty_tpl->tpl_vars['header_format']->value;?>
">
    <div id="header">
      <img src="images/logo.png" class="Logo" />
    </div>
    <div id="header2">
      <h2>Cottonwood Gulch Alumni Connections<br /><br /></h2>
  
      <?php 
new Block_nav_200754386556bf9646ea5e88_14049780($_smarty_tpl, $this->tplIndex);
?>

      
    </div>
  </div>
<?php
}
}
/* {/block 'header'} */
/* {block 'edit'} file:page.tpl */
class Block_edit_22166074656bf9646eaffe1_06289546 extends Smarty_Internal_Block
{
public $name = "edit";
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

      <?php
}
}
/* {/block 'edit'} */
/* {block 'edit_wrapper'} file:page.tpl */
class Block_edit_wrapper_86566225056bf9646eb18d0_93222636 extends Smarty_Internal_Block
{
public $name = "edit_wrapper";
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

  <div id="edit-wrapper">
    <div id="edit">
      <?php 
new Block_edit_22166074656bf9646eaffe1_06289546($_smarty_tpl, $this->tplIndex);
?>

    </div>
  </div>
<?php
}
}
/* {/block 'edit_wrapper'} */
/* {block 'content'} file:page.tpl */
class Block_content_110844897356bf9646eb9510_61909595 extends Smarty_Internal_Block
{
public $name = "content";
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

      <?php
}
}
/* {/block 'content'} */
/* {block 'content_wrapper'} file:page.tpl */
class Block_content_wrapper_208055077356bf9646ebafb8_51395213 extends Smarty_Internal_Block
{
public $name = "content_wrapper";
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

  <div id="<?php echo $_smarty_tpl->tpl_vars['content_format']->value;?>
">
    <div id="content">
      <?php 
new Block_content_110844897356bf9646eb9510_61909595($_smarty_tpl, $this->tplIndex);
?>

    </div>
  </div>
<?php
}
}
/* {/block 'content_wrapper'} */
/* {block 'footer'} file:page.tpl */
class Block_footer_131495282056bf9646ec53f8_45185203 extends Smarty_Internal_Block
{
public $name = "footer";
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

      <p><?php echo $_smarty_tpl->tpl_vars['footer']->value;?>
</p>
      <?php
}
}
/* {/block 'footer'} */
/* {block 'footer_wrapper'} file:page.tpl */
class Block_footer_wrapper_122571424656bf9646ec7025_08619056 extends Smarty_Internal_Block
{
public $name = "footer_wrapper";
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <div id="footer">
      <?php 
new Block_footer_131495282056bf9646ec53f8_45185203($_smarty_tpl, $this->tplIndex);
?>

    </div>
  <?php
}
}
/* {/block 'footer_wrapper'} */
}
