<?php 
class wizwiz_option{

    var $conn;
    var $db;

    public function __construct()
    {     
        $this->db = new wizwiz_db();
    }

    public function get_option( $key ){
        if( isset($key) && !empty($key) ){
            $sql = "SELECT * FROM `setting` where `type` = '{$key}'";
            $result = $this->db->query($sql);
            if( isset($result['value']) && $result['value'] != null ){
                return $result['value'];
            }else{
                return '';
            }
        }
    }

    public function update_option( $key, $value ){
        if( isset($key) && !empty($key) ){
            $sql = "SELECT * FROM `setting` where `type` = $key";
            $result = $this->db->query($sql);
            if( isset($result['id']) && $result['id'] != null ){
                $this->db->query("UPDATE setting SET value='{$value}' WHERE id=".$result['id']);
            }else{
                $sql = "INSERT INTO `setting` (`id`, `type`, `value`) VALUES (NULL, $key, $value );";
                $this->db->query($sql);
            }
        }
    }

}

class wizwiz_db{

    
    var $conn;

    public function __construct()
    {
        // include db file
        ################################
        require 'includ/db.php';
        $this->conn = $conn;
        ################################        
    }

    public function query($sql){
        $stmt   = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        if (strpos($sql, "SELECT") !== false) {
            $result = $result->fetch_assoc();
        }
        
        $stmt->close();    
        return $result;
    }

}
