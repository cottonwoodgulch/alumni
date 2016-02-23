{extends file="page.tpl"}

{block name="edit_wrapper"}
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
              <a href="roster_members.php?roster_id={$y['roster_id']}">
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
              <a href="roster_members.php?roster_id={$y['roster_id']}">
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
              <a href="roster_members.php?roster_id={$y['roster_id']}">
                 {$y['group']}</a>
            </li>
          {/foreach}
          </ul>
        </li>
      
      </ul>
  </td>
  {/if}
      
  <td>
      <form method="post" action="roster_members.php">
        <table class="edit">
          <thead>
          <tr><td colspan="2">Roster Lookup</td></tr>
          </thead>
          <tr>
            <td class="label"><label for="roster_year">Year</label></td>
            <td>
            <select id="roster_year" name="roster_year" 
                 onChange="getRosters(this.value)" />
              <option value="0">Select Year</option>
              {foreach $roster_years as $y}
                {if $y == $roster_members->roster_year}
                  <option value="{$y}" selected="selected">{$y}
                     </option>
                {else}
                  <option value="{$y}">{$y}</option>
                {/if}
              {/foreach}
            </select>
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

  <p class="thin">Use &#34;Invite&#34; to send a message to a trekker whose e-mail address you know. &#34;Send E-Mail&#34; option is available for trekkers where there is an e-mail address in the database. Many e-mail addresses in the database are out of date, so if you have a good address, please consider using Invite.</p>
  <p></p>
  <table class="edit">
    {foreach $roster_members->rm as $rd}
      <tr>
        <td>{$rd.primary_name}, {$rd.first_name} {$rd.middle_name}
           {if $rd.nickname != ""}"{$rd.nickname}"{/if}</td>
        <td>{$rd.role}</td>
        {if $rd.deceased == 0}
        <td><a href="email.php?target_id={$rd.contact_id}&email_type=invite">Invite</a>
        </td>
        {if $rd.is_email != 0}
        <td><a href="email.php?target_id={$rd.contact_id}&email_type=send" >Send E-Mail</a>
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