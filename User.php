<?php
require_once "Model.php";

class User extends Model{
    public function __construct(){
        parent::__construct('user');
    }

    protected function row2array($row){
        return array('pk' => $row['pk'],
                     'room' => htmlspecialchars($row['room'], ENT_QUOTES, 'UTF-8'),
                     'nick' => htmlspecialchars($row['nick'], ENT_QUOTES, 'UTF-8'),
                     'dt' => $row['dt']);
    }

    public function get_room($room){
        $sql = "SELECT * FROM $this->name WHERE room = '$room' ORDER BY dt;";
        $rets = $this->filter($sql);
        return $rets;
    }

    public function get_usernames($room){
        $room = $this->get_room($room);
        $usernames = "";
        for($i=0;$i<count($room);$i++){
            $u = $room[$i];
            $usernames .= (':::' . $u['nick']);
        }
        return $usernames;
    }

    public function is_login($room, $nick){
        $sql = "SELECT * FROM $this->name WHERE room = '$room' and nick = '$nick' ORDER BY dt;";
        $result = $this->link->query($sql);
        $row_cnt = $result->num_rows;
        $result->close();
        return $row_cnt != 0;
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