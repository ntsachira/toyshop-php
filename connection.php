<?php

class DBdata{
    const HOST = "localhost";
    const USERNAME = "root";
    const PASSWORD = "ntsachira";
    const DATABASE = "toyshopdb";
    const PORT = "3306";
}

class Database
{
    public static $connection;

    public static function setConnection()
    {
        if (!isset(self::$connection)) {
            self::$connection = new mysqli(DBdata::HOST, DBdata::USERNAME, DBdata::PASSWORD, DBdata::DATABASE, DBdata::PORT);
        }
    }

    public static function execute ($query)
    {
        self::setConnection();
        
        $queryParts = explode(' ', $query);
        $firstWord = $queryParts[0];

        if ($firstWord == 'SELECT') {
            $result =  self::$connection->query($query);  
            if(!$result){
                $message = self::$connection->error;
                header("location:error.php?error=".$message);
            }else{
                return $result;
            }         
        } else {
            self::$connection->query($query);           
        }        
    }
}

class Database2{
    public static $pdo;

    public static function setConnection(){
        if(!isset(self::$pdo)){
            try {
                self::$pdo = new PDO("mysql:host=".DBdata::HOST.";dbname=".DBdata::DATABASE,DBdata::USERNAME,DBdata::PASSWORD);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                header("location:error.php?error=".$e->getMessage());
            }
        }
    }

    public static function execute($query){
        self::setConnection();
        
        $queryParts = explode(' ', $query);
        $firstWord = $queryParts[0];

        try {
            if ($firstWord == 'SELECT') {
                $statement = self::$pdo->prepare($query);  
                $statement->execute();   
                
                return $statement;  
            } else {
                $statement = self::$pdo->prepare($query);  
                $statement->execute();          
            }
        } catch (PDOException $e) {
            header("location:error.php?error=".$e->getMessage());
        } 
    }
}