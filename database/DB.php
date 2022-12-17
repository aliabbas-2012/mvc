<?php
session_start();
class DB{
    // properties
    private static $_host = "";
    private static $_username = "";
    private static $_password = '';
    private static $_database = '';
    static protected $connection;

    // Methods

// make connection
    

    private static function startConnection(){
        self::$_host = host;
        self::$_username = username;
        self::$_password = password;
        self::$_database = dbname;
        self::$connection =  new mysqli(self::$_host, self::$_username, self::$_password,self::$_database); 
        
    }
    // close connection

    private static function closeConnection(){
        self::$connection->close();
    }
// insert data


    public static function insert($table, $payload){
        $table_columns = implode(',', array_keys($payload));
        $table_value = implode("','", $payload);
         $sql="INSERT INTO $table($table_columns) VALUES('$table_value')";
    print_r($sql);
        self::startConnection();
    //    print_r();
    //    die; 
        mysqli_query(self::$connection,$sql);
        $pk = mysqli_insert_id(self::$connection);
        self::closeConnection();
        $payload['id'] = $pk;
      
        return $payload;
    }
// update connection

    public static function update($table, $id, $payload){
        $args = [];
        foreach ($payload as $key => $value) {
            $args[] = "$key = '$value'"; 
        }
        $data  = implode(',',$args);
        $sql="UPDATE  {$table} SET $data WHERE id='$id' ";
        self::startConnection();
        mysqli_query(self::$connection,$sql);
        // $pk = mysqli_insert_id(self::$connection);
        self::closeConnection();
        return $payload;
    }
// delete connection

    public static function delete($table,$id){
        
        $sql="DELETE FROM $table WHERE id='$id'";
        self::startConnection();
        mysqli_query(self::$connection,$sql);
        self::closeConnection();
    }
// get data connection

    public static function get($table ,$id){
        $sql = "Select * from $table where id = $id";
        
        self::startConnection();
        $result =  mysqli_query(self::$connection,$sql);
        $row =  mysqli_fetch_assoc($result);
        
        self::closeConnection();
        return $row;
    }
    public static function getList($table,$param=null){
     
        $sql = "Select * from $table";
        if($param != null){
          $sql .=" where ". implode(" ", $param);
    
        }

        self::startConnection();
        $result =  mysqli_query(self::$connection,$sql);
        $rows =  mysqli_fetch_all($result,MYSQLI_ASSOC);
        self::closeConnection();
        return $rows;
    }
    public static function getAttributeByValue($table,$column,$value, $pk, $pk_column){
         $sql = "Select * from $table where $column='$value'";
        if(!empty($pk) &&  $pk > 0){
            $sql.=" AND {$pk_column} <> $pk";
        }
        self::startConnection();
        $result =  mysqli_query(self::$connection,$sql);
        $row =  mysqli_fetch_assoc($result);
        self::closeConnection();
        return $row;
    }
    public static function loginUser($table,$payload){
        $email = $payload['email'];
        $pass = $payload['password'];
         $sql = "Select * from $table where  email='$email' and password='$pass'";
        // print_r($sql);
        // die;
        self::startConnection();
        $result =  mysqli_query(self::$connection,$sql);
        
        $row =  mysqli_fetch_assoc($result);
        self::closeConnection();
        return $row;
        
    }

}
