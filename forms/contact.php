<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../assets/vendor/PHPMailer/src/PHPMailer.php';
require '../assets/vendor/PHPMailer/src/Exception.php';
require '../assets/vendor/PHPMailer/src/SMTP.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$receiving_email_address = 'benjamin.dusunceli@investitrack.fr';
$your_email = 'benjamin.dusunceli@investitrack.fr';
$your_password = 'Azert.cici91';

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.ionos.fr';
    $mail->SMTPAuth = true;
    $mail->Username = $your_email;
    $mail->Password = $your_password;
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom($your_email, $_POST['name']);
    $mail->addAddress($receiving_email_address);

    // Sujet avec valeur par défaut
    $mail->Subject = $_POST['subject'] ?: 'Nouveau message depuis le formulaire de contact';

    // Corps HTML amélioré
    $mail->isHTML(true);
    $mail->Body = "
        <!DOCTYPE html>
        <html lang='fr'>
        <head>
            <meta charset='UTF-8'>
            <style>
                body {
                    font-family: 'Arial', sans-serif;
                    background-color: #1a1a1a;
                    color: #ffffff;
                    margin: 0;
                    padding: 20px;
                }
                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    background-color: #222222;
                    padding: 20px;
                    border-radius: 10px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
                }
                .header {
                    text-align: center;
                    padding-bottom: 20px;
                    border-bottom: 2px solid #28a745;
                }
                .header h2 {
                    color: #28a745;
                    margin: 0;
                    font-size: 24px;
                }
                .content {
                    padding: 20px 0;
                }
                .content p {
                    margin: 10px 0;
                    font-size: 16px;
                }
                .content strong {
                    color: #28a745;
                }
                .footer {
                    text-align: center;
                    padding-top: 20px;
                    border-top: 1px solid #444;
                    color: #888;
                    font-size: 12px;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>Nouveau message reçu</h2>
                </div>
                <div class='content'>
                    <p><strong>Nom :</strong> {$_POST['name']}</p>
                    <p><strong>Email :</strong> {$_POST['email']}</p>
                    <p><strong>Sujet :</strong> {$_POST['subject'] ?: 'Aucun sujet'}</p>
                    <p><strong>Message :</strong><br>{$_POST['message']}</p>
                </div>
                <div class='footer'>
                    <p>Envoyé via le portfolio de Benjamin Dusunceli - {date('Y-m-d H:i:s')}</p>
                </div>
            </div>
        </body>
        </html>
    ";

    // Version texte pour les clients non HTML
    $mail->AltBody = "Nouveau message reçu\n\n" .
                     "Nom: {$_POST['name']}\n" .
                     "Email: {$_POST['email']}\n" .
                     "Sujet: {$_POST['subject'] ?: 'Aucun sujet'}\n" .
                     "Message: {$_POST['message']}\n\n" .
                     "Envoyé via le portfolio de Benjamin Dusunceli - " . date('Y-m-d H:i:s');

    // Envoyer l'email
    $mail->send();
    echo 'OK'; // Réponse attendue par validate.js
} catch (Exception $e) {
    echo "L'envoi a échoué. Erreur : {$mail->ErrorInfo}";
}
?>