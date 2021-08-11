<?php
   class conn_config{
        public $servername = "< dbs_server_ >";
        public $username = "< dbs_username >";
        public $password = "< dbs_password >";
        public $dbs = false;
    
        function __construct($dbs){
            $this->dbs = $dbs;
        }
    }
class sql{
    function __construct(){
        $this->set_dbs('< dbs_namr >');
    }
	function set_dbs($dbs){
		$this->dbs = $dbs;
	}
	function connection(){
		$dbs = new conn_config($this->dbs);
		return $conn  = new mysqli(
            $dbs->servername ,
            $dbs->username ,
            $dbs->password ,
            $dbs->dbs
        );
	}
    function select($query , $type , $param , $stm = 0){
        $conn  = $this->connection();
        $stmt = $conn->prepare($query);
        $stmt->bind_param($type,...$param);
        $stmt->execute();
        $result = $stmt->get_result();
        
        //check multiple row result
        if($stm == 0){
            return $result->fetch_assoc();
        }else{
            $ret = array();
            while($row = $result->fetch_assoc()){
                array_push( $ret, json_decode (json_encode($row)) );
            }
            return $ret;
        }
        
        $stmt->close();
        $conn->close();
    }
    
    function boolen($query , $type , $param){
            $conn  = $this->connection();
            $stmt = $conn->prepare($query);
            $stmt->bind_param($type,...$param);
            if($stmt->execute()){
                return true;
            }
            else
            {
                return false;
            }
            
            $stmt->close();
            $conn->close();
        }
	function insert($query , $type , $param){
            $conn  = $this->connection();
            $stmt = $conn->prepare($query);
            $stmt->bind_param($type,...$param);
            if($stmt->execute()){
                return $stmt->insert_id;
            }
            else
            {
                return false;
            }
            
            $stmt->close();
            $conn->close();
    }
}