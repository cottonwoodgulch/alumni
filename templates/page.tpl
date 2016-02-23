<!DOCTYPE html>
<html><head>
  <title>Alumni Connections</title>
  <link rel="stylesheet" href="css/alumni.css" />
  <link rel="icon" href="images/skull.ico" />
  <script src="vendor/components/jquery/jquery.min.js"></script>
  <script src="js/alumni.js"></script>
  {block name="js"}
    <script>
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
    </script>
  {/block}
</head>
<body>

{block name="header"}
  <div id="{$header_format}">
    <div id="header">
      <img src="images/transparent logo.gif" class="Logo" />
    </div>
    <div id="header2">
      <h2>Cottonwood Gulch Alumni Connections<br /><br /></h2>
  
      {block name="nav"}
      <div id="nav-wrapper">
        <div id="nav1"><ul class="navbar">
          {foreach from=$menu item=menuitem}
            {if $menuitem == $page_request}
              <li>{$menuitem|capitalize}</li>
            {else}
              <li><a class="filelist_normal" href="index.php?page_request={$menuitem}">{$menuitem|capitalize}</a></li>
            {/if}
          {/foreach}
          </ul>
        </div>
        <div id="nav2">
          <ul class="HelloName">
          <li><b>{$HelloName}</b>
              <img src="images/dropdownarrow.png" />
            <nav>
            <ul>
              <li>Change Password</li>
              <li><a class="filelist_normal" href="index.php?page_request=logout" >Logout</a></li>
            </ul>
            </div>
          </ul>
        </nav>
      </div>
      {/block}
      
    </div>
  </div>
{/block}
  
{block name="edit_wrapper"}
  <div id="edit-wrapper">
    <div id="edit">
      {block name="edit"}
      {/block}
    </div>
  </div>
{/block}

{block name="content_wrapper"}
  <div id="{$content_format}">
    <div id="content">
      {block name="content"}
      {/block}
    </div>
  </div>
{/block}

{if isset($footer)}
  {block name="footer_wrapper"}
    <div id="footer">
      {block name="footer"}
      <p>{$footer}</p>
      {/block}
    </div>
  {/block}
{/if}

</body></html>