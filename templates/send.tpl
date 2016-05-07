{extends file="email.tpl"}

{block name="addresses"}
<tr><td colspan="2">
  <h3>Sending message to {$target_user_data->ud.first_name["v"]} {$target_user_data->ud.primary_name["v"]}</h3>
</td></tr>
<tr><td class="label">
  <label for="replyto">Reply-to:</label></td>
  <td><input id="replyto" name="replyto" type="email" size="30" autofocus
         {if isset($user_email)}
           value="{$user_email}" />
         {else}
           placeholder="&lt;Your e-mail address&gt;" /> supply your e-mail address for {$target_user_data->ud.first_name} 
           to reply
         {/if}
  </td>
</tr>
<tr><td class="label" style="height: 30px; vertical-align: middle"><label for="to">To:</label></td>
    <td style="height: 30px; vertical-align: middle">Message will go to the address(es) in the database.
    </td>
</tr>
{/block}
