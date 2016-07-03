{extends file="page.tpl"}

{block name="js"}
  <script src="js/people.js"></script>
{/block}

{block name="content"}
  <table class="edit">
  <tr>
    <form id="get_alum" method="get">
    <td style="text-align: right;"><label for="alum_id">Trekker Lookup:</label></td>
    <td><input id="alum_id" name="alum_id"></td>
    </form>
  </tr>
  </table>
  <br />
  {if isset($user)}
    {if $is_contact_viewer || ($user->contact_id == $user_id)}
      {include file='templates/display_user.tpl'}
    {/if}  {* user allowed to view this contact's data *}
    {include file='templates/display_rosters.tpl'}
  {/if}    {* isset user *}
{/block}
