<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérification anti-spam simple
    if (!isset($_POST['antispam_token']) || $_POST['antispam_token'] !== 'sncom2025') {
        die("Requête invalide.");
    }

    $name = htmlspecialchars(trim($_POST['name'] ?? ''));
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $formula = htmlspecialchars(trim($_POST['formula'] ?? ''));
    $package = htmlspecialchars(trim($_POST['package'] ?? ''));

    if (empty($name) || empty($phone) || empty($formula)) {
        die("Veuillez remplir tous les champs obligatoires.");
    }

    $to = "contact@sncom-mango.com"; // Remplacez par votre adresse email
    $subject = "Nouvelle demande de souscription SNCom";
    $message = "Nom: $name\n";
    $message .= "Téléphone: $phone\n";
    $message .= "Email: $email\n";
    $message .= "Formule choisie: $formula\n";
    $message .= "Forfait souhaité: " . ($package ?: "Non précisé") . "\n";
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";

    if (mail($to, $subject, $message, $headers)) {
        header("Location: index.html?success=1");
        exit;
    } else {
        echo "Une erreur est survenue. Veuillez nous appeler directement.";
    }
} else {
    header("Location: index.html");
    exit;
}
?>