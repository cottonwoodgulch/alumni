{extends file="email.tpl"}

{block name="addresses"}
<h3>Inviting {$target_user_data->ud.first_name} {$target_user_data->ud.primary_name}</h3>
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
    <td><input id="to" name="to" type="email" size="30"
      placeholder="&lt;{$target_user_data->ud.first_name} {$target_user_data->ud.primary_name}'s e-mail&gt;" /> you need to provide the e-mail address
    </td>
  </tr>
{/block}