<?php

class User{
    private $link;
    private $name = 'user';

    public function __construct(){
        include "db_info.php";
        $this->link = new mysqli($host, $username, $password, $dbname);
    }

    public function __destruct(){
        $this->link->close();
    }

    public function count(){
        $sql = "SELECT COUNT(*) FROM $this->name;";
        $result = $this->link->query($sql);
        $row = $result->fetch_row();
        $count = $row[0];
        $result->close();
        return $count;
    }

    public function get_pk($pk){
        $sql = "SELECT * FROM $this->name WHERE pk = '$pk';";
        $result = $this->link->query($sql);
        if($row = $result->fetch_assoc()){
            $user = array('pk' => $row['pk'],
                          'room' => $row['room'],
                          'nick' => $row['nick'],
                          'dt' => $row['dt']);
        }else{
            $user = null;
        }
        $result->close();
        return $user;   
    }

    public function get_room($room){
        $sql = "SELECT * FROM $this->name WHERE room = '$room' ORDER BY dt;";
        $result = $this->link->query($sql);
        $users = array();
        while($row = $result->fetch_assoc()){
            $users[] = array('pk' => $row['pk'],
                             'room' => $row['room'],
                             'nick' => $row['nick'],
                             'dt' => $row['dt']);
        }
        $result->close();
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
        $result = $this->link->query($sql);
        $row_cnt = $result->num_rows();
        $result->close();
        return $row_cnt != 0;
    }

    public function select_dict(){
        $sql = "SELECT * FROM $this->name ORDER BY dt;";
        $result = $this->link->query($sql);
        $users = array();
        while($row = $result->fetch_assoc()) {
            $users[] = array('pk' => $row['pk'],
                             'room' => $row['room'],
                             'nick' => $row['nick'],
                             'dt' => $row['dt']);
        }
        $result->close();
        return $users;
    }
  
    public function insert($room, $nick, $dt){
        $sql = "INSERT INTO $this->name (room, nick, dt) values ('$room', '$nick', '$dt');";
        $this->link->query($sql);
    }

    public function delete($room, $nick){
        $sql = "DELETE FROM $this->name WHERE room = '$room' and nick = '$nick';";
        $this->link->query($sql);
    }
}
?>