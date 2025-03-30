<?php
class ConnexionBD
{
    private static $_dbname = "school_db";
    private static $_user = "";
    private static $_pwd = "";
    private static $_host = "localhost";
    private static $_bdd = null;

    // Constructor now receives dynamic credentials
    private function __construct($db_user, $db_pass)
    {
        self::$_user = $db_user;
        self::$_pwd = $db_pass;
        try {
            self::$_bdd = new PDO("mysql:host=" . self::$_host . ";dbname=" . self::$_dbname . ";charset=utf8", self::$_user, self::$_pwd,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'));
        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    // Singleton pattern to only create one connection instance
    public static function getInstance($db_user = null, $db_pass = null)
    {
        if (self::$_bdd === null && $db_user && $db_pass) {
            new ConnexionBD($db_user, $db_pass); // Create a new instance if needed
        }
        return self::$_bdd;
    }
}
?>
