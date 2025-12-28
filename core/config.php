<?php
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
date_default_timezone_set('Asia/Ho_Chi_Minh');
class teamapiit {
    private $ketnoi;
    private $localhost;
    private $server;
    private $pass_db;
    private $user_db;

    public function __construct() {
        $this->localhost = $_ENV['DB_HOST'];
        $this->server   = $_ENV['DB_NAME'];
        $this->pass_db  = $_ENV['DB_PASS'];
        $this->user_db  = $_ENV['DB_USER'];
    }
    function ketnoi() {
        if (!$this->ketnoi) {
            $this->ketnoi = mysqli_connect($this->localhost, $this->user_db, $this->pass_db, $this->server) 
                or die('Bạn chưa kết nối database');
            mysqli_query($this->ketnoi, "set names 'utf8'");
        }
    }
    public function insert($table,$data){
        $this->ketnoi();
        $field_list = '';
        $value_list = '';
        foreach ($data as $key => $value) {
            $field_list .= ",$key";
            $value_list .= ",'".mysqli_real_escape_string($this->ketnoi, $value)."'";
        }
        $sql = 'INSERT INTO '.$table. '('.trim($field_list, ',').') VALUES ('.trim($value_list, ',').')';

        return mysqli_query($this->ketnoi, $sql);
    }
    public function remove($table, $where)
    {
        $this->ketnoi();
        $sql = "DELETE FROM $table WHERE $where";
        return mysqli_query($this->ketnoi, $sql);
    }
    public function get_list($sql)
    {
        $this->ketnoi();
        $result = mysqli_query($this->ketnoi, $sql);
        if (!$result) {
            die('Câu truy vấn bị sai');
        }
        $return = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $return[] = $row;
        }
        mysqli_free_result($result);
        return $return;
    }
    public function get_row($sql)
    {
        $this->ketnoi();
        $result = mysqli_query($this->ketnoi, $sql);
        if (!$result) {
            die('Câu truy vấn bị sai');
        }
        $row = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        if ($row) {
            return $row;
        }
        return false;
    }
    public function update($table, $data, $where)
    {
        $this->ketnoi();
        $sql = '';
        foreach ($data as $key => $value) {
            $sql .= "$key = '".mysqli_real_escape_string($this->ketnoi, $value)."',";
        }
        $sql = 'UPDATE '.$table. ' SET '.trim($sql, ',').' WHERE '.$where;
        return mysqli_query($this->ketnoi, $sql);
    }
    public function num_rows($sql)
    {
        $this->ketnoi();
        $result = mysqli_query($this->ketnoi, $sql);
        if (!$result) {
            die('Câu truy vấn bị sai');
        }
        $row = mysqli_num_rows($result);
        mysqli_free_result($result);
        if ($row) {
            return $row;
        }
        return false;
    }
    public function cong($table, $data, $sotien, $where)
    {
        $this->ketnoi();
        $row = $this->ketnoi->query("UPDATE `$table` SET `$data` = `$data` + '$sotien' WHERE $where ");
        return $row;
    }
    public function tru($table, $data , $sotien , $where)
    {
        $this->ketnoi();
        $row = $this->ketnoi->query("UPDATE `$table` SET `$data` = `$data` - $sotien WHERE $where ");
        return $row;
    }
    public function site($data)
    {
        $this->ketnoi();
        $row = $this->ketnoi->query("SELECT * FROM `options` WHERE `key` = '$data' ")->fetch_array();
        return $row['value'];
    }
    public function begin_transaction() 
    {
        $this->ketnoi();
        mysqli_begin_transaction($this->ketnoi);
    }
    public function commit() 
    {
        mysqli_commit($this->ketnoi);
    }
    public function rollback() 
    {
        mysqli_rollback($this->ketnoi);
    }
}

?>