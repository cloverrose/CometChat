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
        $sql = "SELECT * FROM $this->name WHERE dt >= '$dt' and pk <> '$pre_pk' ORDER BY dt;";
        $ret = $this->get($sql);
        return $ret;
    }

    public function insert($nick, $words, $dt){
        $sql = "INSERT INTO $this->name (nick, words, dt) values ('$nick', '$words', '$dt');";
        $this->link->query($sql);
    }
}
?>