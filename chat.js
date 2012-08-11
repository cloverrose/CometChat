var htmlEscape = (function(){
  var map = {"<":"&lt;", ">":"&gt;", "&":"&amp;", "'":"&#39;", "\"":"&quot;", " ":"&nbsp;"};
  var replaceStr = function(s){ return map[s]; };
  return function(str) { return str.replace(/<|>|&|'|"|\s/g, replaceStr); };
})();

function onLoad() {
    Event.observe($("login_button"), "click", onLogin, false);
    Event.observe($("logout_button"), "click", onLogout, false);
    Event.observe($("write_button"), "click", onWrite, false);
    Element.hide("room_info");
    Element.hide("write_form");
    Element.hide("logout_form");
    Field.focus("login_username");
    onRead("force");
}

function jparse(responseText, key){
    var obj = JSON.parse(responseText);
    if(key == "read_response"){
	return obj.read_response;
    }else if (key == "login_users"){
	return obj.login_users;
    }
    return obj;
}
function onRead(option) {
    var room = $F("login_room");
    var url = "read.php?option=" + option + "&room=" + encodeURIComponent(room);
    new Ajax.Request(url,
        {
            method: "get",
            onComplete: function(request) {
                $("read_timestamp").innerHTML = new Date() + 'read ' + option;
                $("read_response").innerHTML = jparse(request.responseText, "read_response");
		$("login_users").innerHTML = jparse(request.responseText, "login_users");
                onRead("wait");
            }
        }
    );
}

function onLogin() {
    var username = $F("login_username");
    var username_e = htmlEscape(username);
    var room = $F("login_room");
    var url = "login.php?username=" + encodeURIComponent(username) + "&room=" + encodeURIComponent(room);
    new Ajax.Request(url,
        {
            method: "get",
            onComplete: function(request) {
                $("read_timestamp").innerHTML = new Date() + 'login';
                $("read_response").innerHTML = jparse(request.responseText, "read_response");
                $("write_username").innerHTML = username_e + ": ";
		$("login_users").innerHTML = jparse(request.responseText, "login_users");
                Field.clear("write_message");
                Element.hide("login_form");
                Element.show("write_form");
                Element.show("logout_form");
                Field.focus("write_message");
            }
        }
    );
}

function onLogout() {
    var username = $F("login_username");
    var room = $F("login_room");
    var url = "logout.php?username=" + encodeURIComponent(username) + "&room=" + encodeURIComponent(room);
    new Ajax.Request(url,
        {
            method: "get",
            onComplete: function(request) {
                $("read_timestamp").innerHTML = new Date() + 'logout';
                $("read_response").innerHTML = jparse(request.responseText, "read_response");
                $("write_username").innerHTML = "";
		$("login_users").innerHTML = jparse(request.responseText, "login_users");
                Field.clear("write_message");
                Element.show("login_form");
                Element.hide("write_form");
                Element.hide("logout_form");
                Field.clear("login_username");
                Field.focus("login_username");		
            }
        }
    );
}

function onWrite() {
    var username = $F("login_username");
    var message = $F("write_message");
    var room = $F("login_room");
    var pk = 0;
    var display_form = $("display_form");
    var radiolist = display_form.pk;
    for(var i=0;i<radiolist.length;i++){
	if(radiolist[i].checked){
            pk = radiolist[i].value;
	    break;
	}
    }
    var url = "write.php?username=" + encodeURIComponent(username) + "&message=" + encodeURIComponent(message) + "&pk=" + encodeURIComponent(pk) + "&room=" + encodeURIComponent(room);
    new Ajax.Request(url,
        {
            method: "get",
            onComplete: function(request) {
                $("read_timestamp").innerHTML = new Date() + 'write';
                $("read_response").innerHTML = jparse(request.responseText, "read_response");
		$("login_users").innerHTML = jparse(request.responseText, "login_users");
                Field.clear("write_message");
                Element.hide("login_form");
                Element.show("write_form");
                Element.show("logout_form");
                Field.focus("write_message");
            }
        }
    );
}


// for index.html

function onLoad2() {
    Event.observe($("create_room_button"), "click", onCreateRoom, false);
    Field.focus("create_room");
    onRead2("force");
}

function onRead2(option) {
    var url = "roomlist.php?option=" + option;
    new Ajax.Request(url,
        {
            method: "get",
            onComplete: function(request) {
                $("roomlist").innerHTML = request.responseText;
		onRead2("wait");
            }
        }
    );
}

function onCreateRoom() {
    var room = $F("create_room");
    var url = "createroom.php?room=" + encodeURIComponent(room);
    new Ajax.Request(url,
        {
            method: "get",
            onComplete: function(request) {
                $("roomlist").innerHTML = request.responseText;
                Field.clear("create_room");
                Field.focus("create_room");
            }
        }
    );
}
