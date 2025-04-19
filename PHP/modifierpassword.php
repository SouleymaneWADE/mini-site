<?php
echo '<link rel="stylesheet" href="../CSS/styles.css">';

$conn = new mysqli('localhost', 'root', '', 'minisite');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_POST['password'], $_POST['password'], $_POST['ine']) &&
        !empty($_POST['password']) &&
        !empty($_POST['password']) &&
        !empty($_POST['ine'])
    ) {
        $ine = htmlspecialchars($_POST['ine']);
        $oldPassword = htmlspecialchars($_POST['password']);
        $newPassword = htmlspecialchars($_POST['password']);

        $query = "SELECT password FROM etudiants WHERE ine = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $ine);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $etudiant = $result->fetch_assoc();

            if (password_verify($oldPassword, $etudiant['password'])) {
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                $updateQuery = "UPDATE etudiants SET password = ? WHERE ine = ?";
                $updateStmt = $conn->prepare($updateQuery);
                $updateStmt->bind_param("ss", $hashedPassword, $ine);

                if ($updateStmt->execute()) {
                    echo "<p>Mot de passe modifié avec succès.</p>";
                } else {
                    echo "<p>Erreur lors de la mise à jour du mot de passe.</p>";
                }
            } else {
                echo "<p>Ancien mot de passe incorrect.</p>";
            }
        } else {
            echo "<p>Aucun étudiant trouvé avec cet INE.</p>";
        }
    } else {
        echo "<p>Veuillez remplir tous les champs.</p>";
    }
} else {
    echo "<p>Requête invalide.</p>";
}
?>