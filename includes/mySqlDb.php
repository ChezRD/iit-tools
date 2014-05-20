<?php
/**
 *Database Class
 *For one point of database access
 */
class Database
{
  /**
   *User name to connect to database
   *@var string $_mysqlUser
   */
  private static $_mysqlUser = 'iit-tools';
  /**
   *Password to connect to database
   *@var string $_mysqlPass
   */
  private static $_mysqlPass = 'Lab22408#';
  /**
   *Database name
   *@var string $_mysqlDb
   */
  private static $_mysqlDb = 'iit-tools';
  /**
   *Hostname for the server
   *@var string $_hostname
   */
  private static $_hostName = 'localhost';
  /**
   *Database connetion
   *@var Mysqli $_connection
   */
  private static $_connection = NULL;
  /**
   *Constructor
   */
  private function __construct() {
  }
  /**
   *Get the databse connection
   *
   *@return Mysqli
   */
  public static function MySqlConnection() {
    if (!self::$_connection) {
      self::$_connection = new mysqli(self::$_hostName,self::$_mysqlUser, self::$_mysqlPass, self::$_mysqlDb);
      if (self::$_connection->connect_error) {
	die('Connect Error:' . self::$_connection->connect_error);
      }
    }
    return self::$_connection;
  }
}
