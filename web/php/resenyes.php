<?php
include 'db.php';

$sql_taula = "CREATE TABLE IF NOT EXISTS ressenyes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    puntuacio INT NOT NULL,
    comentari TEXT NOT NULL,
    data_creacio TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";

$conexion->query($sql_taula);

$sql = "SELECT id, nom, email, puntuacio, comentari, data_creacio FROM ressenyes ORDER BY data_creacio DESC";
$resultat = mysqli_query($conexion, $sql);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Ressenyes - RIFFHUB</title>
  <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>

<body>
  <div class="pagina-marco">

    <div class="bloque-destacado">
      <h1>Ressenyes de RIFFHUB</h1>
      <p>Envia una ressenya sobre la teva experiència amb les sales, instruments i serveis de RIFFHUB.</p>
    </div>

    <div class="seccion">
      <h2 class="titulo-seccion">Nova ressenya</h2>

      <div class="distribucion-contacto">
        <div class="caja-contacto">
          <form class="formulario-contacto" action="crear_resenya.php" method="post" accept-charset="UTF-8">
            <p>Nom:</p>
            <p><input type="text" name="resenya_nom" required></p>

            <p>Email:</p>
            <p><input type="email" name="resenya_email" required></p>

            <p>Puntuació:</p>
            <p>
              <select name="resenya_puntuacio" required>
                <option value="5">5 - Excel·lent</option>
                <option value="4">4 - Molt bé</option>
                <option value="3">3 - Bé</option>
                <option value="2">2 - Regular</option>
                <option value="1">1 - Malament</option>
              </select>
            </p>

            <p>Comentari:</p>
            <p><textarea name="resenya_comentari" rows="6" cols="40" required></textarea></p>

            <p><input type="submit" value="Enviar ressenya" class="boton-busqueda"></p>
          </form>
        </div>

        <div class="caja-contacto caja-contacto-final">
          <h3>Dades que es guarden</h3>
          <p class="texto-secundario">Aquest formulari envia les dades al servidor amb el mètode POST i les desa a la base de dades.</p>

          <table class="tabla-precios">
            <tr>
              <th>Camp</th>
              <th>Descripció</th>
            </tr>
            <tr>
              <td>nom</td>
              <td>Nom de l'usuari</td>
            </tr>
            <tr>
              <td>email</td>
              <td>Correu de contacte</td>
            </tr>
            <tr>
              <td>puntuacio</td>
              <td>Valoració de l'1 al 5</td>
            </tr>
            <tr>
              <td>comentari</td>
              <td>Text de la ressenya</td>
            </tr>
            <tr>
              <td>data_creacio</td>
              <td>Data automàtica del registre</td>
            </tr>
          </table>
        </div>

        <div class="limpiar-flotantes"></div>
      </div>
    </div>

    <div class="seccion">
      <h2 class="titulo-seccion">Ressenyes publicades</h2>

      <?php
      if (!$resultat) {
          echo "<p class='texto-secundario'>No s'han pogut carregar les ressenyes.</p>";
      } elseif (mysqli_num_rows($resultat) == 0) {
          echo "<p class='texto-secundario'>Encara no hi ha ressenyes publicades.</p>";
      } else {
          while ($fila = mysqli_fetch_assoc($resultat)) {
              echo "<div class='nota-precios'>";
              echo "<h3>" . $fila['nom'] . "</h3>";
              echo "<p class='texto-secundario'>" . $fila['email'] . "</p>";
              echo "<p><strong>Puntuació:</strong> " . $fila['puntuacio'] . "/5</p>";
              echo "<p>" . $fila['comentari'] . "</p>";
              echo "<p class='texto-secundario'>Data: " . $fila['data_creacio'] . "</p>";
              echo "</div>";
          }
      }
      ?>
    </div>

  </div>
</body>
</html>
<?php
$conexion->close();
?>
