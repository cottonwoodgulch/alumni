{extends file="page.tpl"}

{* prevent nav <div> from showing *}
{block name="nav"}{/block}

{block name="content"}
    <p style="font-weight: bold;margin: 2px 0 10px">{$HelloName}, please reset your password</p>
      <form method="post" action="pwreset.php">
        <table class="edit">
          <tr>
            <td class="label">
              <label for="newpass">New Password</label></td>
            <td><input id="newpass" name="newpass" autofocus/></td>
          </tr>
          <tr>
            <td class="label">
              <label for="retype">Re-type new Password</label></td>
            <td><input name="retype" type="retype"/></td>
          </tr>
          <tr>
            <td></td>
            <td><input type="submit" value="Submit" /></td>
          </tr>
        </table>
      </form>
      <p>Need help? Call the office - 505-248-0563</p>
{/block}

{block name="footer"}
  {$footer}
{/block}
