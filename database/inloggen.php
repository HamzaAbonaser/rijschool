<?php
session_start();

include_once '../database/db.php';

class Login {
    private $dbh;

    public function __construct($dbh)
    {
        $this->dbh = $dbh;
    }

    public function userLogin($Username, $Password) {
        $stmt = $this->dbh->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$Username]);
        $manager = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($manager && password_verify($Password, $manager['password'])) {
            $_SESSION['Username'] = $Username;
            
            header("Location: ../homepage/index1.html");
            exit; // Stop verdere uitvoering van de code
        } else {
            return false; // Foutieve inloggegevens
        }
    }
}

$db = new Database();  // Dit maakt automatisch verbinding met de database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $login = new Login($db->getPdo());
    
    if ($login->userLogin($username, $password)) {
    } else {
        echo "<p>Ongeldige gebruikersnaam of wachtwoord.</p>"; // Toon foutmelding bij foutieve login
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Medewerker Login</title>
    <link rel="stylesheet" href="stylie.css">
</head>
<body>

<div class="container">
    <h2>Inloggen</h2>

    <form method="post">
        <input type="text" name="username" placeholder="Gebruikersnaam" required>
        <input type="password" name="password" placeholder="Wachtwoord" required>

        <button type="submit">Inloggen</button>
    </form>

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$login->userLogin($username, $password)) : ?>
        <p>Ongeldige gebruikersnaam of wachtwoord.</p>
    <?php endif; ?>
</div>

</body>
</html>
