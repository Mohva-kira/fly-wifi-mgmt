<?php
/*
 * DB Class
 * This class is used for database related (connect, insert, and update) operations
 * @author    CodexWorld.com
 * @url        http://www.codexworld.com
 * @license    http://www.codexworld.com/license
 */
class DB{
    private $dbHost     = "flywifi_mysql_1";
    private $dbUsername = "root";
    private $dbPassword = "";
    private $dbName     = "flywifi";
    private $tblName    = "mobile_numbers";
    private $dbPort    = "9906";
    
    public function __construct(){
        if(!isset($this->db)){
            // Connect to the database
            $conn = new PDO("mysql:host=" . $this->dbHost . ";dbname=" . $this->dbName , $this->dbUsername, $this->dbPassword);
            if($conn->connect_error){
                die("Failed to connect with MySQL: " . $conn->connect_error);
            }else{
                $this->db = $conn;
            }
        }
    }
    
    /*
     * Returns rows from the database based on the conditions
     * @param string name of the table
     * @param array select, where, order_by, limit and return_type conditions
     */
    public function checkRow($conditions = array()){
        $sql = 'SELECT * FROM '.$this->tblName;
        if(!empty($conditions)&& is_array($conditions)){
            $sql .= ' WHERE ';
            $i = 0;
            foreach($conditions as $key => $value){
                $pre = ($i > 0)?' AND ':'';
                $sql .= $pre.$key." = ".$value."";
                $i++;
            }
        }
        $result =$this->db->query($sql);
        echo json_encode(array("message" => "Row found", $result->rowCount()));
        return !empty($result->rowCount() > 0)?true:false;
    }
    
    /*
     * Insert data into the database
     * @param string name of the table
     * @param array the data for inserting into the table
     */
    public function insert($data){
        if(!empty($data) && is_array($data)){
            $columns = '';
            $values  = '';
            $i = 0;
            foreach($data as $key=>$val){
                $pre = ($i > 0)?', ':'';
                $columns .= $pre.$key;
                $values  .= $pre."'".$val."'";
                $i++;
            }
            $query = "INSERT INTO ".$this->tblName." (".$columns.") VALUES (".$values.")";
            $insert = $this->db->query($query);
          
    
            return $insert ;
        }else{
            return false;
        }
    }
    
    /*
     * Update data into the database
     * @param string name of the table
     * @param array the data for updating into the table
     * @param array where condition on updating data
     */
    public function update($data,$conditions){
        if(!empty($data) && is_array($data)){
            $colvalSet = '';
            $whereSql = '';
            $i = 0;
            foreach($data as $key=>$val){
                $pre = ($i > 0)?', ':'';
                $colvalSet .= $pre.$key."='".$val."'";
                $i++;
            }
            if(!empty($conditions)&& is_array($conditions)){
                $whereSql .= ' WHERE ';
                $i = 0;
                foreach($conditions as $key => $value){
                    $pre = ($i > 0)?' AND ':'';
                    $whereSql .= $pre.$key." = '".$value."'";
                    $i++;
                }
            }
            $query = "UPDATE ".$this->tblName." SET ".$colvalSet.$whereSql;
            $update = $this->db->query($query);
            return $update;
        }else{
            return false;
        }
    }
}