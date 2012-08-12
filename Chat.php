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
                     'room' => htmlspecialchars($row['room'], ENT_QUOTES, 'UTF-8'),
                     'mt' => $row['mt']);
    }

    public function find_post($mt, $pre_pk, $room){
        $stmt = $this->link->prepare("SELECT * FROM $this->name WHERE mt >= ? and pk <> ? and room = ? ORDER BY mt");
        $stmt->bind_param("sis", $mt, $pre_pk, $room);
        $ret = $this->safeget($stmt);
        return $ret;
    }

    public function filter_room($room){
        $stmt = $this->link->prepare("SELECT * FROM $this->name WHERE room = ? ORDER BY mt, pk");
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

    public function insert($nick, $words, $dt, $room, $mt){
        $stmt = $this->link->prepare("INSERT INTO $this->name (nick, words, dt, room, mt) values (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $nick, $words, $dt, $room, $mt);
        $stmt->execute();
        $stmt->close();
    }
}
?>