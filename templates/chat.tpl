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

    <body onload="onLoad()">
        <h1><a href="index.php">Chat</a></h1>

	<form id="room_info">
            <input id="login_room" type="text" size="10" value="{$room}" />
        </form>

	<h2>Login Users</h2>
	<p id="login_users"></p>

	<form id="login_form" onSubmit="onLogin(); return false;">
            <span class="caption">Enter username to login:</span>
            <input id="login_username" type="text" size="10" value="" />
            <input id="login_button" type="button" value="Login" />
        </form>

        <form id="write_form" onSubmit="onWrite(); return false;">
            <span id="write_username" class="caption"></span>
            <input id="write_message" type="text" size="40" value="" />
            <input id="write_button" type="button" value="Write" />
        </form>

        <form id="logout_form" onSubmit="onLogout(); return false;">
            <input id="logout_button" type="button" value="Logout" />
        </form>

        <h2>Chat Log</h2>

	<p id="read_timestamp"></p>        
        <p id="read_response"></p>

    </body>
</html>
