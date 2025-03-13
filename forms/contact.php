<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../assets/vendor/PHPMailer/src/PHPMailer.php';
require '../assets/vendor/PHPMailer/src/Exception.php';
require '../assets/vendor/PHPMailer/src/SMTP.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Remplacez par votre adresse email IONOS
$receiving_email_address = 'benjamin.dusunceli@investitrack.fr'; // Email où recevoir les messages
$your_email = 'benjamin.dusunceli@investitrack.fr'; // Votre email IONOS pour l'envoi
$your_password = 'Azert.cici91'; // Votre mot de passe email IONOS

// Créer une instance de PHPMailer
$mail = new PHPMailer(true);

try {
    // Configuration du serveur SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.ionos.fr';
    $mail->SMTPAuth = true;
    $mail->Username = $your_email; // Votre adresse email
    $mail->Password = $your_password; // Votre mot de passe
    $mail->SMTPSecure = 'tls'; // Utiliser TLS
    $mail->Port = 587; // Port recommandé par IONOS

    // Expéditeur et destinataire
    $mail->setFrom($your_email, $_POST['name']);
    $mail->addAddress($receiving_email_address); // Email où recevoir les messages

    // Contenu de l'email
    $mail->isHTML(true);
    $mail->Subject = $_POST['subject'] ?: 'Nouveau message depuis le formulaire de contact';
    $mail->Body = "
        <h2>Nouveau message</h2>
        <p><strong>Nom :</strong> {$_POST['name']}</p>
        <p><strong>Email :</strong> {$_POST['email']}</p>
        <p><strong>Sujet :</strong> {$_POST['subject']}</p>
        <p><strong>Message :</strong><br>{$_POST['message']}</p>
    ";
    $mail->AltBody = "Nom: {$_POST['name']}\nEmail: {$_POST['email']}\nSujet: {$_POST['subject']}\nMessage: {$_POST['message']}";

    // Envoyer l'email
    $mail->send();
    echo json_encode(['message' => 'Votre message a été envoyé avec succès. Merci !', 'status' => 'success']);
} catch (Exception $e) {
    echo json_encode(['message' => "L'envoi a échoué. Erreur : {$mail->ErrorInfo}", 'status' => 'error']);
}
?>