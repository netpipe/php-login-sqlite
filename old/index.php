<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title></title>

</head>
<body>
<br> testing </br>
<?php
// This file walks you through the most common features of PHP's SQLite3 API.
// The code is runnable in its entirety and results in an `analytics.sqlite` file.

//https://gist.github.com/bladeSk/6294d3266370868601a7d2e50285dbf5

// Create a new database, if the file doesn't exist and open it for reading/writing.
// The extension of the file is arbitrary.
$db = new SQLite3('analytics.sqlite', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);

// Create a table.
function createtable(){
$GLOBALS['db'] = new SQLite3('analytics.sqlite', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
	$GLOBALS['db']->query('CREATE TABLE IF NOT EXISTS "visits" (
    "id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    "password" VARCHAR,
"user_id" INTEGER,
    "url" VARCHAR,
    "time" DATETIME
	)');

}

// Insert some sample data.
//
// It's advisable to wrap related queries in a transaction (BEGIN and COMMIT),
// even if you don't care about atomicity.
// If you don't do this, SQLite automatically wraps every single query
// in a transaction, which slows down everything immensely. If you're new to SQLite,
// you may be surprised why the INSERTs are so slow.

function insert1(){
$GLOBALS['db']->exec('BEGIN');
$GLOBALS['db']->query('INSERT INTO "visits" ("user_id", "password","url", "time")
    VALUES (42, "/test","/test", "2017-01-14 10:11:23")');
$GLOBALS['db']->query('INSERT INTO "visits" ("user_id", "password","url", "time")
    VALUES (42, "/test2","/test2", "2017-01-14 10:11:44")');
$GLOBALS['db']->exec('COMMIT');
}


// Insert potentially unsafe data with a prepared statement.
// You can do this with named parameters:
function insert2(){
$statement = $GLOBALS['db']->prepare('INSERT INTO "visits" ("user_id","password", "url", "time")
    VALUES (:uid,  :password,:url, :time)');
$statement->bindValue(':uid', 1337);
$statement->bindValue(':password', '/test');
$statement->bindValue(':url', '/test');
$statement->bindValue(':time', date('Y-m-d H:i:s'));
$statement->execute(); // you can reuse the statement with different values
}




createtable();
insert1();
insert2();
//$db->close();

//$db = new SQLite3('analytics.sqlite', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
// Fetch today's visits of user #42.
// We'll use a prepared statement again, but with numbered parameters this time:

$statement = $db->prepare('SELECT * FROM "visits" WHERE "user_id" = ? AND "time" >= ?');
$statement->bindValue(1, 42);
$statement->bindValue(2, '2017-01-14');
$result = $statement->execute();

echo("Get the 1st row as an associative array:\n");
print_r($result->fetchArray(SQLITE3_ASSOC));
echo("\n");

echo("Get the next row as a numeric array:\n");
print_r($result->fetchArray(SQLITE3_NUM));
echo("\n");

// If there are no more rows, fetchArray() returns FALSE.

// free the memory, this in NOT done automatically, while your script is running
$result->finalize();


// A useful shorthand for fetching a single row as an associative array.
// The second parameter means we want all the selected columns.
//
// Watch out, this shorthand doesn't support parameter binding, but you can
// escape the strings instead.
// Always put the values in SINGLE quotes! Double quotes are used for table
// and column names (similar to backticks in MySQL).

$query = 'SELECT * FROM "visits" WHERE "url" = \'' .
    SQLite3::escapeString('/test') .
    '\' ORDER BY "id" DESC LIMIT 1';

$lastVisit = $db->querySingle($query, true);

echo("Last visit of '/test':\n");
print_r($lastVisit);
echo("\n");


// Another useful shorthand for retrieving just one value.

$userCount = $db->querySingle('SELECT COUNT(DISTINCT "user_id") FROM "visits"');

echo("User count: $userCount\n");
echo("\n");
// Finally, close the database.
// This is done automatically when the script finishes, though.

?>

</body>
</html>

$db->close();
