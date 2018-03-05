<?php

namespace src\Core;

class DB
{
    /**
     * @var \PDO $db
     */
    protected $db;

    /**
     * DB constructor.
     */
    public function __construct(){
        $this->db = $this->getDBConnection();
    }

    private function getDBConnection()
    {
        $dbhost="localhost";
        $dbuser="root";
        $dbpass="";
        $dbname="test-levi";

        $dbConnection = new \PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);

        $dbConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        return $dbConnection;
    }
}