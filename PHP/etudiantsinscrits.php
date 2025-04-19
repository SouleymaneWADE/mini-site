<?php

echo '<link rel="stylesheet" href="../CSS/styles.css">';

$conn = new mysqli('localhost', 'root', '', 'minisite');

if ($conn->connect_error) {
    die('Erreur de connexion : ' . $conn->connect_error);
}

$sql = 'SELECT * FROM etudiantsinscrits';
$result = $conn->query($sql);

if (!$result) {
    die('Erreur dans la requête SQL : ' . $conn->error);
}

if ($result->num_rows > 0) {
    echo '<table border="1">';
    echo '<tr><th>INE</th><th>Prénom</th><th>Nom</th><th>Email</th><th>Formation</th></tr>';
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['ine']) . '</td>';
        echo '<td>' . htmlspecialchars($row['prenom']) . '</td>';
        echo '<td>' . htmlspecialchars($row['nom']) . '</td>';
        echo '<td>' . htmlspecialchars($row['email']) . '</td>';
        echo '<td>' . htmlspecialchars($row['formation']) . '</td>';
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo 'Aucun étudiant inscrit trouvé.';
}

$conn->close();
?>