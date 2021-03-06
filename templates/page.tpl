<!DOCTYPE html>
<html><head>
  <title>Alumni Connections</title>
  <link rel="stylesheet" href="css/alumni.css" />
  <link rel="stylesheet" href="css/jquery-ui.css" />
  <link rel="icon" href="images/skull.ico" />
  <script src="vendor/components/jquery/jquery.min.js"></script>
  <script src="vendor/components/jqueryui/jquery-ui.js"></script>
  <script src="js/alumni.js"></script>
  {block name="js"}
  {/block}
</head>
<body>

{block name="header"}
  <div id="header-wrapper">
    <div id="header">
      <img src="images/transparent_logo.png" class="Logo" />
    </div>
    <div id="header2">
      <h2>Cottonwood Gulch Alumni Connections<br /><br /></h2>
  
      {block name="nav"}
      <div id="nav-wrapper">
        <div id="nav1"><ul class="navbar">
          {foreach $sitemenu as $menuitem}
              <li><a class="filelist_normal"
               href="{$menuitem['t']}.php">{$menuitem['d']}</a></li>
          {/foreach}
          </ul>
        </div>
        <div id="nav2">
          <ul class="drop-down">
          <li><b>Tom{*{$HelloName}*}</b>
              <img src="images/dropdownarrow.png" />
            <ul class="fallback">
              <li><a class="filelist_normal" href="pwreset.php">Change Password</li>
              <li><a class="filelist_normal" href="logout.php" >Logout</a></li>
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

{if isset($localmenu)}
  <div id="localmenu">
  {block name="localmenu"}
  {/block}
  {if isset($changeclasses)}
  <br /><br />
  <span class="change" style="padding: 3px;">Value Changed</span>
  <br /><br />
  <span class="add" style="padding: 3px;">To Be Added</span>
  <br /><br />
  <span class="del" style="padding: 3px;">To Be Deleted</span>
  {/if}
  <br /><br />
  </div>
{/if}

{if isset($footer)}
  <div id="footer">
    {block name="footer"}
    {$footer}
    {/block}
  </div>
{/if}

</body></html>
