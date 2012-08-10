<?php

abstract class Model{
    protected $link;
    protected $name;

    public function __construct($name){
        include "db_info.php";
        $this->link = new mysqli($host, $username, $password, $dbname);
        $this->name = $name;
    }

    public function __destruct(){
        $this->link->close();
    }

    abstract protected function row2array($row);

    protected function num($sql){
        $result = $this->link->query($sql);
        $row = $result->fetch_row();
        $count = $row[0];
        $result->close();
        return $count;
    }

    protected function safeget($stmt){
        // return first result
        // if empty set return null
        $stmt->execute();
        $result = $stmt->get_result();
        if($row = $result->fetch_assoc()){
            $ret = $this->row2array($row);
        }else{
            $ret = null;
        }
        $result->close();
        $stmt->close();
        return $ret;
    }

    protected function get($sql){
        // return first result
        // if empty set return null
        $result = $this->link->query($sql);
        if($row = $result->fetch_assoc()){
            $ret = $this->row2array($row);
        }else{
            $ret = null;
        }
        $result->close();
        return $ret;
    }

    protected function safefilter($stmt){
        // return all result
        $stmt->execute();
        $result = $stmt->get_result();
        $rets = array();
        while($row = $result->fetch_assoc()) {
            $rets[] = $this->row2array($row);
        }
        $result->close();
        $stmt->close();
        return $rets;
    }

    protected function filter($sql){
        // return all result
        $result = $this->link->query($sql);
        $rets = array();
        while($row = $result->fetch_assoc()) {
            $rets[] = $this->row2array($row);
        }
        $result->close();
        return $rets;
    }

    public function count(){
        $sql = "SELECT COUNT(*) FROM $this->name;";
        $ret = $this->num($sql);
        return $ret;
    }

    public function get_pk($pk){
        $stmt = $this->link->prepare("SELECT * FROM $this->name WHERE pk = ?");
        $stmt->bind_param("i", $pk);
        $ret = $this->safeget($stmt);
        return $ret;
    }

    public function select_dict(){
        $sql = "SELECT * FROM $this->name ORDER BY dt, pk;";
        $ret = $this->filter($sql);
        return $ret;
   }
}
?>