{* this template section needs to be {include}d in 
   a template that extends page.tpl *}

<p style="font-weight: bold;margin: 2px 0 10px">
  {$user->ud.first_name.v} {$user->ud.middle_name.v} {$user->ud.primary_name.v}</p>
<table class="edit">
    <tr>
      <td>
        <table class="edit">
          <tr>
            <td>{$user->ud.first_name.v} {if $user->ud.nickname.v != ''}"{$user->ud.nickname.v}" {/if}
                {$user->ud.middle_name.v} {$user->ud.primary_name.v}
                {if $user->ud.degree.v != ''}{$user->ud.degree.v}{/if}</td>
          </tr>
          <tr>
            <td>Date of Birth: {$user->ud.birth_date.v}</td>
          </tr>
          <tr>
            <td>Gender: {$user->ud.gender.v}</td>
          </tr>
          <tr>
            <td>Contact ID: {$user->contact_id}</td>
          </tr>
        </table>
      </td>
      <td>
        <table class="edit">
          {foreach $contact->ad as $add}
            <tr>
              <td>{$add.address_type.v}:</td><td>{$add.street_address_1.v}</td>
            </tr>
            {if $add.street_address_2.v != ''}
              <tr>
                <td></td><td>{$add.street_address_2.v}</td>
              </tr>
            {/if}
            <tr>
              <td></td><td>{$add.city.v}, {$add.state.v} {$add.postal_code.v}
                 {if $add.country.v != '' &&
                     $add.country.v != 'United States'}
                   {$add.country.v}
                 {/if}</td>
            </tr>
          {foreachelse}
            <tr><td>No addresses in database</td></tr>
          {/foreach}
        </table>
      </td>
      <td>
        <table class="edit">
          {foreach $contact->ph as $ph}
            <tr>
              <td>{$ph.phone_type.v}:</td>
              <td>{$ph.number.v|formatPhone:$ph.formatted.v}</td>
            </tr>
          {foreachelse}
            <tr><td>No phones in database</td></tr>
          {/foreach}
        </table>
      </td>
      <td>
        <table class="edit">
          {foreach $contact->em as $em}
            <tr>
              <td>{$em.email_type.v}:</td><td>{$em.email.v}</td>
            </tr>
          {foreachelse}
            <tr><td>No E-Mail addresses in database</td></tr>
          {/foreach}
        </table>
      </td>
    </tr>
</table>
<table class="edit">
  <tr>
    <td><form action="edit_contact.php" method="post">
      <input type="submit" value="Edit Data" /></td>
      <input name="contact_id" type="hidden" value="{$user->contact_id}"/>
    </form></td>
    {if $is_contact_editor && is_null($user->ud.username.v)}
      <td><form action="username.php" method="post">
        <input type="submit" value="Create User Account" /></td>
        <input name="contact_id" type="hidden" value="{$user->contact_id}"/>
      </form></td>
    {/if}
  </tr>
</table><br />
