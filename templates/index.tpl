<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC
  "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">

    <head>
        <meta http-equiv="Content-Language" content="ja" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="content-style-type" content="text/css" />
        <meta http-equiv="content-script-type" content="text/javascript" />
        <script type="text/javascript" src="prototype.js"></script>
        <script type="text/javascript" src="chat.js"></script>
        <link href="chat.css" type="text/css" rel="stylesheet" />
        <title>Chat</title>
    </head>

    <body onload="onLoad2()">
        <h1>Chat Entrance</h1>
	
	<span class="caption">Select room:</span>
	<p id="roomlist"></p>

	<form id="create_room_form" onSubmit="onCreateRoom(); return false;">
	    <span class="caption">or create room:</span><br />
            <input id="create_room" type="text" size="15" value="" />
            <input id="create_room_button" type="button" value="Create" />
        </form>
    </body>
</html>
