{extends file="page.tpl"}

{block name="js"}
  <script src="js/ContactData.js"></script>
{/block}

{block name="dialog"}
  <div id="AddressDialog" title="New Address" style="display: none;">
  <form method="post" action="edit_contact.php"
        id="AddressDialogForm">
  <table class="edit" 
        style="margin: 1em; border: 10px solid #C49F75;">
    <tr>
      <td class="label">
        <label for="add_address_type">Address Type</td>
      <td><select id="add-address-type" name="add_address_type"
        form="AddressDialogForm">
        {foreach $address_types as $tx}
          <option value="{$tx.address_type_id}">              
             {$tx.address_type}</option>
        {/foreach}
        </select>  
      </td>
    </tr><tr>
      <td class="label">
        <label for="add_street_address_1">Address</td>
      <td><input name="add_street_address_1"/></td>
    </tr><tr>
      <td></td>
      <td><input name="add_street_address_2"/></td>
    </tr><tr>
      <td class="label"><label for="add_city">City</td>
      <td><input name="add_city" /></td>
    </tr><tr>
      <td class="label"><label for="add_state">State</td>
      <td><input name="add_state" /></td>
    </tr><tr>
      <td class="label">
        <label for="add_postal_code">Postal Code</td>
      <td><input name="add_postal_code" /></td>
    </tr><tr>
      <td class="label"><label for="add_country">Country</td>
      <td><input name="add_country" /></td>
    </tr>
  </table>
  <input type="hidden" name="buttonAction" value="AddAddress"/>
  <input type="hidden" name="contact_id" 
         value="{$user->contact_id}"/>
  </form>
  Address will be saved to a holding file pending release
     to the live database.
  </div>
  <div id="PhoneDialog" title="New Phone" style="display: none;">
  <form method="post" action="edit_contact.php"
        id="PhoneDialogForm">
  <table class="edit" 
        style="margin: 1em; border: 10px solid #C49F75;">
    <tr>
      <td class="label">
        <label for="add_phone_type">Phone Type</td>
      <td><select id="add-phone-type" name="add_phone_type"
        form="PhoneDialogForm">
        {foreach $phone_types as $tx}
          <option value="{$tx.phone_type_id}">              
             {$tx.phone_type}</option>
        {/foreach}
        </select>  
      </td>
    </tr><tr>
      <td class="label">
        <label for="add_phone">Number</td>
      <td><input name="add_phone"></td>
    </tr>
  </table>
  <input type="hidden" name="buttonAction" value="AddPhone"/>
  <input type="hidden" name="contact_id" 
         value="{$user->contact_id}"/>
  </form>
  Phone will be saved to a holding file pending release
     to the live database.
  </div>
  
  <div id="EmailDialog" title="New Email" style="display: none;">
  <form method="post" action="edit_contact.php"
        id="EmailDialogForm">
  <table class="edit" 
        style="margin: 1em; border: 10px solid #C49F75;">
    <tr>
      <td class="label">
        <label for="add_email_type">Email Type</td>
      <td><select id="add-email-type" name="add_email_type"
        form="EmailDialogForm">
        {foreach $email_types as $tx}
          <option value="{$tx.email_type_id}">              
             {$tx.email_type}</option>
        {/foreach}
        </select>  
      </td>
    </tr><tr>
      <td class="label">
        <label for="add_email">E-mail Address</td>
      <td><input name="add_email"></td>
    </tr>
  </table>
  <input type="hidden" name="buttonAction" value="AddEmail"/>
  <input type="hidden" name="contact_id" 
         value="{$user->contact_id}"/>
  </form>
  Email will be saved to a holding file pending release
     to the live database.
  </div>
{/block}

{block name="content"}
  <form action="edit_contact.php" method="post">
    <table class="edit">
      <tr>
        <td class="label">
          <label for="title">Title</label>
        </td>
        <td>
          <select class="content" name="title">
            {foreach $titles as $tx}
            {if $user->ud.title_id == $tx['title_id']}
              <option value="{$tx.title_id}" selected="selected">
                 {$tx.title}</option>
            {else}
              <option value="{$tx.title_id}">{$tx.title}</option>
            {/if}
            {/foreach}
          </select>
        </td>
        <td></td><td><button type="submit" name="buttonAction"
          value="SaveAll" disabled="disabled">Save Changes</button>
          </td>
      </tr>
      <tr>
        <td class="label">
          <label for="first_name">First Name</label>
        </td>
        <td>
          <input name="first_name" value="{$user->ud.first_name}"/>
        </td>
      </tr>
      <tr>
        <td class="label">
          <label for="nickname">Nickname</label>
        </td>
        <td>
          <input ="nickname" value="{$user->ud.nickname}"/>
        </td>
      </tr>
      <tr>
        <td class="label">
          <label for="middle_name">Middle/Maiden Name</label>
        </td>
        <td>
          <input name="middle_name" value="{$user->ud.middle_name}"/>
        </td>
      </tr>
      <tr>
        <td class="label">
          <label for="primary_name">Last Name</label>
        </td>
        <td>
          <input name="primary_name"
            value="{$user->ud.primary_name}" />
        </td>
      </tr>
      <tr>
        <td class="label">
          <label for="degree">Degree</label>
        </td>
        <td>
          <select class="content" name="degree">
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
          <input type="date" name="DOB"
            value="{$user->ud.birth_date|date_format:'%D'}" />
        </td>
      </tr>
      <tr>
        <td class="label">
          <label for="gender">Gender</label>
        </td>
        <td>
          <select class="content" name="gender">
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
          <td><input name="{$tx.address_id}_street_address_1" value="{$tx.street_address_1}" /></td>
          <td><button type="submit" name="buttonAction"
                 value="DeleteAddress_{$tx.address_id}">
                 Delete this Address</button></td>
          {if $tx@first}
            <td><button type="button" onClick="getAddress();">
               Add Address</button></td>
          {/if}
        </tr>
        <tr><td></td><td><input
          name="{$tx.address_id}_street_address_2"
          value="{$tx.street_address_2}" /></td></tr>
        <tr><td></td><td><input
          name="{$tx.address_id}_city"
          value="{$tx.city}" /></td></tr>
        <tr><td></td><td><input
          name="{$tx.address_id}_state"
          value="{$tx.state}" /></td></tr>
        <tr><td></td><td><input
          name="{$tx.address_id}_postal_code"
          value="{$tx.postal_code}" /></td></tr>
        <tr><td></td><td><input
          name="{$tx.address_id}_country"
          value="{$tx.country}" /></td></tr>
      {foreachelse}
        <tr><td></td><td></td>
          <td><button type="button" onClick="getAddress();">
               Add Address</button></td>
        </tr>
      {/foreach}
      <tr><td>&nbsp;</td></tr>
      {foreach $contact->phone as $tx}
        <tr><td class="label">{$tx.phone_type}</td>
          <td><input
            name="{$tx.phone_id}_number"
            value="{$tx.number|formatPhone:$tx.formatted}" /></td>
          <td><button type="submit" name="buttonAction"
             value="DeletePhone_{$tx.phone_id}">
             Delete this Phone</button></td>
          {if $tx@first}
            <td><button type="button" onClick="getPhone();">
               Add Phone</button></td>
          {/if}
        </tr>
      {foreachelse}
        <tr><td></td><td></td>
        <td><button type="button" onClick="getPhone();">
               Add Phone</button></td></tr>
      {/foreach}
      <tr><td>&nbsp;</td></tr>
      {foreach $contact->email as $tx}
        <tr>
          <td class="label">{$tx.email_type}</td>
          <td><input
            name="{$tx.email_id}_email"
            value="{$tx.email}" /></td>
          <td><button type="submit" name="buttonAction"
             value="DeleteEmail_{$tx.email_id}">
             Delete this E-mail</button></td>
          {if $tx@first}
            <td><button type="button" onClick="getEmail();">
              Add E-mail</button></td>
          {/if}
        </tr>
      {foreachelse}
        <tr><td></td><td></td>
        <td><button type="button" onClick="getEmail();">
             Add E-mail</button></td></tr>
      {/foreach}
    </table>
    <input type="hidden" name="contact_id"
           value="{$user->contact_id}"/>
  </form>
{/block}
