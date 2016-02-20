{extends file="page.tpl"}

{block name="edit"}
  <table class="edit">
    <tr>
      <td>
        <table class="edit">
          <tr>
            <td>{if $user->ud.title != ''}{$user->ud.title} {/if}
                {$user->ud.first_name} {if $user->ud.nickname != ''}"{$user->ud.nickname}" {/if}
                {$user->ud.middle_name} {$user->ud.primary_name}
                {if $user->ud.degree != ''}{$user->ud.degree}{/if}</td>
          </tr>
          <tr>
            <td>Date of Birth: {$user->ud.birth_date}</td>
          </tr>
          <tr>
            <td>Gender: {$user->ud.gender}</td>
          </tr>
          <tr><td>&nbsp;</td></tr>
          <tr><td><form action="edit_contact.php" method="post">
            <input type="submit" value="Edit My Data" /></td>
            <input name="contact_id" type="hidden" value="{$user->contact_id}">
          </form></td></tr>
        </table>
      </td>
      <td>
        <table class="edit">
          {foreach $contact->address as $add}
            <tr>
              <td>{$add.address_type}:</td><td>{$add.street_address_1}</td>
            </tr>
            {if $add->street_address_2 != ''}
              <tr>
                <td></td><td>{$add.street_address_2}</td>
              </tr>
            {/if}
            <tr>
              <td></td><td>{$add.city}, {$add.state} {$add.postal_code}
                 {if $add.country != '' && $add.country != 'United States'} {$add.country}{/if}</td>
            </tr>
          {foreachelse}
            <tr><td>No addresses in database</td></tr>
          {/foreach}
        </table>
      </td>
      <td>
        <table class="edit">
          {foreach $contact->phone as $ph}
            <tr>
              <td>{$ph.phone_type}:</td><td>{$ph.number|formatPhone:$formatted}</td>
            </tr>
          {foreachelse}
            <tr><td>No phones in database</td></tr>
          {/foreach}
        </table>
      </td>
      <td>
        <table class="edit">
          {foreach $contact->email as $em}
            <tr>
              <td>{$em.email_type}:</td><td>{$em.email}</td>
            </tr>
          {foreachelse}
            <tr><td>No E-Mail addresses in database</td></tr>
          {/foreach}
        </table>
      </td>
    </tr>
  </table>
{/block}

{block name="content"}
  <ul class="link">
  {foreach $roster->rd as $rd}
    <li><a class="filelist_normal" 
           href="roster_members.php?roster_id={$rd.roster_id}">
           {if $rd.role != ''}{$rd.role}, {/if}
        {if $rd.year > 0}{$rd.year} {/if}
        {$rd.group}</a></li>
  {foreachelse}
    <p>No rosters in database: {$rostercount}</p>
  {/foreach}
  </ul>
{/block}