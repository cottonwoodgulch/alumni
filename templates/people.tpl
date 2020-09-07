{extends file="page.tpl"}

{block name="js"}
  <script defer src="js/AlumLookup.js"></script>
{/block}

{block name="content"}
  <form method="post" id="LookupAlumForm" action="people.php">
    <label for="alum_name">Trekker Lookup:</label>
    <input id="alum_name" name="alum_name" autofocus value="{$alum_name}"
       autocomplete="off" onclick="$(this).select()"/>
    <input id="alum_id" name="alum_id" type="hidden">
  </form>
  <br />
  {if isset($user)}
    {*$user object is person being looked up,
       $user_id is person logged in*}
    {if $is_contact_viewer || ($user->contact_id == $user_id)}
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
