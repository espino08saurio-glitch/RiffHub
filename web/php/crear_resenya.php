<?php
header("Content-Type: text/html; charset=UTF-8");
include 'db.php';

function mostrar_pagina($titol, $missatge) {
    echo '<!DOCTYPE html>';
    echo '<html>';
    echo '<head>';
    echo '<meta charset="UTF-8">';
    echo '<title>' . $titol . ' - RIFFHUB</title>';
    echo '<link rel="stylesheet" type="text/css" href="../css/style.css">';
    echo '</head>';
    echo '<body>';
    echo '<div class="pagina-marco">';
    echo '<div class="bloque-destacado">';
    echo '<h1>' . $titol . '</h1>';
    echo '<p>' . $missatge . '</p>';
    echo '</div>';
    echo '<p><a href="resenyes.php" class="boton boton-principal">Tornar a ressenyes</a></p>';
    echo '</div>';
    echo '</body>';
    echo '</html>';
}

$sql_taula = "CREATE TABLE IF NOT EXISTS ressenyes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    puntuacio INT NOT NULL,
    comentari TEXT NOT NULL,
    data_creacio TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";

if (!$conexion->query($sql_taula)) {
    mostrar_pagina("Error", "No s'ha pogut preparar la taula de ressenyes.");
    exit;
}

$nom = isset($_POST['resenya_nom']) ? $_POST['resenya_nom'] : "";
$email = isset($_POST['resenya_email']) ? $_POST['resenya_email'] : "";
$puntuacio = isset($_POST['resenya_puntuacio']) ? $_POST['resenya_puntuacio'] : "";
$comentari = isset($_POST['resenya_comentari']) ? $_POST['resenya_comentari'] : "";

if ($nom == "" || $email == "" || $puntuacio == "" || $comentari == "") {
    mostrar_pagina("Error", "Falten dades obligatòries del formulari.");
    exit;
}

$puntuacio = intval($puntuacio);

if ($puntuacio < 1 || $puntuacio > 5) {
    mostrar_pagina("Error", "La puntuació no és correcta.");
    exit;
}

$stmt = $conexion->prepare("INSERT INTO ressenyes (nom, email, puntuacio, comentari) VALUES (?, ?, ?, ?)");

if (!$stmt) {
    mostrar_pagina("Error", "No s'ha pogut preparar la consulta.");
    exit;
}

$stmt->bind_param("ssis", $nom, $email, $puntuacio, $comentari);

if ($stmt->execute()) {
    mostrar_pagina("Ressenya enviada", "La ressenya s'ha guardat correctament a la base de dades.");
} else {
    mostrar_pagina("Error", "No s'ha pogut guardar la ressenya.");
}

$stmt->close();
$conexion->close();
?>
