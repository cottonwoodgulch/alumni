{extends file="email.tpl"}

{block name="addresses"}
<tr><td colspan="2">
  <h3>Sending message to {$target_name}</h3>
</td></tr>
<tr><td class="label">
  <label for="replyto">Reply-to:</label></td>
  <td><input id="replyto" name="replyto" type="email" size="30"
       autofocus value="{$replyto}"
       placeholder="&lt;Your e-mail address&gt;" />
       &nbsp;supply your e-mail address for {$target_first_name} 
           to reply
  </td>
</tr>
<tr><td class="label" style="height: 30px; vertical-align: middle"><label for="to">To:</label></td>
    <td style="height: 30px; vertical-align: middle">Message will go to the address(es) in the database.
    </td>
</tr>
{/block}
