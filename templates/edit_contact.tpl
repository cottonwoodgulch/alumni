{extends file="page.tpl"}

{block name="content"}
  <form action="edit_contact.php" method="post">
    <table class="edit">
      <tr>
        <td class="label">
          <label for="title">Title</label>
        </td>
        <td>
          <select id="title">
<!--             {foreach $titles as $tx} -->
            {if $user->ud.title_id == $tx['title_id']}
              <option value="{$tx.title_id}" selected="selected">
                 {$tx.title}</option>
            {else}
              <option value="{$tx.title_id}">{$tx.title}</option>
            {/if}
            {/foreach}
          </select>  
        </td>
        <td><input type="submit" value="Save Changes" disabled="disabled" /></td>
      </tr>
      <tr>
        <td class="label">
          <label for="first_name">First Name</label>
        </td>
        <td>
          <input id="first_name" value="{$user->ud.first_name}"/>
        </td>
      </tr>
      <tr>
        <td class="label">
          <label for="nickname">Nickname</label>
        </td>
        <td>
          <input id="nickname" value="{$user->ud.nickname}"/>
        </td>
      </tr>
      <tr>
        <td class="label">
          <label for="middle_name">Middle/Maiden Name</label>
        </td>
        <td>
          <input id="middle_name" value="{$user->ud.middle_name}"/>
        </td>
      </tr>
      <tr>
        <td class="label">
          <label for="primary_name">Last Name</label>
        </td>
        <td>
          <input id="primary_name" value="{$user->ud.primary_name}" />
        </td>
      </tr>
      <tr>
        <td class="label">
          <label for="degree">Degree</label>
        </td>
        <td>
          <select id="degree">
            {foreach $degrees as $tx}
            {if $user->ud.degree_id == $tx.degree_id}
              <option value="{$tx.degree_id}" selected="selected">
                 {$tx.degree}</option>
            {else}
              <option value="{$tx.degree_id}">{$tx.degree}</option>
            {/if}
            {/foreach}
          </select>  
        </td>
      </tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td class="label">
          <label for="DOB">Date of Birth</label>
        </td>
        <td>
          <input type="date" id="DOB" value="{$user->ud.birth_date|date_format:"%D"}" />
        </td>
      </tr>
      <tr>
        <td class="label">
          <label for="gender">Gender</label>
        </td>
        <td>
          <select id="gender">
            {foreach array('Female','Male','') as $tx}
              {if $user->ud.gender == $tx}
                <option value="{$tx}" selected="selected">{$tx}</option>
              {else}
                <option value="{$tx}">{$tx}</option>
              {/if}
            {/foreach}
          </select>
        </td>
      </tr>
      <tr><td>&nbsp;</td></tr>
      {foreach $contact->address as $tx}
        <tr><td class="label">{$tx.address_type}</td>
          <td><input id="{$tx.address_id}_street_address_1" value="{$tx.street_address_1}" /></td>
          <td><input type="submit" value="Delete this Address"  disabled="disabled"/></td>
          {if $tx@first}
            <td><input type="submit" value="Add Address"  disabled="disabled" /></td>
          {/if}
        </tr>
        <tr><td></td><td><input
          id="{$tx.address_id}_street_address_2"
          value="{$tx.street_address_2}" /></td></tr>
        <tr><td></td><td><input
          id="{$tx.address_id}_city"
          value="{$tx.city}" /></td></tr>
        <tr><td></td><td><input
          id="{$tx.address_id}_state"
          value="{$tx.state}" /></td></tr>
        <tr><td></td><td><input
          id="{$tx.address_id}_postal_code"
          value="{$tx.postal_code}" /></td></tr>
        <tr><td></td><td><input
          id="{$tx.address_id}_country"
          value="{$tx.country}" /></td></tr>
      {foreachelse}
        <tr><td></td><td></td>
        <td><input type="submit" value="Add Address"  disabled="disabled" /></td></tr>
      {/foreach}
      <tr><td>&nbsp;</td></tr>
      {foreach $contact->phone as $tx}
        <tr><td class="label">{$tx.phone_type}</td>
          <td><input
            id="{$tx.phone_id}_number"
            value="{$tx.number|formatPhone:$tx.formatted}" /></td>
          <td><input type="submit" value="Delete this Phone"  disabled="disabled" /></td>
          {if $tx@first}
            <td><input type="submit" value="Add Phone"  disabled="disabled"/></td>
          {/if}
        </tr>
      {foreachelse}
        <tr><td></td><td></td>
        <td><input type="submit" value="Add Phone"  disabled="disabled"/></td></tr>
      {/foreach}
      <tr><td>&nbsp;</td></tr>
      {foreach $contact->email as $tx}
        <tr>
          <td class="label">{$tx.email_type}</td>
          <td><input
            id="{$tx.email_id}_email"
            value="{$tx.email}" /></td>
          <td><input type="submit" value="Delete this E-mail"  disabled="disabled"/></td>
          {if $tx@first}
            <td><input type="submit" value="Add E-mail"  disabled="disabled"/></td>
          {/if}
        </tr>
      {foreachelse}
        <tr><td></td><td></td>
        <td><input type="submit" value="Add E-mail"  disabled="disabled"/></td></tr>
      {/foreach}
    </table>
  </form>
{/block}