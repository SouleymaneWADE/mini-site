<?php

$conn = new mysqli('localhost', 'root', '', 'minisite');

if ($conn->connect_error) {
    die('Erreur de connexion : ' . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ine = $_POST['ine'] ?? '';
    $formation = $_POST['formation'] ?? '';
    $nouvelle_note = $_POST['nouvelle-note'] ?? '';

    if (!empty($ine) && !empty($formation) && !empty($nouvelle_note)) {

        $stmt = $conn->prepare('UPDATE notes SET note = ? WHERE ine = ? AND formation = ?');
        $stmt->bind_param('dss', $nouvelle_note, $ine, $formation);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo '<p>La note a été mise à jour avec succès.</p>';
            } else {
                echo '<p>Aucune note trouvée pour cet étudiant et ce formation.</p>';
            }
        } else {
            echo '<p>Erreur lors de la mise à jour : ' . $stmt->error . '</p>';
        }

        $stmt->close();
    } else {
        echo '<p>Veuillez remplir tous les champs requis.</p>';
    }
}

$conn->close();
?>