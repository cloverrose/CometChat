<?php
require_once "Model.php";

class Chat extends Model{
    public function __construct(){
        parent::__construct('chat');
    }

    protected function row2array($row){
        return array('pk' => $row['pk'],
                     'nick' => htmlspecialchars($row['nick'], ENT_QUOTES, 'UTF-8'),
                     'words' => htmlspecialchars($row['words'], ENT_QUOTES, 'UTF-8'),
                     'dt' => $row['dt'],
                     'room' => htmlspecialchars($row['room'], ENT_QUOTES, 'UTF-8'));
    }

    public function find_post($dt, $pre_pk, $room){
        $stmt = $this->link->prepare("SELECT * FROM $this->name WHERE dt >= ? and pk <> ? and room = ? ORDER BY dt");
        $stmt->bind_param("sis", $dt, $pre_pk, $room);
        $ret = $this->safeget($stmt);
        return $ret;
    }

    public function filter_room($room){
        $stmt = $this->link->prepare("SELECT * FROM $this->name WHERE room = ? ORDER BY dt, pk");
        $stmt->bind_param("s", $room);
        $rets = $this->safefilter($stmt);
        return $rets;
    }

    public function get_max_pk($room){
        $stmt = $this->link->prepare("SELECT * FROM $this->name WHERE room = ? ORDER BY pk DESC LIMIT 1");
        $stmt->bind_param("s", $room);
        $ret = $this->safeget($stmt);
        $pk = $ret['pk'];
        return $pk;
    }

    public function insert($nick, $words, $dt, $room){
        $stmt = $this->link->prepare("INSERT INTO $this->name (nick, words, dt, room) values (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nick, $words, $dt, $room);
        $stmt->execute();
        $stmt->close();
    }
}
?>