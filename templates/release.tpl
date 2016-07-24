{extends file="page.tpl"}

{block name="js"}
  <script src="js/release.js"></script>
{/block}

{block name="content"}
{if isset($user)}
  <p style="font-weight: bold;margin: 2px 0 10px">Release Changes to Live Database</p>

  <form id="release_form" action="release.php" method="post">
  <input type="hidden" name="contact_id"
         value="{$user->contact_id}"/>
  <table class="edit">
  <tr style="font-weight: bold;">
  <td class="release" style="border-width: 1px;">
      <input type="checkbox" id="user_data"
              name="user_data"
        onchange="changeCheck('#user_data','.user_data')" />
        </td>
  <td></td><td>Current</td><td>Proposed</td><td>By</td></tr>
  <tr><td class="release">
      <input type="checkbox" class="user_data"
             name="su_u_title_id"></td>
      <td>Title</td>
      <td>{$user->ud.title.o}</td>
      <td>{$user->ud.title.v}</td>
      
      <td>{$user->ud.user_name.v}</td>
  </tr>
     
  <tr><td class="release">
      <input type="checkbox" class="user_data"
             name="su_u_first_name"></td>
      <td>First Name</td>
      <td>{$user->ud.first_name.o}</td>
      <td class="{$user->ud.first_name.c}">{$user->ud.first_name.v}</td>
  </tr>
  <tr><td class="release">
      <input type="checkbox" class="user_data"
             name="su_u_nickname"></td>
      <td>Nickname</td>
      <td>{$user->ud.nickname.o}</td>
      <td class="{$user->ud.nickname.c}">{$user->ud.nickname.v}</td>
  </tr>
  <tr><td class="release">
      <input type="checkbox" class="user_data"
             name="su_u_middle_name"></td>
      <td>Middle/Maiden Name</td>
      <td>{$user->ud.middle_name.o}</td>
      <td class="{$user->ud.middle_name.c}">{$user->ud.middle_name.v}
      </td>
  </tr>
  <tr><td class="release">
      <input type="checkbox" class="user_data"
             name="su_u_primary_name"></td>
      <td>Last Name</td>
      <td>{$user->ud.primary_name.o}</td>
      <td class="{$user->ud.primary_name.c}">{$user->ud.primary_name.v}
      </td>
  </tr>
  <tr><td class="release">
      <input type="checkbox" class="user_data"
             name="su_u_degree_id"></td>
      <td>Degree</td>
      <td>{$user->ud.degree.o}</td>
      <td class="{$user->ud.degree_id.c}">{$user->ud.degree.v}</td>
  </tr>
  <tr><td class="release">
      <input type="checkbox" class="user_data"
             name="su_u_birth_date"></td>
      <td>Date of Birth</td>
      <td>{$user->ud.birth_date.o}</td>
      <td class="{$user->ud.birth_date.c}">
        {$user->ud.birth_date.v|date_format: "%m/%d/%Y"}</td>
  </tr>
  <tr>
  <td class="release" style="border-width: 0 1px 1px;">
      <input type="checkbox" class="user_data"
             name="su_u_gender"/></td>
      <td>Gender</td>
      <td>{$user->ud.gender.o}</td>
      <td class="{$user->ud.gender.c}">{$user->ud.gender.v}</td>
  </tr>

  {*  ADDRESS  *}
  {foreach $contact->ad as $tx}
    <tr><td>&nbsp;</td></tr>
    <tr><td class="release" style="border-width: 1px;">
       <input type="checkbox" id="a_{$tx.address_id.v}"
         name="a_{$tx.address_id.v}"
         onchange="changeCheck('#a_{$tx.address_id.v}',
             '.a_{$tx.address_id.v}')"/>
         </td></tr>
    <tr><td class="release">
        <input type="checkbox"
             class="a_{$tx.address_id.v}"
             name="sa_{$tx.address_id.v}_address_type_id">
             </td>
        <td>Address Type</td>
        <td>{$tx.address_type.o}</td>
        <td class="{$tx.address_type_id.c}">{$tx.address_type.v}</td>
        <td>{$tx.user_name.v}</td>
    </tr><tr>
      <td class="release">
      <input type="checkbox"
             name="sa_{$tx.address_id.v}_street_address_1"
             class="a_{$tx.address_id.v}"></td>
      <td>Address 1</td>
      <td>{$tx.street_address_1.o}</td>
      <td class="{$tx.street_address_1.c}">{$tx.street_address_1.v}</td>
    </tr><tr>
      <td class="release">
      <input type="checkbox"
             name="sa_{$tx.address_id.v}_street_address_2"
             class="a_{$tx.address_id.v}"></td>
      <td>Address 2</td>
      <td>{$tx.street_address_2.o}</td>
      <td class="{$tx.street_address_2.c}">{$tx.street_address_2.v}</td>
    </tr><tr>
      <td class="release">
      <input type="checkbox"
             name="sa_{$tx.address_id.v}_city"
             class="a_{$tx.address_id.v}"></td>
      <td>City</td>
      <td>{$tx.city.o}</td>
      <td class="{$tx.city.c}">{$tx.city.v}</td>
    </tr><tr>
      <td class="release">
      <input type="checkbox"
             name="sa_{$tx.address_id.v}_state"
             class="a_{$tx.address_id.v}"></td>
      <td>State</td>
      <td>{$tx.state.o}</td>
      <td class="{$tx.state.c}">{$tx.state.v}</td>
    </tr><tr>
      <td class="release">
      <input type="checkbox"
             name="sa_{$tx.address_id.v}_postal_code"
             class="a_{$tx.address_id.v}"></td>
      <td>Postal Code</td>
      <td>{$tx.postal_code.o}</td>
        <td class="{$tx.postal_code.c}">{$tx.postal_code.v}</td>
    </tr><tr>
      <td class="release"
          style="border-width: 0 1px 1px 1px;">
        <input type="checkbox"
             name="sa_{$tx.address_id.v}_country"
             class="a_{$tx.address_id.v}"></td>
      <td>Country</td>
      <td>{$tx.country.o}</td>
      <td class="{$tx.country.c}">{$tx.country.v}</td>
    </tr>
  {/foreach}

  {*  PHONE  *}
  {foreach $contact->ph as $tx}
    <tr><td>&nbsp;</td></tr>
    <tr><td class="release" style="border-width: 1px;">
       <input type="checkbox" id="p_{$tx.phone_id.v}"
         name="p_{$tx.phone_id.v}"
         onClick="changeCheck('#p_{$tx.phone_id.v}',
            '.p_{$tx.phone_id.v}')"/>
         </td></tr>
    <tr><td class="release">
    <input type="checkbox"
             name="sp_{$tx.phone_id.v}_phone_type_id"
            class="p_{$tx.phone_id.v}"></td>
        <td>Phone Type</td>
        <td>{$tx.phone_type.o}</td>
        <td class="{$tx.phone_type_id.c}">{$tx.phone_type.v}</td>
        <td>{$tx.user_name.v}</td></tr>
    <tr>
    <td class="release" style="border-width: 0 1px 1px;">
        <input type="checkbox"
             name="sp_{$tx.phone_id.v}_number"
               class="p_{$tx.phone_id.v}"/></td>
        <td>Number</td>
        <td>{$tx.number.o|formatPhone:$tx.formatted.o}</td>
        <td class="{$tx.number.c}">
          {$tx.number.v|formatPhone:$tx.formatted.v}</td></tr>
  {/foreach}
  
  {*  E-MAIL  *}
  {foreach $contact->em as $tx}
    <tr><td>&nbsp;</td></tr>
    <tr><td class="release" style="border-width: 1px;">
       <input type="checkbox" id="e_{$tx.email_id.v}"
             name="e_{$tx.email_id.v}" 
             onchange="changeCheck('#e_{$tx.email_id.v}',
                '.e_{$tx.email_id.v}')"/>
       </td></tr>
    <tr><td class="release">
    <input type="checkbox"
             name="se_{$tx.email_id.v}_email_type_id"
            class="e_{$tx.email_id.v}" /></td>
        <td>E-Mail Type</td>
        <td>{$tx.email_type.o}</td>
        <td class="{$tx.email_type_id.c}">{$tx.email_type.v}</td>
        <td>{$tx.user_name.v}</td></tr>
    <tr>
    <td class="release" style="border-width: 0 1px 1px;">
        <input type="checkbox"
             name="se_{$tx.email_id.v}_email"
            class="e_{$tx.email_id.v}"></td>
        <td>E-Mail</td>
        <td>{$tx.email.o}</td>
        <td class="{$tx.email.c}">{$tx.email.v}</td></tr>
  
  {/foreach}
  </table>
  </form>
{else}
  <p style="font-weight: bold;margin: 2px 0 10px">{$endmessage}</p>
{/if} {* isset $user *}
{/block}

  {block name="localmenu"}
  <label>
    <input type="checkbox" id="select_all"
           name="select_all"
         onchange="changeCheck('#select_all',':checkbox')"/>
    <b>Select All</b>
  </label>
  <br />
     <button form="release_form"
        id="release_button"
        {*onclick="releaseLive()"*}
        type="submit"
        name="buttonAction" value="release"
        style="margin-bottom: 5px;">
     Release Checked</button>
  <br />
  <button form="release_form" type="submit"
     name="buttonAction" value="next"
     style="margin-bottom: 5px;">Next</button>
  <br />
  <form id="edit_form" action="edit_contact.php" method="post">
    <button type="submit">Edit</button>
    <input name="contact_id" type="hidden" value="{$user->contact_id}"/>
    <input name="referrer" type="hidden" value="release"/>
  </form>
{/block}
