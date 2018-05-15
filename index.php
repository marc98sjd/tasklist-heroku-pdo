<form action="" method="POST">
	<big><b>TASK LIST  ||</b></big> <i>things to do</i>
	<br><br>
	<input type="text" name="tasca" placeholder="introdueix la tasca">
	<input type="submit" name="enviar" value="Afegir">
</form>


<?php
  try {
    $hostname = "ec2-54-163-240-54.compute-1.amazonaws.com";
    $dbname = "d8t86b7otkttua	";
    $username = "htoqcllnwfuwfc";
    $pw = "b181f5ec8a27b545f35b86c81a4e3bd34f65d1fe3209e3cb8c2abf0bc5dc5bd3";
    $pdo = new PDO ("pgsql:host=$hostname;dbname=$dbname","$username","$pw");
  } catch (PDOException $e) {
    echo "Failed to get DB handle: " . $e->getMessage() . "\n";
    exit;
  }

   if (isset($_POST['tasca'])) {
  	$crearTarea = "INSERT INTO tasks VALUES ('".$_POST['tasca']."')";
  	$resultado = $pdo->prepare($crearTarea);
    try {
      $resultado->execute();
    } catch (PDOException $e) {
      echo "Fallo al insertar el elemento: " . $e->getMessage() . "\n";
    }
  } else {
  	echo "<br>no se ha añadido nada";
  }
  
  //preparem i executem la consulta
  $query = $pdo->prepare("select * FROM tasks");
  $query->execute();

  //anem agafant les fileres d'amb una amb una
  $row = $query->fetch();
  echo "<ul>";
  while ( $row ) {
    echo "<li>".$row['tasca']."</li>";
    $row = $query->fetch();
  }
  echo "</ul>";

  //eliminem els objectes per alliberar memòria
  unset($_POST['tasca']);
  unset($pdo); 
  unset($query)

?>