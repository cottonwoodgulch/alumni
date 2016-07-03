{* this template section needs to be {include}d in 
   a template that extends page.tpl *}

  {if isset($roster)}
    <h4>Rosters:</h4>
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
  {/if}
