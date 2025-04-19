<?php

echo '<link rel="stylesheet" href="../CSS/styles.css">';

// Connexion à la base de données
$conn = new mysqli('localhost', 'root', '', 'minisite');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si l'INE est fourni
    if (isset($_POST['ine']) && !empty($_POST['ine'])) {
        $ine = htmlspecialchars($_POST['ine']); // Sécuriser l'entrée utilisateur

        // Préparer la requête SQL
        $query = "SELECT * FROM etudiants WHERE ine = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $ine);
        $stmt->execute();
        $result = $stmt->get_result();

        // Vérifier si des données sont trouvées
        if ($result->num_rows > 0) {
            $etudiant = $result->fetch_assoc();
            echo "<h1>Informations Administratives</h1>";
            echo "<table>";
            echo "<tr><th>Nom</th><td>" . htmlspecialchars($etudiant['nom']) . "</td></tr>";
            echo "<tr><th>Prénom</th><td>" . htmlspecialchars($etudiant['prenom']) . "</td></tr>";
            echo "<tr><th>Email</th><td>" . htmlspecialchars($etudiant['email']) . "</td></tr>";
            echo "<tr><th>INE</th><td>" . htmlspecialchars($etudiant['ine']) . "</td></tr>";
            echo "</table>";
        } else {
            echo "<p>Aucun étudiant trouvé avec cet INE.</p>";
        }
    } else {
        echo "<p>Veuillez fournir un INE valide.</p>";
    }
} else {
    echo "<p>Requête invalide.</p>";
}
?>