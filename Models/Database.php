<?php
/*
* created by Michael Jarratt
* this class processes queries, it can either run inserts and return nothing,
* or can run selects and return the results as an associative index.
* this is a singleton class
*/

class Database
{
    private $connection; //PDO to interact with database
    static private $database; //holds an instance of itself (singleton)

    private function __construct()
    {
        $serverName = //name of the server hosting your mySQL DB;
        $username = //your username on the server;
        $password = //your password for the server;
        $this->connection = new PDO("mysql:host=$serverName;dbname=hackcamp10_spatdb", $username, $password);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //sets error mode to create an exception saying what went wrong
    }

    //returns instance of Database
    public static function getInstance()
    {
        if(!isset(self::$database)) //if an instance does not already exist
        {
            self::$database = new Database();
        }
        return self::$database;
    }

    /*
     *  Executes SELECT queries and returns any results in the form of an associatively indexed array
     */
    public function retrieve($query)
    {
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC); //sets array to associative indexing
        $result = $statement->fetchAll();
        return $result;
    }

    /*
     * executes any query that updates the database, does not return output
     */
    public function update($query)
    {
        $statement = $this->connection->prepare($query);
        $statement->execute();
    }
}
