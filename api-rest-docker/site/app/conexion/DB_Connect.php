<?php
 
class DB_Connect {
 
    // constructor
    function __construct() 
    {
         
    }
 
    // destructor
    function __destruct() 
    {
        // $this->close();
    }
 
    // Connecting to database
    public function connect() 
    {
        require_once 'Config.php';

        $host = getenv('DB_HOST');
        $dbname = getenv('DB_NAME');
        $user = getenv('MYSQL_USER');
        $password = getenv('MYSQL_PASSWORD');
        $charset = getenv('DB_CHARSET');

        $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
        $con = new PDO($dsn, $user, $password);

        $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
        // return database handler
        return $con;
    }
 
    // Closing database connection
    public function close() 
    {
        // mysql_close();
    }
 
}
 
?>