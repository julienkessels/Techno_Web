<html>
<head>
  <title>Réservation</title>
  <link rel="stylesheet" href="style.css" type="text/css"/>
</head>
<body class="body">
  <form action="index.php" method="POST">
    <p id="titre">RESERVATION</p>
    <?php echo $reservation->getError(); ?>
    <div class="div1">
      <p class="SmallText">Le prix de la place est de 10 euros jusqu'à 12 ans, ensuite de 15 euros.</p>
      <p class="SmallText">Le prix de l'assurance annulation est de 20 euros quel que soit le nombre de voyageurs.</p>
      <div class="div2">
        <div class="div21">
          <p class="SmallText">Destination</p>
          <p class="SmallText">Nombre de places</p>
          <p class="SmallText">Assurance annulations</p>
        </div>
        <div class="div21">
          <p class="SmallText"><input id="destination" type="text" name="destination" value=<?php echo $reservation->getDestination();?>></p>
          <p class="SmallText"><input id="nb" type="text" name="nb" value=<?php echo ($reservation->getNbrPersons()==0 ? '' :$reservation->getNbrPersons());?>></p>
          <p class="SmallText"><input id="ins" type="checkbox" name="ins" <?php echo ($reservation->getInsurance()=="on" ? 'checked' : '');?> ></p>
        </div>
      </div>
      <div>
        <input  name="step"   type="hidden" value="1">
        <button name="button" type="submit" value="next">Etape suivante</button>
        <button name="button" type="submit" value="cancel">Annuler la réservation</button>
      </div>
    </div>
  </form>
</body>
</html>
