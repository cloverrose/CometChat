<?php

class Chat{
    private $link;
    private $name = 'chat';

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
            $speak = array('pk' => $row['pk'],
                           'nick' => $row['nick'],
                           'words' => $row['words'],
                           'dt' => $row['dt']);
        }else{
            $speak = null;
        }
        $result->close();
        return $speak;   
    }

    public function find_post($dt, $pre_pk){
        $sql = "SELECT * FROM $this->name WHERE dt >= '$dt' ORDER BY dt;";
        $result = $this->link->query($sql);
        while($row = $result->fetch_assoc()){
            $speak = array('pk' => $row['pk'],
                           'nick' => $row['nick'],
                           'words' => $row['words'],
                           'dt' => $row['dt']);
            if($speak['pk'] != $pre_pk){
                $result->close();
                return $speak;
            }
        }
        $result->close();
        return null;
    }

    public function select_dict(){
        $sql = "SELECT * FROM $this->name ORDER BY dt;";
        $result = $this->link->query($sql);
        $speaks = array();
        while($row = $result->fetch_assoc()) {
            $speaks[] = array('pk' => $row['pk'],
                              'nick' => $row['nick'],
                              'words' => $row['words'],
                              'dt' => $row['dt']);
        }
        $result->close();
        return $speaks;
   }

    public function insert($nick, $words, $dt){
        $sql = "INSERT INTO $this->name (nick, words, dt) values ('$nick', '$words', '$dt');";
        $this->link->query($sql);
    }
}
?>