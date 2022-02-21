<?php

include 'Parameters.php';

class DB {
    public $connection;
    public function __construct() {
        $db_host        = "host = 127.0.0.1";
        $db_port        = "port = 5432";
        $db_name      = "dbname = twitter_db";
        $db_credentials = "user = twitter_user password=12345";
        $this->connection = pg_connect("$db_host $db_port $db_name $db_credentials");
    }

    public function __destruct() {
        pg_close($this->connection);
    }
}
