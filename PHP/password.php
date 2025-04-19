<?php

$host = 'localhost';
$dbname = 'minisite';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ine = htmlspecialchars($_POST['ine']);
    $newPassword = $_POST['password-change'];
    $confirmPassword = $_POST['password-change-confirm'];
    $userType = htmlspecialchars($_POST['user_type']); // Récupère le type d'utilisateur (etudiant ou administrateur)

    if ($newPassword === $confirmPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        if ($userType === 'etudiant') {
            $stmt = $pdo->prepare("UPDATE etudiants SET password = ? WHERE ine = ?");
            if ($stmt->execute([$hashedPassword, $ine])) {
                header("Location: ../PAGES/etudiantForm.html");
                exit;
            } else {
                header("Location: ../PAGES/password.html?error=update_failed");
                exit;
            }
        } elseif ($userType === 'administrateur') {
            $stmt = $pdo->prepare("UPDATE administrateurs SET password = ? WHERE ine = ?");
            if ($stmt->execute([$hashedPassword, $ine])) {
                header("Location: ../PAGES/adminForm.html");
                exit;
            } else {
                header("Location: ../PAGES/password.html?error=update_failed");
                exit;
            }
        } else {
            header("Location: ../PAGES/password.html?error=invalid_user_type");
            exit;
        }
    } else {
        header("Location: ../PAGES/password.html?error=password_mismatch");
        exit;
    }
}
?>