<?php
session_start();
include("const.inc.php");

$pseudo = isset($_POST['pseudo']) ? $_POST['pseudo'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$pass = isset($_POST['pass']) ? $_POST['pass'] : '';

$erreurs = [];

// Perform validation on user inputs
if (preg_match("/^[A-Za-z0-9À-ú]{5,20}/", $pseudo) === 0) {
    $erreurs["pseudo"] = "Le pseudo n'est pas valide";
}

if (preg_match("/^[A-Za-zÀ-ú]{1,}@[A-Za-zÀ-ú]{1,}/", $email) === 0) {
    $erreurs["email"] = "L'email n'est pas valide";
}

if (preg_match("/^[A-Za-z0-9_$]{8,}/", $pass) === 0) {
    $erreurs["pass"] = "Le mot de passe n'est pas valide";
}

$pseudo = htmlspecialchars($pseudo);
$email = htmlspecialchars($email);
$pass = htmlspecialchars($pass);

if (count($erreurs) > 0) {
    $_SESSION["compte-donnees"]["pseudo"] = $pseudo;
    $_SESSION["compte-donnees"]["email"] = $email;
    $_SESSION["compte-donnees"]["pass"] = $pass; 
    $_SESSION["compte-erreurs"] = $erreurs; 
    header("location: forminscription.php"); 
    exit;
}

// Hash the password
$hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

try {
    $cnn = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    $cnn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $cnn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    $sql = 'SELECT COUNT(*) AS nb FROM formsignup WHERE email = ?';
    $qry = $cnn->prepare($sql);
    $qry->execute([$email]);
    $row = $qry->fetch();

    if ($row['nb'] > 0) {
        echo 'This email is already registered. Please sign in.';
        exit;
    }

    $sql = 'INSERT INTO formsignup(pseudo, email, pass) VALUES(?, ?, ?)';
    $qry = $cnn->prepare($sql);
    $qry->execute([$pseudo, $email, $hashedPassword]);

    $_SESSION['signed_up'] = true; // Set the flag to indicate successful sign-up

    unset($cnn); // Close the database connection

    header("location: home.php"); // Redirect to the home page
    exit;
} catch (PDOException $err) {
    echo $err->getMessage();
    $_SESSION["compte-erreur-sql"] = $err->getMessage();
    $_SESSION["compte-donnees"]["pseudo"] = $pseudo;
    $_SESSION["compte-donnees"]["email"] = $email;
    $_SESSION["compte-donnees"]["pass"] = $pass;
    header("location: home.php");
    exit;
}
?>
