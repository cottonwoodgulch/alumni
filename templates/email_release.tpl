{extends file="page.tpl"}

{block name="js"}
  <script src="js/release.js"></script>
{/block}

{block name="content"}
{if isset($emails)}
  <p style="font-weight: bold;margin: 2px 0 10px">Messages from Sender 
  {$sender_name}</p>
  <form id="send_form" action="email_release.php" method="post">
  <input type="hidden" name="sender_id"
         value="{$sender_id}"/>
  <table class="edit" width="75%">
  <tr style="font-weight: bold">
    <td></td><td>To</td><td>Subject</td><td>Message</td></tr>
  </tr>
  {foreach $emails as $ex}
  <tr>
    <td class="email">
      <input type="checkbox" name="c_{$ex['hold_msg_id']}"></td>
    <td class="email">{$ex['target']}</td>
    <td class="email">{$ex['subject']}</td>
    <td class="email">{$ex['message']}</td>
  </tr>
  {/foreach}
  </table>
  </form>
{else}
  <p style="font-weight: bold;margin: 2px 0 10px">{$endmessage}</p>
{/if} {* isset $emails *}
{/block}

  {block name="localmenu"}
  <label>
    <input type="checkbox" id="select_all"
           name="select_all"
         onchange="changeCheck('#select_all',':checkbox')"/>
    <b>Select All</b>
  </label>
  <br />
     <button form="send_form"
        id="send_button"
        type="submit"
        name="buttonAction" value="send"
        style="margin-bottom: 5px;">
     Send Checked Messages</button>
  <br />
  <button form="send_form" type="submit"
     name="buttonAction" value="delete"
     style="margin-bottom: 5px;">Delete Checked Messages</button>
  <br />
  <button form="send_form" type="submit"
     name="buttonAction" value="next"
     style="margin-bottom: 5px;">Next Sender</button>
{/block}
