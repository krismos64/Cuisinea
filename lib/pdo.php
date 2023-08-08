<?php
class Database
{
    private static $dbHost = "mysql-krismos64.alwaysdata.net";
    private static $dbName = "krismos64_cuisinea";
    private static $dbUsername = "krismos64";
    private static $dbUserpassword = "Mostefaoui1";
    
    private static $connection = null;
    
    public static function connect()
    {
        if(self::$connection == null)
        {
            try
            {
              self::$connection = new PDO("mysql:host=" . self::$dbHost . ";dbname=" . self::$dbName , self::$dbUsername, self::$dbUserpassword);
            }
            catch(PDOException $e)
            {
                die($e->getMessage());
            }
        }
        return self::$connection;
    }
    
    public static function disconnect()
    {
        self::$connection = null;
    }

}

?>