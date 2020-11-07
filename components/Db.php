<?php


class Db
{
    private static $instance = null;
    private static $conn;


    private function __construct() {
        $dbConfigs = ROOT . '/configs/db.php';
        $params = include($dbConfigs);

        $dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
        self::$conn = new PDO($dsn, $params['user'], $params['password'],  [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"]);
    }

    private static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function getConnection()
    {
        $object = self::getInstance();
        return $object::$conn;
    }

    /**
     *  Disable the clone
     * @throws Exception
     */
    final public function __clone()
    {
        throw new Exception('Feature disabled.');
    }

    /**
     * Disable the wakeup of this class.
     *
     * @return void
     * @throws Exception
     */
    final public function __wakeup()
    {
        throw new Exception('Feature disabled.');
    }


}