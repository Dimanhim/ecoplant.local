<?php

class Db {
  public static $db = false;

  public static function getConnection() {
    if (self::$db) {
      return self::$db;
    }

    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
    self::$db = new PDO($dsn, DB_USER, DB_PASSWORD);
    // $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    self::$db->exec("set names utf8;");

    return self::$db;
  }
}