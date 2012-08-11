{foreach from=$roomlist item=room}
  <a href="chat.php?room={$room}">{$room}</a>
{/foreach}