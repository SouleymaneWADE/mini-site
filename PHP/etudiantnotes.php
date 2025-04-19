<?php
echo '<link rel="stylesheet" href="../CSS/styles.css">';

$conn = new mysqli('localhost', 'root', '', 'minisite');

if ($conn->connect_error) {
    die('Erreur de connexion : ' . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ine = $_POST['ine'] ?? '';

    if (!empty($ine)) {
        $stmt = $conn->prepare('SELECT formation, note FROM notes WHERE ine = ?');
        $stmt->bind_param('s', $ine);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo '<table border="1">';
            echo '<thead><tr><th>Formation</th><th>Note</th></tr></thead>';
            echo '<tbody>';
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['formation']) . '</td>';
                echo '<td>' . htmlspecialchars($row['note']) . '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<p>Aucune note trouvée pour cet étudiant.</p>';
        }

        $stmt->close();
    } else {
        echo '<p>Veuillez entrer un INE valide.</p>';
    }
}

$conn->close();
?>