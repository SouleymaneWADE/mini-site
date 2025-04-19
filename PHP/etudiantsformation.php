<?php
echo '<link rel="stylesheet" href="../CSS/styles.css">';

$conn = new mysqli('localhost', 'root', '', 'minisite');

if ($conn->connect_error) {
    die('Erreur de connexion : ' . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'] ?? '';

    if (!empty($titre)) {
        $stmt = $conn->prepare('SELECT ine, prenom, nom, email FROM etudiantsinscrits WHERE formation = ?');
        $stmt->bind_param('s', $titre);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo '<table border="1">';
            echo '<thead><tr><th>INE</th><th>Prénom</th><th>Nom</th><th>Email</th></tr></thead>';
            echo '<tbody>';
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['ine']) . '</td>';
                echo '<td>' . htmlspecialchars($row['prenom']) . '</td>';
                echo '<td>' . htmlspecialchars($row['nom']) . '</td>';
                echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<p>Aucun étudiant trouvé pour cette formation.</p>';
        }

        $stmt->close();
    } else {
        echo '<p>Veuillez entrer un titre de formation.</p>';
    }
}

$conn->close();
?>