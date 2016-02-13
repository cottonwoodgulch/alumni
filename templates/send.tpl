{extends file="email.tpl"}

{block name="addresses"}
<h3>Sending message to {$target_user_data->ud.first_name} {$target_user_data->ud.primary_name}</h3>
<form><table class="edit">
  <tr><td class="label"><label for="replyto">Reply-to:</label></td>
    <td><input id="replyto" name="replyto" type="email" size="30" autofocus
         {if isset($user_email)}
           value="{$user_email}" />
         {else}
           placeholder="&lt;Your e-mail address&gt;" /> you need to supply your e-mail address for {$target_user_data->ud.first_name} 
           {$target_user_data->ud.primary_name} to reply
         {/if}
    </td>
  </tr>
  <tr><td class="label"><label for="to">To:</label></td>
    <td style="height: 30px; valign: middle">Message will go to the address(es) in the database.
    </td>
  </tr>
{/block}

{block name="submit_send"}
{/block}