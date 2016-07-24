{extends file="page.tpl"}

{block name="content"}
<form method="post" action="email_send.php?target_id={$target_id}
   &email_type={$email_type}&referrer=email">
<table class="edit">
{block name="addresses"}
{/block}
  <tr><td class="label"><label for="subject">Subject:</label></td>
    <td colspan="3"><input id="subject" name="subject"
      value="{$subject}" size="87"/>
    </td>
  </tr>
  <tr>
  <td class="label"><label for="message">Message:</label></td>
  <td colspan="3">
  <textarea cols="100" rows="15" id="message" name="message">
{$message}
  </textarea>
  </td></tr>
  <tr><td></td><td>
  {block name="submit_send"}
    <input type="submit" value="Send"/>
    <button 
      formaction="rosters.php?roster_id={$roster_id}">Cancel</button>
  {/block}
  </td></tr>
</table>
<input type="hidden" name="user_first_name"
  value="{$user_first_name}" />
<input type="hidden" name="target_first_name"
  value="{$target_first_name}" />
<input type="hidden" name="target_name"
  value="{$target_name}" />
<input type="hidden" name="roster_id" value="{$roster_id}" />
</form>
{/block}

