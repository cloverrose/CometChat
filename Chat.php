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
                      'dt' => $row['dt']);
    }

    public function find_post($dt, $pre_pk){
        $stmt = $this->link->prepare("SELECT * FROM $this->name WHERE dt >= ? and pk <> ? ORDER BY dt");
        $stmt->bind_param("si", $dt, $pre_pk);
        $ret = $this->safeget($stmt);
        return $ret;
    }

    public function insert($nick, $words, $dt){
        $stmt = $this->link->prepare("INSERT INTO $this->name (nick, words, dt) values (?, ?, ?)");
        $stmt->bind_param("sss", $nick, $words, $dt);
        $stmt->execute();
        $stmt->close();
    }
}
?>