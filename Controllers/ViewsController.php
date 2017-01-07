<?php
//Recovering input data
$step = isset($_POST['step']) ? checkData($_POST['step']) : -1;
$destination = isset($_POST['destination']) ? checkData($_POST['destination']) : NULL;
$nb = isset($_POST['nb']) ? checkData($_POST['nb']) : NULL;
$insurance = isset($_POST['ins']) ? checkData($_POST['ins']) : NULL;
$noms = isset($_POST['Nom']) ? checkData($_POST['Nom']) : NULL;
$ages = isset($_POST['Age']) ? checkData($_POST['Age']) : NULL;
$id = isset($_POST['id']) ? checkData($_POST['id']) : 0;

if ($id=="") {
  $id=0;
}

$error=false; //true if error needs to be displayed
$prix=0;  // final price

//Saving data in Model
if (!$destination==NULL) {
  $reservation->setDestination($destination);
}

if (!$nb==NULL) {
  $reservation->setNbrPersons($nb);
}

if (!$noms==NULL) {
  $reservation->resetPersons();
  foreach ($noms as $i => $nom) {
    $reservation->addPerson(new Person($nom, $ages[$i]));
  }
}

//Router that will display a view depending on user input / current view
switch ($step) {
  case -1: // user entering the site
  include 'Views/form0.php';
  break;
  case 0: // user was on the first view (Home - new reservation or edit reservation)
  //user wants to edit an existing reservation
  if($_POST['button']=="edit"){
    //Checks if the reservation number exists
    if ($reservation->checkId($id)) {
      //Reservation number exists -> storing reservation from database to current reservation
      $reservation = new Reservation;
      $_SESSION["reservation"] = $reservation;
      $reservation->setResState("edit");
      $oldTrip = $reservation->load_trip($id);
      $oldPersons = $reservation->load_persons($id);
      include 'Views/form1.php';
    }
    else{
      //Reservation number does not exist -> prompting an error
      $reservation->setError("Numéro de réservation introuvable.");
      include 'Views/form0.php';
    }
  }
  // user wants to make a new reservation
  else if($_POST['button']=="new"){
    $reservation = new Reservation;
    $_SESSION["reservation"] = $reservation;
    $reservation->setResState("new");
    include 'Views/form1.php';
  }
  break;
  case 1: // user was on the second view (destination & number of passengers)
  if ($_POST['button']=="next") {
    //Checking for error 1 : number of passengers not corresponding to criteras -> prompting an error
    if(!is_numeric($reservation->getNbrPersons()) || 0>=$reservation->getNbrPersons() || 10<=$reservation->getNbrPersons())
    {
      $reservation->setError("Veuillez entrer un nombre de places entre 0 et 10.");
      $error = true;
    }
    //Checking for error 2 : no valid destination -> prompting an error
    if ($reservation->getDestination()=="") {
      $reservation->setError("Veuillez entrer une destination.");
      $error = true;
    }
    //saving insurance state
    if (!$insurance==NULL) {
      $reservation->setInsurance("on");
    }
    else{
      $reservation->setInsurance("off");
    }
    //Prompting next step, or the same step if an error occured
    if ($error) {
      include("Views/form1.php");
    }
    else {
      include("Views/form2.php");
    }
  }
  //Client cancels a reservation
  else if($_POST['button']=="cancel"){
    $reservation = new Reservation;
    $_SESSION["reservation"] = $reservation;
    include("Views/form0.php");
  }
  break;
  case 2: //user was on the third view (passenger information)
  if ($_POST['button']=="next") {
    //Checks for errors regarding age limitations and input values errors
    $passengers = $reservation->getPersons();
    foreach ($passengers as $person) {
      if ($person->getAge() < 1) {
        $reservation->setError("Veuillez entrer un age suppérieur à 0.");
        $error=true;
      }
      if($person->getName()==""){
        $reservation->setError("Veuillez entrer un nom pour chaque personne.");
        $error=true;
      }
    }
    //Prompting next step, or the same step if an error occured
    if ($error) {
      include("Views/form2.php");
    }
    else {
      include("Views/form3.php");
    }
  }
  //Client cancels a reservation
  else if($_POST['button']=="cancel"){
    $reservation = new Reservation;
    $_SESSION["reservation"] = $reservation;
    include("Views/form0.php");
  }
  //Client wants to change something on previous step
  elseif ($_POST['button']=="return") {
    include("Views/form1.php");
  }
  break;
  case 3: //user is on 4th view (confirm view)
  // user confiming flight
  if ($_POST['button']=="confirm") {
    //Calculating price (insurance + kids + adults)
    if ($reservation->getInsurance()=="on") {
      $prix=$prix +20;
    }
    $passengers = $reservation->getPersons();
    foreach ($passengers as &$value) {
      if ($value->getAge() <12) {
        $prix=$prix +10;
      }
      else{
        $prix=$prix +15;
      }
    }
    $reservation->save();
    include("Views/form4.php");

  }
  //Client cancels a reservation
  elseif($_POST['button']=="cancel"){
    $reservation = new Reservation;
    $_SESSION["reservation"] = $reservation;
    include("Views/form0.php");
  }
  //Client wants to change something on previous step
  elseif ($_POST['button']=="return") {
    include("Views/form2.php");
  }
  break;
  default:
  break;
}

/**
*Checks input for bad characters
*@param user input
*@return user input - dangerous characters
*/
function checkData($data) {
  if (is_array($data)) {
    foreach ($data as &$value) {
      $value = trim($value);
      $value = stripslashes($value);
      $value = htmlspecialchars($value);
    }
    return $data;
  }
  else{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
  }
  return $data;
}
?>
