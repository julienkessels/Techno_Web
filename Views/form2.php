<html>
<head>
  <title>Details</title>
  <link rel="stylesheet" href="style.css" type="text/css"/>
</head>
<body class="body">
  <form action="index.php" method="POST">
    <p>DETAIL DES RESERVATIONS</p>
    <?php echo $reservation->getError(); ?>
    <div class="div1">
      <?php for ($i=0; $i < $reservation->getNbrPersons(); $i++) {?>
        <div class="div2reservation2">
          <div class="div21">
            <p class="SmallText">Nom</p>
            <p class="SmallText">Age</p>
          </div>
          <div class="div21">
            <p class="SmallText"><input type="text" name="Nom[]" value=<?php echo $reservation->getPersons()[$i]->getName();?>></p>
            <p class="SmallText"><input type="text" name="Age[]" value=<?php echo $reservation->getPersons()[$i]->getAge();?>></p>
          </div>
          <div class="div22">
          </div>
        </div>
        <?php }?>
        <div>
          <input  type="hidden" name="step" value="2">
          <button type="submit" name="button" value="next">Etape suivante</button>
          <button type="submit" name="button" value="return">Etape précédente</button>
          <button type="submit" name="button" value="cancel">Annuler la réservation</button>
        </div>
      </div>

    </form>
  </body>
  </html>
