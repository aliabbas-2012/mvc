<?php

use LDAP\Result;

class Model implements Crud, Validate
{
    // properties

    protected static $table_name = "";
    protected $id = "";
    public $attributes;
    public $rules = ["required" => [], "unique" => []];
    public $loginrules = [
        "length" => [],
        "required" => []
    ];
    protected static $primary_key = "id";


    // methods


    // constructer

    public function __construct()
    {

        $this->attributes = new stdClass;
    }
    // create
    public function create($payload)
    {
        // print_r($payload);
        // die;
        // die;
        $table = get_class($this)::$table_name;
        $this->setInstance($payload);
        $this->validate();
        // print_r($this->errors);
        // die;
        if (empty($this->errors)) {

            $res = DB::insert($table, $payload);
            $this->setInstance($res);
        }
    }
    // update
    public function update($payload)
    {
        $table = get_class($this)::$table_name;
        $this->setInstance($payload);
        $this->validate();
        if (empty($this->errors)) {

            $res = DB::update($table, $this->id, $payload);
            $this->setInstance($res);
        }
    }
    // delete
    public function delete()
    {
        $table = get_class($this)::$table_name;
        DB::delete($table, $this->id);
    }

    // get recorde by id

    public static function get($id)

    {
        $class = get_called_class();
        // echo $id;
        // echo $class::$table_name;
        // die;
        $class = get_called_class();
        $row = DB::get($class::$table_name, $id);

        $instance = new $class();
        $instance->setInstance($row);
        return $instance;
    }

    /**
     * 
     */
    public static function getList($param = null)
    {


        $class = get_called_class();
        $obj = new $class();
        if ($param != null) {

            if (isset($param['condition'])) {
                foreach ($param['condition'] as $key => $value) {
                    $result = $obj->checkArray($value);

                    if (is_array($result)) {
                        $query[] = "(";
                        foreach ($value as $subkey => $subvalue) {
                            if (is_array($subvalue)) {
                                foreach ($subvalue as $field => $result) {
                                    if (is_string($field)) {
                                        $query[] = "$field " .  $obj->getoperator($result);
                                    } else {
                                        $query[] = $result;
                                    }
                                }
                            }
                        }
                        $query[] = ")";
                    } else {
                        foreach ($value as $subkey => $subvalue) {

                            if (is_string($subkey)) {
                                $query[] = "$subkey " . $obj->getoperator($subvalue);
                            }
                            if (is_int($subkey)) {
                                $query[]  = $subvalue;
                            }
                        }
                    }
                }
            }
            if (isset($param['order_by'])) {
                foreach ($param['order_by'] as $col => $row) {
                    $query[] = "order by " . $col . " $row";
                }
            }
            $param = $query;
        }

        $rows = DB::getList($class::$table_name, $param);

        return $obj->multiInstance($rows);
    }

    //create multiple instance in array 

    private function multiInstance($rows)
    {
        $class = get_called_class();
        foreach ($rows as $payload) {
            $obj = new $class;
            $obj->setInstance($payload);
            $array[] =  $obj;
        }
        return $array;
    }

    // create instance

    private function setInstance($payload)
    {
        // $pk = $this->pk;
        // if (!isset($this->$pk)) {
        //     $this->$pk = null;
        // }

        if (is_array($payload)) {

            foreach ($payload as $col => $val) {
                $this->$col = $val;
                $this->attributes->$col = $val;
                $_SESSION['user'][$col] = $val;
            }
        }

        return $this;
    }

    // insert validation

    public function validate()
    {
        $this->validteAlphabet($this->rules['alphabet']);
        $this->validateUnique($this->rules['unique']);
        $this->validteLength($this->rules['length']);
        $this->validteRequire($this->rules['required']);
        return $this;
    }


    // method

    // validteRequire
    public function validteRequire($payload)
    {
        foreach ($payload as $field => $value) {
            if (is_string($field)) {
                if (empty($this->$field)) {
                    $this->errors[$field] = $value;
                    $_SESSION['error'][$field] = $value;
                }
            } else {
                if (empty($this->$value)) {

                    $this->errors[$value] = " is Required";
                    $_SESSION['error'][$value] = "is Required";
                }
            }
        }
    }
    // validteAlphabet
    public function validteAlphabet($payload)
    {

        foreach ($payload as $field => $value) {
            if (is_string($field)) {
                if (!preg_match("/^[a-zA-Z ]*$/", $this->$field)) {
                    $this->errors[$field] = $value;
                    $_SESSION['error'][$field] = $value;
                    //  $_SESSION['error'][$field];
                    //  print_r($_SESSION['error']);
                    //  die;
                    // echo $field;
                    // die;
                } 
            } else {
                if (!preg_match("/^[a-zA-Z ]*$/", $this->$value)) {
                    $this->errors[$value] = "Only alphabets and white space are allowed";
                    $_SESSION['error'][$value] = "Only alphabets and white space are allowed";
                } 
            }
            // if (!preg_match("/^[a-zA-Z ]*$/", $this->$value)){
            //     $this->errors[$value] = "Only alphabets and white space are allowed";
            // }
        }
    }
    // validateUnique
    public  function validateUnique($payload)
    {
        $pk_column = $this->getPrimaryKeyColumn();

        foreach ($payload as $field => $value) {
            if (is_string($field)) {
                $model =  self::getAttributeByValue($field, $this->$field, $this->$pk_column);
                if (!empty($model)) {
                    $this->errors[$field] = $value;
                    $_SESSION['error'][$field] = $value;
                }
                
            } else {
                $model =  self::getAttributeByValue($field, $this->$value, $this->$pk_column);
                if (!empty($model)) {

                    $this->errors[$value] = " this '" . $this->$value . "' $value already in use";
                    $_SESSION['error'][$value] = " this '" . $this->$value . "' $value already in use";
                }
                
            }
        }
    }
    // validteLength
    public function validteLength($payload)
    {

        foreach ($payload as $field => $value) {
            foreach ($value as $key => $data) {
                if ($key == "max") {
                    if (is_array($data)) {
                        foreach ($data as $subkey => $value) {
                            $max = $value;
                            $valueKey = $subkey;
                        }

                        if (strlen($this->$field) > $valueKey) {
                            $this->errors[$field] = $max;
                            $_SESSION['error'][$field] = $max;
                        }
                        
                    } else {
                        $max = $data;
                        if (strlen($this->$field) > $max) {
                            $this->errors[$field] = "The maximum length of $field must $max characters";
                            $_SESSION['error'][$field] = "The maximum length of $field must $max characters";
                        }
                        
                    }
                } else {
                    if (is_array($data)) {
                        foreach ($data as $subkey => $value) {
                            $min = $value;
                            $valueKey = $subkey;
                        }
                        if (strlen($this->$field) < $valueKey) {
                            $this->errors[$field] = $min;
                            $_SESSION['error'][$field] = $min;
                        }
                        
                    } else {
                        $min = $data;
                        if (strlen($this->$field) < $min) {
                            $this->errors[$field] = "The maximum length of $field must $min characters";
                            $_SESSION['error'][$field] = "The maximum length of $field must $min characters";
                        }
                        
                    }
                }
            }
        }
    }
    public static function getAttributeByValue($column, $value, $pk = null)
    {

        $class = self::getCalledClass();
        $pk_column = $class::$primary_key;
        $row = DB::getAttributeByValue($class::$table_name, $column, $value, $pk, $pk_column);
        
        return $row;
    }

    private function getPrimaryKeyColumn()
    {
        $class = get_called_class();
        $pk_column = $class::$primary_key;
        return $pk_column;
    }

    private function getTableName()
    {
        $class = get_called_class();

        $pk_column = $class::$table_name;
        return $pk_column;
    }

    private static function getCalledClass()
    {
        return get_called_class();
    }
    public static function getoperator($data)
    {
        foreach ($data as $key => $value) {
            switch ($key) {
                case "endWith":
                    return "like '%$value'";
                    break;
                case "startWith":
                    return "like '$value%'";
                    break;
                case "greaterThan":
                    return "> '$value'";
                    break;
                case "lessThan":
                    return "< '$value'";
                    break;
                case "equal":
                    return "= '$value'";
                    break;
                case "notEqual":
                    return "<> '$value'";
                    break;
            }
        }
    }
    public static function checkArray($data)
    {
        foreach ($data as $value) {
            if (is_array($value)) {
                foreach ($value as $subvalue) {
                    if (is_array($subvalue)) {
                        return $subvalue;
                        break;
                    }
                }
            } else {
                return "false";
            }
        }
    }
    public function loginValidate()
    {
        // $this->validteLength($this->loginrules['length']);
        $this->validteRequire($this->loginrules['required']);

        return $this;
    }
    public static function login($payload)
    {
        $class = self::getCalledClass();
        $instance = new $class();
        $instance->setInstance($payload);
        $instance->loginValidate();
        if (empty($instance->errors)) {
            $row = DB::loginUser($class::$table_name, $payload);
            if (!empty($row)) {
                $instance->setInstance($row);
                $_SESSION['error']["loginError"] = "";
            } else {
                $instance->errors["loginError"] = "Please enter correct Email and password please try again";
                $_SESSION['error']["loginError"] = "Please enter correct Email and password please try again";
            }
        }
        return $instance;
    }
}
