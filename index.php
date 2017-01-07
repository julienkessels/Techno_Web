<?php
include_once("config.php");
include_once("Models/Reservation.php");


//Starting the session
session_start();

if (!isset($_SESSION["reservation"])) //Creation of new reservation
{
  $reservation = new Reservation;
  $_SESSION["reservation"] = $reservation;
}
else {                                //Loading existing reservation
  $reservation = $_SESSION['reservation'];
  $reservation->setError("");
}

//Creates Reservation database if it doesn't exist
try
{
  $db = new PDO('mysql:host='.MYSQL_HOST.';dbname='.MYSQL_DB.';
  charset=UTF8', MYSQL_USER, MYSQL_PASS);
}
catch (Exception $e)
{
  //Creates DB if it is non existing
  $sql_db = "CREATE DATABASE IF NOT EXISTS `".MYSQL_DB."`;";

  //table1 : trip
  $sql_table1 = "CREATE TABLE IF NOT EXISTS `".MYSQL_DB."`.`trip`(
    `id` INT(16) NOT NULL AUTO_INCREMENT ,
    `destination` TEXT NOT NULL ,
    `insurance` TEXT NOT NULL ,
    PRIMARY KEY (`id`)) ENGINE = InnoDB;";

  //table2 : persons
  $sql_table2 = "CREATE TABLE IF NOT EXISTS `".MYSQL_DB."`.`persons` (
    `name` TEXT NOT NULL ,
    `age` INT(16) NOT NULL ,
    `id` INT(16) NOT NULL ) ENGINE = InnoDB;";

  try
  {
    $db = new PDO('mysql:host='.MYSQL_HOST.';', MYSQL_USER, MYSQL_PASS);
    $db->exec($sql_db);
    $db->exec($sql_table1);
    $db->exec($sql_table2);
  }
  catch (Exception $e)
  {
    die($e->getMessage());
  }
}

include("Controllers/ViewsController.php");
?>
