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
    {include file='templates/display_user.tpl'}
  {/if}  {* isset user *}
{/block}
