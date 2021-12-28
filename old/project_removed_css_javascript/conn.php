<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
	//check if the database file exists and create a new if not
	if(!is_file('db/db_member.sqlite3')){
		file_put_contents('db/db_member.sqlite3', null);
	}
	// connecting the database
	//$conn = new PDO('sqlite:db/db_member.sqlite3');
	$GLOBALS['conn'] = new SQLite3('db/db_member.sqlite3', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
	//Setting connection attributes
	//$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//Query for creating reating the member table in the database if not exist yet.
	$query = "CREATE TABLE IF NOT EXISTS member(mem_id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username TEXT, password TEXT, firstname TEXT, lastname TEXT)";
	//Executing the query
	$GLOBALS['conn']->exec($query);
?>
