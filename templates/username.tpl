{extends file="page.tpl"}

{block name="content"}
<p style="font-weight: bold;margin: 2px 0 10px">Create login for 
  {$alum->ud.first_name.v} {$alum->ud.middle_name.v} {$alum->ud.primary_name.v}</p>
<p>User will be required to change password on the first log-in. Suggested username and
   initial password are shown.</p>
<form action="username.php" method="post">
<input type="hidden" name="contact_id" value="{$alum->contact_id}" />
<table class="edit">
    <tr>
      <td class="label"><label for="username">New User Name</label></td>
      <td><input id="username" name="username" value="{$username}" autofocus/></td>
    </tr><tr>
      <td class="label"><label for="pw">Initial Password</label>
      <td><input id="pw" name="pw" value="{$pw}"/></td>
    </tr>
</table>
<br />
<table class="edit">
  <tr>
    <td><button type="submit" name="buttonAction" value="save">Save</button></td>
    <td><button type="submit"
      formaction="people.php?alum_id={$alum->contact_id}">Cancel</button></td>
  </tr>
</form>
{/block}
