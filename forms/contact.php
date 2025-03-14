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
    // Configuration SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.ionos.fr';
    $mail->SMTPAuth = true;
    $mail->Username = $your_email;
    $mail->Password = $your_password;
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    
    // Configuration de l'encodage pour éviter les problèmes de caractères spéciaux
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';

    // Expéditeur et destinataire
    $mail->setFrom($your_email, $_POST['name']);
    $mail->addAddress($receiving_email_address);

    // Sujet avec valeur par défaut
    $mail->Subject = $_POST['subject'] ?: 'Nouveau message depuis le formulaire de contact';

    // Évalue les valeurs ternaires avant d'insérer dans la chaîne
    $subject_body = $_POST['subject'] ?: 'Aucun sujet';
    $subject_alt = $_POST['subject'] ?: 'Aucun sujet';
    
    // Préparation des données pour éviter les injections
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = nl2br(htmlspecialchars($_POST['message']));
    $date = date('d/m/Y H:i');

    // Corps HTML amélioré
    $mail->isHTML(true);
    $mail->Body = "
        <!DOCTYPE html>
        <html lang='fr'>
        <head>
            <meta charset='UTF-8'>
            <style>
                body {
                    font-family: 'Helvetica', Arial, sans-serif;
                    background-color: #f7f7f7;
                    color: #333333;
                    margin: 0;
                    padding: 0;
                    line-height: 1.6;
                }
                .container {
                    max-width: 600px;
                    margin: 20px auto;
                    background-color: #ffffff;
                    padding: 30px;
                    border-radius: 8px;
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                }
                .logo {
                    text-align: center;
                    margin-bottom: 20px;
                }
                .header {
                    border-bottom: 2px solid #28a745;
                    padding-bottom: 15px;
                    margin-bottom: 25px;
                }
                .header h2 {
                    color: #28a745;
                    margin: 0;
                    font-size: 24px;
                    font-weight: 600;
                }
                .content {
                    padding: 0 10px;
                }
                .field {
                    margin-bottom: 20px;
                }
                .field-label {
                    display: block;
                    font-weight: bold;
                    color: #555555;
                    margin-bottom: 5px;
                    font-size: 14px;
                }
                .field-value {
                    background-color: #f9f9f9;
                    padding: 12px;
                    border-radius: 4px;
                    border-left: 3px solid #28a745;
                    font-size: 16px;
                }
                .message-field {
                    line-height: 1.8;
                }
                .footer {
                    text-align: center;
                    margin-top: 30px;
                    padding-top: 15px;
                    border-top: 1px solid #eeeeee;
                    color: #888888;
                    font-size: 13px;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>Nouveau message reçu</h2>
                </div>
                <div class='content'>
                    <div class='field'>
                        <span class='field-label'>Nom</span>
                        <div class='field-value'>$name</div>
                    </div>
                    <div class='field'>
                        <span class='field-label'>Email</span>
                        <div class='field-value'>$email</div>
                    </div>
                    <div class='field'>
                        <span class='field-label'>Sujet</span>
                        <div class='field-value'>$subject_body</div>
                    </div>
                    <div class='field'>
                        <span class='field-label'>Message</span>
                        <div class='field-value message-field'>$message</div>
                    </div>
                </div>
                <div class='footer'>
                    <p>Envoyé via le portfolio de Benjamin Dusunceli - $date</p>
                </div>
            </div>
        </body>
        </html>
    ";

    // Version texte pour les clients non HTML
    $mail->AltBody = "Nouveau message reçu\n\n" .
                     "Nom: $name\n" .
                     "Email: $email\n" .
                     "Sujet: $subject_alt\n" .
                     "Message: {$_POST['message']}\n\n" .
                     "Envoyé via le portfolio de Benjamin Dusunceli - $date";

    // Envoyer l'email
    $mail->send();
    echo 'OK'; // Réponse attendue par validate.js
} catch (Exception $e) {
    echo "L'envoi a échoué. Erreur : {$mail->ErrorInfo}";
}
?>