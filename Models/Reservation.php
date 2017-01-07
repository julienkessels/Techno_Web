<?php
include_once 'Person.php';
include_once("../config.php");

class Reservation
{
  private $resState;
  private $destination;
  private $nbrPersons = 0;
  private $insurance = "off";
  private $persons = array();
  private $id = 0;
  private $mysqli;
  private $error="";

  /**
  * Setter
  * @param the value of the property
  */
  public function setDestination($destination)
  {
    $this->destination = $destination;
  }

  /**
  * Getter
  * @return the value of the property
  */
  public function getDestination()
  {
    return $this->destination;
  }

  /**
  * Setter
  * @param the value of the property
  */
  public function setNbrPersons($nbrPersons)
  {
    $this->nbrPersons = $nbrPersons;
  }

  /**
  * Getter
  * @return the value of the property
  */
  public function getNbrPersons()
  {
    return $this->nbrPersons;
  }

  /**
  * Setter
  * @param the value of the property
  */
  public function setInsurance($insurance)
  {
    $this->insurance = $insurance;
  }

  /**
  * Getter
  * @return the value of the property
  */
  public function getInsurance()
  {
    return $this->insurance;
  }

  /**
  * Setter
  * @param the value of the property
  */
  public function addPerson($person)
  {
    $this->persons[] = $person;
  }

  /**
  * Getter
  * @return the value of the property
  */
  public function getPersons()
  {
    return $this->persons;
  }

  /**
  * Resets every Person saved
  * @param none
  * @return none
  */
  public function resetPersons()
  {
    $this->persons = array();
  }

  /**
  * Getter
  * @return the value of the property
  */
  public function getId()
  {
    return $this->id;
  }

  /**
  * Setter
  * @param the value of the property
  */
  public function setId($id)
  {
    $this->id = $id;
  }

  /**
  * Setter
  * @param the value of the property
  */
  public function setResState($state)
  {
    $this->resState = $state;
  }

  /**
  * Getter
  * @return the value of the property
  */
  public function getResState()
  {
    return $this->resState;
  }

  /**
  * Setter
  * @param the value of the property
  */
  public function setError($err)
  {
    $this->error = $err;
  }

  /**
  * Getter
  * @return the value of the property
  */
  public function getError()
  {
    return $this->error;
  }

  /**
  * Resets ever error
  * @param none
  * @return none
  */
  public function resetError()
  {
    $this->error = "";
  }
  /**
  * Checks for existing id in database
  * @param id
  * @return boolean
  */
  public function checkId($id)
  {
    $this->mysqli = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DB) or die('Could not select database');
    if ($this->mysqli->connect_errno) {
    }
    $check = "SELECT 1 FROM reservation.trip WHERE id=$id";
    $result = $this->mysqli->query($check);
    $array = $result->fetch_array(MYSQLI_ASSOC);
    if (count($array)>0) {
      return true;
    }
    else {
      return false;
    }
  }

  /**
  * Loads database value in reservation
  * @param id
  * @return array of elements
  */
  public function load_trip($id)
  {
    $this->mysqli = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DB) or die('Could not select database');
    if ($this->mysqli->connect_errno) {
      echo 'Echec lors de la connexion à MySQLi : ('.$this->mysqli->connect_errno.') '.$this->mysqli->connect_error;
    }
    $load_Trip = "SELECT * FROM reservation.trip WHERE id ='$id'";
    $result = $this->mysqli->query($load_Trip);
    foreach ($result as $res) {
      $count++;
      $this->setDestination($res['destination']);
      $this->setId($res['id']);
      $this->setInsurance($res['insurance']);
    }
    $array = $result->fetch_array(MYSQLI_ASSOC);
    return $array;
  }

  /**
  * Deletes reservation from Database
  * @param none
  * @return none
  */
  public function deleteTrip()
  {
    $sqlDeletePersons = "DELETE FROM reservation.persons WHERE id=$this->id";
    if ($this->mysqli->query($sqlDeletePersons) != true) {
      echo 'Error deleting record: '.$this->mysqli->error;
    }

    $sqlDeleteTrip = "DELETE FROM reservation.trip WHERE id=$this->id";
    if ($this->mysqli->query($sqlDeleteTrip) != true) {
      echo 'Error deleting record: '.$this->mysqli->error;
    }
  }

  /**
  * Loads person from existing reservation
  * @param id of reservation
  * @return array of elements
  */
  public function load_persons($id)
  {
    $this->mysqli = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DB) or die('Could not select database');
    if ($this->mysqli->connect_errno) {
      echo 'Echec lors de la connexion à MySQLi : ('.$this->mysqli->connect_errno.') '.$this->mysqli->connect_error;
    }
    $load_Persons = "SELECT * FROM reservation.persons WHERE id ='$id'";
    $result = $this->mysqli->query($load_Persons);
    $count = 0;
    foreach ($result as $res) {
      $count++;
      $this->addPerson(new Person($res['name'],$res['age']));
    }

    $this->setNbrPersons($count);
    $array = $result->fetch_array(MYSQLI_ASSOC);
    return $result;
  }

  /**
  * Saves reservation to database
  * @param none
  * @return none
  */
  public function save()
  {
    $this->mysqli = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DB) or die('Could not select database');
    if ($this->mysqli->connect_errno) {
      echo 'Echec lors de la connexion à MySQLi : ('.$this->mysqli->connect_errno.') '.$this->mysqli->connect_error;
    }
    if ($this->getResState()=="new") {

      $sqlReserv = "INSERT INTO reservation.trip(destination, insurance) VALUES('$this->destination','$this->insurance')";
      if ($this->mysqli->query($sqlReserv) == true) {
        //  echo 'Record updated successfully';
        $insert_id = $this->mysqli->insert_id;
        $this->id = $insert_id;
      }
      else {
        echo 'Error inserting record: '.$this->mysqli->error;
      }
      foreach ($this->persons as &$person) {
        $sqlPerson = "INSERT INTO reservation.persons(name, age, id) VALUES('$person->name','$person->age','$insert_id')";
        if ($this->mysqli->query($sqlPerson) != true) {
          echo 'Error inserting record: '.$this->mysqli->error;
        }
      }
    }
    elseif ($this->getResState()=="edit") {

      $sqlReserv = "UPDATE reservation.trip SET destination='$this->destination',insurance='$this->insurance' WHERE id=$this->id";
      if ($this->mysqli->query($sqlReserv) != true) {
        echo 'Error inserting record: '.$this->mysqli->error;
      }

      $sqlDeleteOld = "DELETE FROM reservation.persons WHERE id=$this->id";
      if ($this->mysqli->query($sqlDeleteOld) != true) {
        echo 'Error deleting record: '.$this->mysqli->error;
      }

      foreach ($this->persons as &$person) {
        $sqlPerson = "INSERT INTO reservation.persons(name, age, id) VALUES('$person->name','$person->age','$this->id')";
        if ($this->mysqli->query($sqlPerson) != true) {
          echo 'Error inserting record: '.$this->mysqli->error;
        }
      }
    }
  }
}
