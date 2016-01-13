<?php

//Connection to xamp database.

//define("DB_DATA_SOURCE", "mysql:host=localhost;dbname=u1470153");
//define("DB_USERNAME", 'root');
//define("DB_PASSWORD","");


//connection to selene
define("DB_DATA_SOURCE", "mysql:host=localhost;dbname=u1470153");
define("DB_USERNAME", 'u1470153');
define("DB_PASSWORD",""); //add password



//check that we can connect to the database.
class ConnectionFactory{
    private static $conn;
    public static function connect()
    {
        if(!self::$conn)
        {
            try{
                self::$conn = new PDO(DB_DATA_SOURCE, DB_USERNAME, DB_PASSWORD);
                //echo " Database connected";
             }
             catch (PDOException $exception) 
             {
                echo "Oops, you brooke it" . $exception->getMessage();
             }
        }
        return self ::$conn;
    }
}

$conn=ConnectionFactory::connect();

?>