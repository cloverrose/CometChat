<form id="display_form">
<input type="radio" name="pk" value="0"><br />
{foreach from=$speaks item=speak}
  [{$speak.pk}][{$speak.dt}]{$speak.nick}: {$speak.words}<br />
  <input type="radio" name="pk" value="{$speak.pk}" checked><br />
{/foreach}
</form>