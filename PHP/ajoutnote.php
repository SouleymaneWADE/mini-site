<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ine = $_POST['ine'] ?? '';
    $formation = $_POST['formation'] ?? '';
    $note = $_POST['note'] ?? '';

    if (!empty($ine) && !empty($formation) && !empty($note)) {
        $conn = new mysqli('localhost', 'root', '', 'minisite');

        if ($conn->connect_error) {
            die('Erreur de connexion : ' . $conn->connect_error);
        }

        $stmt = $conn->prepare('SELECT id_etudiantinscrit FROM etudiantsinscrits WHERE ine = ? AND formation = ?');
        $stmt->bind_param('ss', $ine, $formation);
        $stmt->execute();
        $stmt->bind_result($etudiantId);
        $stmt->fetch();
        $stmt->close();

        if (!empty($etudiantId)) {

            $stmt = $conn->prepare('INSERT INTO notes (ine, formation, note) VALUES (?, ?, ?)');
            $stmt->bind_param('ssd', $ine, $formation, $note);

            if ($stmt->execute()) {
                echo 'Note ajoutée avec succès.';
            } else {
                echo 'Erreur lors de l\'ajout de la note.';
            }

            $stmt->close();
        } else {
            echo 'Étudiant introuvable ou non inscrit à cette formation.';
        }

        $conn->close();
    } else {
        echo 'Tous les champs sont requis.';
    }
}
?>