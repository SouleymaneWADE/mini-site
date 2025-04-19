<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'] ?? '';
    $presentation = $_POST['presentation'] ?? '';
    $modules = $_POST['modules'] ?? '';

    if (!empty($titre) && !empty($presentation) && !empty($modules)) {
        $conn = new mysqli('localhost', 'root', '', 'minisite');

        if ($conn->connect_error) {
            die('Erreur de connexion : ' . $conn->connect_error);
        }

        $stmt = $conn->prepare('INSERT INTO formations (titre, presentation, modules) VALUES (?, ?, ?)');
        $stmt->bind_param('sss', $titre, $presentation, $modules);

        if ($stmt->execute()) {
            echo 'Formation ajoutée avec succès.';
        } else {
            echo 'Erreur lors de l\'ajout de la formation.';
        }

        $stmt->close();
        $conn->close();
    } else {
        echo 'Tous les champs sont requis.';
    }
}
?>