{extends file="page.tpl"}

{block name="js"}
  <script src="js/rosters.js"></script>
{/block}

{block name="content"}
  <table class="edit">
  <tr>
  {if isset($roster_members)}
  <td style="width: 35%;">
  <table class="edit">
    <tr><td style="font-size: 1.3em; font-weight: bold;">
        {$roster_members->roster_year}</td></tr>
    <tr><td style="font-size: 1.3em; font-weight: bold;">
        {$roster_members->group_name}</td></tr>
  </table>
  </td>
  <td style="width: 45%;">
      <ul class="drop-down">
        <li><b>Other expeditions in {$roster_members->roster_year}</b>
           <img src="images/dropdownarrow.png" />
          <ul class="fallback">
          {foreach $this_year as $y}
            <li>
              <a href="rosters.php?roster_id={$y['roster_id']}">
               {$y['group']}</a>
            </li>
          {/foreach}
          </ul>
        </li>
      
        <li><b>{$roster_members->roster_year - 1} expeditions</b>
           <img src="images/dropdownarrow.png" />
          <ul class="fallback">
            {foreach $last_year as $y}
            <li>
              <a href="rosters.php?roster_id={$y['roster_id']}">
                 {$y['group']}</a>
            </li>
            {/foreach}
          </ul>
        </li>
      
        <li><b>{$roster_members->roster_year + 1} expeditions</b>
           <img src="images/dropdownarrow.png" />
          <ul class="fallback">
          {foreach $next_year as $y}
            <li>
              <a href="rosters.php?roster_id={$y['roster_id']}">
                 {$y['group']}</a>
            </li>
          {/foreach}
          </ul>
        </li>
      
      </ul>
  </td>
  {/if}
      
  <td>
      <form method="post" action="rosters.php">
        <table class="edit">
          <thead>
          <tr><td colspan="2"><b>Roster Lookup</b></td></tr>
          </thead>
          <tr>
            <td class="label"><label for="roster_year">Year</label></td>
            <td>
            <input id="roster_year" name="roster_year"
               value="{$roster_members->roster_year}"
               onKeyup="getRosters(this.value)"
               onClick="selectAll('#roster_year')"
               autocomplete="off" size="5"/>
            </td>
          </tr>
          <tr id="roster_group_select">
          </tr>
        </table>
      </form>
  </td>
  </tr>
  </table>
  </div>

  {if isset($roster_members) && $roster_members->rostermember_count >0}
  <p class="thin">Use &#34;Invite&#34; to send a message to a trekker whose e-mail address you know. &#34;Send E-Mail&#34; option is available for trekkers where there is an e-mail address in the database. Many e-mail addresses in the database are out of date, so if you have a good address, please consider using Invite.</p>
  {/if}
  <p></p>
  <table class="edit">
    {foreach $roster_members->rm as $rd}
      <tr>
        <td>{$rd.primary_name}, {$rd.first_name} {$rd.middle_name}
           {if $rd.nickname != ""}"{$rd.nickname}"{/if}</td>
        <td>{$rd.role}</td>
        {if $rd.deceased == 0}
        <td><a href="email_send.php?target_id={$rd.contact_id}&roster_id={$roster_id}&email_type=invite&referrer=roster_members">Invite</a>
        </td>
        {if $rd.is_email != 0}
        <td><a href="email_send.php?target_id={$rd.contact_id}&roster_id={$roster_id}&email_type=send&referrer=roster_members" >Send E-Mail</a>
        </td>
        {/if}
        {/if}
      </tr>
    {foreachelse}
      {if isset($roster_members)}
        <tr><td>No members available</td></tr>
      {/if}
    {/foreach}
  </table>
{/block}
