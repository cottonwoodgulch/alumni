{extends file="page.tpl"}

{block name="content"}
<form>
<table class="edit">
{block name="addresses"}
{/block}
  <tr><td class="label"><label for="subject">Subject:</label></td>
    <td colspan="3"><input id="subject" name="subject"
      value="{$user->ud.first_name["v"]} {$user->ud.middle_name["v"]} {$user->ud.primary_name["v"]} contacting you via Cottonwood Gulch" size="87"/>
    </td>
  </tr>
  <tr>
  <td class="label"><label for="message">Message:</label></td>
  <td colspan="3">
  <textarea cols="100" rows="15" id="message" name="message">Dear {if strlen($target_user_data->ud.nickname["v"])==0}{$target_user_data->ud.first_name["v"]}{else}{$target_user_data->ud.nickname["v"]}{/if},

  {if $rosters_in_common_count > 0}We were on the {assign var="i" value="1"}{foreach $rosters_in_common as $r}{$r['year']} {$r['group']}{if $rosters_in_common_count>1}{if $i<$rosters_in_common_count-1}, {elseif $i == $rosters_in_common_count-1} and {/if}{/if}{assign var=i value=$i+1}{/foreach} together, and I am re-connecting with some of my friends from that era...
  {else}
 We weren't on any groups together, but I remember you ...
  {/if}
  
  This message is coming via the Cottonwood Gulch system, but if you respond, it will come directly back to me.
  
  Hope to hear from you.
  
Yours,
{$user->ud.first_name["v"]} {$user->ud.middle_name["v"]} {$user->ud.primary_name["v"]}
  </textarea>
  </td></tr>
  <tr><td></td><td>
  {block name="submit_send"}
    <input type="submit" value="Send" disabled="disabled"/>
  {/block}
  </td></tr>
</table>
</form>
{/block}

