<!DOCTYPE html>
<html><head>
  <title>Alumni Connections</title>
  <link rel="stylesheet" href="css/alumni.css" />
  <link rel="stylesheet" href="css/jquery-ui.css" />
  <link rel="icon" href="images/skull.ico" />
  <script src="vendor/components/jquery/jquery.min.js"></script>
  <script src="vendor/components/jqueryui/jquery-ui.js">
  </script>
  <script src="js/alumni.js"></script>
  {block name="js"}
  {/block}
</head>
<body>

{block name="header"}
  <div id="header-wrapper">
    <div id="header">
      <img src="images/transparent_logo.gif" class="Logo" />
    </div>
    <div id="header2">
      <h2>Cottonwood Gulch Alumni Connections<br /><br /></h2>
  
      {block name="nav"}
      <div id="nav-wrapper">
        <div id="nav1"><ul class="navbar">
          {foreach array("home","rosters") as $menuitem}
            {if $menuitem == $page_request}
              <li>{$menuitem|capitalize}</li>
            {else}
              <li><a class="filelist_normal" href="index.php?page_request={$menuitem}">{$menuitem|capitalize}</a></li>
            {/if}
          {/foreach}
          </ul>
        </div>
        <div id="nav2">
          <ul class="drop-down">
          <li><b>{$HelloName}</b>
              <img src="images/dropdownarrow.png" />
            <ul class="fallback">
              <li class="filelist_normal">Change Password</li>
              <li><a class="filelist_normal" href="index.php?page_request=logout" >Logout</a></li>
            </ul>
          </li>
          </ul>
        </div>
      </div>
      {/block}
      
    </div>
  </div>
{/block}

{block name="dialog"}
{/block}

<div id="content-wrapper">
  <div id="content">
    {block name="content"}
    {/block}
  </div>
</div>

{if isset($footer)}
  {block name="footer_wrapper"}
    <div id="footer">
      {block name="footer"}
      {$footer}
      {/block}
    </div>
  {/block}
{/if}

</body></html>
