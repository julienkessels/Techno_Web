<?php
$reservation = new Reservation;
$_SESSION["reservation"] = $reservation;
header( "refresh:3; url=index.php" );
?>
<html>
<head>
  <title>Confirmation</title>
  <link rel="stylesheet" href="style.css" type="text/css"/>
</head>
<body class="body">
  <p id="titre">CONFIRMATION DES RESERVATIONS</p>
  <div class="div1">
    <p class="SmallText">Votre demande a bien été enregistrée. Votre numéro de réservation est : <?php echo $reservation->getId(); ?> </p>
    <p class="SmallText">Merci de bien vouloir verser la somme de <?php echo $prix ?> sur le compte 000-0000-000.</p>
  </div>
</body>
</html>
