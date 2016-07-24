{extends file="email.tpl"}

{block name="addresses"}
<tr><td colspan="2">
  <h3>Inviting {$target_name}</h3>
</td></tr>
<tr><td class="label"><label for="replyto">Reply-to:</label></td>
    <td><input id="replyto" name="replyto" type="email" size="30"
         autofocus value="{$replyto}"
         placeholder="&lt;Your e-mail address&gt;" />
         &nbsp;supply your e-mail address for 
         {$target_first_name} to reply
    </td>
  </tr>
  <tr><td class="label"><label for="to">To:</label></td>
    <td><input id="to" name="to" type="email" size="30"
      value="{$to}"
      placeholder="&lt;{$target_name}'s e-mail&gt;" />
      &nbsp;you provide the e-mail address
    </td>
  </tr>
{/block}
