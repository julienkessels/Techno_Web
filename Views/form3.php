<html>
<head>
  <title>VALIDATION DES RESERVATIONS</title>
  <link rel="stylesheet" href="style.css" type="text/css"/>
</head>
<body class="body">
  <form action="index.php" method="POST">
    <p>VALIDATION DES RESERVATIONS</p>
    <div class="div2reservation2">
      <div class="div21">
        <p class="SmallText">Destination</p>
        <p class="SmallText">Assurance</p>
      </div>
      <div class="div21">
        <p class="SmallText"><?php echo $reservation->getDestination();?></p>
        <p id="pAssurance" class="SmallText"><?php echo ($reservation->getInsurance()=="on" ? 'Oui' : 'Non');?></p>
      </div>
      <div class="div22">
      </div>
    </div>
    <?php for ($i=0; $i < $reservation->getNbrPersons() ; $i++) {?>
      <div class="div2reservation2">
        <div class="div21">
          <p class="SmallText">Nom</p>
          <p class="SmallText">Age</p>
        </div>
        <div class="div21">
          <p id="pNom<?php echo $i;?>" class="SmallText"><?php echo $passengers[$i]->name;?></p>
          <p id="pAge<?php echo $i;?>" class="SmallText"><?php echo $passengers[$i]->age;?></p>
        </div>
        <div class="div22">
        </div>
      </div>
      <?php } ?>
      <div>
        <input type="hidden" name="step" value="3">
        <button name="button" type="submit" value="confirm">Confirmer</button>
        <button name="button" type="submit" value="return">Etape précédente</button>
        <button name="button" type="submit" value="cancel">Annuler la réservation</button>
      </div>

    </div>
  </form>

</body>
</html>
