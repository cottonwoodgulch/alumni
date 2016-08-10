{extends file="page.tpl"}

{block name="js"}
  <script src="js/people.js"></script>
{/block}

{block name="content"}
  <table class="edit">
  <tr>
    <form id="get_alum" method="post" action="people.php">
    <td style="text-align: right;">
      <label for="alum_name">Trekker Lookup:</label></td>
    <td><input id="alum_name" name="alum_name" autofocus 
       value="{$alum_name}" /></td>
    {if isset($alum_list)}
    </tr><tr><td></td><td>
    {foreach $alum_list as $ax}
    <tr><td></td><td>
      <a href="people.php?alum_id={$ax->value}">{$ax->label}</a>
    </td></tr>
    {/foreach}
    </td>
    {/if}
    </form>
  </tr>
  </table>
  <br />
  {if isset($user)}
    {if $is_contact_viewer || ($user->contact_id == $alum_id)}
      {include file='templates/display_user.tpl'}
    {/if}  {* user allowed to view this contact's data *}
    {if $user->ud['deceased']['v'] == 0}
      <table class="edit">
      <tr><td colspan="2"><b>Email {if $user->ud['nickname']['v'] != ""}
         {$user->ud['nickname']['v']}
         {else}{$user->ud['first_name']['v']}{/if}:</b></td></tr>
      <tr><td>
        <a href="email_send.php?target_id={$user->contact_id}&roster_id=
          &email_type=invite&referrer=people">I have the e-mail address</a>
      </td>
      {if $contact->em}
        <td>
          <a href="email_send.php?target_id={$user->contact_id}&roster_id=
            &email_type=send&referrer=people">Use the e-mail address from the database</a>
        </td>
      {/if}
      </tr>
      </table>
    {/if}
    <br />
    {include file='templates/display_rosters.tpl'}
  {/if}    {* isset user *}
{/block}
