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
    if (isset($_POST['action']) && $_POST['action'] === 'inscription') {
        $prenom = htmlspecialchars($_POST['prenom']);
        $nom = htmlspecialchars($_POST['nom']);
        $ine = htmlspecialchars($_POST['ine']);
        $email = htmlspecialchars($_POST['email']);
        $telephone = htmlspecialchars($_POST['telephone']);
        $genre = htmlspecialchars($_POST['genre']);
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $stmt = $pdo->prepare("INSERT INTO administrateurs (prenom, nom, ine, email, telephone, genre, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$prenom, $nom, $ine, $email, $telephone, $genre, $password])) {
            header("Location: ../PAGES/admin.html");
            exit;
        } else {
            echo "Inscription échouée.";
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'connexion') {
        $email = htmlspecialchars($_POST['email']);
        $password = $_POST['password'];

        $stmt = $pdo->prepare("SELECT * FROM administrateurs WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            header("Location: ../PAGES/admin.html");
            exit;
        } else {
            echo "Email ou mot de passe incorrect.";
        }
    }
}
?>