<?php

class books{

    	private static $conn;
	public $isbn;
        public $title;
	public $description;
	public $search_term;
   
    
    public static function connect_it($connection)
    {
   	books::$conn=$connection;
    }
    public static function allbooks($table)
    {
    	$conn=books::$conn;
    	$query = "SELECT * FROM $table";
	$result = $conn->query($query);
	$table=$result->fetchAll(PDO::FETCH_CLASS,"books");
	return $table;
    }
    
}


?>