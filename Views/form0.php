<html>
<head>
  <title>Réservation</title>
  <link rel="stylesheet" href="style.css" type="text/css"/>
</head>
<body class="body">
  <form action="index.php" method="POST">
    <p id="titre">RESERVATION</p>
    <?php echo $reservation->getError(); ?>
    <div class="div2">
      <div class="div21">
        <p class="SmallText">Numéro de réservation pour modifier une réservation :</p>
      </div>
      <div class="div21">
        <p class="SmallText" style="width:200px;"><input id="id" type="text" name="id" value=""></p>
      </div>
      <button name="button" type="submit" value="edit" style="width:200px;">Editer une réservation</button>
    </div>
     <button name="button" type="submit" value="new">Créer une réservation</button>
    <input name="step" type="hidden" value="0">
  </form>
</body>
</html>
