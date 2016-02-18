<?php
/* Smarty version 3.1.30-dev/44, created on 2016-02-18 16:32:44
  from "/var/www/html/alumni/templates/page.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30-dev/44',
  'unifunc' => 'content_56c5f22c7dba08_20893705',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1e6758e7fc7cfee779e1fc89cf63b790bec707dd' => 
    array (
      0 => '/var/www/html/alumni/templates/page.tpl',
      1 => 1455813158,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_56c5f22c7dba08_20893705 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_capitalize')) require_once '/var/www/html/alumni/vendor/smarty/smarty/libs/plugins/modifier.capitalize.php';
$_smarty_tpl->ext->_inheritance->init($_smarty_tpl, false);
?>
<!DOCTYPE html>
<html><head>
  <title>Alumni Connections</title>
  <link rel="stylesheet" href="css/alumni.css" />
  <link rel="icon" href="images/skull.ico" />
  <?php echo '<script'; ?>
 src="vendor/components/jquery/jquery.min.js"><?php echo '</script'; ?>
>
  <?php echo '<script'; ?>
 src="js/alumni.js"><?php echo '</script'; ?>
>
  <?php 
new Block_js_81935244856c5f22c78c408_40852509($_smarty_tpl);
?>

</head>
<body>

<?php 
new Block_header_74350425556c5f22c7b7b70_82775399($_smarty_tpl);
?>

  
<?php 
new Block_edit_wrapper_210409077956c5f22c7c1d52_10481281($_smarty_tpl);
?>


<?php 
new Block_content_wrapper_192846782956c5f22c7ccf78_13658711($_smarty_tpl);
?>


<?php if (isset($_smarty_tpl->tpl_vars['footer']->value)) {?>
  <?php 
new Block_footer_wrapper_127104748656c5f22c7d9007_76108831($_smarty_tpl);
?>

<?php }?>

</body></html><?php }
/* {block 'js'} /var/www/html/alumni/templates/page.tpl */
class Block_js_81935244856c5f22c78c408_40852509 extends Smarty_Internal_Block
{
public $name = "js";
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->blockNesting++;
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
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'js'} */
/* {block 'nav'} /var/www/html/alumni/templates/page.tpl */
class Block_nav_171385977756c5f22c7b4c87_79521293 extends Smarty_Internal_Block
{
public $name = "nav";
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->blockNesting++;
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
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'nav'} */
/* {block 'header'} /var/www/html/alumni/templates/page.tpl */
class Block_header_74350425556c5f22c7b7b70_82775399 extends Smarty_Internal_Block
{
public $name = "header";
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->blockNesting++;
?>

  <div id="<?php echo $_smarty_tpl->tpl_vars['header_format']->value;?>
">
    <div id="header">
      <img src="images/transparent logo.gif" class="Logo" />
    </div>
    <div id="header2">
      <h2>Cottonwood Gulch Alumni Connections<br /><br /></h2>
  
      <?php 
new Block_nav_171385977756c5f22c7b4c87_79521293($_smarty_tpl, $this->tplIndex);
?>

      
    </div>
  </div>
<?php
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'header'} */
/* {block 'edit'} /var/www/html/alumni/templates/page.tpl */
class Block_edit_5363616056c5f22c7bf916_84890816 extends Smarty_Internal_Block
{
public $name = "edit";
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->blockNesting++;
?>

      <?php
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'edit'} */
/* {block 'edit_wrapper'} /var/www/html/alumni/templates/page.tpl */
class Block_edit_wrapper_210409077956c5f22c7c1d52_10481281 extends Smarty_Internal_Block
{
public $name = "edit_wrapper";
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->blockNesting++;
?>

  <div id="edit-wrapper">
    <div id="edit">
      <?php 
new Block_edit_5363616056c5f22c7bf916_84890816($_smarty_tpl, $this->tplIndex);
?>

    </div>
  </div>
<?php
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'edit_wrapper'} */
/* {block 'content'} /var/www/html/alumni/templates/page.tpl */
class Block_content_208028256756c5f22c7cb621_03100819 extends Smarty_Internal_Block
{
public $name = "content";
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->blockNesting++;
?>

      <?php
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'content'} */
/* {block 'content_wrapper'} /var/www/html/alumni/templates/page.tpl */
class Block_content_wrapper_192846782956c5f22c7ccf78_13658711 extends Smarty_Internal_Block
{
public $name = "content_wrapper";
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->blockNesting++;
?>

  <div id="<?php echo $_smarty_tpl->tpl_vars['content_format']->value;?>
">
    <div id="content">
      <?php 
new Block_content_208028256756c5f22c7cb621_03100819($_smarty_tpl, $this->tplIndex);
?>

    </div>
  </div>
<?php
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'content_wrapper'} */
/* {block 'footer'} /var/www/html/alumni/templates/page.tpl */
class Block_footer_67741068956c5f22c7d7523_20449753 extends Smarty_Internal_Block
{
public $name = "footer";
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->blockNesting++;
?>

      <p><?php echo $_smarty_tpl->tpl_vars['footer']->value;?>
</p>
      <?php
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'footer'} */
/* {block 'footer_wrapper'} /var/www/html/alumni/templates/page.tpl */
class Block_footer_wrapper_127104748656c5f22c7d9007_76108831 extends Smarty_Internal_Block
{
public $name = "footer_wrapper";
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->ext->_inheritance->blockNesting++;
?>

    <div id="footer">
      <?php 
new Block_footer_67741068956c5f22c7d7523_20449753($_smarty_tpl, $this->tplIndex);
?>

    </div>
  <?php
$_smarty_tpl->ext->_inheritance->blockNesting--;
}
}
/* {/block 'footer_wrapper'} */
}
