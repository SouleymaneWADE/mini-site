<?php

$conn = new mysqli('localhost', 'root', '', 'minisite');

if ($conn->connect_error) {
    die('Erreur de connexion : ' . $conn->connect_error);
}

$sql = "SELECT prenom, nom, ine, email, formation FROM etudiantsinscrits";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<table border="1" class="table-etudiants">';
    echo '<thead><tr><th>Prénom</th><th>Nom</th><th>INE</th><th>Email</th><th>Formation</th></tr></thead>';
    echo '<tbody>';
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
         echo '<td>' . htmlspecialchars($row['prenom']) . '</td>';
        echo '<td>' . htmlspecialchars($row['nom']) . '</td>';
        echo '<td>' . htmlspecialchars($row['ine']) . '</td>';
        echo '<td>' . htmlspecialchars($row['email']) . '</td>';
        echo '<td>' . htmlspecialchars($row['formation']) . '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
} else {
    echo '<p>Aucun étudiant inscrit trouvé.</p>';
}

$conn->close();
?>