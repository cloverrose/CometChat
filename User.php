<?php

class User{
    private $link;
    private $name = 'user';

    public function __construct(){
        include "db_info.php";
        $this->link = mysql_connect($host, $username, $password);
        mysql_select_db($dbname, $this->link);
    }

    public function __destruct(){
        mysql_close($this->link);
    }

    public function count(){
        $sql = "SELECT COUNT(*) FROM $this->name;";
        $result = mysql_query($sql, $this->link);
        $count = mysql_fetch_row($result);
        return $count[0];
    }

    public function get_pk($pk){
        $sql = "SELECT * FROM $this->name WHERE pk = '$pk';";
        $result = mysql_query($sql, $this->link);
        list($pk, $r, $n, $dt) = mysql_fetch_row($result);
        $user = array('pk' => $pk, 'room' => $r, 'nick' => $n, 'dt' => $dt);
        return $user;   
    }

    public function get_room($room){
        $sql = "SELECT * FROM $this->name WHERE room = '$room' ORDER BY dt;";
        $result = mysql_query($sql, $this->link);
        $rows = mysql_num_rows($result);
        $users = array();
        for($i=1;$i<=$rows; $i++) {
            list($pk, $r, $n, $dt) = mysql_fetch_row($result);
            $users[] = array('pk' => $pk, 'room' => $r, 'nick' => $n, 'dt' => $dt);
        }
        return $users;
    }

    public function get_usernames($room){
        $room = $this->get_room($room);
        $usernames = "";
        for($i=0;$i<count($room);$i++){
            $u = $room[$i];
            $usernames .= (':::' . $u['nick']);
            error_log($u['nick'], 3, '/home/rose/Documents/temp/usernames.log');
        }
        error_log($usernames, 3, '/home/rose/Documents/temp/usernames.log');
        return $usernames;
    }

    public function is_login($room, $nick){
        $sql = "SELECT * FROM $this->name WHERE room = '$room' and nick = '$nick' ORDER BY dt;";
        $result = mysql_query($sql, $this->link);
        $rows = mysql_num_rows($result);
        return $rows != 0;
    }

    public function select_dict(){
        $sql = "SELECT * FROM $this->name ORDER BY dt;";
        $result = mysql_query($sql, $this->link);
        $rows = mysql_num_rows($result);
        $users = array();
        for($i=1;$i<=$rows; $i++) {
            list($pk, $r, $n, $dt) = mysql_fetch_row($result);
            $users[] = array('pk' => $pk, 'room' => $r, 'nick' => $n, 'dt' => $dt);
        }
        return $users;
    }
  
    public function insert($room, $nick, $dt){
        $sql = "INSERT INTO $this->name (room, nick, dt) values ('$room', '$nick', '$dt');";
        mysql_query($sql, $this->link);
    }

    public function delete($room, $nick){
        $sql = "DELETE FROM $this->name WHERE room = '$room' and nick = '$nick';";
        mysql_query($sql, $this->link);
    }
}
?>