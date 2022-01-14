<?php
require __DIR__ . "../helpers.php";

class PDOConfig extends PDO {
    private $engine;
    private $host;
    private $database;
    private $user;
    private $pass;
    private $port;
    private $db;


    public function __construct() {
        $this->engine = "mysql";
        $this->host = get_env_value("MYSQL_HOST");
        $this->database = get_env_value("MYSQL_DATABASE");
        $this->user = get_env_value("MYSQL_USER");
        $this->pass = get_env_value("MYSQL_PASSWORD");
        $this->port = get_env_value("MYSQL_PORT");
        $dsn = $this->engine . ':dbname=' . $this->database . ';host=' . $this->host . ';port=' . $this->port;
        parent::__construct($dsn, $this->user, $this->pass);
    }
}

?>
