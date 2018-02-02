<?php
namespace ContactForm\Core;

use PDO;
use PDOException;

class Database
{
    private $dbHost = DB_HOST;
    private $dbName = DB_NAME;
    private $dbUser = DB_USER;
    private $dbPass = DB_PASSWORD;
    private $db;
    private $stmt;
    private $error;

    public function __construct()
    {
        $dsn = 'mysql:host='.$this->dbHost.';dbname='.$this->dbName;
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ];
        try{
            $this->db = new PDO($dsn, $this->dbUser, $this->dbPass, $options);
        }catch(PDOException $ex){
            $this->error = $ex->getMessage();
            echo $this->error;
            die();
        }
    }

    public function query($sql)
    {
        $this->stmt = $this->db->prepare($sql);
    }

    public function bind($param, $value, $type = null)
    {
        if(empty($type)){
            switch(true){
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    public function execute()
    {
        $this->stmt->execute();
    }
}