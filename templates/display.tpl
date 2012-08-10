<form id="display_form">
<input type="radio" name="pk" value="0"><br />
{foreach from=$speaks item=speak}
  {if $speak.pk eq $now}
  <span class="now"> 
  [{$speak.pk}][{$speak.dt}]{$speak.nick}: {$speak.words}<br />
  </span>
  <input type="radio" name="pk" value="{$speak.pk}" checked><br />
  {else}
  [{$speak.pk}][{$speak.dt}]{$speak.nick}: {$speak.words}<br />
  <input type="radio" name="pk" value="{$speak.pk}"><br />
  {/if}
{/foreach}
</form>