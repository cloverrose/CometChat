<?php

class Chat{
    private $link;
    private $name = 'chat';

    public function __construct(){
        include "db_info.php";
        $this->link = mysql_connect($host, $username, $password);
        mysql_select_db($dbname, $this->link);
    }

    public function __destruct(){
        mysql_close($this->link);
    }

    public function count(){
        $sql = "SELECT COUNT(*) FROM chat;";
        $result = mysql_query($sql, $this->link);
        $count = mysql_fetch_row($result);
        return $count[0];
    }

    public function get_pk($pk){
        $sql = "SELECT * FROM chat WHERE pk = '$pk';";
        $result = mysql_query($sql, $this->link);
        list($pk, $n, $w, $dt) = mysql_fetch_row($result);
        $speak = array('pk' => $pk, 'nick' => $n, 'words' => $w, 'dt' => $dt);
        return $speak;   
    }

    public function find_post($dt, $pre_pk){
        $sql = "SELECT * FROM chat WHERE dt >= '$dt' ORDER BY dt;";
        $result = mysql_query($sql, $this->link);
        $rows = mysql_num_rows($result);
        $post = null;
        for($i=1;$i<=$rows; $i++) {
            list($pk, $n, $w, $dt) = mysql_fetch_row($result);
            if($pk != $pre_pk){
                return array('pk' => $pk, 'nick' => $n, 'words' => $w, 'dt' => $dt);
            }
        }
        return null;
    }

    public function select_dict(){
        $sql = "SELECT * FROM chat ORDER BY dt;";
        $result = mysql_query($sql, $this->link);
        $rows = mysql_num_rows($result);
        $speaks = array();
        for($i=1;$i<=$rows; $i++) {
            list($pk, $n, $w, $dt) = mysql_fetch_row($result);
            $speaks[] = array('pk' => $pk, 'nick' => $n, 'words' => $w, 'dt' => $dt);
        }
        return $speaks;
    }

    public function insert($nick, $words, $dt){
        $sql = "INSERT INTO chat(nick, words, dt) values ('$nick', '$words', '$dt');";
        mysql_query($sql, $this->link);
    }
}
?>