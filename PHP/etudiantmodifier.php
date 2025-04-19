<?php

$conn = new mysqli('localhost', 'root', '', 'minisite');

if ($conn->connect_error) {
    die('Erreur de connexion : ' . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ine = $_POST['ine'] ?? '';
    $nom = $_POST['nom'] ?? null;
    $prenom = $_POST['prenom'] ?? null;
    $email = $_POST['email'] ?? null;

    if (!empty($ine)) {

        $query = 'UPDATE etudiants SET ';
        $params = [];
        $types = '';

        if (!empty($nom)) {
            $query .= 'nom = ?, ';
            $params[] = $nom;
            $types .= 's';
        }
        if (!empty($prenom)) {
            $query .= 'prenom = ?, ';
            $params[] = $prenom;
            $types .= 's';
        }
        if (!empty($email)) {
            $query .= 'email = ?, ';
            $params[] = $email;
            $types .= 's';
        }

        $query = rtrim($query, ', ') . ' WHERE ine = ?';
        $params[] = $ine;
        $types .= 's';

        if (count($params) > 1) {
            $stmt = $conn->prepare($query);
            $stmt->bind_param($types, ...$params);

            if ($stmt->execute()) {
                echo '<p>Les informations de l\'étudiant ont été mises à jour avec succès.</p>';
            } else {
                echo '<p>Erreur lors de la mise à jour : ' . $stmt->error . '</p>';
            }

            $stmt->close();
        } else {
            echo '<p>Aucune information à mettre à jour.</p>';
        }
    } else {
        echo '<p>Veuillez fournir un INE valide.</p>';
    }
}

$conn->close();
?>