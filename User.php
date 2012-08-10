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
        $stmt = $this->link->prepare("SELECT * FROM $this->name WHERE room = ? ORDER BY dt");
        $stmt->bind_param("s", $room);
        $rets = $this->safefilter($stmt);
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
        $stmt = $this->link->prepare("SELECT * FROM $this->name WHERE room = ? and nick = ? ORDER BY dt");
        $stmt->bind_param("ss", $room, $nick);
        $stmt->execute();
        $result = $stmt->get_result();
        $row_cnt = $result->num_rows;
        $result->close();
        $stmt->close();
        return $row_cnt != 0;
    }
  
    public function insert($room, $nick, $dt){
        $stmt = $this->link->prepare("INSERT INTO $this->name (room, nick, dt) values (?, ?, ?)");
        $stmt->bind_param("sss", $room, $nick, $dt);
        $stmt->execute();
        $stmt->close();
    }

    public function delete($room, $nick){
        $stmt = $this->link->prepare("DELETE FROM $this->name WHERE room = ? and nick = ?");
        $stmt->bind_param("ss", $room, $nick);
        $stmt->execute();
        $stmt->close();
    }
}
?>